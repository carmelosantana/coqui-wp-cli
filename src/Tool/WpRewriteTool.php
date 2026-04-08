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
 * WordPress rewrite rules — flush, list, structure.
 */
final readonly class WpRewriteTool
{
    public function __construct(
        private WpCliRunner $runner,
    ) {}

    public function build(): ToolInterface
    {
        return new Tool(
            name: 'wp_rewrite',
            description: 'Manage WordPress rewrite rules — flush to regenerate .htaccess/web.config, list all rules, view permalink structure, or update it.',
            parameters: [
                new EnumParameter(
                    'action',
                    'Operation to perform.',
                    values: ['flush', 'list', 'structure'],
                    required: true,
                ),
                new BoolParameter(
                    'hard',
                    'Perform a hard flush (regenerate .htaccess or web.config). Used with flush.',
                    required: false,
                ),
                new StringParameter(
                    'permastruct',
                    'New permalink structure (e.g. "/%postname%/"). Used with structure to update it.',
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
            'flush' => $this->flush($args, $path, $ssh, $url),
            'list' => $this->runner->run('rewrite list', ['--format=json'], $path, $ssh, $url)->toToolResult(),
            'structure' => $this->structure($args, $path, $ssh, $url),
            default => ToolResult::error("Unknown action: {$action}."),
        };
    }

    /**
     * @param array<string, mixed> $args
     */
    private function flush(array $args, string $path, string $ssh, string $url): ToolResult
    {
        $wpArgs = [];

        if (!empty($args['hard'])) {
            $wpArgs[] = '--hard';
        }

        return $this->runner->run('rewrite flush', $wpArgs, $path, $ssh, $url)->toToolResult();
    }

    /**
     * @param array<string, mixed> $args
     */
    private function structure(array $args, string $path, string $ssh, string $url): ToolResult
    {
        $permastruct = trim((string) ($args['permastruct'] ?? ''));

        if ($permastruct !== '') {
            // Update the permalink structure via option
            return $this->runner->run('rewrite structure', [$permastruct, '--hard'], $path, $ssh, $url)->toToolResult();
        }

        // Get the current permalink structure via option
        return $this->runner->run('option get', ['permalink_structure'], $path, $ssh, $url)->toToolResult();
    }
}
