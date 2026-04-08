<?php

declare(strict_types=1);

use CarmeloSantana\PHPAgents\Enum\ToolResultStatus;
use CarmeloSantana\CoquiToolkitWpCli\Runtime\WpCliResult;

test('succeeded returns true for exit code 0', function () {
    $result = new WpCliResult(0, 'output', '');

    expect($result->succeeded())->toBeTrue();
});

test('succeeded returns false for non-zero exit code', function () {
    $result = new WpCliResult(1, '', 'error');

    expect($result->succeeded())->toBeFalse();
});

test('output combines stdout and stderr', function () {
    $result = new WpCliResult(0, 'stdout content', 'stderr content');

    expect($result->output())->toBe("stdout content\nstderr content");
});

test('output trims whitespace', function () {
    $result = new WpCliResult(0, "  stdout  \n", "  stderr  \n");

    expect($result->output())->toBe("stdout\nstderr");
});

test('output returns only stdout when stderr is empty', function () {
    $result = new WpCliResult(0, 'just stdout', '');

    expect($result->output())->toBe('just stdout');
});

test('output returns only stderr when stdout is empty', function () {
    $result = new WpCliResult(1, '', 'just stderr');

    expect($result->output())->toBe('just stderr');
});

test('toToolResult returns success for exit code 0', function () {
    $result = new WpCliResult(0, 'all good', '');
    $toolResult = $result->toToolResult();

    expect($toolResult->status)->toBe(ToolResultStatus::Success);
    expect($toolResult->content)->toBe('all good');
});

test('toToolResult returns OK when output is empty on success', function () {
    $result = new WpCliResult(0, '', '');
    $toolResult = $result->toToolResult();

    expect($toolResult->status)->toBe(ToolResultStatus::Success);
    expect($toolResult->content)->toBe('OK');
});

test('toToolResult returns error for non-zero exit code', function () {
    $result = new WpCliResult(1, '', 'fatal: something went wrong');
    $toolResult = $result->toToolResult();

    expect($toolResult->status)->toBe(ToolResultStatus::Error);
    expect($toolResult->content)->toContain('fatal: something went wrong');
});

test('toToolResult includes combined output in error', function () {
    $result = new WpCliResult(1, 'some output', 'some error');
    $toolResult = $result->toToolResult();

    expect($toolResult->status)->toBe(ToolResultStatus::Error);
    expect($toolResult->content)->toContain('some output');
    expect($toolResult->content)->toContain('some error');
});

test('readonly properties are accessible', function () {
    $result = new WpCliResult(42, 'out', 'err');

    expect($result->exitCode)->toBe(42);
    expect($result->stdout)->toBe('out');
    expect($result->stderr)->toBe('err');
});
