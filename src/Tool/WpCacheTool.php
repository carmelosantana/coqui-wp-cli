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
 * WordPress object cache management — flush, get, set, delete, type.
 */
final readonly class WpCacheTool
{
    public function __construct(
        private WpCliRunner $runner,
    ) {}

    public function build(): ToolInterface
    {
        return new Tool(
            name: 'wp_cache',
            description: 'Manage WordPress object cache — flush the cache, get/set/delete cache entries, or check the cache type (e.g. Redis, Memcached, default).',
            parameters: [
                new EnumParameter(
                    'action',
                    'Operation to perform.',
                    values: ['flush', 'get', 'set', 'delete', 'type'],
                    required: true,
                ),
                new StringParameter(
                    'key',
                    'Cache key. Required for get, set, delete.',
                    required: false,
                ),
                new StringParameter(
                    'value',
                    'Cache value. Required for set.',
                    required: false,
                ),
                new StringParameter(
                    'group',
                    'Cache group (default: "default"). Used with get, set, delete.',
                    required: false,
                ),
                new StringParameter(
                    'expiration',
                    'Cache expiration in seconds. Used with set. Default: 0 (no expiry).',
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
        $group = trim((string) ($args['group'] ?? ''));
        $path = trim((string) ($args['path'] ?? ''));
        $ssh = trim((string) ($args['ssh'] ?? ''));
        $url = trim((string) ($args['url'] ?? ''));

        return match ($action) {
            'flush' => $this->runner->run('cache flush', [], $path, $ssh, $url)->toToolResult(),
            'get' => $this->cacheGet($key, $group, $path, $ssh, $url),
            'set' => $this->cacheSet($key, $args, $group, $path, $ssh, $url),
            'delete' => $this->cacheDelete($key, $group, $path, $ssh, $url),
            'type' => $this->runner->run('cache type', [], $path, $ssh, $url)->toToolResult(),
            default => ToolResult::error("Unknown action: {$action}."),
        };
    }

    private function cacheGet(string $key, string $group, string $path, string $ssh, string $url): ToolResult
    {
        if ($key === '') {
            return ToolResult::error('The "key" parameter is required for get action.');
        }

        $wpArgs = [$key];
        if ($group !== '') {
            $wpArgs[] = $group;
        }

        return $this->runner->run('cache get', $wpArgs, $path, $ssh, $url)->toToolResult();
    }

    /**
     * @param array<string, mixed> $args
     */
    private function cacheSet(string $key, array $args, string $group, string $path, string $ssh, string $url): ToolResult
    {
        if ($key === '') {
            return ToolResult::error('The "key" parameter is required for set action.');
        }

        $value = (string) ($args['value'] ?? '');
        $expiration = trim((string) ($args['expiration'] ?? ''));

        $wpArgs = [$key, $value];

        if ($group !== '') {
            $wpArgs[] = $group;
        } elseif ($expiration !== '') {
            // Need to specify group as positional argument before expiration
            $wpArgs[] = 'default';
        }

        if ($expiration !== '') {
            $wpArgs[] = $expiration;
        }

        return $this->runner->run('cache set', $wpArgs, $path, $ssh, $url)->toToolResult();
    }

    private function cacheDelete(string $key, string $group, string $path, string $ssh, string $url): ToolResult
    {
        if ($key === '') {
            return ToolResult::error('The "key" parameter is required for delete action.');
        }

        $wpArgs = [$key];
        if ($group !== '') {
            $wpArgs[] = $group;
        }

        return $this->runner->run('cache delete', $wpArgs, $path, $ssh, $url)->toToolResult();
    }
}
