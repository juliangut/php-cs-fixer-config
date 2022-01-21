<?php

/*
 * (c) 2021-2022 Julián Gutiérrez <juliangut@gmail.com>
 *
 * @license BSD-3-Clause
 *
 * @see https://github.com/juliangut/php-cs-fixer-config
 */

declare(strict_types=1);

use Jgut\CS\Fixer\FixerConfig74;
use PhpCsFixer\Finder;

$header = <<<'HEADER'
(c) 2021-{{year}} Julián Gutiérrez <juliangut@gmail.com>

@license BSD-3-Clause

@see https://github.com/juliangut/php-cs-fixer-config
HEADER;

$finder = Finder::create()
    ->ignoreDotFiles(false)
    ->exclude(['vendor'])
    ->in(__DIR__)
    ->name('.php-cs-fixer.php');

return (new FixerConfig74($header))
    ->setFinder($finder);
