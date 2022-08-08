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

class FixerConfig73 extends AbstractFixerConfig
{
    /**
     * @inheritDoc
     */
    protected function getRequiredPhpVersion(): string
    {
        return '7.3.0';
    }

    /**
     * @inheritDoc
     */
    protected function getFixerRules(): array
    {
        return array_merge(
            parent::getFixerRules(),
            [
                TrailingCommaInMultilineFixer::class => [
                    'elements' => ['arrays', 'arguments'],
                    'after_heredoc' => true,
                ],
            ],
        );
    }
}
