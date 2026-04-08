<?php declare(strict_types = 1);

// odsl-/Users/carmelo/Projects/CoquiBot/Toolkits/coqui-toolkit-wp-cli/src/Runtime/WpCliRunner.php-PHPStan\BetterReflection\Reflection\ReflectionClass-CoquiBot\Toolkits\WpCli\Runtime\WpCliRunner
return \PHPStan\Cache\CacheItem::__set_state(array(
   'variableKey' => 'v2-6.65.0.9-8.4.18-c2e29eb249f4660ae185413ce0523189821bbf62c378144fb5b6909981eccb29',
   'data' => 
  array (
    'locatedSource' => 
    array (
      'class' => 'PHPStan\\BetterReflection\\SourceLocator\\Located\\LocatedSource',
      'data' => 
      array (
        'name' => 'CoquiBot\\Toolkits\\WpCli\\Runtime\\WpCliRunner',
        'filename' => '/Users/carmelo/Projects/CoquiBot/Toolkits/coqui-toolkit-wp-cli/src/Runtime/WpCliRunner.php',
      ),
    ),
    'namespace' => 'CoquiBot\\Toolkits\\WpCli\\Runtime',
    'name' => 'CoquiBot\\Toolkits\\WpCli\\Runtime\\WpCliRunner',
    'shortName' => 'WpCliRunner',
    'isInterface' => false,
    'isTrait' => false,
    'isEnum' => false,
    'isBackedEnum' => false,
    'modifiers' => 32,
    'docComment' => '/**
 * Core process runner for WP-CLI commands.
 *
 * Resolves the wp binary, builds commands with proper argument escaping,
 * global parameter injection (--path, --ssh, --url, --no-color), and
 * executes via proc_open() with non-blocking output reads, timeout
 * support, and output truncation.
 */',
    'attributes' => 
    array (
    ),
    'startLine' => 15,
    'endLine' => 227,
    'startColumn' => 1,
    'endColumn' => 1,
    'parentClassName' => NULL,
    'implementsClassNames' => 
    array (
    ),
    'traitClassNames' => 
    array (
    ),
    'immediateConstants' => 
    array (
      'DEFAULT_TIMEOUT' => 
      array (
        'declaringClassName' => 'CoquiBot\\Toolkits\\WpCli\\Runtime\\WpCliRunner',
        'implementingClassName' => 'CoquiBot\\Toolkits\\WpCli\\Runtime\\WpCliRunner',
        'name' => 'DEFAULT_TIMEOUT',
        'modifiers' => 4,
        'type' => 
        array (
          'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
          'data' => 
          array (
            'name' => 'int',
            'isIdentifier' => true,
          ),
        ),
        'value' => 
        array (
          'code' => '60',
          'attributes' => 
          array (
            'startLine' => 17,
            'endLine' => 17,
            'startTokenPos' => 35,
            'startFilePos' => 445,
            'endTokenPos' => 35,
            'endFilePos' => 446,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 17,
        'endLine' => 17,
        'startColumn' => 5,
        'endColumn' => 43,
      ),
      'MAX_OUTPUT_BYTES' => 
      array (
        'declaringClassName' => 'CoquiBot\\Toolkits\\WpCli\\Runtime\\WpCliRunner',
        'implementingClassName' => 'CoquiBot\\Toolkits\\WpCli\\Runtime\\WpCliRunner',
        'name' => 'MAX_OUTPUT_BYTES',
        'modifiers' => 4,
        'type' => 
        array (
          'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
          'data' => 
          array (
            'name' => 'int',
            'isIdentifier' => true,
          ),
        ),
        'value' => 
        array (
          'code' => '65536',
          'attributes' => 
          array (
            'startLine' => 18,
            'endLine' => 18,
            'startTokenPos' => 48,
            'startFilePos' => 490,
            'endTokenPos' => 48,
            'endFilePos' => 495,
          ),
        ),
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 18,
        'endLine' => 18,
        'startColumn' => 5,
        'endColumn' => 48,
      ),
    ),
    'immediateProperties' => 
    array (
      'resolvedBinary' => 
      array (
        'declaringClassName' => 'CoquiBot\\Toolkits\\WpCli\\Runtime\\WpCliRunner',
        'implementingClassName' => 'CoquiBot\\Toolkits\\WpCli\\Runtime\\WpCliRunner',
        'name' => 'resolvedBinary',
        'modifiers' => 4,
        'type' => 
        array (
          'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
          'data' => 
          array (
            'name' => 'string',
            'isIdentifier' => true,
          ),
        ),
        'default' => 
        array (
          'code' => '\'\'',
          'attributes' => 
          array (
            'startLine' => 21,
            'endLine' => 21,
            'startTokenPos' => 61,
            'startFilePos' => 569,
            'endTokenPos' => 61,
            'endFilePos' => 570,
          ),
        ),
        'docComment' => '/** Cached wp binary path */',
        'attributes' => 
        array (
        ),
        'startLine' => 21,
        'endLine' => 21,
        'startColumn' => 5,
        'endColumn' => 40,
        'isPromoted' => false,
        'declaredAtCompileTime' => true,
        'immediateVirtual' => false,
        'immediateHooks' => 
        array (
        ),
      ),
      'defaultPath' => 
      array (
        'declaringClassName' => 'CoquiBot\\Toolkits\\WpCli\\Runtime\\WpCliRunner',
        'implementingClassName' => 'CoquiBot\\Toolkits\\WpCli\\Runtime\\WpCliRunner',
        'name' => 'defaultPath',
        'modifiers' => 132,
        'type' => 
        array (
          'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
          'data' => 
          array (
            'name' => 'string',
            'isIdentifier' => true,
          ),
        ),
        'default' => NULL,
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 24,
        'endLine' => 24,
        'startColumn' => 9,
        'endColumn' => 49,
        'isPromoted' => true,
        'declaredAtCompileTime' => true,
        'immediateVirtual' => false,
        'immediateHooks' => 
        array (
        ),
      ),
      'defaultSsh' => 
      array (
        'declaringClassName' => 'CoquiBot\\Toolkits\\WpCli\\Runtime\\WpCliRunner',
        'implementingClassName' => 'CoquiBot\\Toolkits\\WpCli\\Runtime\\WpCliRunner',
        'name' => 'defaultSsh',
        'modifiers' => 132,
        'type' => 
        array (
          'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
          'data' => 
          array (
            'name' => 'string',
            'isIdentifier' => true,
          ),
        ),
        'default' => NULL,
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 25,
        'endLine' => 25,
        'startColumn' => 9,
        'endColumn' => 48,
        'isPromoted' => true,
        'declaredAtCompileTime' => true,
        'immediateVirtual' => false,
        'immediateHooks' => 
        array (
        ),
      ),
      'defaultUrl' => 
      array (
        'declaringClassName' => 'CoquiBot\\Toolkits\\WpCli\\Runtime\\WpCliRunner',
        'implementingClassName' => 'CoquiBot\\Toolkits\\WpCli\\Runtime\\WpCliRunner',
        'name' => 'defaultUrl',
        'modifiers' => 132,
        'type' => 
        array (
          'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
          'data' => 
          array (
            'name' => 'string',
            'isIdentifier' => true,
          ),
        ),
        'default' => NULL,
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 26,
        'endLine' => 26,
        'startColumn' => 9,
        'endColumn' => 48,
        'isPromoted' => true,
        'declaredAtCompileTime' => true,
        'immediateVirtual' => false,
        'immediateHooks' => 
        array (
        ),
      ),
    ),
    'immediateMethods' => 
    array (
      '__construct' => 
      array (
        'name' => '__construct',
        'parameters' => 
        array (
          'defaultPath' => 
          array (
            'name' => 'defaultPath',
            'default' => 
            array (
              'code' => '\'\'',
              'attributes' => 
              array (
                'startLine' => 24,
                'endLine' => 24,
                'startTokenPos' => 81,
                'startFilePos' => 654,
                'endTokenPos' => 81,
                'endFilePos' => 655,
              ),
            ),
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
              'data' => 
              array (
                'name' => 'string',
                'isIdentifier' => true,
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => true,
            'attributes' => 
            array (
            ),
            'startLine' => 24,
            'endLine' => 24,
            'startColumn' => 9,
            'endColumn' => 49,
            'parameterIndex' => 0,
            'isOptional' => true,
          ),
          'defaultSsh' => 
          array (
            'name' => 'defaultSsh',
            'default' => 
            array (
              'code' => '\'\'',
              'attributes' => 
              array (
                'startLine' => 25,
                'endLine' => 25,
                'startTokenPos' => 94,
                'startFilePos' => 704,
                'endTokenPos' => 94,
                'endFilePos' => 705,
              ),
            ),
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
              'data' => 
              array (
                'name' => 'string',
                'isIdentifier' => true,
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => true,
            'attributes' => 
            array (
            ),
            'startLine' => 25,
            'endLine' => 25,
            'startColumn' => 9,
            'endColumn' => 48,
            'parameterIndex' => 1,
            'isOptional' => true,
          ),
          'defaultUrl' => 
          array (
            'name' => 'defaultUrl',
            'default' => 
            array (
              'code' => '\'\'',
              'attributes' => 
              array (
                'startLine' => 26,
                'endLine' => 26,
                'startTokenPos' => 107,
                'startFilePos' => 754,
                'endTokenPos' => 107,
                'endFilePos' => 755,
              ),
            ),
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
              'data' => 
              array (
                'name' => 'string',
                'isIdentifier' => true,
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => true,
            'attributes' => 
            array (
            ),
            'startLine' => 26,
            'endLine' => 26,
            'startColumn' => 9,
            'endColumn' => 48,
            'parameterIndex' => 2,
            'isOptional' => true,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => NULL,
        'startLine' => 23,
        'endLine' => 27,
        'startColumn' => 5,
        'endColumn' => 8,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'CoquiBot\\Toolkits\\WpCli\\Runtime',
        'declaringClassName' => 'CoquiBot\\Toolkits\\WpCli\\Runtime\\WpCliRunner',
        'implementingClassName' => 'CoquiBot\\Toolkits\\WpCli\\Runtime\\WpCliRunner',
        'currentClassName' => 'CoquiBot\\Toolkits\\WpCli\\Runtime\\WpCliRunner',
        'aliasName' => NULL,
      ),
      'run' => 
      array (
        'name' => 'run',
        'parameters' => 
        array (
          'subcommand' => 
          array (
            'name' => 'subcommand',
            'default' => NULL,
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
              'data' => 
              array (
                'name' => 'string',
                'isIdentifier' => true,
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 39,
            'endLine' => 39,
            'startColumn' => 9,
            'endColumn' => 26,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
          'args' => 
          array (
            'name' => 'args',
            'default' => 
            array (
              'code' => '[]',
              'attributes' => 
              array (
                'startLine' => 40,
                'endLine' => 40,
                'startTokenPos' => 135,
                'startFilePos' => 1324,
                'endTokenPos' => 136,
                'endFilePos' => 1325,
              ),
            ),
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
              'data' => 
              array (
                'name' => 'array',
                'isIdentifier' => true,
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 40,
            'endLine' => 40,
            'startColumn' => 9,
            'endColumn' => 24,
            'parameterIndex' => 1,
            'isOptional' => true,
          ),
          'path' => 
          array (
            'name' => 'path',
            'default' => 
            array (
              'code' => '\'\'',
              'attributes' => 
              array (
                'startLine' => 41,
                'endLine' => 41,
                'startTokenPos' => 145,
                'startFilePos' => 1351,
                'endTokenPos' => 145,
                'endFilePos' => 1352,
              ),
            ),
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
              'data' => 
              array (
                'name' => 'string',
                'isIdentifier' => true,
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 41,
            'endLine' => 41,
            'startColumn' => 9,
            'endColumn' => 25,
            'parameterIndex' => 2,
            'isOptional' => true,
          ),
          'ssh' => 
          array (
            'name' => 'ssh',
            'default' => 
            array (
              'code' => '\'\'',
              'attributes' => 
              array (
                'startLine' => 42,
                'endLine' => 42,
                'startTokenPos' => 154,
                'startFilePos' => 1377,
                'endTokenPos' => 154,
                'endFilePos' => 1378,
              ),
            ),
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
              'data' => 
              array (
                'name' => 'string',
                'isIdentifier' => true,
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 42,
            'endLine' => 42,
            'startColumn' => 9,
            'endColumn' => 24,
            'parameterIndex' => 3,
            'isOptional' => true,
          ),
          'url' => 
          array (
            'name' => 'url',
            'default' => 
            array (
              'code' => '\'\'',
              'attributes' => 
              array (
                'startLine' => 43,
                'endLine' => 43,
                'startTokenPos' => 163,
                'startFilePos' => 1403,
                'endTokenPos' => 163,
                'endFilePos' => 1404,
              ),
            ),
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
              'data' => 
              array (
                'name' => 'string',
                'isIdentifier' => true,
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 43,
            'endLine' => 43,
            'startColumn' => 9,
            'endColumn' => 24,
            'parameterIndex' => 4,
            'isOptional' => true,
          ),
          'timeout' => 
          array (
            'name' => 'timeout',
            'default' => 
            array (
              'code' => 'self::DEFAULT_TIMEOUT',
              'attributes' => 
              array (
                'startLine' => 44,
                'endLine' => 44,
                'startTokenPos' => 172,
                'startFilePos' => 1430,
                'endTokenPos' => 174,
                'endFilePos' => 1450,
              ),
            ),
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
              'data' => 
              array (
                'name' => 'int',
                'isIdentifier' => true,
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 44,
            'endLine' => 44,
            'startColumn' => 9,
            'endColumn' => 44,
            'parameterIndex' => 5,
            'isOptional' => true,
          ),
        ),
        'returnsReference' => false,
        'returnType' => 
        array (
          'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
          'data' => 
          array (
            'name' => 'CoquiBot\\Toolkits\\WpCli\\Runtime\\WpCliResult',
            'isIdentifier' => false,
          ),
        ),
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Execute a wp subcommand and return the result.
 *
 * @param list<string> $args      Arguments for the wp subcommand
 * @param string       $path      WordPress install path (overrides default)
 * @param string       $ssh       SSH connection string (overrides default)
 * @param string       $url       Site URL for multisite (overrides default)
 * @param int          $timeout   Seconds before the process is killed (0 = no timeout)
 */',
        'startLine' => 38,
        'endLine' => 68,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'CoquiBot\\Toolkits\\WpCli\\Runtime',
        'declaringClassName' => 'CoquiBot\\Toolkits\\WpCli\\Runtime\\WpCliRunner',
        'implementingClassName' => 'CoquiBot\\Toolkits\\WpCli\\Runtime\\WpCliRunner',
        'currentClassName' => 'CoquiBot\\Toolkits\\WpCli\\Runtime\\WpCliRunner',
        'aliasName' => NULL,
      ),
      'runRaw' => 
      array (
        'name' => 'runRaw',
        'parameters' => 
        array (
          'command' => 
          array (
            'name' => 'command',
            'default' => NULL,
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
              'data' => 
              array (
                'name' => 'string',
                'isIdentifier' => true,
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 74,
            'endLine' => 74,
            'startColumn' => 9,
            'endColumn' => 23,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
          'timeout' => 
          array (
            'name' => 'timeout',
            'default' => 
            array (
              'code' => 'self::DEFAULT_TIMEOUT',
              'attributes' => 
              array (
                'startLine' => 75,
                'endLine' => 75,
                'startTokenPos' => 366,
                'startFilePos' => 2379,
                'endTokenPos' => 368,
                'endFilePos' => 2399,
              ),
            ),
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
              'data' => 
              array (
                'name' => 'int',
                'isIdentifier' => true,
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 75,
            'endLine' => 75,
            'startColumn' => 9,
            'endColumn' => 44,
            'parameterIndex' => 1,
            'isOptional' => true,
          ),
        ),
        'returnsReference' => false,
        'returnType' => 
        array (
          'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
          'data' => 
          array (
            'name' => 'CoquiBot\\Toolkits\\WpCli\\Runtime\\WpCliResult',
            'isIdentifier' => false,
          ),
        ),
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Run a raw wp-cli command string (for complex piped/redirect scenarios).
 */',
        'startLine' => 73,
        'endLine' => 78,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'CoquiBot\\Toolkits\\WpCli\\Runtime',
        'declaringClassName' => 'CoquiBot\\Toolkits\\WpCli\\Runtime\\WpCliRunner',
        'implementingClassName' => 'CoquiBot\\Toolkits\\WpCli\\Runtime\\WpCliRunner',
        'currentClassName' => 'CoquiBot\\Toolkits\\WpCli\\Runtime\\WpCliRunner',
        'aliasName' => NULL,
      ),
      'resolveBinary' => 
      array (
        'name' => 'resolveBinary',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => 
        array (
          'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
          'data' => 
          array (
            'name' => 'string',
            'isIdentifier' => true,
          ),
        ),
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Resolve the absolute path to the wp binary.
 */',
        'startLine' => 83,
        'endLine' => 115,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'CoquiBot\\Toolkits\\WpCli\\Runtime',
        'declaringClassName' => 'CoquiBot\\Toolkits\\WpCli\\Runtime\\WpCliRunner',
        'implementingClassName' => 'CoquiBot\\Toolkits\\WpCli\\Runtime\\WpCliRunner',
        'currentClassName' => 'CoquiBot\\Toolkits\\WpCli\\Runtime\\WpCliRunner',
        'aliasName' => NULL,
      ),
      'isAvailable' => 
      array (
        'name' => 'isAvailable',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => 
        array (
          'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
          'data' => 
          array (
            'name' => 'bool',
            'isIdentifier' => true,
          ),
        ),
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Check if wp-cli is available on the system.
 */',
        'startLine' => 120,
        'endLine' => 123,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'CoquiBot\\Toolkits\\WpCli\\Runtime',
        'declaringClassName' => 'CoquiBot\\Toolkits\\WpCli\\Runtime\\WpCliRunner',
        'implementingClassName' => 'CoquiBot\\Toolkits\\WpCli\\Runtime\\WpCliRunner',
        'currentClassName' => 'CoquiBot\\Toolkits\\WpCli\\Runtime\\WpCliRunner',
        'aliasName' => NULL,
      ),
      'appendGlobalParams' => 
      array (
        'name' => 'appendGlobalParams',
        'parameters' => 
        array (
          'parts' => 
          array (
            'name' => 'parts',
            'default' => NULL,
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
              'data' => 
              array (
                'name' => 'array',
                'isIdentifier' => true,
              ),
            ),
            'isVariadic' => false,
            'byRef' => true,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 128,
            'endLine' => 128,
            'startColumn' => 41,
            'endColumn' => 53,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
          'path' => 
          array (
            'name' => 'path',
            'default' => NULL,
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
              'data' => 
              array (
                'name' => 'string',
                'isIdentifier' => true,
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 128,
            'endLine' => 128,
            'startColumn' => 56,
            'endColumn' => 67,
            'parameterIndex' => 1,
            'isOptional' => false,
          ),
          'ssh' => 
          array (
            'name' => 'ssh',
            'default' => NULL,
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
              'data' => 
              array (
                'name' => 'string',
                'isIdentifier' => true,
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 128,
            'endLine' => 128,
            'startColumn' => 70,
            'endColumn' => 80,
            'parameterIndex' => 2,
            'isOptional' => false,
          ),
          'url' => 
          array (
            'name' => 'url',
            'default' => NULL,
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
              'data' => 
              array (
                'name' => 'string',
                'isIdentifier' => true,
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 128,
            'endLine' => 128,
            'startColumn' => 83,
            'endColumn' => 93,
            'parameterIndex' => 3,
            'isOptional' => false,
          ),
        ),
        'returnsReference' => false,
        'returnType' => 
        array (
          'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
          'data' => 
          array (
            'name' => 'void',
            'isIdentifier' => true,
          ),
        ),
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * @param list<string> $parts Command parts to append global params to
 */',
        'startLine' => 128,
        'endLine' => 146,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 4,
        'namespace' => 'CoquiBot\\Toolkits\\WpCli\\Runtime',
        'declaringClassName' => 'CoquiBot\\Toolkits\\WpCli\\Runtime\\WpCliRunner',
        'implementingClassName' => 'CoquiBot\\Toolkits\\WpCli\\Runtime\\WpCliRunner',
        'currentClassName' => 'CoquiBot\\Toolkits\\WpCli\\Runtime\\WpCliRunner',
        'aliasName' => NULL,
      ),
      'execute' => 
      array (
        'name' => 'execute',
        'parameters' => 
        array (
          'command' => 
          array (
            'name' => 'command',
            'default' => NULL,
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
              'data' => 
              array (
                'name' => 'string',
                'isIdentifier' => true,
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 148,
            'endLine' => 148,
            'startColumn' => 30,
            'endColumn' => 44,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
          'timeout' => 
          array (
            'name' => 'timeout',
            'default' => NULL,
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
              'data' => 
              array (
                'name' => 'int',
                'isIdentifier' => true,
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 148,
            'endLine' => 148,
            'startColumn' => 47,
            'endColumn' => 58,
            'parameterIndex' => 1,
            'isOptional' => false,
          ),
        ),
        'returnsReference' => false,
        'returnType' => 
        array (
          'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
          'data' => 
          array (
            'name' => 'CoquiBot\\Toolkits\\WpCli\\Runtime\\WpCliResult',
            'isIdentifier' => false,
          ),
        ),
        'attributes' => 
        array (
        ),
        'docComment' => NULL,
        'startLine' => 148,
        'endLine' => 216,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 4,
        'namespace' => 'CoquiBot\\Toolkits\\WpCli\\Runtime',
        'declaringClassName' => 'CoquiBot\\Toolkits\\WpCli\\Runtime\\WpCliRunner',
        'implementingClassName' => 'CoquiBot\\Toolkits\\WpCli\\Runtime\\WpCliRunner',
        'currentClassName' => 'CoquiBot\\Toolkits\\WpCli\\Runtime\\WpCliRunner',
        'aliasName' => NULL,
      ),
      'truncateOutput' => 
      array (
        'name' => 'truncateOutput',
        'parameters' => 
        array (
          'output' => 
          array (
            'name' => 'output',
            'default' => NULL,
            'type' => 
            array (
              'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
              'data' => 
              array (
                'name' => 'string',
                'isIdentifier' => true,
              ),
            ),
            'isVariadic' => false,
            'byRef' => false,
            'isPromoted' => false,
            'attributes' => 
            array (
            ),
            'startLine' => 218,
            'endLine' => 218,
            'startColumn' => 37,
            'endColumn' => 50,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
        ),
        'returnsReference' => false,
        'returnType' => 
        array (
          'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
          'data' => 
          array (
            'name' => 'string',
            'isIdentifier' => true,
          ),
        ),
        'attributes' => 
        array (
        ),
        'docComment' => NULL,
        'startLine' => 218,
        'endLine' => 226,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 4,
        'namespace' => 'CoquiBot\\Toolkits\\WpCli\\Runtime',
        'declaringClassName' => 'CoquiBot\\Toolkits\\WpCli\\Runtime\\WpCliRunner',
        'implementingClassName' => 'CoquiBot\\Toolkits\\WpCli\\Runtime\\WpCliRunner',
        'currentClassName' => 'CoquiBot\\Toolkits\\WpCli\\Runtime\\WpCliRunner',
        'aliasName' => NULL,
      ),
    ),
    'traitsData' => 
    array (
      'aliases' => 
      array (
      ),
      'modifiers' => 
      array (
      ),
      'precedences' => 
      array (
      ),
      'hashes' => 
      array (
      ),
    ),
  ),
));