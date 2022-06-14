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
use PhpCsFixer\Fixer\LanguageConstruct\GetClassToClassKeywordFixer;
use PhpCsFixer\Fixer\Operator\AssignNullCoalescingToCoalesceEqualFixer;
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

        // kubawerlos/php-cs-fixer-custom-fixers 3.0
        if (class_exists(StringableInterfaceFixer::class)) {
            $rules['PhpCsFixerCustomFixers/stringable_interface'] = true;
        }

        return $rules;
    }
}
