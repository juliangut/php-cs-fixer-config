<?php

/*
 * (c) 2021-2023 Julián Gutiérrez <juliangut@gmail.com>
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

/**
 * @phpstan-import-type PhpCsFixerRuleList from AbstractFixerConfig
 */
class FixerConfig80 extends FixerConfig74
{
    protected function getRequiredPhpVersion(): string
    {
        return '8.0.0';
    }

    protected function getFixerRules(): array
    {
        return array_merge(
            parent::getFixerRules(),
            $this->getPhpCsFixerRules(),
            $this->getKubawerlosFixerRules(),
        );
    }

    /**
     * @return PhpCsFixerRuleList
     */
    private function getPhpCsFixerRules(): array
    {
        $rules = [
            TrailingCommaInMultilineFixer::class => [
                'elements' => ['arrays', 'arguments', 'parameters'],
                'after_heredoc' => true,
            ],
        ];

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

    /**
     * @return PhpCsFixerRuleList
     */
    private function getKubawerlosFixerRules(): array
    {
        return [
            MultilinePromotedPropertiesFixer::class => true,
            PromotedConstructorPropertyFixer::class => [
                'promote_only_existing_properties' => false,
            ],
            StringableInterfaceFixer::class => true,
        ];
    }
}
