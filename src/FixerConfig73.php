<?php

/*
 * (c) 2021-2022 Julián Gutiérrez <juliangut@gmail.com>
 *
 * @license BSD-3-Clause
 * @link https://github.com/juliangut/php-cs-fixer-config
 */

declare(strict_types=1);

namespace Jgut\CS\Fixer;

class FixerConfig73 extends AbstractFixerConfig
{
    /**
     * @inheritDoc
     */
    protected function getRequiredPhpVersion(): string
    {
        return '7.3.0';
    }
}
