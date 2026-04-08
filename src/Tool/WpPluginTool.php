<?php

declare(strict_types=1);

namespace CarmeloSantana\CoquiToolkitWpCli\Tool;

use CarmeloSantana\PHPAgents\Contract\ToolInterface;
use CarmeloSantana\PHPAgents\Tool\Tool;
use CarmeloSantana\PHPAgents\Tool\ToolResult;
use CarmeloSantana\PHPAgents\Tool\Parameter\BoolParameter;
use CarmeloSantana\PHPAgents\Tool\Parameter\EnumParameter;
use CarmeloSantana\PHPAgents\Tool\Parameter\NumberParameter;
use CarmeloSantana\PHPAgents\Tool\Parameter\StringParameter;
use CarmeloSantana\CoquiToolkitWpCli\Runtime\WpCliRunner;

/**
 * Manage WordPress plugins — list, install, activate, deactivate, delete, update, search.
 */
final readonly class WpPluginTool
{
    public function __construct(
        private WpCliRunner $runner,
    ) {}

    public function build(): ToolInterface
    {
        return new Tool(
            name: 'wp_plugin',
            description: 'Manage WordPress plugins — list installed plugins, install new ones, activate, deactivate, delete, update, or search the plugin directory.',
            parameters: [
                new EnumParameter(
                    'action',
                    'Operation to perform.',
                    values: ['list', 'install', 'activate', 'deactivate', 'delete', 'update', 'search', 'get', 'is_installed', 'status'],
                    required: true,
                ),
                new StringParameter(
                    'plugin',
                    'Plugin slug (e.g. "akismet", "hello-dolly"). Required for install, activate, deactivate, delete, update, get, is_installed.',
                    required: false,
                ),
                new StringParameter(
                    'version',
                    'Specific version to install (e.g. "5.0.0"). Only used with install action.',
                    required: false,
                ),
                new BoolParameter(
                    'activate',
                    'Activate the plugin immediately after installing. Only used with install action.',
                    required: false,
                ),
                new BoolParameter(
                    'all',
                    'Apply action to all plugins (used with update and deactivate).',
                    required: false,
                ),
                new BoolParameter(
                    'force',
                    'Force install even if already installed, or force deactivate even when dependencies exist.',
                    required: false,
                ),
                new BoolParameter(
                    'network',
                    'Network-wide operation for multisite. Used with activate/deactivate.',
                    required: false,
                ),
                new StringParameter(
                    'status_filter',
                    'Filter listed plugins by status: active, inactive, must-use, dropin. Only used with list action.',
                    required: false,
                ),
                new NumberParameter(
                    'per_page',
                    'Number of results per page for search (default: 10, max: 100).',
                    required: false,
                    integer: true,
                    minimum: 1,
                    maximum: 100,
                ),
                new StringParameter(
                    'path',
                    'WordPress install path. Overrides the default WP_CLI_PATH.',
                    required: false,
                ),
                new StringParameter(
                    'ssh',
                    'SSH connection string (e.g. user@host:/path). Overrides WP_CLI_SSH.',
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
        $plugin = trim((string) ($args['plugin'] ?? ''));
        $path = trim((string) ($args['path'] ?? ''));
        $ssh = trim((string) ($args['ssh'] ?? ''));
        $url = trim((string) ($args['url'] ?? ''));

        return match ($action) {
            'list' => $this->listPlugins($args, $path, $ssh, $url),
            'install' => $this->installPlugin($args, $plugin, $path, $ssh, $url),
            'activate' => $this->simplePluginAction('activate', $plugin, $args, $path, $ssh, $url),
            'deactivate' => $this->simplePluginAction('deactivate', $plugin, $args, $path, $ssh, $url),
            'delete' => $this->simplePluginAction('delete', $plugin, $args, $path, $ssh, $url),
            'update' => $this->updatePlugin($plugin, $args, $path, $ssh, $url),
            'search' => $this->searchPlugins($plugin, $args, $path, $ssh, $url),
            'get' => $this->getPlugin($plugin, $path, $ssh, $url),
            'is_installed' => $this->isInstalled($plugin, $path, $ssh, $url),
            'status' => $this->pluginStatus($plugin, $path, $ssh, $url),
            default => ToolResult::error("Unknown action: {$action}."),
        };
    }

    /**
     * @param array<string, mixed> $args
     */
    private function listPlugins(array $args, string $path, string $ssh, string $url): ToolResult
    {
        $wpArgs = ['--format=json'];

        $statusFilter = trim((string) ($args['status_filter'] ?? ''));
        if ($statusFilter !== '') {
            $wpArgs[] = '--status=' . $statusFilter;
        }

        return $this->runner->run('plugin list', $wpArgs, $path, $ssh, $url)->toToolResult();
    }

    /**
     * @param array<string, mixed> $args
     */
    private function installPlugin(array $args, string $plugin, string $path, string $ssh, string $url): ToolResult
    {
        if ($plugin === '') {
            return ToolResult::error('The "plugin" parameter is required for install action (e.g. "akismet", "hello-dolly").');
        }

        $wpArgs = [$plugin];

        $version = trim((string) ($args['version'] ?? ''));
        if ($version !== '') {
            $wpArgs[] = '--version=' . $version;
        }

        if (!empty($args['activate'])) {
            $wpArgs[] = '--activate';
        }

        if (!empty($args['force'])) {
            $wpArgs[] = '--force';
        }

        return $this->runner->run('plugin install', $wpArgs, $path, $ssh, $url)->toToolResult();
    }

    /**
     * @param array<string, mixed> $args
     */
    private function simplePluginAction(string $action, string $plugin, array $args, string $path, string $ssh, string $url): ToolResult
    {
        $wpArgs = [];

        if (!empty($args['all'])) {
            $wpArgs[] = '--all';
        } elseif ($plugin === '') {
            return ToolResult::error("The \"plugin\" parameter is required for {$action} action.");
        } else {
            $wpArgs[] = $plugin;
        }

        if (!empty($args['network'])) {
            $wpArgs[] = '--network';
        }

        if (!empty($args['force'])) {
            $wpArgs[] = '--force';
        }

        return $this->runner->run('plugin ' . $action, $wpArgs, $path, $ssh, $url)->toToolResult();
    }

    /**
     * @param array<string, mixed> $args
     */
    private function updatePlugin(string $plugin, array $args, string $path, string $ssh, string $url): ToolResult
    {
        $wpArgs = [];

        if (!empty($args['all'])) {
            $wpArgs[] = '--all';
        } elseif ($plugin === '') {
            return ToolResult::error('The "plugin" parameter is required for update action (or use all=true).');
        } else {
            $wpArgs[] = $plugin;
        }

        return $this->runner->run('plugin update', $wpArgs, $path, $ssh, $url)->toToolResult();
    }

    /**
     * @param array<string, mixed> $args
     */
    private function searchPlugins(string $plugin, array $args, string $path, string $ssh, string $url): ToolResult
    {
        if ($plugin === '') {
            return ToolResult::error('The "plugin" parameter is required as the search term.');
        }

        $wpArgs = [$plugin, '--format=json'];

        $perPage = (int) ($args['per_page'] ?? 10);
        $wpArgs[] = '--per-page=' . max(1, min($perPage, 100));

        return $this->runner->run('plugin search', $wpArgs, $path, $ssh, $url)->toToolResult();
    }

    private function getPlugin(string $plugin, string $path, string $ssh, string $url): ToolResult
    {
        if ($plugin === '') {
            return ToolResult::error('The "plugin" parameter is required for get action.');
        }

        return $this->runner->run('plugin get', [$plugin, '--format=json'], $path, $ssh, $url)->toToolResult();
    }

    private function isInstalled(string $plugin, string $path, string $ssh, string $url): ToolResult
    {
        if ($plugin === '') {
            return ToolResult::error('The "plugin" parameter is required for is_installed action.');
        }

        return $this->runner->run('plugin is-installed', [$plugin], $path, $ssh, $url)->toToolResult();
    }

    private function pluginStatus(string $plugin, string $path, string $ssh, string $url): ToolResult
    {
        $wpArgs = [];
        if ($plugin !== '') {
            $wpArgs[] = $plugin;
        }

        return $this->runner->run('plugin status', $wpArgs, $path, $ssh, $url)->toToolResult();
    }
}
