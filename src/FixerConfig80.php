<?php

/*
 * (c) 2021-2022 Julián Gutiérrez <juliangut@gmail.com>
 *
 * @license BSD-3-Clause
 * @link https://github.com/juliangut/php-cs-fixer-config
 */

declare(strict_types=1);

namespace Jgut\CS\Fixer;

use PhpCsFixer\Fixer\Alias\ModernizeStrposFixer;
use PhpCsFixer\Fixer\LanguageConstruct\GetClassToClassKeywordFixer;
use PhpCsFixer\Fixer\Operator\AssignNullCoalescingToCoalesceEqualFixer;
use PhpCsFixerCustomFixers\Fixer\NumericLiteralSeparatorFixer;
use PhpCsFixerCustomFixers\Fixer\StringableInterfaceFixer;

class FixerConfig80 extends AbstractFixerConfig
{
    /**
     * @inheritDoc
     */
    protected function getRequiredPhpVersion(): string
    {
        return '8.0.0';
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
                GetClassToClassKeywordFixer::class => true,
                ModernizeStrposFixer::class => true,
                NumericLiteralSeparatorFixer::class => [
                    'decimal' => true,
                    'float' => true,
                ],
                StringableInterfaceFixer::class => true,
            ],
        );
    }
}
