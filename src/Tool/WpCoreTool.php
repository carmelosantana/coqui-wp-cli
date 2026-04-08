<?php

declare(strict_types=1);

namespace CarmeloSantana\CoquiToolkitWpCli\Tool;

use CarmeloSantana\PHPAgents\Contract\ToolInterface;
use CarmeloSantana\PHPAgents\Tool\Tool;
use CarmeloSantana\PHPAgents\Tool\ToolResult;
use CarmeloSantana\PHPAgents\Tool\Parameter\BoolParameter;
use CarmeloSantana\PHPAgents\Tool\Parameter\EnumParameter;
use CarmeloSantana\PHPAgents\Tool\Parameter\StringParameter;
use CarmeloSantana\CoquiToolkitWpCli\Runtime\WpCliRunner;

/**
 * WordPress core management — version, check-update, update, verify-checksums.
 */
final readonly class WpCoreTool
{
    public function __construct(
        private WpCliRunner $runner,
    ) {}

    public function build(): ToolInterface
    {
        return new Tool(
            name: 'wp_core',
            description: 'WordPress core management — check the installed version, check for updates, apply updates, verify checksums, or check if multisite is installed.',
            parameters: [
                new EnumParameter(
                    'action',
                    'Operation to perform.',
                    values: ['version', 'check_update', 'update', 'verify_checksums', 'is_installed', 'is_multisite', 'update_db', 'download'],
                    required: true,
                ),
                new StringParameter(
                    'version',
                    'Specific WordPress version to update or download. Used with update and download actions.',
                    required: false,
                ),
                new BoolParameter(
                    'force',
                    'Force update/reinstall even if the current version matches.',
                    required: false,
                ),
                new BoolParameter(
                    'minor',
                    'Only apply minor version updates (e.g. 6.4.1 → 6.4.2).',
                    required: false,
                ),
                new BoolParameter(
                    'network',
                    'For multisite: run update-db across all sites in the network.',
                    required: false,
                ),
                new StringParameter(
                    'path',
                    'WordPress install path. Overrides the default WP_CLI_PATH.',
                    required: false,
                ),
                new StringParameter(
                    'ssh',
                    'SSH connection string. Overrides WP_CLI_SSH.',
                    required: false,
                ),
                new StringParameter(
                    'url',
                    'Site URL for multisite targeting. Overrides WP_CLI_URL.',
                    required: false,
                ),
            ],
            callback: fn(array $args) => $this->execute($args),
        );
    }

    /**
     * @param array<string, mixed> $args
     */
    private function execute(array $args): ToolResult
    {
        $action = trim((string) ($args['action'] ?? ''));
        $path = trim((string) ($args['path'] ?? ''));
        $ssh = trim((string) ($args['ssh'] ?? ''));
        $url = trim((string) ($args['url'] ?? ''));

        return match ($action) {
            'version' => $this->runner->run('core version', [], $path, $ssh, $url)->toToolResult(),
            'check_update' => $this->runner->run('core check-update', ['--format=json'], $path, $ssh, $url)->toToolResult(),
            'update' => $this->updateCore($args, $path, $ssh, $url),
            'verify_checksums' => $this->runner->run('core verify-checksums', [], $path, $ssh, $url)->toToolResult(),
            'is_installed' => $this->runner->run('core is-installed', [], $path, $ssh, $url)->toToolResult(),
            'is_multisite' => $this->runner->run('core is-installed', ['--network'], $path, $ssh, $url)->toToolResult(),
            'update_db' => $this->updateDb($args, $path, $ssh, $url),
            'download' => $this->downloadCore($args, $path, $ssh, $url),
            default => ToolResult::error("Unknown action: {$action}."),
        };
    }

    /**
     * @param array<string, mixed> $args
     */
    private function updateCore(array $args, string $path, string $ssh, string $url): ToolResult
    {
        $wpArgs = [];

        $version = trim((string) ($args['version'] ?? ''));
        if ($version !== '') {
            $wpArgs[] = '--version=' . $version;
        }

        if (!empty($args['force'])) {
            $wpArgs[] = '--force';
        }

        if (!empty($args['minor'])) {
            $wpArgs[] = '--minor';
        }

        return $this->runner->run('core update', $wpArgs, $path, $ssh, $url, timeout: 120)->toToolResult();
    }

    /**
     * @param array<string, mixed> $args
     */
    private function updateDb(array $args, string $path, string $ssh, string $url): ToolResult
    {
        $wpArgs = [];

        if (!empty($args['network'])) {
            $wpArgs[] = '--network';
        }

        return $this->runner->run('core update-db', $wpArgs, $path, $ssh, $url)->toToolResult();
    }

    /**
     * @param array<string, mixed> $args
     */
    private function downloadCore(array $args, string $path, string $ssh, string $url): ToolResult
    {
        $wpArgs = [];

        $version = trim((string) ($args['version'] ?? ''));
        if ($version !== '') {
            $wpArgs[] = '--version=' . $version;
        }

        if (!empty($args['force'])) {
            $wpArgs[] = '--force';
        }

        return $this->runner->run('core download', $wpArgs, $path, $ssh, $url, timeout: 120)->toToolResult();
    }
}
