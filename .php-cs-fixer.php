<?php

/*
 * (c) 2021-2023 Julián Gutiérrez <juliangut@gmail.com>
 *
 * @license BSD-3-Clause
 * @link https://github.com/juliangut/php-cs-fixer-config
 */

declare(strict_types=1);

use Jgut\CS\Fixer\FixerConfig74;
use Jgut\CS\Fixer\FixerConfig80;
use Jgut\CS\Fixer\FixerConfig81;
use PhpCsFixer\Finder;

$header = <<<'HEADER'
(c) 2021-{{year}} Julián Gutiérrez <juliangut@gmail.com>

@license BSD-3-Clause
@link https://github.com/juliangut/php-cs-fixer-config
HEADER;

$finder = Finder::create()
    ->ignoreDotFiles(false)
    ->exclude(['vendor'])
    ->in(__DIR__)
    ->name(__FILE__);

if (\PHP_VERSION_ID >= 80_100) {
    $configurator = new FixerConfig81();
} elseif (\PHP_VERSION_ID >= 80_000) {
    $configurator = new FixerConfig80();
} else {
    $configurator = new FixerConfig74();
}

return $configurator
    ->setHeader($header)
    ->setFinder($finder);
