<?php declare(strict_types = 1);

// odsl-/Users/carmelo/Projects/CoquiBot/Toolkits/coqui-toolkit-wp-cli/src/WpCliToolkit.php-PHPStan\BetterReflection\Reflection\ReflectionClass-CoquiBot\Toolkits\WpCli\WpCliToolkit
return \PHPStan\Cache\CacheItem::__set_state(array(
   'variableKey' => 'v2-6.65.0.9-8.4.18-bcb702fffb82a7410b65d7e1c54b192c528efa5b3c53424a5bc70201b337942b',
   'data' => 
  array (
    'locatedSource' => 
    array (
      'class' => 'PHPStan\\BetterReflection\\SourceLocator\\Located\\LocatedSource',
      'data' => 
      array (
        'name' => 'CoquiBot\\Toolkits\\WpCli\\WpCliToolkit',
        'filename' => '/Users/carmelo/Projects/CoquiBot/Toolkits/coqui-toolkit-wp-cli/src/WpCliToolkit.php',
      ),
    ),
    'namespace' => 'CoquiBot\\Toolkits\\WpCli',
    'name' => 'CoquiBot\\Toolkits\\WpCli\\WpCliToolkit',
    'shortName' => 'WpCliToolkit',
    'isInterface' => false,
    'isTrait' => false,
    'isEnum' => false,
    'isBackedEnum' => false,
    'modifiers' => 32,
    'docComment' => '/**
 * WP-CLI toolkit — manage WordPress sites through natural language commands.
 *
 * Wraps WP-CLI to provide plugin, theme, user, post, option, database, site (multisite),
 * core, cache, rewrite, search-replace, cron, and media management tools.
 */',
    'attributes' => 
    array (
    ),
    'startLine' => 30,
    'endLine' => 144,
    'startColumn' => 1,
    'endColumn' => 1,
    'parentClassName' => NULL,
    'implementsClassNames' => 
    array (
      0 => 'CarmeloSantana\\PHPAgents\\Contract\\ToolkitInterface',
    ),
    'traitClassNames' => 
    array (
    ),
    'immediateConstants' => 
    array (
    ),
    'immediateProperties' => 
    array (
      'runner' => 
      array (
        'declaringClassName' => 'CoquiBot\\Toolkits\\WpCli\\WpCliToolkit',
        'implementingClassName' => 'CoquiBot\\Toolkits\\WpCli\\WpCliToolkit',
        'name' => 'runner',
        'modifiers' => 132,
        'type' => 
        array (
          'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
          'data' => 
          array (
            'name' => 'CoquiBot\\Toolkits\\WpCli\\Runtime\\WpCliRunner',
            'isIdentifier' => false,
          ),
        ),
        'default' => NULL,
        'docComment' => NULL,
        'attributes' => 
        array (
        ),
        'startLine' => 32,
        'endLine' => 32,
        'startColumn' => 5,
        'endColumn' => 41,
        'isPromoted' => false,
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
                'startLine' => 35,
                'endLine' => 35,
                'startTokenPos' => 131,
                'startFilePos' => 1247,
                'endTokenPos' => 131,
                'endFilePos' => 1248,
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
            'startLine' => 35,
            'endLine' => 35,
            'startColumn' => 9,
            'endColumn' => 32,
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
                'startLine' => 36,
                'endLine' => 36,
                'startTokenPos' => 140,
                'startFilePos' => 1280,
                'endTokenPos' => 140,
                'endFilePos' => 1281,
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
            'startLine' => 36,
            'endLine' => 36,
            'startColumn' => 9,
            'endColumn' => 31,
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
                'startLine' => 37,
                'endLine' => 37,
                'startTokenPos' => 149,
                'startFilePos' => 1313,
                'endTokenPos' => 149,
                'endFilePos' => 1314,
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
            'startLine' => 37,
            'endLine' => 37,
            'startColumn' => 9,
            'endColumn' => 31,
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
        'startLine' => 34,
        'endLine' => 44,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'CoquiBot\\Toolkits\\WpCli',
        'declaringClassName' => 'CoquiBot\\Toolkits\\WpCli\\WpCliToolkit',
        'implementingClassName' => 'CoquiBot\\Toolkits\\WpCli\\WpCliToolkit',
        'currentClassName' => 'CoquiBot\\Toolkits\\WpCli\\WpCliToolkit',
        'aliasName' => NULL,
      ),
      'fromEnv' => 
      array (
        'name' => 'fromEnv',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => 
        array (
          'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
          'data' => 
          array (
            'name' => 'self',
            'isIdentifier' => false,
          ),
        ),
        'attributes' => 
        array (
        ),
        'docComment' => '/**
 * Create a toolkit instance from environment variables.
 *
 * Reads: WP_CLI_PATH, WP_CLI_SSH, WP_CLI_URL
 */',
        'startLine' => 51,
        'endLine' => 58,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 17,
        'namespace' => 'CoquiBot\\Toolkits\\WpCli',
        'declaringClassName' => 'CoquiBot\\Toolkits\\WpCli\\WpCliToolkit',
        'implementingClassName' => 'CoquiBot\\Toolkits\\WpCli\\WpCliToolkit',
        'currentClassName' => 'CoquiBot\\Toolkits\\WpCli\\WpCliToolkit',
        'aliasName' => NULL,
      ),
      'tools' => 
      array (
        'name' => 'tools',
        'parameters' => 
        array (
        ),
        'returnsReference' => false,
        'returnType' => 
        array (
          'class' => 'PHPStan\\BetterReflection\\Reflection\\ReflectionNamedType',
          'data' => 
          array (
            'name' => 'array',
            'isIdentifier' => true,
          ),
        ),
        'attributes' => 
        array (
          0 => 
          array (
            'name' => 'Override',
            'isRepeated' => false,
            'arguments' => 
            array (
            ),
          ),
        ),
        'docComment' => '/**
 * @return list<ToolInterface>
 */',
        'startLine' => 63,
        'endLine' => 81,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'CoquiBot\\Toolkits\\WpCli',
        'declaringClassName' => 'CoquiBot\\Toolkits\\WpCli\\WpCliToolkit',
        'implementingClassName' => 'CoquiBot\\Toolkits\\WpCli\\WpCliToolkit',
        'currentClassName' => 'CoquiBot\\Toolkits\\WpCli\\WpCliToolkit',
        'aliasName' => NULL,
      ),
      'guidelines' => 
      array (
        'name' => 'guidelines',
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
          0 => 
          array (
            'name' => 'Override',
            'isRepeated' => false,
            'arguments' => 
            array (
            ),
          ),
        ),
        'docComment' => NULL,
        'startLine' => 83,
        'endLine' => 136,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 1,
        'namespace' => 'CoquiBot\\Toolkits\\WpCli',
        'declaringClassName' => 'CoquiBot\\Toolkits\\WpCli\\WpCliToolkit',
        'implementingClassName' => 'CoquiBot\\Toolkits\\WpCli\\WpCliToolkit',
        'currentClassName' => 'CoquiBot\\Toolkits\\WpCli\\WpCliToolkit',
        'aliasName' => NULL,
      ),
      'env' => 
      array (
        'name' => 'env',
        'parameters' => 
        array (
          'key' => 
          array (
            'name' => 'key',
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
            'startLine' => 138,
            'endLine' => 138,
            'startColumn' => 33,
            'endColumn' => 43,
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
        'startLine' => 138,
        'endLine' => 143,
        'startColumn' => 5,
        'endColumn' => 5,
        'couldThrow' => false,
        'isClosure' => false,
        'isGenerator' => false,
        'isVariadic' => false,
        'modifiers' => 20,
        'namespace' => 'CoquiBot\\Toolkits\\WpCli',
        'declaringClassName' => 'CoquiBot\\Toolkits\\WpCli\\WpCliToolkit',
        'implementingClassName' => 'CoquiBot\\Toolkits\\WpCli\\WpCliToolkit',
        'currentClassName' => 'CoquiBot\\Toolkits\\WpCli\\WpCliToolkit',
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