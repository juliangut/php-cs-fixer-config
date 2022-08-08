<?php

/*
 * (c) 2021-2022 Julián Gutiérrez <juliangut@gmail.com>
 *
 * @license BSD-3-Clause
 * @link https://github.com/juliangut/php-cs-fixer-config
 */

declare(strict_types=1);

namespace Jgut\CS\Fixer;

use PhpCsFixer\Fixer\ControlStructure\TrailingCommaInMultilineFixer;
use PhpCsFixer\Fixer\Operator\AssignNullCoalescingToCoalesceEqualFixer;
use PhpCsFixerCustomFixers\Fixer\NumericLiteralSeparatorFixer;

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
        return array_merge(
            parent::getFixerRules(),
            [
                AssignNullCoalescingToCoalesceEqualFixer::class => true,
                NumericLiteralSeparatorFixer::class => [
                    'decimal' => true,
                    'float' => true,
                ],
                TrailingCommaInMultilineFixer::class => [
                    'elements' => ['arrays', 'arguments'],
                    'after_heredoc' => true,
                ],
            ],
        );
    }
}
