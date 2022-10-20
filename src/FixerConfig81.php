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
use PhpCsFixer\Fixer\Basic\OctalNotationFixer;
use PhpCsFixer\Fixer\ClassNotation\ClassAttributesSeparationFixer;

/**
 * @phpstan-import-type PhpCsFixerRuleList from AbstractFixerConfig
 */
class FixerConfig81 extends FixerConfig80
{
    protected function getRequiredPhpVersion(): string
    {
        return '8.1.0';
    }

    protected function getFixerRules(): array
    {
        return array_merge(
            parent::getFixerRules(),
            $this->getPhpCsFixerRules(),
        );
    }

    /**
     * @return PhpCsFixerRuleList
     */
    private function getPhpCsFixerRules(): array
    {
        $rules = [];

        /** @var string $phpCsFixerVersion */
        $phpCsFixerVersion = preg_replace(
            '/^v/',
            '',
            InstalledVersions::getPrettyVersion('friendsofphp/php-cs-fixer') ?? '',
        );

        if (version_compare($phpCsFixerVersion, '3.2', '>=')) {
            $rules[OctalNotationFixer::class] = true;
        }

        if (version_compare($phpCsFixerVersion, '3.7', '>=')) {
            $rules[ClassAttributesSeparationFixer::class] = [
                'elements' => [
                    'trait_import' => 'one',
                    'const' => 'none',
                    'property' => 'one',
                    'method' => 'one',
                    'case' => 'one',
                ],
            ];
        }

        return $rules;
    }
}
