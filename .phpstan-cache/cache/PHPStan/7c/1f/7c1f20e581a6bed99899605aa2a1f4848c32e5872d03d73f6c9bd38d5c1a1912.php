<?php declare(strict_types = 1);

// odsl-/Users/carmelo/Projects/CoquiBot/Toolkits/coqui-toolkit-wp-cli/src/Runtime/WpCliResult.php-PHPStan\BetterReflection\Reflection\ReflectionClass-CoquiBot\Toolkits\WpCli\Runtime\WpCliResult
return \PHPStan\Cache\CacheItem::__set_state(array(
   'variableKey' => 'v2-6.65.0.9-8.4.18-75bcce466cfc3b6f07b5a5e3d8d2f1795ffbf3dde79abe0164f5f3b38a1aec26',
   'data' => 
  array (
    'locatedSource' => 
    array (
      'class' => 'PHPStan\\BetterReflection\\SourceLocator\\Located\\LocatedSource',
      'data' => 
      array (
        'name' => 'CoquiBot\\Toolkits\\WpCli\\Runtime\\WpCliResult',
        'filename' => '/Users/carmelo/Projects/CoquiBot/Toolkits/coqui-toolkit-wp-cli/src/Runtime/WpCliResult.php',
      ),
    ),
    'namespace' => 'CoquiBot\\Toolkits\\WpCli\\Runtime',
    'name' => 'CoquiBot\\Toolkits\\WpCli\\Runtime\\WpCliResult',
    'shortName' => 'WpCliResult',
    'isInterface' => false,
    'isTrait' => false,
    'isEnum' => false,
    'isBackedEnum' => false,
    'modifiers' => 65568,
    'docComment' => '/**
 * Typed result value object for WP-CLI operations.
 *
 * Wraps exit code, stdout, and stderr from a proc_open() call
 * and provides helpers for converting to ToolResult.
 */',
    'attributes' => 
    array (
    ),
    'startLine' => 15,
    'endLine' => 59,
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
    ),
    'immediateProperties' => 
    array (
      'exitCode' => 
      array (
        'declaringClassName' => 'CoquiBot\\Toolkits\\WpCli\\Runtime\\WpCliResult',
        'implementingClassName' => 'CoquiBot\\Toolkits\\WpCli\\Runtime\\WpCliResult',
        'name' => 'exitCode',
        'modifiers' => 1,
        'type' => 
        array (
          'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
          'data' => 
          array (
            'name' => 'int',
            'isIdentifier' => true,
          ),
        ),
        'default' => NULL,
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 18,
        'endLine' => 18,
        'startColumn' => 9,
        'endColumn' => 28,
        'isPromoted' => true,
        'declaredAtCompileTime' => true,
        'immediateVirtual' => false,
        'immediateHooks' => 
        array (
        ),
      ),
      'stdout' => 
      array (
        'declaringClassName' => 'CoquiBot\\Toolkits\\WpCli\\Runtime\\WpCliResult',
        'implementingClassName' => 'CoquiBot\\Toolkits\\WpCli\\Runtime\\WpCliResult',
        'name' => 'stdout',
        'modifiers' => 1,
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
        'startLine' => 19,
        'endLine' => 19,
        'startColumn' => 9,
        'endColumn' => 29,
        'isPromoted' => true,
        'declaredAtCompileTime' => true,
        'immediateVirtual' => false,
        'immediateHooks' => 
        array (
        ),
      ),
      'stderr' => 
      array (
        'declaringClassName' => 'CoquiBot\\Toolkits\\WpCli\\Runtime\\WpCliResult',
        'implementingClassName' => 'CoquiBot\\Toolkits\\WpCli\\Runtime\\WpCliResult',
        'name' => 'stderr',
        'modifiers' => 1,
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
        'startLine' => 20,
        'endLine' => 20,
        'startColumn' => 9,
        'endColumn' => 29,
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
          'exitCode' => 
          array (
            'name' => 'exitCode',
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
            'isPromoted' => true,
            'attributes' => 
            array (
            ),
            'startLine' => 18,
            'endLine' => 18,
            'startColumn' => 9,
            'endColumn' => 28,
            'parameterIndex' => 0,
            'isOptional' => false,
          ),
          'stdout' => 
          array (
            'name' => 'stdout',
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
            'isPromoted' => true,
            'attributes' => 
            array (
            ),
            'startLine' => 19,
            'endLine' => 19,
            'startColumn' => 9,
            'endColumn' => 29,
            'parameterIndex' => 1,
            'isOptional' => false,
          ),
          'stderr' => 
          array (
            'name' => 'stderr',
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
            'isPromoted' => true,
            'attributes' => 
            array (
            ),
            'startLine' => 20,
            'endLine' => 20,
            'startColumn' => 9,
            'endColumn' => 29,
            'parameterIndex' => 2,
            'isOptional' => false,
          ),
        ),
        'returnsReference' => false,
        'returnType' => NULL,
        'attributes' => 
        array (
        ),
        'docComment' => NULL,
        'startLine' => 17,
        'endLine' => 21,
        'startColumn' => 5,
        'endColumn' => 8,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'CoquiBot\\Toolkits\\WpCli\\Runtime',
        'declaringClassName' => 'CoquiBot\\Toolkits\\WpCli\\Runtime\\WpCliResult',
        'implementingClassName' => 'CoquiBot\\Toolkits\\WpCli\\Runtime\\WpCliResult',
        'currentClassName' => 'CoquiBot\\Toolkits\\WpCli\\Runtime\\WpCliResult',
        'aliasName' => NULL,
      ),
      'succeeded' => 
      array (
        'name' => 'succeeded',
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
 * Whether the command exited successfully (code 0).
 */',
        'startLine' => 26,
        'endLine' => 29,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'CoquiBot\\Toolkits\\WpCli\\Runtime',
        'declaringClassName' => 'CoquiBot\\Toolkits\\WpCli\\Runtime\\WpCliResult',
        'implementingClassName' => 'CoquiBot\\Toolkits\\WpCli\\Runtime\\WpCliResult',
        'currentClassName' => 'CoquiBot\\Toolkits\\WpCli\\Runtime\\WpCliResult',
        'aliasName' => NULL,
      ),
      'output' => 
      array (
        'name' => 'output',
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
 * Combined trimmed output (stdout + stderr).
 */',
        'startLine' => 34,
        'endLine' => 44,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'CoquiBot\\Toolkits\\WpCli\\Runtime',
        'declaringClassName' => 'CoquiBot\\Toolkits\\WpCli\\Runtime\\WpCliResult',
        'implementingClassName' => 'CoquiBot\\Toolkits\\WpCli\\Runtime\\WpCliResult',
        'currentClassName' => 'CoquiBot\\Toolkits\\WpCli\\Runtime\\WpCliResult',
        'aliasName' => NULL,
      ),
      'toToolResult' => 
      array (
        'name' => 'toToolResult',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => 
        array (
          'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
          'data' => 
          array (
            'name' => 'CarmeloSantana\\PHPAgents\\Tool\\ToolResult',
            'isIdentifier' => false,
          ),
        ),
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Convert to a ToolResult — success if exit 0, error otherwise.
 */',
        'startLine' => 49,
        'endLine' => 58,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'CoquiBot\\Toolkits\\WpCli\\Runtime',
        'declaringClassName' => 'CoquiBot\\Toolkits\\WpCli\\Runtime\\WpCliResult',
        'implementingClassName' => 'CoquiBot\\Toolkits\\WpCli\\Runtime\\WpCliResult',
        'currentClassName' => 'CoquiBot\\Toolkits\\WpCli\\Runtime\\WpCliResult',
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