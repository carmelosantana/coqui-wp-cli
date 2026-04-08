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
 * WordPress media management — regenerate thumbnails, import, list.
 */
final readonly class WpMediaTool
{
    public function __construct(
        private WpCliRunner $runner,
    ) {}

    public function build(): ToolInterface
    {
        return new Tool(
            name: 'wp_media',
            description: 'Manage WordPress media — regenerate thumbnails, import files from URL or path, or list media library attachments.',
            parameters: [
                new EnumParameter(
                    'action',
                    'Operation to perform.',
                    values: ['regenerate', 'import', 'list', 'image_size'],
                    required: true,
                ),
                new StringParameter(
                    'ids',
                    'Comma-separated attachment IDs (e.g. "100,200,300"). Used with regenerate. If omitted, all images are regenerated.',
                    required: false,
                ),
                new StringParameter(
                    'import_url',
                    'URL or file path to import. Required for import action.',
                    required: false,
                ),
                new StringParameter(
                    'title',
                    'Attachment title. Used with import.',
                    required: false,
                ),
                new StringParameter(
                    'image_size',
                    'Only regenerate a specific image size (e.g. "thumbnail", "medium", "large"). Used with regenerate.',
                    required: false,
                ),
                new BoolParameter(
                    'skip_delete',
                    'Skip deleting old thumbnail files during regeneration.',
                    required: false,
                ),
                new BoolParameter(
                    'only_missing',
                    'Only generate thumbnails for images missing them.',
                    required: false,
                ),
                new StringParameter(
                    'post_type',
                    'Filter listed media by parent post type. Used with list.',
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
            'regenerate' => $this->regenerate($args, $path, $ssh, $url),
            'import' => $this->import($args, $path, $ssh, $url),
            'list' => $this->listMedia($args, $path, $ssh, $url),
            'image_size' => $this->runner->run('media image-size', ['--format=json'], $path, $ssh, $url)->toToolResult(),
            default => ToolResult::error("Unknown action: {$action}."),
        };
    }

    /**
     * @param array<string, mixed> $args
     */
    private function regenerate(array $args, string $path, string $ssh, string $url): ToolResult
    {
        $wpArgs = ['--yes'];

        $ids = trim((string) ($args['ids'] ?? ''));
        if ($ids !== '') {
            // Prepend the IDs before flags
            array_unshift($wpArgs, ...explode(',', $ids));
        }

        $imageSize = trim((string) ($args['image_size'] ?? ''));
        if ($imageSize !== '') {
            $wpArgs[] = '--image_size=' . $imageSize;
        }

        if (!empty($args['skip_delete'])) {
            $wpArgs[] = '--skip-delete';
        }

        if (!empty($args['only_missing'])) {
            $wpArgs[] = '--only-missing';
        }

        return $this->runner->run('media regenerate', $wpArgs, $path, $ssh, $url, timeout: 300)->toToolResult();
    }

    /**
     * @param array<string, mixed> $args
     */
    private function import(array $args, string $path, string $ssh, string $url): ToolResult
    {
        $importUrl = trim((string) ($args['import_url'] ?? ''));
        if ($importUrl === '') {
            return ToolResult::error('The "import_url" parameter is required for import action (URL or file path).');
        }

        $wpArgs = [$importUrl];

        $title = trim((string) ($args['title'] ?? ''));
        if ($title !== '') {
            $wpArgs[] = '--title=' . $title;
        }

        $wpArgs[] = '--porcelain';

        return $this->runner->run('media import', $wpArgs, $path, $ssh, $url, timeout: 120)->toToolResult();
    }

    /**
     * @param array<string, mixed> $args
     */
    private function listMedia(array $args, string $path, string $ssh, string $url): ToolResult
    {
        $wpArgs = ['--format=json'];

        $postType = trim((string) ($args['post_type'] ?? ''));
        if ($postType !== '') {
            $wpArgs[] = '--post_type=' . $postType;
        }

        // Media are attachments — use post list with post_type=attachment
        return $this->runner->run('post list', ['--post_type=attachment', '--format=json'], $path, $ssh, $url)->toToolResult();
    }
}
