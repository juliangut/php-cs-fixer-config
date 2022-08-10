<?php

/*
 * (c) 2021-2022 Julián Gutiérrez <juliangut@gmail.com>
 *
 * @license BSD-3-Clause
 * @link https://github.com/juliangut/php-cs-fixer-config
 */

declare(strict_types=1);

namespace Jgut\CS\Fixer;

use Composer\InstalledVersions;
use PhpCsFixer\Fixer\Alias\ModernizeStrposFixer;
use PhpCsFixer\Fixer\Basic\OctalNotationFixer;
use PhpCsFixer\Fixer\ClassNotation\ClassAttributesSeparationFixer;
use PhpCsFixer\Fixer\ControlStructure\TrailingCommaInMultilineFixer;
use PhpCsFixer\Fixer\LanguageConstruct\GetClassToClassKeywordFixer;
use PhpCsFixer\Fixer\Operator\AssignNullCoalescingToCoalesceEqualFixer;
use PhpCsFixer\Fixer\Operator\NoUselessNullsafeOperatorFixer;
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
                TrailingCommaInMultilineFixer::class => [
                    'elements' => ['arrays', 'arguments', 'parameters'],
                    'after_heredoc' => true,
                ],
            ],
        );

        /** @var string $phpCsFixerVersion */
        $phpCsFixerVersion = preg_replace(
            '/^v/',
            '',
            InstalledVersions::getPrettyVersion('friendsofphp/php-cs-fixer') ?? '',
        );

        if (version_compare($phpCsFixerVersion, '3.2', '>=')) {
            $rules[AssignNullCoalescingToCoalesceEqualFixer::class] = true;
            $rules[ModernizeStrposFixer::class] = true;
            $rules[OctalNotationFixer::class] = true;
        }

        if (version_compare($phpCsFixerVersion, '3.5', '>=')) {
            $rules[GetClassToClassKeywordFixer::class] = true;
        }

        if (version_compare($phpCsFixerVersion, '3.9.1', '>=')) {
            $rules[NoUselessNullsafeOperatorFixer::class] = true;
        }

        /** @var string $kubawerlosVersion */
        $kubawerlosVersion = preg_replace(
            '/^v/',
            '',
            InstalledVersions::getPrettyVersion('kubawerlos/php-cs-fixer-custom-fixers') ?? '',
        );

        if (version_compare($kubawerlosVersion, '3.0', '>=')) {
            $rules[StringableInterfaceFixer::class] = true;
        }

        if (version_compare($kubawerlosVersion, '3.1', '>=')) {
            $rules[MultilinePromotedPropertiesFixer::class] = true;
            $rules[PromotedConstructorPropertyFixer::class] = [
                'promote_only_existing_properties' => false,
            ];
        }

        return $rules;
    }
}
