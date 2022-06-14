<?php

/*
 * (c) 2021-2022 Julián Gutiérrez <juliangut@gmail.com>
 *
 * @license BSD-3-Clause
 * @see https://github.com/juliangut/php-cs-fixer-config
 */

declare(strict_types=1);

namespace Jgut\CS\Fixer;

use Composer\InstalledVersions;
use DateTime;
use PedroTroller\CS\Fixer\Fixers as PedroTrollerFixers;
use PhpCsFixer\Config;
use PhpCsFixer\Fixer\Casing\ClassReferenceNameCasingFixer;
use PhpCsFixer\Fixer\Casing\IntegerLiteralCaseFixer;
use PhpCsFixer\Fixer\Comment\SingleLineCommentSpacingFixer;
use PhpCsFixer\Fixer\ControlStructure\EmptyLoopBodyFixer;
use PhpCsFixer\Fixer\FunctionNotation\DateTimeCreateFromFormatCallFixer;
use PhpCsFixer\Fixer\FunctionNotation\NoTrailingCommaInSinglelineFunctionCallFixer;
use PhpCsFixer\Fixer\Import\NoUnneededImportAliasFixer;
use PhpCsFixer\Fixer\LanguageConstruct\DeclareParenthesesFixer;
use PhpCsFixer\Fixer\StringNotation\StringLengthToEmptyFixer;
use PhpCsFixer\Fixer\Whitespace\TypesSpacesFixer;
use PhpCsFixerCustomFixers\Fixer\IssetToArrayKeyExistsFixer;
use PhpCsFixerCustomFixers\Fixer\NoDuplicatedArrayKeyFixer;
use PhpCsFixerCustomFixers\Fixer\NoTrailingCommaInSinglelineFixer;
use PhpCsFixerCustomFixers\Fixer\NoUselessDirnameCallFixer;
use PhpCsFixerCustomFixers\Fixer\NoUselessParenthesisFixer;
use PhpCsFixerCustomFixers\Fixer\PhpdocArrayStyleFixer;
use PhpCsFixerCustomFixers\Fixer\PhpdocTypesCommaSpacesFixer;
use PhpCsFixerCustomFixers\Fixers as KubawerlosFixes;
use RuntimeException;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
abstract class AbstractFixerConfig extends Config
{
    /**
     * @var string|null
     */
    private $header;

    /**
     * @var bool
     */
    private $typeInfer = false;

    /**
     * @var bool
     */
    private $phpUnit = false;

    /**
     * @var array<string, bool|array<string, mixed>>
     */
    private $additionalRules = [];

    public function __construct()
    {
        if (version_compare($this->getRequiredPhpVersion(), \PHP_VERSION, '>')) {
            throw new RuntimeException(sprintf(
                'Minimum required PHP version is "%s", current version is "%s".',
                $this->getRequiredPhpVersion(),
                \PHP_VERSION,
            ));
        }

        parent::__construct('juliangut/php-cs-fixer-config');

        $this
            ->setUsingCache(true)
            ->setRiskyAllowed(true)
            ->registerCustomFixers(new KubawerlosFixes())
            ->registerCustomFixers(new PedroTrollerFixers());
    }

    abstract protected function getRequiredPhpVersion(): string;

    /**
     * @inheritDoc
     *
     * @return array<string, bool|array<string, mixed>>
     */
    final public function getRules(): array
    {
        $rules = $this->getFixerRules();

        $header = $this->getHeader();
        if ($header !== null) {
            $rules['header_comment'] = [
                'header' => $header,
                'comment_type' => 'comment',
                'location' => 'after_open',
                'separate' => 'both',
            ];
        }

        ksort($rules, \SORT_NATURAL);

        return $rules;
    }

