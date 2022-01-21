<?php

/*
 * (c) 2021-2022 Julián Gutiérrez <juliangut@gmail.com>
 *
 * @license BSD-3-Clause
 * @see https://github.com/juliangut/php-cs-fixer-config
 */

declare(strict_types=1);

namespace Jgut\CS\Fixer;

class FixerConfig74 extends AbstractConfig
{
    /**
     * @inheritDoc
     */
    protected function getRulesets(): array
    {
        return [
            '@PSR12' => true,
            '@PSR12:risky' => true,
            '@PHP74Migration' => true,
            '@PHP74Migration:risky' => true,
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
                'clean_namespace' => true,
                'no_alias_functions' => [
                    'sets' => ['@all'],
                ],
                'no_php4_constructor' => true,
                'no_unneeded_final_method' => true,
                'no_unset_cast' => true,
                'trailing_comma_in_multiline' => [
                    'elements' => ['arrays', 'arguments'],
                ],
            ],
        );
    }
}
