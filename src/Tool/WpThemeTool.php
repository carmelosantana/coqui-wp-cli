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
 * Manage WordPress themes — list, install, activate, delete, update, search.
 */
final readonly class WpThemeTool
{
    public function __construct(
        private WpCliRunner $runner,
    ) {}

    public function build(): ToolInterface
    {
        return new Tool(
            name: 'wp_theme',
            description: 'Manage WordPress themes — list installed themes, install new ones, activate, delete, update, or search the theme directory.',
            parameters: [
                new EnumParameter(
                    'action',
                    'Operation to perform.',
                    values: ['list', 'install', 'activate', 'delete', 'update', 'search', 'get', 'is_installed', 'status'],
                    required: true,
                ),
                new StringParameter(
                    'theme',
                    'Theme slug (e.g. "twentytwentyfive", "astra"). Required for install, activate, delete, update, get, is_installed.',
                    required: false,
                ),
                new StringParameter(
                    'version',
                    'Specific version to install. Only used with install action.',
                    required: false,
                ),
                new BoolParameter(
                    'activate',
                    'Activate the theme immediately after installing.',
                    required: false,
                ),
                new BoolParameter(
                    'all',
                    'Apply update to all themes.',
                    required: false,
                ),
                new BoolParameter(
                    'force',
                    'Force install even if already installed.',
                    required: false,
                ),
                new BoolParameter(
                    'network',
                    'Network-enable the theme for multisite.',
                    required: false,
                ),
                new StringParameter(
                    'status_filter',
                    'Filter listed themes by status: active, inactive, parent. Only used with list action.',
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
        $theme = trim((string) ($args['theme'] ?? ''));
        $path = trim((string) ($args['path'] ?? ''));
        $ssh = trim((string) ($args['ssh'] ?? ''));
        $url = trim((string) ($args['url'] ?? ''));

        return match ($action) {
            'list' => $this->listThemes($args, $path, $ssh, $url),
            'install' => $this->installTheme($args, $theme, $path, $ssh, $url),
            'activate' => $this->activateTheme($theme, $path, $ssh, $url),
            'delete' => $this->deleteTheme($theme, $args, $path, $ssh, $url),
            'update' => $this->updateTheme($theme, $args, $path, $ssh, $url),
            'search' => $this->searchThemes($theme, $path, $ssh, $url),
            'get' => $this->getTheme($theme, $path, $ssh, $url),
            'is_installed' => $this->isInstalled($theme, $path, $ssh, $url),
            'status' => $this->themeStatus($theme, $path, $ssh, $url),
            default => ToolResult::error("Unknown action: {$action}."),
        };
    }

    /**
     * @param array<string, mixed> $args
     */
    private function listThemes(array $args, string $path, string $ssh, string $url): ToolResult
    {
        $wpArgs = ['--format=json'];

        $statusFilter = trim((string) ($args['status_filter'] ?? ''));
        if ($statusFilter !== '') {
            $wpArgs[] = '--status=' . $statusFilter;
        }

        return $this->runner->run('theme list', $wpArgs, $path, $ssh, $url)->toToolResult();
    }

    /**
     * @param array<string, mixed> $args
     */
    private function installTheme(array $args, string $theme, string $path, string $ssh, string $url): ToolResult
    {
        if ($theme === '') {
            return ToolResult::error('The "theme" parameter is required for install action (e.g. "twentytwentyfive").');
        }

        $wpArgs = [$theme];

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

        return $this->runner->run('theme install', $wpArgs, $path, $ssh, $url)->toToolResult();
    }

    private function activateTheme(string $theme, string $path, string $ssh, string $url): ToolResult
    {
        if ($theme === '') {
            return ToolResult::error('The "theme" parameter is required for activate action.');
        }

        return $this->runner->run('theme activate', [$theme], $path, $ssh, $url)->toToolResult();
    }

    /**
     * @param array<string, mixed> $args
     */
    private function deleteTheme(string $theme, array $args, string $path, string $ssh, string $url): ToolResult
    {
        $wpArgs = [];

        if (!empty($args['all'])) {
            $wpArgs[] = '--all';
        } elseif ($theme === '') {
            return ToolResult::error('The "theme" parameter is required for delete action.');
        } else {
            $wpArgs[] = $theme;
        }

        if (!empty($args['force'])) {
            $wpArgs[] = '--force';
        }

        return $this->runner->run('theme delete', $wpArgs, $path, $ssh, $url)->toToolResult();
    }

    /**
     * @param array<string, mixed> $args
     */
    private function updateTheme(string $theme, array $args, string $path, string $ssh, string $url): ToolResult
    {
        $wpArgs = [];

        if (!empty($args['all'])) {
            $wpArgs[] = '--all';
        } elseif ($theme === '') {
            return ToolResult::error('The "theme" parameter is required for update action (or use all=true).');
        } else {
            $wpArgs[] = $theme;
        }

        return $this->runner->run('theme update', $wpArgs, $path, $ssh, $url)->toToolResult();
    }

    private function searchThemes(string $theme, string $path, string $ssh, string $url): ToolResult
    {
        if ($theme === '') {
            return ToolResult::error('The "theme" parameter is required as the search term.');
        }

        return $this->runner->run('theme search', [$theme, '--format=json', '--per-page=10'], $path, $ssh, $url)->toToolResult();
    }

    private function getTheme(string $theme, string $path, string $ssh, string $url): ToolResult
    {
        if ($theme === '') {
            return ToolResult::error('The "theme" parameter is required for get action.');
        }

        return $this->runner->run('theme get', [$theme, '--format=json'], $path, $ssh, $url)->toToolResult();
    }

    private function isInstalled(string $theme, string $path, string $ssh, string $url): ToolResult
    {
        if ($theme === '') {
            return ToolResult::error('The "theme" parameter is required for is_installed action.');
        }

        return $this->runner->run('theme is-installed', [$theme], $path, $ssh, $url)->toToolResult();
    }

    private function themeStatus(string $theme, string $path, string $ssh, string $url): ToolResult
    {
        $wpArgs = [];
        if ($theme !== '') {
            $wpArgs[] = $theme;
        }

        return $this->runner->run('theme status', $wpArgs, $path, $ssh, $url)->toToolResult();
    }
}
