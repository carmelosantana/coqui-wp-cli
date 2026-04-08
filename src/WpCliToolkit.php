<?php

declare(strict_types=1);

namespace CarmeloSantana\CoquiToolkitWpCli;

use CarmeloSantana\PHPAgents\Contract\ToolInterface;
use CarmeloSantana\PHPAgents\Contract\ToolkitInterface;
use CarmeloSantana\CoquiToolkitWpCli\Runtime\WpCliRunner;
use CarmeloSantana\CoquiToolkitWpCli\Tool\WpCacheTool;
use CarmeloSantana\CoquiToolkitWpCli\Tool\WpCoreTool;
use CarmeloSantana\CoquiToolkitWpCli\Tool\WpCronTool;
use CarmeloSantana\CoquiToolkitWpCli\Tool\WpDbTool;
use CarmeloSantana\CoquiToolkitWpCli\Tool\WpMediaTool;
use CarmeloSantana\CoquiToolkitWpCli\Tool\WpOptionTool;
use CarmeloSantana\CoquiToolkitWpCli\Tool\WpPluginTool;
use CarmeloSantana\CoquiToolkitWpCli\Tool\WpPostTool;
use CarmeloSantana\CoquiToolkitWpCli\Tool\WpRewriteTool;
use CarmeloSantana\CoquiToolkitWpCli\Tool\WpSearchReplaceTool;
use CarmeloSantana\CoquiToolkitWpCli\Tool\WpSiteTool;
use CarmeloSantana\CoquiToolkitWpCli\Tool\WpThemeTool;
use CarmeloSantana\CoquiToolkitWpCli\Tool\WpUserTool;

/**
 * WP-CLI toolkit — manage WordPress sites through natural language commands.
 *
 * Wraps WP-CLI to provide plugin, theme, user, post, option, database, site (multisite),
 * core, cache, rewrite, search-replace, cron, and media management tools.
 */
final class WpCliToolkit implements ToolkitInterface
{
    private readonly WpCliRunner $runner;

    public function __construct(
        string $defaultPath = '',
        string $defaultSsh = '',
        string $defaultUrl = '',
    ) {
        $this->runner = new WpCliRunner(
            defaultPath: $defaultPath,
            defaultSsh: $defaultSsh,
            defaultUrl: $defaultUrl,
        );
    }

    /**
     * Create a toolkit instance from environment variables.
     *
     * Reads: WP_CLI_PATH, WP_CLI_SSH, WP_CLI_URL
     */
    public static function fromEnv(): self
    {
        return new self(
            defaultPath: self::env('WP_CLI_PATH'),
            defaultSsh: self::env('WP_CLI_SSH'),
            defaultUrl: self::env('WP_CLI_URL'),
        );
    }

    /**
     * @return list<ToolInterface>
     */
    #[\Override]
    public function tools(): array
    {
        return [
            (new WpPluginTool($this->runner))->build(),
            (new WpThemeTool($this->runner))->build(),
            (new WpUserTool($this->runner))->build(),
            (new WpPostTool($this->runner))->build(),
            (new WpOptionTool($this->runner))->build(),
            (new WpDbTool($this->runner))->build(),
            (new WpSiteTool($this->runner))->build(),
            (new WpCoreTool($this->runner))->build(),
            (new WpCacheTool($this->runner))->build(),
            (new WpRewriteTool($this->runner))->build(),
            (new WpSearchReplaceTool($this->runner))->build(),
            (new WpCronTool($this->runner))->build(),
            (new WpMediaTool($this->runner))->build(),
        ];
    }

    #[\Override]
    public function guidelines(): string
    {
        return <<<'XML'
<WP-CLI-TOOLKIT-GUIDELINES>
## Tool Selection

| Intent | Tool | Action |
|--------|------|--------|
| Install/activate/deactivate/delete/search plugins | wp_plugin | install, activate, deactivate, delete, search |
| Install/activate/delete/search themes | wp_theme | install, activate, delete, search |
| Create/update/delete/list users | wp_user | create, update, delete, list |
| Create/edit/list posts and pages | wp_post | create, update, delete, list |
| Read/write site settings | wp_option | get, update, list |
| Backup/restore database | wp_db | export (backup), import (restore) |
| List/create multisite subsites | wp_site | list, create, delete |
| Check WordPress version/updates | wp_core | version, check_update, update |
| Flush object or page cache | wp_cache | flush |
| Flush rewrite rules | wp_rewrite | flush |
| Domain migration / URL changes | wp_search_replace | (old → new) |
| List/run scheduled tasks | wp_cron | event_list, event_run |
| Regenerate thumbnails | wp_media | regenerate |

## Multisite Workflow

When the user wants to act on a specific site in a multisite network:

1. First, use `wp_site` with action `list` (optionally with `search` to filter by title/URL) to discover the target site's blog_id and URL.
2. Then, pass the site's URL via the `url` parameter on subsequent tool calls (e.g. `wp_plugin` with `url` set).

Example: "Install hello-dolly on the site called Example Site"
→ Step 1: `wp_site(action: "list", search: "Example Site")` → finds blog_id=3, url=example.com/example-site/
→ Step 2: `wp_plugin(action: "install", plugin: "hello-dolly", activate: true, url: "example.com/example-site/")`

## Database Backup/Restore

- "Backup my database" → `wp_db(action: "export")`
- "Backup to backup.sql" → `wp_db(action: "export", file: "backup.sql")`
- "Restore from backup.sql" → `wp_db(action: "import", file: "backup.sql")`
- Always confirm with the user before importing (restoring) — this overwrites the current database.

## Search-Replace Safety

- Always run `wp_search_replace` with `dry_run: true` first to preview changes.
- Only after user confirmation, run again without `dry_run`.

## Common Patterns

- Use `--format=json` output (automatic for list operations) for structured data.
- Every tool supports optional `path`, `ssh`, and `url` overrides for targeting different WordPress installations.
- SSH format: `user@host` or `user@host:/path/to/wp`
</WP-CLI-TOOLKIT-GUIDELINES>
XML;
    }

    private static function env(string $key): string
    {
        $value = getenv($key);

        return $value !== false ? $value : '';
    }
}
