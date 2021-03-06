[![PHP version](https://img.shields.io/badge/PHP-%3E%3D7.4-8892BF.svg?style=flat-square)](http://php.net)
[![Latest Version](https://img.shields.io/packagist/v/juliangut/php-cs-fixer-config.svg?style=flat-square)](https://packagist.org/packages/juliangut/php-cs-fixer-config)
[![License](https://img.shields.io/github/license/juliangut/php-cs-fixer-config.svg?style=flat-square)](https://github.com/juliangut/php-cs-fixer-config/blob/master/LICENSE)

[![Total Downloads](https://img.shields.io/packagist/dt/juliangut/php-cs-fixer-config.svg?style=flat-square)](https://packagist.org/packages/juliangut/php-cs-fixer-config/stats)
[![Monthly Downloads](https://img.shields.io/packagist/dm/juliangut/php-cs-fixer-config.svg?style=flat-square)](https://packagist.org/packages/juliangut/php-cs-fixer-config/stats)

# php-cs-fixer-config

Opinionated as can be configuration defaults for [PHP-CS-Fixer](https://github.com/FriendsOfPhp/PHP-CS-Fixer)

Configurations for PHPUnit assumes version 8.4 or newer is being used

## Installation

### Composer

```
composer require --dev juliangut/php-cs-fixer-config
```

## Usage

Create `.php-cs-fixer.php` file at your project's root directory

```php
<?php

use Jgut\CS\Fixer\FixerConfig80;
use PhpCsFixer\Finder;

$finder = Finder::create()
    ->ignoreDotFiles(false)
    ->exclude(['vendor'])
    ->in(__DIR__)
    ->name('.php-cs-fixer.php');

return (new FixerConfig80())
    ->setFinder($finder);
```

Use one of the provided configurations depending on the PHP version you want to support:

* `Jgut\CS\Fixer\FixerConfig73`, PHP >= 7.3
* `Jgut\CS\Fixer\FixerConfig74`, PHP >= 7.4
* `Jgut\CS\Fixer\FixerConfig80`, PHP >= 8.0
* `Jgut\CS\Fixer\FixerConfig81`, PHP >= 8.1

Add `.php-cs-fixer.cache` to your `.gitignore` file

### Configurations

#### Header

Provide a header string, it will be prepended to every file analysed by php-cs-fixer.

The string `{{year}}` will be replaced by the current year, and the string `{{package}}` will be replaced by your package name

```php
return (new FixerConfig80())
    ->setHeader(<<<'HEADER'
(c) 2021-{{year}} Juli??n Guti??rrez <juliangut@gmail.com>

This file is part of package {{package}}
HEADER);
```

```diff
--- Original
+++ New
 <?php

+/*
+ * (c) 2021-2022 Juli??n Guti??rrez <juliangut@gmail.com>
+ *
+ * This file is part of package juliangut/php-cs-fixer-config
+ */
+
 declare(strict_types=1);

 namespace App;
```

#### PHPUnit

If you work with PHPUnit

```php
return (new FixerConfig80())
    ->enablePhpUnitRules();
```

#### Type Infer

If you're in the middle of "type hinting everything", you could enable type inference rules and let php-cs-fixer try to migrate types from annotations into properties, parameters and returns

Be aware these rules are experimental and will need human supervision after fixing, so you are advised NOT to permanently enable type inference

```php
return (new FixerConfig80())
    ->enableTypeInferRules();
```

```diff
--- Original
+++ New
<?php

 declare(strict_types=1);

 namespace App;
 
 class Foo
 {
-    /**
-     * @var string|null
-     */
-    protected $foo
+    protected ?string $foo

-    /**
-     * @var Bar
-     */
-    protected $bar
+    protected Bar $bar

-    /**
-     * @var bool
-     */
-    protected $baz
+    protected bool $baz

     /**
      * Foo constructor.
-     *
-     * @param string|null $foo
-     * @param Bar         $bar
-     * @param bool        $baz
      */
-    public function __construct($foo, $bar, $baz = false)
+    public function __construct(?string $foo, Bar $bar, bool $baz = false)
     {
         $this->foo = $foo;
         $this->bar = $bar;
         $this->baz = $baz;
     }

-    /**
-     * @return bool
-     *
-    public function isBaz()
+    public function isBaz(): bool
     {
        return $this->baz;
     }
 }
```

#### Additional rules

Additional rules can be added, this rules can be new or override rules already set

```php
return (new FixerConfig80())
    ->setHeader($header)
    ->setAdditionalRules([
        'single_line_throw' => true,
    ])
    ->setFinder($finder);
```

#### Custom fixer config

If you need more control over applied rules or prefer a cleaner setup, you can easily create your custom fixer config instead of setting additional rules

```php
use Jgut\CS\Fixer\FixerConfig80;

class CustomFixerConfig extends FixerConfig80
{
    protected function getRequiredPhpVersion(): string
    {
        return '8.1.0';
    }

    protected function getFixerRules(): array
    {
        // Return your custom rules, or add/remove rules from parent::getFixerRules()
    }
}
```

## Contributing

Found a bug or have a feature request? [Please open a new issue](https://github.com/juliangut/php-cs-fixer-config/issues). Have a look at existing issues before.

See file [CONTRIBUTING.md](https://github.com/juliangut/php-cs-fixer-config/blob/master/CONTRIBUTING.md)

## License

See file [LICENSE](https://github.com/juliangut/php-cs-fixer-config/blob/master/LICENSE) included with the source code for a copy of the license terms.
