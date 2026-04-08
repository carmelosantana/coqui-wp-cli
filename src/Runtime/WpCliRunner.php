<?php

declare(strict_types=1);

namespace CarmeloSantana\CoquiToolkitWpCli\Runtime;

/**
 * Core process runner for WP-CLI commands.
 *
 * Resolves the wp binary, builds commands with proper argument escaping,
 * global parameter injection (--path, --ssh, --url, --no-color), and
 * executes via proc_open() with non-blocking output reads, timeout
 * support, and output truncation.
 */
final class WpCliRunner
{
    private const int DEFAULT_TIMEOUT = 60;
    private const int MAX_OUTPUT_BYTES = 65_536;

    /** Cached wp binary path */
    private string $resolvedBinary = '';

    public function __construct(
        private readonly string $defaultPath = '',
        private readonly string $defaultSsh = '',
        private readonly string $defaultUrl = '',
    ) {}

    /**
     * Execute a wp subcommand and return the result.
     *
     * @param list<string> $args      Arguments for the wp subcommand
     * @param string       $path      WordPress install path (overrides default)
     * @param string       $ssh       SSH connection string (overrides default)
     * @param string       $url       Site URL for multisite (overrides default)
     * @param int          $timeout   Seconds before the process is killed (0 = no timeout)
     */
    public function run(
        string $subcommand,
        array $args = [],
        string $path = '',
        string $ssh = '',
        string $url = '',
        int $timeout = self::DEFAULT_TIMEOUT,
    ): WpCliResult {
        $binary = $this->resolveBinary();
        if ($binary === '') {
            return new WpCliResult(127, '', 'wp-cli not found. Install it: https://wp-cli.org/#installing');
        }

        $parts = [escapeshellarg($binary), $subcommand];

        foreach ($args as $arg) {
            // Arguments starting with -- are flags, pass as-is but escaped
            if (str_starts_with($arg, '--')) {
                $parts[] = $arg;
            } else {
                $parts[] = escapeshellarg($arg);
            }
        }

        // Append global parameters
        $this->appendGlobalParams($parts, $path, $ssh, $url);

        $command = implode(' ', $parts);

        return $this->execute($command, $timeout);
    }

    /**
     * Run a raw wp-cli command string (for complex piped/redirect scenarios).
     */
    public function runRaw(
        string $command,
        int $timeout = self::DEFAULT_TIMEOUT,
    ): WpCliResult {
        return $this->execute($command, $timeout);
    }

    /**
     * Resolve the absolute path to the wp binary.
     */
    public function resolveBinary(): string
    {
        if ($this->resolvedBinary !== '') {
            return $this->resolvedBinary;
        }

        $which = trim((string) shell_exec('which wp 2>/dev/null'));
        if ($which !== '' && file_exists($which)) {
            $this->resolvedBinary = $which;
            return $which;
        }

        // Check common locations
        $home = getenv('HOME');
        $commonPaths = [
            '/usr/local/bin/wp',
            '/usr/bin/wp',
        ];

        if (is_string($home) && $home !== '') {
            $commonPaths[] = $home . '/.local/bin/wp';
            $commonPaths[] = $home . '/bin/wp';
        }

        foreach ($commonPaths as $path) {
            if (file_exists($path) && is_executable($path)) {
                $this->resolvedBinary = $path;
                return $path;
            }
        }

        return '';
    }

    /**
     * Check if wp-cli is available on the system.
     */
    public function isAvailable(): bool
    {
        return $this->resolveBinary() !== '';
    }

    /**
     * @param list<string> $parts Command parts to append global params to
     */
    private function appendGlobalParams(array &$parts, string $path, string $ssh, string $url): void
    {
        $effectivePath = $path !== '' ? $path : $this->defaultPath;
        $effectiveSsh = $ssh !== '' ? $ssh : $this->defaultSsh;
        $effectiveUrl = $url !== '' ? $url : $this->defaultUrl;

        if ($effectiveSsh !== '') {
            $parts[] = '--ssh=' . escapeshellarg($effectiveSsh);
        } elseif ($effectivePath !== '') {
            $parts[] = '--path=' . escapeshellarg($effectivePath);
        }

        if ($effectiveUrl !== '') {
            $parts[] = '--url=' . escapeshellarg($effectiveUrl);
        }

        // Suppress color codes for clean output
        $parts[] = '--no-color';
    }

    private function execute(string $command, int $timeout): WpCliResult
    {
        $descriptors = [
            0 => ['pipe', 'r'],
            1 => ['pipe', 'w'],
            2 => ['pipe', 'w'],
        ];

        $process = proc_open($command, $descriptors, $pipes);

        if (!is_resource($process)) {
            return new WpCliResult(1, '', 'Failed to start process: ' . $command);
        }

        fclose($pipes[0]);

        stream_set_blocking($pipes[1], false);
        stream_set_blocking($pipes[2], false);

        $stdout = '';
        $stderr = '';
        $startTime = time();

        while (true) {
            $status = proc_get_status($process);

            $out = stream_get_contents($pipes[1]) ?: '';
            $err = stream_get_contents($pipes[2]) ?: '';

            $stdout .= $out;
            $stderr .= $err;

            if (!$status['running']) {
                break;
            }

            if ($timeout > 0 && (time() - $startTime) >= $timeout) {
                proc_terminate($process, 15); // SIGTERM
                usleep(100_000);
                proc_terminate($process, 9);  // SIGKILL
                fclose($pipes[1]);
                fclose($pipes[2]);
                proc_close($process);

                return new WpCliResult(
                    124,
                    $this->truncateOutput($stdout),
                    "Command timed out after {$timeout}s.\n" . $this->truncateOutput($stderr),
                );
            }

            usleep(10_000);
        }

        // Read any remaining output after process exits
        $stdout .= stream_get_contents($pipes[1]) ?: '';
        $stderr .= stream_get_contents($pipes[2]) ?: '';

        fclose($pipes[1]);
        fclose($pipes[2]);

        $exitCode = proc_close($process);

        return new WpCliResult(
            $exitCode,
            $this->truncateOutput(trim($stdout)),
            $this->truncateOutput(trim($stderr)),
        );
    }

    private function truncateOutput(string $output): string
    {
        if (strlen($output) <= self::MAX_OUTPUT_BYTES) {
            return $output;
        }

        return substr($output, 0, self::MAX_OUTPUT_BYTES)
            . "\n\n[Output truncated at " . self::MAX_OUTPUT_BYTES . ' bytes]';
    }
}
