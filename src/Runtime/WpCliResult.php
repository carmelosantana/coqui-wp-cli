<?php

declare(strict_types=1);

namespace CarmeloSantana\CoquiToolkitWpCli\Runtime;

use CarmeloSantana\PHPAgents\Tool\ToolResult;

/**
 * Typed result value object for WP-CLI operations.
 *
 * Wraps exit code, stdout, and stderr from a proc_open() call
 * and provides helpers for converting to ToolResult.
 */
final readonly class WpCliResult
{
    public function __construct(
        public int $exitCode,
        public string $stdout,
        public string $stderr,
    ) {}

    /**
     * Whether the command exited successfully (code 0).
     */
    public function succeeded(): bool
    {
        return $this->exitCode === 0;
    }

    /**
     * Combined trimmed output (stdout + stderr).
     */
    public function output(): string
    {
        $combined = trim($this->stdout);

        $err = trim($this->stderr);
        if ($err !== '') {
            $combined .= ($combined !== '' ? "\n" : '') . $err;
        }

        return $combined;
    }

    /**
     * Convert to a ToolResult — success if exit 0, error otherwise.
     */
    public function toToolResult(): ToolResult
    {
        $output = $this->output();

        if ($this->succeeded()) {
            return ToolResult::success($output !== '' ? $output : 'OK');
        }

        return ToolResult::error($output !== '' ? $output : 'WP-CLI command failed with exit code ' . $this->exitCode);
    }
}
