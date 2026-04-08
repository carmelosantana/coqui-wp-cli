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
 * WordPress cron management — list, run, delete events, and test cron connectivity.
 */
final readonly class WpCronTool
{
    public function __construct(
        private WpCliRunner $runner,
    ) {}

    public function build(): ToolInterface
    {
        return new Tool(
            name: 'wp_cron',
            description: 'Manage WordPress cron jobs — list scheduled events, run specific events, delete events, or test cron connectivity.',
            parameters: [
                new EnumParameter(
                    'action',
                    'Operation to perform.',
                    values: ['event_list', 'event_run', 'event_delete', 'test', 'schedule_list'],
                    required: true,
                ),
                new StringParameter(
                    'hook',
                    'Cron hook name. Required for event_run and event_delete (e.g. "wp_update_plugins").',
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
        $hook = trim((string) ($args['hook'] ?? ''));
        $path = trim((string) ($args['path'] ?? ''));
        $ssh = trim((string) ($args['ssh'] ?? ''));
        $url = trim((string) ($args['url'] ?? ''));

        return match ($action) {
            'event_list' => $this->runner->run('cron event list', ['--format=json'], $path, $ssh, $url)->toToolResult(),
            'event_run' => $this->eventAction('run', $hook, $path, $ssh, $url),
            'event_delete' => $this->eventAction('delete', $hook, $path, $ssh, $url),
            'test' => $this->runner->run('cron test', [], $path, $ssh, $url)->toToolResult(),
            'schedule_list' => $this->runner->run('cron schedule list', ['--format=json'], $path, $ssh, $url)->toToolResult(),
            default => ToolResult::error("Unknown action: {$action}."),
        };
    }

    private function eventAction(string $action, string $hook, string $path, string $ssh, string $url): ToolResult
    {
        if ($hook === '') {
            return ToolResult::error("The \"hook\" parameter is required for event_{$action} action (e.g. \"wp_update_plugins\").");
        }

        return $this->runner->run("cron event {$action}", [$hook], $path, $ssh, $url)->toToolResult();
    }
}
