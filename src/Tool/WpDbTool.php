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
 * WordPress database management — export, import, optimize, repair, check, size, query.
 */
final readonly class WpDbTool
{
    public function __construct(
        private WpCliRunner $runner,
    ) {}

    public function build(): ToolInterface
    {
        return new Tool(
            name: 'wp_db',
            description: 'WordPress database management — backup (export) and restore (import) the database, run queries, optimize, repair, check tables, and view database size. Use export for "backup my database" and import for "restore from backup".',
            parameters: [
                new EnumParameter(
                    'action',
                    'Operation to perform.',
                    values: ['export', 'import', 'optimize', 'repair', 'check', 'size', 'query', 'tables', 'search', 'cli'],
                    required: true,
                ),
                new StringParameter(
                    'file',
                    'SQL file path. For export: output filename (default: auto-generated). For import: input filename (required).',
                    required: false,
                ),
                new StringParameter(
                    'query_string',
                    'SQL query to execute. Only used with "query" action. BE CAREFUL — this runs directly against the database.',
                    required: false,
                ),
                new StringParameter(
                    'tables',
                    'Comma-separated list of specific tables to include. Used with export action.',
                    required: false,
                ),
                new StringParameter(
                    'exclude_tables',
                    'Comma-separated list of tables to exclude. Used with export action.',
                    required: false,
                ),
                new BoolParameter(
                    'add_drop_table',
                    'Include DROP TABLE IF EXISTS before each CREATE TABLE in exports.',
                    required: false,
                ),
                new StringParameter(
                    'search_string',
                    'String to search for in the database. Only used with "search" action.',
                    required: false,
                ),
                new BoolParameter(
                    'all_tables',
                    'Search/list all tables including non-WordPress tables.',
                    required: false,
                ),
                new StringParameter(
                    'format',
                    'Output format: table, csv, json, yaml. Used with size and tables actions.',
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
            'export' => $this->exportDb($args, $path, $ssh, $url),
            'import' => $this->importDb($args, $path, $ssh, $url),
            'optimize' => $this->runner->run('db optimize', [], $path, $ssh, $url)->toToolResult(),
            'repair' => $this->runner->run('db repair', [], $path, $ssh, $url)->toToolResult(),
            'check' => $this->runner->run('db check', [], $path, $ssh, $url)->toToolResult(),
            'size' => $this->dbSize($args, $path, $ssh, $url),
            'query' => $this->dbQuery($args, $path, $ssh, $url),
            'tables' => $this->dbTables($args, $path, $ssh, $url),
            'search' => $this->dbSearch($args, $path, $ssh, $url),
            'cli' => $this->runner->run('db cli', [], $path, $ssh, $url)->toToolResult(),
            default => ToolResult::error("Unknown action: {$action}."),
        };
    }

    /**
     * @param array<string, mixed> $args
     */
    private function exportDb(array $args, string $path, string $ssh, string $url): ToolResult
    {
        $wpArgs = [];

        $file = trim((string) ($args['file'] ?? ''));
        if ($file !== '') {
            $wpArgs[] = $file;
        }

        $tables = trim((string) ($args['tables'] ?? ''));
        if ($tables !== '') {
            $wpArgs[] = '--tables=' . $tables;
        }

        $excludeTables = trim((string) ($args['exclude_tables'] ?? ''));
        if ($excludeTables !== '') {
            $wpArgs[] = '--exclude_tables=' . $excludeTables;
        }

        if (!empty($args['add_drop_table'])) {
            $wpArgs[] = '--add-drop-table';
        }

        return $this->runner->run('db export', $wpArgs, $path, $ssh, $url, timeout: 120)->toToolResult();
    }

    /**
     * @param array<string, mixed> $args
     */
    private function importDb(array $args, string $path, string $ssh, string $url): ToolResult
    {
        $file = trim((string) ($args['file'] ?? ''));
        if ($file === '') {
            return ToolResult::error('The "file" parameter is required for import action (e.g. "backup.sql").');
        }

        return $this->runner->run('db import', [$file], $path, $ssh, $url, timeout: 120)->toToolResult();
    }

    /**
     * @param array<string, mixed> $args
     */
    private function dbSize(array $args, string $path, string $ssh, string $url): ToolResult
    {
        $format = trim((string) ($args['format'] ?? 'table'));
        $wpArgs = ['--format=' . $format];

        if (!empty($args['all_tables'])) {
            $wpArgs[] = '--all-tables';
        }

        return $this->runner->run('db size', $wpArgs, $path, $ssh, $url)->toToolResult();
    }

    /**
     * @param array<string, mixed> $args
     */
    private function dbQuery(array $args, string $path, string $ssh, string $url): ToolResult
    {
        $query = trim((string) ($args['query_string'] ?? ''));
        if ($query === '') {
            return ToolResult::error('The "query_string" parameter is required for query action.');
        }

        return $this->runner->run('db query', [$query], $path, $ssh, $url)->toToolResult();
    }

    /**
     * @param array<string, mixed> $args
     */
    private function dbTables(array $args, string $path, string $ssh, string $url): ToolResult
    {
        $format = trim((string) ($args['format'] ?? ''));
        $wpArgs = [];

        if ($format !== '') {
            $wpArgs[] = '--format=' . $format;
        }

        if (!empty($args['all_tables'])) {
            $wpArgs[] = '--all-tables';
        }

        return $this->runner->run('db tables', $wpArgs, $path, $ssh, $url)->toToolResult();
    }

    /**
     * @param array<string, mixed> $args
     */
    private function dbSearch(array $args, string $path, string $ssh, string $url): ToolResult
    {
        $search = trim((string) ($args['search_string'] ?? ''));
        if ($search === '') {
            return ToolResult::error('The "search_string" parameter is required for search action.');
        }

        $wpArgs = [$search];

        if (!empty($args['all_tables'])) {
            $wpArgs[] = '--all-tables';
        }

        return $this->runner->run('db search', $wpArgs, $path, $ssh, $url)->toToolResult();
    }
}
