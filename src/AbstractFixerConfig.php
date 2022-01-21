<?php

/*
 * (c) 2021-2022 Julián Gutiérrez <juliangut@gmail.com>
 *
 * @license BSD-3-Clause
 * @see https://github.com/juliangut/php-cs-fixer-config
 */

declare(strict_types=1);

namespace Jgut\CS\Fixer;

use PedroTroller\CS\Fixer\Fixers as PedroTrollerFixers;
use PhpCsFixerCustomFixers\Fixers as KubawerlosFixes;
use PhpCsFixer\Config;
use DateTime;

abstract class AbstractFixerConfig extends Config
{
    private ?string $header = null;

    private bool $typeInfer = false;

    /**
     * @var array<string, bool|array<string, mixed>>
     */
    private array $additionalRules = [];

    public function __construct()
    {
        parent::__construct('juliangut/phpcs-fixer-config');

        $this->setUsingCache(true);
        $this->setRiskyAllowed(true);

        $this->registerCustomFixers([
            ...new PedroTrollerFixers(),
            ...new KubawerlosFixes(),
        ]);
    }

    /**
     * @inheritDoc
     *
     * @return array<string, bool|array<string, mixed>>
     */
    final public function getRules(): array
    {
        $rules = array_merge(
            $this->getRulesets(),
            $this->getBaseRules(),
            $this->getTypeInferRules(),
            $this->additionalRules,
        );

        $header = $this->getHeader();
        if ($header !== null) {
            $rules['header_comment'] = [
                'header' => $header,
                'location' => 'after_open',
            ];
        }

        return $rules;
    }

    /**
     * @return array<string, bool|array<string, mixed>>
     */
    abstract protected function getRulesets(): array;

