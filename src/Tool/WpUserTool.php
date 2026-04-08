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
 * Manage WordPress users — list, create, delete, update, get.
 */
final readonly class WpUserTool
{
    public function __construct(
        private WpCliRunner $runner,
    ) {}

    public function build(): ToolInterface
    {
        return new Tool(
            name: 'wp_user',
            description: 'Manage WordPress users — list users, create new accounts, delete, update roles/metadata, or get user details.',
            parameters: [
                new EnumParameter(
                    'action',
                    'Operation to perform.',
                    values: ['list', 'create', 'delete', 'update', 'get'],
                    required: true,
                ),
                new NumberParameter(
                    'user_id',
                    'User ID. Required for get, update, and delete actions.',
                    required: false,
                    integer: true,
                    minimum: 1,
                ),
                new StringParameter(
                    'login',
                    'Username/login. Required for create action.',
                    required: false,
                ),
                new StringParameter(
                    'email',
                    'User email address. Required for create action.',
                    required: false,
                ),
                new StringParameter(
                    'password',
                    'User password. Used with create action. Auto-generated if omitted.',
                    required: false,
                ),
                new StringParameter(
                    'role',
                    'User role (e.g. administrator, editor, author, contributor, subscriber). Used with create and update.',
                    required: false,
                ),
                new StringParameter(
                    'display_name',
                    'Display name. Used with create and update.',
                    required: false,
                ),
                new StringParameter(
                    'first_name',
                    'First name. Used with create and update.',
                    required: false,
                ),
                new StringParameter(
                    'last_name',
                    'Last name. Used with create and update.',
                    required: false,
                ),
                new StringParameter(
                    'role_filter',
                    'Filter listed users by role. Only used with list action.',
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
            'list' => $this->listUsers($args, $path, $ssh, $url),
            'create' => $this->createUser($args, $path, $ssh, $url),
            'delete' => $this->deleteUser($args, $path, $ssh, $url),
            'update' => $this->updateUser($args, $path, $ssh, $url),
            'get' => $this->getUser($args, $path, $ssh, $url),
            default => ToolResult::error("Unknown action: {$action}."),
        };
    }

    /**
     * @param array<string, mixed> $args
     */
    private function listUsers(array $args, string $path, string $ssh, string $url): ToolResult
    {
        $wpArgs = ['--format=json'];

        $roleFilter = trim((string) ($args['role_filter'] ?? ''));
        if ($roleFilter !== '') {
            $wpArgs[] = '--role=' . $roleFilter;
        }

        return $this->runner->run('user list', $wpArgs, $path, $ssh, $url)->toToolResult();
    }

    /**
     * @param array<string, mixed> $args
     */
    private function createUser(array $args, string $path, string $ssh, string $url): ToolResult
    {
        $login = trim((string) ($args['login'] ?? ''));
        $email = trim((string) ($args['email'] ?? ''));

        if ($login === '') {
            return ToolResult::error('The "login" parameter is required for create action.');
        }

        if ($email === '') {
            return ToolResult::error('The "email" parameter is required for create action.');
        }

        $wpArgs = [$login, $email];

        $password = trim((string) ($args['password'] ?? ''));
        if ($password !== '') {
            $wpArgs[] = '--user_pass=' . $password;
        }

        $role = trim((string) ($args['role'] ?? ''));
        if ($role !== '') {
            $wpArgs[] = '--role=' . $role;
        }

        $displayName = trim((string) ($args['display_name'] ?? ''));
        if ($displayName !== '') {
            $wpArgs[] = '--display_name=' . $displayName;
        }

        $firstName = trim((string) ($args['first_name'] ?? ''));
        if ($firstName !== '') {
            $wpArgs[] = '--first_name=' . $firstName;
        }

        $lastName = trim((string) ($args['last_name'] ?? ''));
        if ($lastName !== '') {
            $wpArgs[] = '--last_name=' . $lastName;
        }

        $wpArgs[] = '--porcelain';

        return $this->runner->run('user create', $wpArgs, $path, $ssh, $url)->toToolResult();
    }

    /**
     * @param array<string, mixed> $args
     */
    private function deleteUser(array $args, string $path, string $ssh, string $url): ToolResult
    {
        $userId = (int) ($args['user_id'] ?? 0);
        if ($userId < 1) {
            return ToolResult::error('The "user_id" parameter is required for delete action.');
        }

        $wpArgs = [(string) $userId, '--yes'];

        return $this->runner->run('user delete', $wpArgs, $path, $ssh, $url)->toToolResult();
    }

    /**
     * @param array<string, mixed> $args
     */
    private function updateUser(array $args, string $path, string $ssh, string $url): ToolResult
    {
        $userId = (int) ($args['user_id'] ?? 0);
        if ($userId < 1) {
            return ToolResult::error('The "user_id" parameter is required for update action.');
        }

        $wpArgs = [(string) $userId];

        $role = trim((string) ($args['role'] ?? ''));
        if ($role !== '') {
            $wpArgs[] = '--role=' . $role;
        }

        $displayName = trim((string) ($args['display_name'] ?? ''));
        if ($displayName !== '') {
            $wpArgs[] = '--display_name=' . $displayName;
        }

        $firstName = trim((string) ($args['first_name'] ?? ''));
        if ($firstName !== '') {
            $wpArgs[] = '--first_name=' . $firstName;
        }

        $lastName = trim((string) ($args['last_name'] ?? ''));
        if ($lastName !== '') {
            $wpArgs[] = '--last_name=' . $lastName;
        }

        $email = trim((string) ($args['email'] ?? ''));
        if ($email !== '') {
            $wpArgs[] = '--user_email=' . $email;
        }

        return $this->runner->run('user update', $wpArgs, $path, $ssh, $url)->toToolResult();
    }

    /**
     * @param array<string, mixed> $args
     */
    private function getUser(array $args, string $path, string $ssh, string $url): ToolResult
    {
        $userId = (int) ($args['user_id'] ?? 0);
        if ($userId < 1) {
            return ToolResult::error('The "user_id" parameter is required for get action.');
        }

        return $this->runner->run('user get', [(string) $userId, '--format=json'], $path, $ssh, $url)->toToolResult();
    }
}
