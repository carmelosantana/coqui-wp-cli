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
 * Manage WordPress multisite sites — list, create, delete, empty.
 */
final readonly class WpSiteTool
{
    public function __construct(
        private WpCliRunner $runner,
    ) {}

    public function build(): ToolInterface
    {
        return new Tool(
            name: 'wp_site',
            description: 'Manage WordPress multisite network sites — list all sites, create new sites, delete sites, or empty a site\'s content. Use list to discover sites by title, slug, or URL. Essential for multisite workflows.',
            parameters: [
                new EnumParameter(
                    'action',
                    'Operation to perform.',
                    values: ['list', 'create', 'delete', 'empty', 'archive', 'unarchive', 'activate', 'deactivate', 'spam', 'not_spam'],
                    required: true,
                ),
                new StringParameter(
                    'slug',
                    'Site slug for creation or targeting (e.g. "my-new-site"). Required for create.',
                    required: false,
                ),
                new StringParameter(
                    'title',
                    'Site title. Used with create action.',
                    required: false,
                ),
                new StringParameter(
                    'email',
                    'Admin email for the new site. Used with create action.',
                    required: false,
                ),
                new StringParameter(
                    'site_id',
                    'Site ID (blog_id) for delete, empty, archive, unarchive, activate, deactivate, spam, not_spam actions.',
                    required: false,
                ),
                new StringParameter(
                    'fields',
                    'Comma-separated fields to display in list output (e.g. "blog_id,url,registered,last_updated").',
                    required: false,
                ),
                new StringParameter(
                    'search',
                    'Filter sites containing this string. Used with list action.',
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
                    'Network URL for multisite targeting. Overrides WP_CLI_URL.',
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
            'list' => $this->listSites($args, $path, $ssh, $url),
            'create' => $this->createSite($args, $path, $ssh, $url),
            'delete' => $this->deleteSite($args, $path, $ssh, $url),
            'empty' => $this->emptySite($args, $path, $ssh, $url),
            'archive', 'unarchive', 'activate', 'deactivate', 'spam', 'not_spam' => $this->siteStateAction($action, $args, $path, $ssh, $url),
            default => ToolResult::error("Unknown action: {$action}."),
        };
    }

    /**
     * @param array<string, mixed> $args
     */
    private function listSites(array $args, string $path, string $ssh, string $url): ToolResult
    {
        $search = trim((string) ($args['search'] ?? ''));

        $wpArgs = ['--format=json'];

        // Always include blogname for search filtering
        $fields = trim((string) ($args['fields'] ?? ''));
        if ($fields !== '') {
            $wpArgs[] = '--fields=' . $fields;
        } elseif ($search !== '') {
            $wpArgs[] = '--fields=blog_id,url,blogname,registered,last_updated';
        }

        $result = $this->runner->run('site list', $wpArgs, $path, $ssh, $url);

        // Client-side filtering — wp site list has no native --search flag
        if ($search !== '' && $result->succeeded()) {
            $decoded = json_decode($result->stdout, true);
            if (is_array($decoded)) {
                $searchLower = mb_strtolower($search);
                $filtered = array_values(array_filter(
                    $decoded,
                    fn(array $site): bool => str_contains(mb_strtolower((string) ($site['blogname'] ?? '')), $searchLower)
                        || str_contains(mb_strtolower((string) ($site['url'] ?? '')), $searchLower),
                ));

                $count = count($filtered);
                $json = json_encode($filtered, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

                return ToolResult::success("Found {$count} site(s) matching \"{$search}\":\n{$json}");
            }
        }

        return $result->toToolResult();
    }

    /**
     * @param array<string, mixed> $args
     */
    private function createSite(array $args, string $path, string $ssh, string $url): ToolResult
    {
        $slug = trim((string) ($args['slug'] ?? ''));
        if ($slug === '') {
            return ToolResult::error('The "slug" parameter is required for create action (e.g. "my-site").');
        }

        $wpArgs = ['--slug=' . $slug];

        $title = trim((string) ($args['title'] ?? ''));
        if ($title !== '') {
            $wpArgs[] = '--title=' . $title;
        }

        $email = trim((string) ($args['email'] ?? ''));
        if ($email !== '') {
            $wpArgs[] = '--email=' . $email;
        }

        $wpArgs[] = '--porcelain';

        return $this->runner->run('site create', $wpArgs, $path, $ssh, $url)->toToolResult();
    }

    /**
     * @param array<string, mixed> $args
     */
    private function deleteSite(array $args, string $path, string $ssh, string $url): ToolResult
    {
        $siteId = trim((string) ($args['site_id'] ?? ''));
        if ($siteId === '') {
            return ToolResult::error('The "site_id" parameter is required for delete action.');
        }

        return $this->runner->run('site delete', [$siteId, '--yes'], $path, $ssh, $url)->toToolResult();
    }

    /**
     * @param array<string, mixed> $args
     */
    private function emptySite(array $args, string $path, string $ssh, string $url): ToolResult
    {
        $siteId = trim((string) ($args['site_id'] ?? ''));
        if ($siteId === '') {
            return ToolResult::error('The "site_id" parameter is required for empty action.');
        }

        return $this->runner->run('site empty', [$siteId, '--yes'], $path, $ssh, $url)->toToolResult();
    }

    /**
     * @param array<string, mixed> $args
     */
    private function siteStateAction(string $action, array $args, string $path, string $ssh, string $url): ToolResult
    {
        $siteId = trim((string) ($args['site_id'] ?? ''));
        if ($siteId === '') {
            return ToolResult::error("The \"site_id\" parameter is required for {$action} action.");
        }

        // Convert underscore to hyphen for WP CLI (not_spam → not-spam)
        $wpAction = str_replace('_', '-', $action);

        return $this->runner->run('site ' . $wpAction, [$siteId], $path, $ssh, $url)->toToolResult();
    }
}
