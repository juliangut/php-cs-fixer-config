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
use PhpCsFixer\Fixer\ClassNotation\ClassAttributesSeparationFixer;
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
        $rules = array_merge(
            parent::getFixerRules(),
            [
                ClassAttributesSeparationFixer::class => [
                    'elements' => [
                        'trait_import' => 'one',
                        'const' => 'none',
                        'property' => 'one',
                        'method' => 'one',
                        'case' => 'one',
                    ],
                ],
                NumericLiteralSeparatorFixer::class => [
                    'decimal' => true,
                    'float' => true,
                ],
            ],
        );

        // PHP-CS-Fixer 3.5
        if (class_exists(GetClassToClassKeywordFixer::class)) {
            $rules[GetClassToClassKeywordFixer::class] = true;
        }

        // PHP-CS-Fixer 3.2
        if (class_exists(AssignNullCoalescingToCoalesceEqualFixer::class)) {
            $rules[AssignNullCoalescingToCoalesceEqualFixer::class] = true;
        }
        if (class_exists(ModernizeStrposFixer::class)) {
            $rules[ModernizeStrposFixer::class] = true;
        }
        if (class_exists(OctalNotationFixer::class)) {
            $rules[OctalNotationFixer::class] = true;
        }

        // kubawerlos/php-cs-fixer-custom-fixers 3.1
        if (class_exists(MultilinePromotedPropertiesFixer::class)) {
            $rules[MultilinePromotedPropertiesFixer::class] = true;
        }
        if (class_exists(PromotedConstructorPropertyFixer::class)) {
            $rules[PromotedConstructorPropertyFixer::class] = [
                'promote_only_existing_properties' => false,
            ];
        }

        // kubawerlos/php-cs-fixer-custom-fixers 3.0
        if (class_exists(StringableInterfaceFixer::class)) {
            $rules[StringableInterfaceFixer::class] = true;
        }

        return $rules;
    }
}
