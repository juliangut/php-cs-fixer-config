<?php

/*
 * (c) 2021-2022 Julián Gutiérrez <juliangut@gmail.com>
 *
 * @license BSD-3-Clause
 * @see https://github.com/juliangut/php-cs-fixer-config
 */

declare(strict_types=1);

namespace Jgut\CS\Fixer;

use PhpCsFixer\Fixer\Alias\ModernizeStrposFixer;
use PhpCsFixer\Fixer\Basic\OctalNotationFixer;
use PhpCsFixer\Fixer\LanguageConstruct\GetClassToClassKeywordFixer;
use PhpCsFixer\Fixer\Operator\AssignNullCoalescingToCoalesceEqualFixer;
use PhpCsFixerCustomFixers\Fixer\MultilinePromotedPropertiesFixer;
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
        $rules = parent::getFixerRules();

        $rules['PhpCsFixerCustomFixers/numeric_literal_separator'] = [
            'decimal' => true,
            'float' => true,
        ];

        // PHP-CS-Fixer 3.5
        if (class_exists(GetClassToClassKeywordFixer::class)) {
            $rules['get_class_to_class_keyword'] = true;
        }

        // PHP-CS-Fixer 3.2
        if (class_exists(AssignNullCoalescingToCoalesceEqualFixer::class)) {
            $rules['assign_null_coalescing_to_coalesce_equal'] = true;
        }
        if (class_exists(ModernizeStrposFixer::class)) {
            $rules['modernize_strpos'] = true;
        }
        if (class_exists(OctalNotationFixer::class)) {
            $rules['octal_notation'] = true;
        }

        // kubawerlos/php-cs-fixer-custom-fixers 3.1
        if (class_exists(MultilinePromotedPropertiesFixer::class)) {
            $rules['PhpCsFixerCustomFixers/multiline_promoted_properties'] = [
                'promote_only_existing_properties' => false,
            ];
        }
        if (class_exists(PromotedConstructorPropertyFixer::class)) {
            $rules['PhpCsFixerCustomFixers/promoted_constructor_property'] = true;
        }

        // kubawerlos/php-cs-fixer-custom-fixers 3.0
        if (class_exists(StringableInterfaceFixer::class)) {
            $rules['PhpCsFixerCustomFixers/stringable_interface'] = true;
        }

        return $rules;
    }
}
