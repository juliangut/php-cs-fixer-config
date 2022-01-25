<?php

/*
 * (c) 2021-2022 Julián Gutiérrez <juliangut@gmail.com>
 *
 * @license BSD-3-Clause
 * @see https://github.com/juliangut/php-cs-fixer-config
 */

declare(strict_types=1);

namespace Jgut\CS\Fixer;

class FixerConfig73 extends AbstractFixerConfig
{
    private const PHP73 = 70300;

    /**
     * @inheritDoc
     */
    protected function getRulesets(): array
    {
        return [
            '@PSR12' => true,
            '@PHP73Migration' => true,
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
                'assign_null_coalescing_to_coalesce_equal' => true,
                'clean_namespace' => true,
                'no_unset_cast' => true,
                'normalize_index_brace' => true,
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
        return self::PHP73;
    }
}
