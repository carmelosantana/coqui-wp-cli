<?php

declare(strict_types=1);

namespace CarmeloSantana\CoquiToolkitWpCli\Tool;

use CarmeloSantana\PHPAgents\Contract\ToolInterface;
use CarmeloSantana\PHPAgents\Tool\Tool;
use CarmeloSantana\PHPAgents\Tool\ToolResult;
use CarmeloSantana\PHPAgents\Tool\Parameter\EnumParameter;
use CarmeloSantana\PHPAgents\Tool\Parameter\StringParameter;
use CarmeloSantana\CoquiToolkitWpCli\Runtime\WpCliRunner;

/**
 * Manage WordPress options — get, update, delete, list.
 */
final readonly class WpOptionTool
{
    public function __construct(
        private WpCliRunner $runner,
    ) {}

    public function build(): ToolInterface
    {
        return new Tool(
            name: 'wp_option',
            description: 'Manage WordPress options — get, update, delete, or list site options. Useful for reading/changing site title, tagline, URL, and other settings.',
            parameters: [
                new EnumParameter(
                    'action',
                    'Operation to perform.',
                    values: ['get', 'update', 'delete', 'list', 'add', 'patch'],
                    required: true,
                ),
                new StringParameter(
                    'key',
                    'Option name/key (e.g. "blogname", "siteurl", "blogdescription"). Required for get, update, delete, add.',
                    required: false,
                ),
                new StringParameter(
                    'value',
                    'Option value. Required for update and add.',
                    required: false,
                ),
                new StringParameter(
                    'search',
                    'Pattern to filter options when listing (supports SQL wildcards: %).',
                    required: false,
                ),
                new StringParameter(
                    'format',
                    'Output format for get and list: json, table, csv, yaml. Default: json.',
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
        $key = trim((string) ($args['key'] ?? ''));
        $path = trim((string) ($args['path'] ?? ''));
        $ssh = trim((string) ($args['ssh'] ?? ''));
        $url = trim((string) ($args['url'] ?? ''));

        return match ($action) {
            'get' => $this->getOption($key, $args, $path, $ssh, $url),
            'update' => $this->updateOption($key, $args, $path, $ssh, $url),
            'delete' => $this->deleteOption($key, $path, $ssh, $url),
            'list' => $this->listOptions($args, $path, $ssh, $url),
            'add' => $this->addOption($key, $args, $path, $ssh, $url),
            'patch' => ToolResult::error('Patch action is not yet supported. Use update instead.'),
            default => ToolResult::error("Unknown action: {$action}."),
        };
    }

    /**
     * @param array<string, mixed> $args
     */
    private function getOption(string $key, array $args, string $path, string $ssh, string $url): ToolResult
    {
        if ($key === '') {
            return ToolResult::error('The "key" parameter is required for get action (e.g. "blogname", "siteurl").');
        }

        $format = trim((string) ($args['format'] ?? 'json'));
        $wpArgs = [$key, '--format=' . $format];

        return $this->runner->run('option get', $wpArgs, $path, $ssh, $url)->toToolResult();
    }

    /**
     * @param array<string, mixed> $args
     */
    private function updateOption(string $key, array $args, string $path, string $ssh, string $url): ToolResult
    {
        if ($key === '') {
            return ToolResult::error('The "key" parameter is required for update action.');
        }

        $value = (string) ($args['value'] ?? '');

        return $this->runner->run('option update', [$key, $value], $path, $ssh, $url)->toToolResult();
    }

    private function deleteOption(string $key, string $path, string $ssh, string $url): ToolResult
    {
        if ($key === '') {
            return ToolResult::error('The "key" parameter is required for delete action.');
        }

        return $this->runner->run('option delete', [$key], $path, $ssh, $url)->toToolResult();
    }

    /**
     * @param array<string, mixed> $args
     */
    private function listOptions(array $args, string $path, string $ssh, string $url): ToolResult
    {
        $format = trim((string) ($args['format'] ?? 'json'));
        $wpArgs = ['--format=' . $format];

        $search = trim((string) ($args['search'] ?? ''));
        if ($search !== '') {
            $wpArgs[] = '--search=' . $search;
        }

        return $this->runner->run('option list', $wpArgs, $path, $ssh, $url)->toToolResult();
    }

    /**
     * @param array<string, mixed> $args
     */
    private function addOption(string $key, array $args, string $path, string $ssh, string $url): ToolResult
    {
        if ($key === '') {
            return ToolResult::error('The "key" parameter is required for add action.');
        }

        $value = (string) ($args['value'] ?? '');

        return $this->runner->run('option add', [$key, $value], $path, $ssh, $url)->toToolResult();
    }
}
