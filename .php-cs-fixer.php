<?php

/*
 * (c) 2021-2022 Julián Gutiérrez <juliangut@gmail.com>
 *
 * @license BSD-3-Clause
 * @link https://github.com/juliangut/php-cs-fixer-config
 */

declare(strict_types=1);

use Jgut\CS\Fixer\FixerConfig73;
use Jgut\CS\Fixer\FixerConfig74;
use Jgut\CS\Fixer\FixerConfig80;
use Jgut\CS\Fixer\FixerConfig81;
use PhpCsFixer\Finder;
use PhpCsFixerCustomFixers\Fixer\NumericLiteralSeparatorFixer;

$header = <<<'HEADER'
(c) 2021-{{year}} Julián Gutiérrez <juliangut@gmail.com>

@license BSD-3-Clause
@link https://github.com/juliangut/php-cs-fixer-config
HEADER;

$finder = Finder::create()
    ->ignoreDotFiles(false)
    ->exclude(['vendor'])
    ->in(__DIR__)
    ->name('.php-cs-fixer.php');

if (\PHP_VERSION_ID >= 80100) {
    $configurator = (new FixerConfig81())
        ->setAdditionalRules([
            NumericLiteralSeparatorFixer::class => false,
        ]);
} elseif (\PHP_VERSION_ID >= 80000) {
    $configurator = (new FixerConfig80())
        ->setAdditionalRules([
            NumericLiteralSeparatorFixer::class => false,
        ]);
} elseif (\PHP_VERSION_ID >= 70400) {
    $configurator = (new FixerConfig74())
        ->setAdditionalRules([
            NumericLiteralSeparatorFixer::class => false,
        ]);
} else {
    $configurator = new FixerConfig73();
}

return $configurator
    ->setHeader($header)
    ->setFinder($finder);