    /**
     * @return array<string, bool|array<string, mixed>>
     *
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    protected function getFixerRules(): array
    {
        $rules = [
            '@PSR12' => true,
            'align_multiline_comment' => [
                'comment_type' => 'phpdocs_like',
            ],
            'array_indentation' => true,
            'array_push' => true,
            'backtick_to_shell_exec' => true,
            'binary_operator_spaces' => [
                'default' => 'single_space',
            ],
            'blank_line_before_statement' => [
                'statements' => ['case', 'continue', 'declare', 'default', 'return', 'throw', 'try'],
            ],
            'cast_spaces' => [
                'space' => 'single',
            ],
            'class_attributes_separation' => [
                'elements' => [
                    'const' => 'one',
                    'method' => 'one',
                    'property' => 'one',
                    'trait_import' => 'none',
                ],
            ],
            'clean_namespace' => true,
            'combine_consecutive_issets' => true,
            'combine_consecutive_unsets' => true,
            'combine_nested_dirname' => true,
            'concat_space' => [
                'spacing' => 'one',
            ],
            'control_structure_continuation_position' => [
                'position' => 'same_line',
            ],
            // 'date_time_immutable' => true,
            'declare_strict_types' => true,
            'dir_constant' => true,
            'echo_tag_syntax' => [
                'format' => 'long',
                'long_function' => 'echo',
                'shorten_simple_statements_only' => true,
            ],
            'ereg_to_preg' => true,
            'error_suppression' => [
                'mute_deprecation_error' => false,
                'noise_remaining_usages' => false,
            ],
            'escape_implicit_backslashes' => [
                'double_quoted' => true,
                'heredoc_syntax' => true,
                'single_quoted' => false,
            ],
            'explicit_indirect_variable' => true,
            'explicit_string_variable' => true,
            // 'final_class' => true,
            // 'final_public_method_for_abstract_class' => true,
            'fopen_flag_order' => true,
            'fopen_flags' => [
                'b_mode' => true,
            ],
            'fully_qualified_strict_types' => true,
            'function_to_constant' => [
                'functions' => ['get_called_class', 'get_class', 'get_class_this', 'php_sapi_name', 'phpversion', 'pi'],
            ],
            'function_typehint_space' => true,
            'general_phpdoc_tag_rename' => [
                'replacements' => [
                    'inheritDocs' => 'inheritDoc',
                ],
                'fix_annotation' => true,
                'fix_inline' => true,
                'case_sensitive' => false,
            ],
            'global_namespace_import' => [
                'import_classes' => true,
                'import_functions' => false,
                'import_constants' => false,
            ],
            'heredoc_indentation' => [
                'indentation' => 'same_as_start',
            ],
            'heredoc_to_nowdoc' => true,
            'implode_call' => true,
            'include' => true,
            'increment_style' => [
                'style' => 'pre',
            ],
            'is_null' => true,
            'lambda_not_used_import' => true,
            'linebreak_after_opening_tag' => true,
            'list_syntax' => [
                'syntax' => 'short',
            ],
            'logical_operators' => true,
            'magic_constant_casing' => true,
            'magic_method_casing' => true,
            'mb_str_functions' => true,
            'method_argument_space' => [
                'after_heredoc' => true,
                'keep_multiple_spaces_after_comma' => false,
                'on_multiline' => 'ensure_fully_multiline',
            ],
            'method_chaining_indentation' => true,
            'modernize_types_casting' => true,
            'multiline_comment_opening_closing' => true,
            'multiline_whitespace_before_semicolons' => [
                'strategy' => 'no_multi_line',
            ],
            'native_constant_invocation' => [
                'exclude' => ['null', 'false', 'true'],
                'fix_built_in' => true,
                'scope' => 'all',
                'strict' => true,
            ],
            'native_function_casing' => true,
            'native_function_invocation' => [
                'include' => ['@compiler_optimized'],
                'scope' => 'all',
                'strict' => true,
            ],
            'native_function_type_declaration_casing' => true,
            'no_alias_functions' => [
                'sets' => ['@all'],
            ],
            'no_alias_language_construct_call' => true,
            'no_alternative_syntax' => true,
            'no_binary_string' => true,
            'no_blank_lines_after_phpdoc' => true,
            'no_empty_comment' => true,
            'no_empty_phpdoc' => true,
            'no_empty_statement' => true,
            'no_homoglyph_names' => true,
            'no_leading_namespace_whitespace' => true,
            'no_mixed_echo_print' => [
                'use' => 'echo',
            ],
            'no_multiline_whitespace_around_double_arrow' => true,
            'no_null_property_initialization' => true,
            'no_php4_constructor' => true,
            'no_short_bool_cast' => true,
            'no_singleline_whitespace_before_semicolons' => true,
            'no_spaces_around_offset' => [
                'positions' => ['inside', 'outside'],
            ],
            'no_superfluous_elseif' => true,
            'no_superfluous_phpdoc_tags' => [
                'allow_mixed' => false,
                'allow_unused_params' => false,
            ],
            'no_trailing_comma_in_singleline_array' => true,
            'no_trailing_whitespace_in_string' => true,
            'no_unneeded_control_parentheses' => [
                'statements' => ['break', 'clone', 'continue', 'echo_print', 'return', 'switch_case', 'yield'],
            ],
            'no_unneeded_curly_braces' => [
                'namespaces' => true,
            ],
            'no_unneeded_final_method' => [
                'private_methods' => true,
            ],
            'no_unreachable_default_argument_value' => true,
            'no_unset_cast' => true,
            'no_unset_on_property' => true,
            'no_unused_imports' => true,
            'no_useless_else' => true,
            'no_useless_sprintf' => true,
            'no_useless_return' => true,
            'no_whitespace_before_comma_in_array' => [
                'after_heredoc' => true,
            ],
            'non_printable_character' => [
                'use_escape_sequences_in_strings' => false,
            ],
            'normalize_index_brace' => true,
            'nullable_type_declaration_for_default_null_value' => [
                'use_nullable_type_declaration' => true,
            ],
            'object_operator_without_whitespace' => true,
            'operator_linebreak' => [
                'position' => 'beginning',
                'only_booleans' => false,
            ],
            'ordered_imports' => [
                'imports_order' => ['class', 'function', 'const'],
                'sort_algorithm' => 'alpha',
            ],
            'PedroTroller/comment_line_to_phpdoc_block' => true,
            'PedroTroller/exceptions_punctuation' => true,
            'PedroTroller/line_break_between_method_arguments' => [
                'max-args' => false,
            ],
            'PhpCsFixerCustomFixers/comment_surrounded_by_spaces' => true,
            'PhpCsFixerCustomFixers/no_commented_out_code' => true,
            'PhpCsFixerCustomFixers/no_leading_slash_in_global_namespace' => true,
            'PhpCsFixerCustomFixers/no_nullable_boolean_type' => true,
            'PhpCsFixerCustomFixers/no_superfluous_concatenation' => [
                'allow_preventing_trailing_spaces' => true,
            ],
            'PhpCsFixerCustomFixers/no_useless_comment' => true,
            'PhpCsFixerCustomFixers/phpdoc_param_order' => true,
            'PhpCsFixerCustomFixers/phpdoc_param_type' => true,
            'PhpCsFixerCustomFixers/phpdoc_self_accessor' => true,
            'PhpCsFixerCustomFixers/phpdoc_types_trim' => true,
            'phpdoc_add_missing_param_annotation' => [
                'only_untyped' => true,
            ],
            'phpdoc_align' => [
                'align' => 'vertical',
                'tags' => ['method', 'param', 'property', 'return', 'throws', 'type', 'var'],
            ],
            'phpdoc_annotation_without_dot' => true,
            'phpdoc_indent' => true,
            'phpdoc_inline_tag_normalizer' => true,
            'phpdoc_line_span' => [
                'const' => 'single',
                'property' => 'multi',
                'method' => 'multi',
            ],
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
            'phpdoc_tag_type' => [
                'tags' => [
                    'api' => 'annotation',
                    'author' => 'annotation',
                    'copyright' => 'annotation',
                    'deprecated' => 'annotation',
                    'example' => 'annotation',
                    'global' => 'annotation',
                    'internal' => 'annotation',
                    'license' => 'annotation',
                    'method' => 'annotation',
                    'param' => 'annotation',
                    'property' => 'annotation',
                    'return' => 'annotation',
                    'see' => 'annotation',
                    'since' => 'annotation',
                    'throws' => 'annotation',
                    'todo' => 'annotation',
                    'uses' => 'annotation',
                    'var' => 'annotation',
                    'version' => 'annotation',
                ],
            ],
            'phpdoc_trim' => true,
            'phpdoc_trim_consecutive_blank_line_separation' => true,
            'phpdoc_types' => true,
            'phpdoc_types_order' => [
                'sort_algorithm' => 'none',
                'null_adjustment' => 'always_last',
            ],
            'phpdoc_var_without_name' => true,
            'pow_to_exponentiation' => true,
            'protected_to_private' => true,
            'psr_autoloading' => true,
            'random_api_migration' => true,
            'regular_callable_call' => true,
            'return_assignment' => true,
            'self_accessor' => true,
            'self_static_accessor' => true,
            'semicolon_after_instruction' => true,
            'set_type_to_cast' => true,
            'simple_to_complex_string_variable' => true,
            'simplified_if_return' => true,
            'simplified_null_return' => true,
            'single_line_comment_style' => [
                'comment_types' => ['asterisk', 'hash'],
            ],
            'single_quote' => [
                'strings_containing_single_quote_chars' => true,
            ],
            'single_space_after_construct' => true,
            'space_after_semicolon' => [
                'remove_in_empty_for_expressions' => false,
            ],
            'standardize_increment' => true,
            'standardize_not_equals' => true,
            'static_lambda' => true,
            'strict_comparison' => true,
            'strict_param' => true,
            'string_line_ending' => true,
            'switch_continue_to_break' => true,
            'ternary_to_elvis_operator' => true,
            'ternary_to_null_coalescing' => true,
            'trailing_comma_in_multiline' => [
                'elements' => ['arrays', 'arguments', 'parameters'],
                'after_heredoc' => true,
            ],
            'trim_array_spaces' => true,
            'unary_operator_spaces' => true,
            'use_arrow_functions' => true,
            'void_return' => true,
            'whitespace_after_comma_in_array' => true,
            'yoda_style' => [
                'equal' => false,
                'identical' => false,
                'less_and_greater' => false,
                'always_move_variable' => false,
            ],
        ];

        // PHP-CS-Fixer 3.8
        if (class_exists(DateTimeCreateFromFormatCallFixer::class)) {
            $rules['date_time_create_from_format_call'] = true;
        }

        // PHP-CS-Fixer 3.7
        if (class_exists(NoTrailingCommaInSinglelineFunctionCallFixer::class)) {
            $rules['no_trailing_comma_in_singleline_function_call'] = true;
        }
        if (class_exists(SingleLineCommentSpacingFixer::class)) {
            $rules['single_line_comment_spacing'] = true;
        }

        // PHP-CS-Fixer 3.6
        if (class_exists(ClassReferenceNameCasingFixer::class)) {
            $rules['class_reference_name_casing'] = true;
        }
        if (class_exists(NoUnneededImportAliasFixer::class)) {
            $rules['no_unneeded_import_alias'] = true;
        }

        // PHP-CS-Fixer 3.4
        if (class_exists(DeclareParenthesesFixer::class)) {
            $rules['declare_parentheses'] = true;
        }

        // PHP-CS-Fixer 3.2
        if (class_exists(IntegerLiteralCaseFixer::class)) {
            $rules['integer_literal_case'] = true;
        }
        if (class_exists(StringLengthToEmptyFixer::class)) {
            $rules['string_length_to_empty'] = true;
        }

        // PHP-CS-Fixer 3.1
        if (class_exists(EmptyLoopBodyFixer::class)) {
            $rules['empty_loop_body'] = [
                'style' => 'braces',
            ];
        }
        if (class_exists(TypesSpacesFixer::class)) {
            $rules['types_spaces'] = [
                'space' => 'none',
            ];
        }

        // kubawerlos/php-cs-fixer-custom-fixers 3.9
        if (class_exists(PhpdocTypesCommaSpacesFixer::class)) {
            $rules['PhpCsFixerCustomFixers/phpdoc_types_comma_spaces'] = true;
        }

        // kubawerlos/php-cs-fixer-custom-fixers 3.7
        if (class_exists(NoTrailingCommaInSinglelineFixer::class)) {
            $rules['PhpCsFixerCustomFixers/no_trailing_comma_in_singleline'] = true;
        }

        // kubawerlos/php-cs-fixer-custom-fixers 3.6
        if (class_exists(IssetToArrayKeyExistsFixer::class)) {
            $rules['PhpCsFixerCustomFixers/isset_to_array_key_exists'] = true;
        }

        // kubawerlos/php-cs-fixer-custom-fixers 3.5
        if (class_exists(NoUselessDirnameCallFixer::class)) {
            $rules['PhpCsFixerCustomFixers/no_useless_dirname_call'] = true;
        }

        // kubawerlos/php-cs-fixer-custom-fixers 3.1
        if (class_exists(PhpdocArrayStyleFixer::class)) {
            $rules['PhpCsFixerCustomFixers/phpdoc_array_style'] = true;
        }

        // kubawerlos/php-cs-fixer-custom-fixers 3.0
        if (class_exists(NoDuplicatedArrayKeyFixer::class)) {
            $rules['PhpCsFixerCustomFixers/no_duplicated_array_key'] = [
                'ignore_expressions' => true,
            ];
        }
        if (class_exists(NoUselessParenthesisFixer::class)) {
            $rules['PhpCsFixerCustomFixers/no_useless_parenthesis'] = true;
        }

        return array_merge(
            $rules,
            $this->getPhpUnitRules(),
            $this->getTypeInferRules(),
            $this->additionalRules,
        );
    }

    /**
     * @return array<string, bool|array<string, mixed>>
     */
    private function getPhpUnitRules(): array
    {
        if ($this->phpUnit === false) {
            return [];
        }

        return [
            'PhpCsFixerCustomFixers/data_provider_name' => [
                'prefix' => '',
                'suffix' => 'Provider',
            ],
            'php_unit_construct' => [
                'assertions' => ['assertEquals', 'assertSame', 'assertNotEquals', 'assertNotSame'],
            ],
            'php_unit_dedicate_assert' => [
                'target' => '5.6',
            ],
            'php_unit_dedicate_assert_internal_type' => [
                'target' => '7.5',
            ],
            'php_unit_expectation' => [
                'target' => '8.4',
            ],
            'php_unit_internal_class' => [
                'types' => ['normal', 'final', 'abstract'],
            ],
            'php_unit_method_casing' => [
                'case' => 'camel_case',
            ],
            'php_unit_mock' => [
                'target' => '5.5',
            ],
            'php_unit_mock_short_will_return' => true,
            'php_unit_namespaced' => [
                'target' => '6.0',
            ],
            'php_unit_no_expectation_annotation' => [
                'target' => '4.3',
                'use_class_const' => true,
            ],
            'php_unit_set_up_tear_down_visibility' => true,
            // 'php_unit_size_class' => [
            //     'small',
            //     'medium',
            //     'large',
            // ],
            // 'php_unit_strict' => [
            //     'assertAttributeEquals',
            //     'assertAttributeNotEquals',
            //     'assertEquals',
            //     'assertNotEquals',
            // ],
            'php_unit_test_annotation' => [
                'style' => 'prefix',
            ],
            'php_unit_test_case_static_method_calls' => [
                'call_type' => 'static',
            ],
            // 'php_unit_test_class_requires_covers' => true,
        ];
    }

    /**
     * These are experimental rules.
     *
     * @return array<string, bool|array<string, mixed>>
     */
    private function getTypeInferRules(): array
    {
        if ($this->typeInfer === false) {
            return [];
        }

        return [
            'phpdoc_to_param_type' => true,
            'phpdoc_to_property_type' => true,
            'phpdoc_to_return_type' => true,
        ];
    }

    /**
     * @param array<string, bool|array<string, mixed>> $additionalRules
     */
    final public function setAdditionalRules(array $additionalRules): self
    {
        $this->additionalRules = $additionalRules;

        return $this;
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
            ['/**', ' */', ' * ', ' *', '{{year}}', '{{package}}'],
            ['', '', '', '', (new DateTime('now'))->format('Y'), InstalledVersions::getRootPackage()['name']],
            $this->header,
        );

        return trim($header) !== '' ? trim($header) : null;
    }

    final public function enablePhpUnitRules(bool $phpUnit = true): self
    {
        $this->phpUnit = $phpUnit;

        return $this;
    }

    final public function enableTypeInferRules(bool $typeInfer = true): self
    {
        $this->typeInfer = $typeInfer;

        return $this;
    }
}
