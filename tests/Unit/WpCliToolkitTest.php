<?php

declare(strict_types=1);

use CarmeloSantana\PHPAgents\Contract\ToolInterface;
use CarmeloSantana\PHPAgents\Contract\ToolkitInterface;
use CarmeloSantana\CoquiToolkitWpCli\WpCliToolkit;

test('toolkit implements ToolkitInterface', function () {
    $toolkit = new WpCliToolkit();

    expect($toolkit)->toBeInstanceOf(ToolkitInterface::class);
});

test('tools returns all 13 tools', function () {
    $toolkit = new WpCliToolkit();

    expect($toolkit->tools())->toHaveCount(13);
});

test('each tool implements ToolInterface', function () {
    $toolkit = new WpCliToolkit();

    foreach ($toolkit->tools() as $tool) {
        expect($tool)->toBeInstanceOf(ToolInterface::class);
    }
});

test('tool names are unique', function () {
    $toolkit = new WpCliToolkit();
    $names = array_map(fn(ToolInterface $t) => $t->name(), $toolkit->tools());

    expect($names)->toHaveCount(count(array_unique($names)));
});

test('each tool produces a valid function schema', function () {
    $toolkit = new WpCliToolkit();

    foreach ($toolkit->tools() as $tool) {
        $schema = $tool->toFunctionSchema();

        expect($schema)
            ->toBeArray()
            ->toHaveKeys(['type', 'function']);

        expect($schema['type'])->toBe('function');
        expect($schema['function'])->toBeArray()->toHaveKeys(['name', 'description', 'parameters']);
        expect($schema['function']['name'])->toBeString()->not->toBeEmpty();
        expect($schema['function']['description'])->toBeString()->not->toBeEmpty();
        expect($schema['function']['parameters'])->toBeArray();
    }
});

test('all tool names start with wp_', function () {
    $toolkit = new WpCliToolkit();

    foreach ($toolkit->tools() as $tool) {
        expect($tool->name())->toStartWith('wp_');
    }
});

test('guidelines returns non-empty string with XML tag', function () {
    $toolkit = new WpCliToolkit();
    $guidelines = $toolkit->guidelines();

    expect($guidelines)
        ->toBeString()
        ->not->toBeEmpty()
        ->toContain('<WP-CLI-TOOLKIT-GUIDELINES>')
        ->toContain('</WP-CLI-TOOLKIT-GUIDELINES>');
});

test('fromEnv creates instance', function () {
    $toolkit = WpCliToolkit::fromEnv();

    expect($toolkit)->toBeInstanceOf(WpCliToolkit::class);
    expect($toolkit->tools())->toHaveCount(13);
});

test('expected tool names are present', function () {
    $toolkit = new WpCliToolkit();
    $names = array_map(fn(ToolInterface $t) => $t->name(), $toolkit->tools());

    $expected = [
        'wp_plugin',
        'wp_theme',
        'wp_user',
        'wp_post',
        'wp_option',
        'wp_db',
        'wp_site',
        'wp_core',
        'wp_cache',
        'wp_rewrite',
        'wp_search_replace',
        'wp_cron',
        'wp_media',
    ];

    foreach ($expected as $name) {
        expect($names)->toContain($name);
    }
});

test('all tools have an action parameter', function () {
    $toolkit = new WpCliToolkit();

    foreach ($toolkit->tools() as $tool) {
        $schema = $tool->toFunctionSchema();
        $properties = $schema['function']['parameters']['properties'] ?? [];

        // wp_search_replace doesn't use action — it's a single-purpose tool
        if ($tool->name() === 'wp_search_replace') {
            expect($properties)->toHaveKey('old');
            expect($properties)->toHaveKey('new');
            continue;
        }

        expect($properties)->toHaveKey('action');
    }
});

test('guidelines contain multisite workflow', function () {
    $toolkit = new WpCliToolkit();
    $guidelines = $toolkit->guidelines();

    expect($guidelines)->toContain('Multisite Workflow');
    expect($guidelines)->toContain('wp_site');
});

test('guidelines contain database backup restore', function () {
    $toolkit = new WpCliToolkit();
    $guidelines = $toolkit->guidelines();

    expect($guidelines)->toContain('Database Backup');
    expect($guidelines)->toContain('export');
    expect($guidelines)->toContain('import');
});
