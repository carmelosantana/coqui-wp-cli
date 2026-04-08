<?php

declare(strict_types=1);

namespace CarmeloSantana\CoquiToolkitWpCli\Tool;

use CarmeloSantana\PHPAgents\Contract\ToolInterface;
use CarmeloSantana\PHPAgents\Tool\Tool;
use CarmeloSantana\PHPAgents\Tool\ToolResult;
use CarmeloSantana\PHPAgents\Tool\Parameter\BoolParameter;
use CarmeloSantana\PHPAgents\Tool\Parameter\StringParameter;
use CarmeloSantana\CoquiToolkitWpCli\Runtime\WpCliRunner;

/**
 * WordPress search-replace across database tables.
 */
final readonly class WpSearchReplaceTool
{
    public function __construct(
        private WpCliRunner $runner,
    ) {}

    public function build(): ToolInterface
    {
        return new Tool(
            name: 'wp_search_replace',
            description: 'Perform a search-replace across the WordPress database. Handles serialized data safely. Useful for domain migrations, protocol changes (http→https), or fixing URLs after a move.',
            parameters: [
                new StringParameter(
                    'old',
                    'The string to search for in the database (e.g. "http://old-domain.com").',
                    required: true,
                ),
                new StringParameter(
                    'new',
                    'The replacement string (e.g. "https://new-domain.com").',
                    required: true,
                ),
                new StringParameter(
                    'tables',
                    'Comma-separated list of specific tables to search. If omitted, all WordPress tables are searched.',
                    required: false,
                ),
                new BoolParameter(
                    'dry_run',
                    'Preview changes without actually modifying the database. Strongly recommended for the first run.',
                    required: false,
                ),
                new BoolParameter(
                    'precise',
                    'Use precise regex matching (slower but more accurate with serialized data).',
                    required: false,
                ),
                new BoolParameter(
                    'all_tables',
                    'Search all tables regardless of prefix, not just WordPress tables.',
                    required: false,
                ),
                new BoolParameter(
                    'network',
                    'Search-replace across all multisite tables (uses --network flag).',
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
        $old = (string) ($args['old'] ?? '');
        $new = (string) ($args['new'] ?? '');
        $path = trim((string) ($args['path'] ?? ''));
        $ssh = trim((string) ($args['ssh'] ?? ''));
        $url = trim((string) ($args['url'] ?? ''));

        if ($old === '') {
            return ToolResult::error('The "old" parameter is required — the string to search for.');
        }

        $wpArgs = [$old, $new];

        $tables = trim((string) ($args['tables'] ?? ''));
        if ($tables !== '') {
            $wpArgs[] = $tables;
        }

        if (!empty($args['dry_run'])) {
            $wpArgs[] = '--dry-run';
        }

        if (!empty($args['precise'])) {
            $wpArgs[] = '--precise';
        }

        if (!empty($args['all_tables'])) {
            $wpArgs[] = '--all-tables';
        }

        if (!empty($args['network'])) {
            $wpArgs[] = '--network';
        }

        $wpArgs[] = '--report-changed-only';

        return $this->runner->run('search-replace', $wpArgs, $path, $ssh, $url, timeout: 120)->toToolResult();
    }
}
