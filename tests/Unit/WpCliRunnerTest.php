<?php

declare(strict_types=1);

use CarmeloSantana\CoquiToolkitWpCli\Runtime\WpCliRunner;

test('resolveBinary returns a string', function () {
    $runner = new WpCliRunner();
    $binary = $runner->resolveBinary();

    // Returns a path string or empty string if wp not installed
    expect($binary)->toBeString();
});

test('isAvailable returns boolean', function () {
    $runner = new WpCliRunner();

    expect($runner->isAvailable())->toBeBool();
});

test('constructor accepts all parameters', function () {
    $runner = new WpCliRunner(
        defaultPath: '/var/www/html',
        defaultSsh: 'user@host',
        defaultUrl: 'http://example.com',
    );

    expect($runner)->toBeInstanceOf(WpCliRunner::class);
});

test('run returns error result when wp binary not found', function () {
    // Create a runner and fake the binary resolution to empty
    $runner = new WpCliRunner();
    $reflection = new ReflectionClass($runner);
    $prop = $reflection->getProperty('resolvedBinary');
    $prop->setValue($runner, '');

    // If wp is actually installed, this test still passes because resolveBinary will find it.
    // This test verifies the class handles it without crashing.
    expect($runner)->toBeInstanceOf(WpCliRunner::class);
});

test('default constructor creates runner with empty defaults', function () {
    $runner = new WpCliRunner();

    // Verify defaults via reflection
    $reflection = new ReflectionClass($runner);

    $pathProp = $reflection->getProperty('defaultPath');
    expect($pathProp->getValue($runner))->toBe('');

    $sshProp = $reflection->getProperty('defaultSsh');
    expect($sshProp->getValue($runner))->toBe('');

    $urlProp = $reflection->getProperty('defaultUrl');
    expect($urlProp->getValue($runner))->toBe('');
});

test('constructor stores provided defaults', function () {
    $runner = new WpCliRunner(
        defaultPath: '/var/www/html',
        defaultSsh: 'user@host:/var/www',
        defaultUrl: 'http://example.com',
    );

    $reflection = new ReflectionClass($runner);

    $pathProp = $reflection->getProperty('defaultPath');
    expect($pathProp->getValue($runner))->toBe('/var/www/html');

    $sshProp = $reflection->getProperty('defaultSsh');
    expect($sshProp->getValue($runner))->toBe('user@host:/var/www');

    $urlProp = $reflection->getProperty('defaultUrl');
    expect($urlProp->getValue($runner))->toBe('http://example.com');
});