    /**
     * @return array<string, bool|array<string, mixed>>
     *
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    protected function getBaseRules(): array
    {
        return [
            'align_multiline_comment' => true,
            'array_push' => true,
            'array_indentation' => true,
            'binary_operator_spaces' => true,
            'blank_line_before_statement' => [
                'statements' => ['break', 'case', 'continue', 'declare', 'default', 'return', 'throw', 'try'],
            ],
            'cast_spaces' => true,
            'class_attributes_separation' => true,
            'combine_consecutive_issets' => true,
            'combine_consecutive_unsets' => true,
            'concat_space' => [
                'spacing' => 'one',
            ],
            'dir_constant' => true,
            'echo_tag_syntax' => true,
            'empty_loop_body' => [
                'style' => 'braces',
            ],
            'escape_implicit_backslashes' => true,
            'explicit_indirect_variable' => true,
            'explicit_string_variable' => true,
            'fopen_flag_order' => true,
            'fopen_flags' => true,
            'fully_qualified_strict_types' => true,
            'function_to_constant' => true,
            'function_typehint_space' => true,
            'global_namespace_import' => [
                'import_constants' => false,
                'import_functions' => false,
                'import_classes' => true,
            ],
            'heredoc_indentation' => [
                'indentation' => 'same_as_start',
            ],
            'heredoc_to_nowdoc' => true,
            'include' => true,
            'is_null' => true,
            'lambda_not_used_import' => true,
            'linebreak_after_opening_tag' => true,
            'logical_operators' => true,
            'magic_constant_casing' => true,
            'magic_method_casing' => true,
            'method_chaining_indentation' => true,
            'mb_str_functions' => true,
            'modernize_types_casting' => true,
            'multiline_comment_opening_closing' => true,
            'multiline_whitespace_before_semicolons' => true,
            'native_constant_invocation' => true,
            'native_function_casing' => true,
            'native_function_invocation' => true,
            'native_function_type_declaration_casing' => true,
            'no_alias_language_construct_call' => true,
            'no_alternative_syntax' => true,
            'no_binary_string' => true,
            'no_blank_lines_after_phpdoc' => true,
            'no_empty_comment' => true,
            'no_empty_phpdoc' => true,
            'no_empty_statement' => true,
            'no_homoglyph_names' => true,
            'no_leading_namespace_whitespace' => true,
            'no_mixed_echo_print' => true,
            'no_multiline_whitespace_around_double_arrow' => true,
            'no_null_property_initialization' => true,
            'no_short_bool_cast' => true,
            'no_singleline_whitespace_before_semicolons' => true,
            'no_spaces_around_offset' => true,
            'no_superfluous_elseif' => true,
            'no_superfluous_phpdoc_tags' => true,
            'no_trailing_comma_in_singleline_array' => true,
            'no_unneeded_control_parentheses' => true,
            'no_unneeded_curly_braces' => [
                'namespaces' => true,
            ],
            'no_unset_on_property' => true,
            'no_unused_imports' => true,
            'no_useless_else' => true,
            'no_useless_sprintf' => true,
            'no_useless_return' => true,
            'nullable_type_declaration_for_default_null_value' => true,
            'object_operator_without_whitespace' => true,
            'operator_linebreak' => true,
            'PedroTroller/comment_line_to_phpdoc_block' => true,
            'PedroTroller/exceptions_punctuation' => true,
            'PedroTroller/line_break_between_method_arguments' => [
                'max-args' => false,
            ],
            'PhpCsFixerCustomFixers/comment_surrounded_by_spaces' => true,
            'PhpCsFixerCustomFixers/constructor_empty_braces' => true,
            'PhpCsFixerCustomFixers/no_commented_out_code' => true,
            'PhpCsFixerCustomFixers/no_duplicated_array_key' => true,
            'PhpCsFixerCustomFixers/no_leading_slash_in_global_namespace' => true,
            'PhpCsFixerCustomFixers/no_nullable_boolean_type' => true,
            'PhpCsFixerCustomFixers/no_superfluous_concatenation' => [
                'allow_preventing_trailing_spaces' => true,
            ],
            'PhpCsFixerCustomFixers/no_useless_dirname_call' => true,
            'PhpCsFixerCustomFixers/no_useless_parenthesis' => true,
            'PhpCsFixerCustomFixers/no_useless_strlen' => true,
            'PhpCsFixerCustomFixers/numeric_literal_separator' => [
                'decimal' => true,
                'float' => true,
            ],
            'PhpCsFixerCustomFixers/phpdoc_array_style' => true,
            'PhpCsFixerCustomFixers/phpdoc_param_order' => true,
            'php_unit_construct' => true,
            'php_unit_internal_class' => true,
            'php_unit_mock_short_will_return' => true,
            'php_unit_set_up_tear_down_visibility' => true,
            'php_unit_test_annotation' => true,
            'php_unit_test_case_static_method_calls' => true,
            'phpdoc_add_missing_param_annotation' => true,
            'phpdoc_align' => true,
            'phpdoc_annotation_without_dot' => true,
            'phpdoc_indent' => true,
            'phpdoc_inline_tag_normalizer' => true,
            'phpdoc_no_access' => true,
            'phpdoc_no_alias_tag' => true,
            'phpdoc_no_empty_return' => true,
            'phpdoc_no_package' => true,
            'phpdoc_no_useless_inheritdoc' => true,
            'phpdoc_order' => true,
            'phpdoc_return_self_reference' => true,
            'phpdoc_scalar' => true,
            'phpdoc_separation' => true,
            'phpdoc_single_line_var_spacing' => true,
            'phpdoc_summary' => true,
            'phpdoc_tag_casing' => true,
            'phpdoc_tag_type' => true,
            'phpdoc_to_comment' => true,
            'phpdoc_trim_consecutive_blank_line_separation' => true,
            'phpdoc_trim' => true,
            'phpdoc_types' => true,
            'phpdoc_types_order' => [
                'sort_algorithm' => 'none',
                'null_adjustment' => 'always_last',
            ],
            'phpdoc_var_without_name' => true,
            'protected_to_private' => true,
            'psr_autoloading' => true,
            'regular_callable_call' => true,
            'return_assignment' => true,
            'self_accessor' => true,
            'self_static_accessor' => true,
            'semicolon_after_instruction' => true,
            'set_type_to_cast' => true,
            'simple_to_complex_string_variable' => true,
            'simplified_null_return' => true,
            'single_line_comment_style' => true,
            'single_quote' => true,
            'space_after_semicolon' => true,
            'standardize_increment' => true,
            'standardize_not_equals' => true,
            'static_lambda' => true,
            'strict_comparison' => true,
            'strict_param' => true,
            'string_line_ending' => true,
            'switch_continue_to_break' => true,
            'trim_array_spaces' => true,
            'unary_operator_spaces' => true,
            'whitespace_after_comma_in_array' => true,
            'yoda_style' => [
                'equal' => false,
                'identical' => false,
                'less_and_greater' => false,
            ],
        ];
    }

    /**
     * @return array<string, bool|array<string, mixed>>
     */
    protected function getTypeInferRules(): array
    {
        return $this->typeInfer === true
            ? [
                // Watch out! these are experimental rules
                'phpdoc_to_param_type' => true,
                'phpdoc_to_property_type' => true,
                'phpdoc_to_return_type' => true,
            ]
            : [];
    }

    /**
     * @param array<string, bool|array<string, mixed>> $additionalRules
     */
    final public function setAdditionalRules(array $additionalRules): void
    {
        $this->additionalRules = $additionalRules;
    }

    final public function setHeader(string $header): self
    {
        $this->header = $header;

        return $this;
    }

    private function getHeader(): ?string
    {
        if ($this->header === null) {
            return null;
        }

        $header = str_replace(
            ['/**', ' */', ' * ', ' *', '{{year}}'],
            ['', '', '', '', (new DateTime('now'))->format('Y')],
            $this->header,
        );

        return trim($header) !== '' ? trim($header) : null;
    }

    final public function setTypeInfer(bool $typeInfer): self
    {
        $this->typeInfer = $typeInfer;

        return $this;
    }
}
