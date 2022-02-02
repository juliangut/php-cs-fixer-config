<?php

/*
 * (c) 2021-2022 Julián Gutiérrez <juliangut@gmail.com>
 *
 * @license BSD-3-Clause
 * @see https://github.com/juliangut/php-cs-fixer-config
 */

declare(strict_types=1);

namespace Jgut\CS\Fixer;

class FixerConfig74 extends AbstractFixerConfig
{
    private const PHP_VERSION = 70400;

    /**
     * @inheritDoc
     */
    protected function getRulesets(): array
    {
        return [
            '@PSR12' => true,
            '@PHP74Migration' => true,
        ];
    }

    /**
     * @inheritDoc
     */
    protected function getCommonRules(): array
    {
        return array_merge(
            parent::getCommonRules(),
            [
                'clean_namespace' => true,
                'no_unset_cast' => true,
                'PhpCsFixerCustomFixers/numeric_literal_separator' => [
                    'decimal' => true,
                    'float' => true,
                ],
                'trailing_comma_in_multiline' => [
                    'elements' => ['arrays', 'arguments'],
                ],
            ],
        );
    }

    /**
     * @inheritDoc
     */
    protected function getMinimumPhpVersion(): int
    {
        return self::PHP_VERSION;
    }
}
