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
use PhpCsFixer\Fixer\Basic\OctalNotationFixer;
use PhpCsFixer\Fixer\LanguageConstruct\GetClassToClassKeywordFixer;
use PhpCsFixer\Fixer\Operator\AssignNullCoalescingToCoalesceEqualFixer;
use PhpCsFixerCustomFixers\Fixer\MultilinePromotedPropertiesFixer;
use PhpCsFixerCustomFixers\Fixer\NumericLiteralSeparatorFixer;
use PhpCsFixerCustomFixers\Fixer\PromotedConstructorPropertyFixer;
use PhpCsFixerCustomFixers\Fixer\StringableInterfaceFixer;

class FixerConfig81 extends AbstractFixerConfig
{
    /**
     * @inheritDoc
     */
    protected function getRequiredPhpVersion(): string
    {
        return '8.1.0';
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
                MultilinePromotedPropertiesFixer::class => true,
                NumericLiteralSeparatorFixer::class => [
                    'decimal' => true,
                    'float' => true,
                ],
                OctalNotationFixer::class => true,
                PromotedConstructorPropertyFixer::class => [
                    'promote_only_existing_properties' => false,
                ],
                StringableInterfaceFixer::class => true,
            ],
        );
    }
}
