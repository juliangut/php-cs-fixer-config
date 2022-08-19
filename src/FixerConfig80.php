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
use PhpCsFixer\Fixer\ControlStructure\TrailingCommaInMultilineFixer;
use PhpCsFixer\Fixer\LanguageConstruct\GetClassToClassKeywordFixer;
use PhpCsFixer\Fixer\Operator\NoUselessNullsafeOperatorFixer;
use PhpCsFixerCustomFixers\Fixer\MultilinePromotedPropertiesFixer;
use PhpCsFixerCustomFixers\Fixer\PromotedConstructorPropertyFixer;
use PhpCsFixerCustomFixers\Fixer\StringableInterfaceFixer;

class FixerConfig80 extends FixerConfig74
{
    protected function getRequiredPhpVersion(): string
    {
        return '8.0.0';
    }

    protected function getFixerRules(): array
    {
        $rules = array_merge(
            parent::getFixerRules(),
            [
                // friendsofphp/php-cs-fixer
                TrailingCommaInMultilineFixer::class => [
                    'elements' => ['arrays', 'arguments', 'parameters'],
                    'after_heredoc' => true,
                ],

                // kubawerlos/php-cs-fixer-custom-fixers
                MultilinePromotedPropertiesFixer::class => true,
                PromotedConstructorPropertyFixer::class => [
                    'promote_only_existing_properties' => false,
                ],
                StringableInterfaceFixer::class => true,
            ],
        );

        /** @var string $phpCsFixerVersion */
        $phpCsFixerVersion = preg_replace(
            '/^v/',
            '',
            InstalledVersions::getPrettyVersion('friendsofphp/php-cs-fixer') ?? '',
        );

        if (version_compare($phpCsFixerVersion, '3.2', '>=')) {
            $rules[ModernizeStrposFixer::class] = true;
        }

        if (version_compare($phpCsFixerVersion, '3.5', '>=')) {
            $rules[GetClassToClassKeywordFixer::class] = true;
        }

        if (version_compare($phpCsFixerVersion, '3.9.1', '>=')) {
            $rules[NoUselessNullsafeOperatorFixer::class] = true;
        }

        return $rules;
    }
}
