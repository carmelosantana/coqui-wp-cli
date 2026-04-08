<?php

declare(strict_types=1);

namespace CarmeloSantana\CoquiToolkitWpCli\Tool;

use CarmeloSantana\PHPAgents\Contract\ToolInterface;
use CarmeloSantana\PHPAgents\Tool\Tool;
use CarmeloSantana\PHPAgents\Tool\ToolResult;
use CarmeloSantana\PHPAgents\Tool\Parameter\EnumParameter;
use CarmeloSantana\PHPAgents\Tool\Parameter\NumberParameter;
use CarmeloSantana\PHPAgents\Tool\Parameter\StringParameter;
use CarmeloSantana\CoquiToolkitWpCli\Runtime\WpCliRunner;

/**
 * Manage WordPress posts and pages — list, create, update, delete, get.
 */
final readonly class WpPostTool
{
    public function __construct(
        private WpCliRunner $runner,
    ) {}

    public function build(): ToolInterface
    {
        return new Tool(
            name: 'wp_post',
            description: 'Manage WordPress posts and pages — list, create, update, delete, or get post details. Supports all post types.',
            parameters: [
                new EnumParameter(
                    'action',
                    'Operation to perform.',
                    values: ['list', 'create', 'update', 'delete', 'get'],
                    required: true,
                ),
                new NumberParameter(
                    'post_id',
                    'Post ID. Required for get, update, and delete actions.',
                    required: false,
                    integer: true,
                    minimum: 1,
                ),
                new StringParameter(
                    'title',
                    'Post title. Used with create and update.',
                    required: false,
                ),
                new StringParameter(
                    'content',
                    'Post content (HTML or plain text). Used with create and update.',
                    required: false,
                ),
                new StringParameter(
                    'post_type',
                    'Post type (e.g. post, page, custom). Used with list and create. Default: post.',
                    required: false,
                ),
                new StringParameter(
                    'post_status',
                    'Post status (e.g. publish, draft, pending, private, trash). Used with list, create, update.',
                    required: false,
                ),
                new StringParameter(
                    'post_author',
                    'Author user ID or login. Used with create and update.',
                    required: false,
                ),
                new StringParameter(
                    'post_excerpt',
                    'Post excerpt. Used with create and update.',
                    required: false,
                ),
                new NumberParameter(
                    'count',
                    'Maximum number of posts to list (default: 20).',
                    required: false,
                    integer: true,
                    minimum: 1,
                    maximum: 100,
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
            'list' => $this->listPosts($args, $path, $ssh, $url),
            'create' => $this->createPost($args, $path, $ssh, $url),
            'update' => $this->updatePost($args, $path, $ssh, $url),
            'delete' => $this->deletePost($args, $path, $ssh, $url),
            'get' => $this->getPost($args, $path, $ssh, $url),
            default => ToolResult::error("Unknown action: {$action}."),
        };
    }

    /**
     * @param array<string, mixed> $args
     */
    private function listPosts(array $args, string $path, string $ssh, string $url): ToolResult
    {
        $wpArgs = ['--format=json'];

        $postType = trim((string) ($args['post_type'] ?? ''));
        if ($postType !== '') {
            $wpArgs[] = '--post_type=' . $postType;
        }

        $postStatus = trim((string) ($args['post_status'] ?? ''));
        if ($postStatus !== '') {
            $wpArgs[] = '--post_status=' . $postStatus;
        }

        $count = (int) ($args['count'] ?? 20);
        $wpArgs[] = '--posts_per_page=' . max(1, min($count, 100));

        return $this->runner->run('post list', $wpArgs, $path, $ssh, $url)->toToolResult();
    }

    /**
     * @param array<string, mixed> $args
     */
    private function createPost(array $args, string $path, string $ssh, string $url): ToolResult
    {
        $title = trim((string) ($args['title'] ?? ''));
        if ($title === '') {
            return ToolResult::error('The "title" parameter is required for create action.');
        }

        $wpArgs = [
            '--post_title=' . $title,
        ];

        $content = trim((string) ($args['content'] ?? ''));
        if ($content !== '') {
            $wpArgs[] = '--post_content=' . $content;
        }

        $postType = trim((string) ($args['post_type'] ?? ''));
        if ($postType !== '') {
            $wpArgs[] = '--post_type=' . $postType;
        }

        $postStatus = trim((string) ($args['post_status'] ?? 'draft'));
        $wpArgs[] = '--post_status=' . $postStatus;

        $postAuthor = trim((string) ($args['post_author'] ?? ''));
        if ($postAuthor !== '') {
            $wpArgs[] = '--post_author=' . $postAuthor;
        }

        $excerpt = trim((string) ($args['post_excerpt'] ?? ''));
        if ($excerpt !== '') {
            $wpArgs[] = '--post_excerpt=' . $excerpt;
        }

        $wpArgs[] = '--porcelain';

        return $this->runner->run('post create', $wpArgs, $path, $ssh, $url)->toToolResult();
    }

    /**
     * @param array<string, mixed> $args
     */
    private function updatePost(array $args, string $path, string $ssh, string $url): ToolResult
    {
        $postId = (int) ($args['post_id'] ?? 0);
        if ($postId < 1) {
            return ToolResult::error('The "post_id" parameter is required for update action.');
        }

        $wpArgs = [(string) $postId];

        $title = trim((string) ($args['title'] ?? ''));
        if ($title !== '') {
            $wpArgs[] = '--post_title=' . $title;
        }

        $content = trim((string) ($args['content'] ?? ''));
        if ($content !== '') {
            $wpArgs[] = '--post_content=' . $content;
        }

        $postStatus = trim((string) ($args['post_status'] ?? ''));
        if ($postStatus !== '') {
            $wpArgs[] = '--post_status=' . $postStatus;
        }

        $postAuthor = trim((string) ($args['post_author'] ?? ''));
        if ($postAuthor !== '') {
            $wpArgs[] = '--post_author=' . $postAuthor;
        }

        $excerpt = trim((string) ($args['post_excerpt'] ?? ''));
        if ($excerpt !== '') {
            $wpArgs[] = '--post_excerpt=' . $excerpt;
        }

        return $this->runner->run('post update', $wpArgs, $path, $ssh, $url)->toToolResult();
    }

    /**
     * @param array<string, mixed> $args
     */
    private function deletePost(array $args, string $path, string $ssh, string $url): ToolResult
    {
        $postId = (int) ($args['post_id'] ?? 0);
        if ($postId < 1) {
            return ToolResult::error('The "post_id" parameter is required for delete action.');
        }

        return $this->runner->run('post delete', [(string) $postId, '--force'], $path, $ssh, $url)->toToolResult();
    }

    /**
     * @param array<string, mixed> $args
     */
    private function getPost(array $args, string $path, string $ssh, string $url): ToolResult
    {
        $postId = (int) ($args['post_id'] ?? 0);
        if ($postId < 1) {
            return ToolResult::error('The "post_id" parameter is required for get action.');
        }

        return $this->runner->run('post get', [(string) $postId, '--format=json'], $path, $ssh, $url)->toToolResult();
    }
}
