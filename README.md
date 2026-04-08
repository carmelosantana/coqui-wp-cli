# WP-CLI Toolkit for Coqui

Manage WordPress sites through natural language commands. This toolkit wraps [WP-CLI](https://wp-cli.org/) to provide 13 tools covering plugins, themes, users, posts, options, database, multisite, core, cache, rewrites, search-replace, cron, and media.

## Requirements

- PHP 8.4+
- [WP-CLI](https://wp-cli.org/) installed and accessible via PATH (or configured via `WP_CLI_PATH`)
- [Coqui Bot](https://github.com/coquibot/coqui) with `carmelosantana/php-agents` ^0.7

## Installation

```bash
composer require coquibot/coqui-toolkit-wp-cli
```

The toolkit is auto-discovered by Coqui — no manual registration needed.

## Configuration

The toolkit uses three environment variables for default WordPress targeting:

| Variable | Description | Example |
|----------|-------------|---------|
| `WP_CLI_PATH` | Local WordPress installation path | `/var/www/html` |
| `WP_CLI_SSH` | SSH connection for remote WordPress | `user@host:/var/www/html` |
| `WP_CLI_URL` | Default site URL (for multisite) | `http://example.com` |

All three are optional. Set them via Coqui's credential system:

```
Set my WP CLI path to /var/www/html
```

Every tool also accepts `path`, `ssh`, and `url` parameters for per-call overriding.

## Tools

| Tool | Description |
|------|-------------|
| `wp_plugin` | Install, activate, deactivate, delete, update, search, list plugins |
| `wp_theme` | Install, activate, delete, update, search, list themes |
| `wp_user` | Create, update, delete, list, get users |
| `wp_post` | Create, update, delete, list, get posts and pages |
| `wp_option` | Get, update, delete, list site options |
| `wp_db` | Export (backup), import (restore), optimize, repair, check, query |
| `wp_site` | List, create, delete multisite subsites with search filtering |
| `wp_core` | Check version, check for updates, update, verify checksums, download |
| `wp_cache` | Flush, get, set, delete cache; check cache type |
| `wp_rewrite` | Flush rules, list rules, view/update permalink structure |
| `wp_search_replace` | Search-replace across database (safe for serialized data) |
| `wp_cron` | List, run, delete cron events; test cron connectivity |
| `wp_media` | Regenerate thumbnails, import media, list attachments |

## Usage Examples

### Plugin Management

```
Install the hello-dolly plugin and activate it
```

```
List all active plugins
```

```
Search for SEO plugins
```

### Multisite Discovery

```
Find which site on my multisite network has a title of "Example Site" and then install the hello-dolly plugin on that site
```

The bot will:
1. Use `wp_site(action: "list", search: "Example Site")` to find the site
2. Use `wp_plugin(action: "install", plugin: "hello-dolly", activate: true, url: "...")` targeting that site

### Database Backup & Restore

```
Backup my database
```

```
Restore my database from backup.sql
```

### Domain Migration

```
Replace all occurrences of http://old-domain.com with https://new-domain.com in the database
```

The bot will first do a dry run, then ask for confirmation before applying.

### Core Management

```
What version of WordPress is installed?
Check if there are any WordPress updates available
Verify the integrity of WordPress core files
```

### User Management

```
Create a new editor user with email john@example.com
List all administrator users
```

## SSH Support

Target remote WordPress installations:

```
List plugins on my remote server user@myserver.com:/var/www/html
```

Or set a default SSH target:

```
Set my WP CLI SSH to user@myserver.com:/var/www/html
```

## Development

```bash
# Install dependencies
composer install

# Run tests
composer test

# Static analysis
composer analyse
```

## License

MIT
