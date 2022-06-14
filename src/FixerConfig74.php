<?php

/*
 * (c) 2021-2022 Julián Gutiérrez <juliangut@gmail.com>
 *
 * @license BSD-3-Clause
 * @see https://github.com/juliangut/php-cs-fixer-config
 */

declare(strict_types=1);

namespace Jgut\CS\Fixer;

use PhpCsFixer\Fixer\Operator\AssignNullCoalescingToCoalesceEqualFixer;

class FixerConfig74 extends AbstractFixerConfig
{
    /**
     * @inheritDoc
     */
    protected function getRequiredPhpVersion(): string
    {
        return '7.4.0';
    }

    /**
     * @inheritDoc
     */
    protected function getFixerRules(): array
    {
        $rules = array_merge(
            parent::getFixerRules(),
            [
                'PhpCsFixerCustomFixers/numeric_literal_separator' => [
                    'decimal' => true,
                    'float' => true,
                ],
                'trailing_comma_in_multiline' => [
                    'elements' => ['arrays', 'arguments'],
                    'after_heredoc' => true,
                ],
            ],
        );

        // PHP-CS-Fixer 3.2
        if (class_exists(AssignNullCoalescingToCoalesceEqualFixer::class)) {
            $rules['assign_null_coalescing_to_coalesce_equal'] = true;
        }

        return $rules;
    }
}
