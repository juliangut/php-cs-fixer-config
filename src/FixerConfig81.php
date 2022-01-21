<?php

/*
 * (c) 2021-2022 Julián Gutiérrez <juliangut@gmail.com>
 *
 * @license BSD-3-Clause
 * @see https://github.com/juliangut/php-cs-fixer-config
 */

declare(strict_types=1);

namespace Jgut\CS\Fixer;

class FixerConfig81 extends AbstractConfig
{
    /**
     * @inheritDoc
     */
    protected function getRulesets(): array
    {
        return [
            '@PSR12' => true,
            '@PSR12:risky' => true,
            '@PHP80Migration:risky' => true,
            '@PHP81Migration' => true,
            '@PHPUnit84Migration:risky' => true,
        ];
    }

    /**
     * @inheritDoc
     */
    protected function getBaseRules(): array
    {
        return array_merge(
            parent::getBaseRules(),
            [
                'PhpCsFixerCustomFixers/multiline_promoted_properties' => true,
                'PhpCsFixerCustomFixers/promoted_constructor_property' => true,
                'PhpCsFixerCustomFixers/stringable_interface' => true,
                'trailing_comma_in_multiline' => [
                    'elements' => ['arrays', 'arguments', 'parameters'],
                ],
            ],
        );
    }
}
