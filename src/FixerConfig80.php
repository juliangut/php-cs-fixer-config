<?php

/*
 * (c) 2021-2022 Julián Gutiérrez <juliangut@gmail.com>
 *
 * @license BSD-3-Clause
 * @see https://github.com/juliangut/php-cs-fixer-config
 */

declare(strict_types=1);

namespace Jgut\CS\Fixer;

class FixerConfig80 extends AbstractFixerConfig
{
    /**
     * @inheritDoc
     */
    protected function getRulesets(): array
    {
        return [
            '@PSR12' => true,
            '@PHP80Migration' => true,
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
                'get_class_to_class_keyword' => true,
                'modernize_strpos' => true,
                'PhpCsFixerCustomFixers/stringable_interface' => true,
                'trailing_comma_in_multiline' => [
                    'elements' => ['arrays', 'arguments', 'parameters'],
                ],
            ],
        );
    }
}