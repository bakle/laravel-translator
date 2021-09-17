<?php

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

$rules = [
    'array_indentation' => true,
    'align_multiline_comment' => true,
    'clean_namespace' => true,
    'combine_consecutive_issets' => true,
    'combine_consecutive_unsets' => true,
    'compact_nullable_typehint' => true,
    'explicit_indirect_variable' => true,
    'explicit_string_variable' => true,
    'simple_to_complex_string_variable' => true,
    'list_syntax' => [
        'syntax' => 'short'
    ],
    'no_empty_comment' => true,
    'return_type_declaration' => [
        'space_before' => 'none'
    ],
    'single_trait_insert_per_statement' => true,
    'simplified_if_return' => true,
    'protected_to_private' => true,
    'binary_operator_spaces' => [],
    'blank_line_after_namespace' => true,
    'blank_line_after_opening_tag' => true,
    'blank_line_before_statement' => [
        'statements' => ['declare', 'if', 'return', 'switch', 'try', 'while', 'for', 'foreach', 'do']
    ],
    'braces' => [
        'position_after_functions_and_oop_constructs' => 'next'
    ],
    'cast_spaces' => [
        'space' => 'none',
    ],
    'class_definition' => true,
    'concat_space' => [
        'spacing' => 'one',
    ],
    'declare_equal_normalize' => [
        'space' => 'single'
    ],
    'elseif' => true,
    'encoding' => true,
    'full_opening_tag' => true,
    'function_declaration' => true,
    'function_typehint_space' => true,
    'single_line_comment_style' => [
        'comment_types' => ['hash']
    ],
    'heredoc_to_nowdoc' => true,
    'include' => true,
    'indentation_type' => true,
    'linebreak_after_opening_tag' => true,
    'lowercase_cast' => true,
    'constant_case' => true,
    'lowercase_keywords' => true,
    'lowercase_static_reference' => true, // added from Symfony
    'magic_constant_casing' => true,
    'magic_method_casing' => true, // added from Symfony
    'method_argument_space' => [
        'keep_multiple_spaces_after_comma' => false,
        'on_multiline' => 'ensure_fully_multiline',
        'after_heredoc' => false
    ],
    'class_attributes_separation' => [
        'elements' => [
            'method' => 'one'
        ]
    ],
    'visibility_required' => [
        'elements' => ['property', 'method', 'const'],
    ],
    'native_function_casing' => true,
    'no_alias_functions' => true,
    'no_extra_blank_lines' => [
    'tokens' => [
        'extra',
        'throw',
        'use',
        'use_trait',
    ]
],
    'no_blank_lines_after_class_opening' => true,
    'no_blank_lines_after_phpdoc' => true,
    'no_closing_tag' => true,
    'no_empty_phpdoc' => true,
    'no_empty_statement' => true,
    'no_leading_import_slash' => true,
    'no_leading_namespace_whitespace' => true,
    'no_multiline_whitespace_around_double_arrow' => true,
    'multiline_whitespace_before_semicolons' => true,
    'no_short_bool_cast' => true,
    'no_spaces_around_offset' => true,
    'no_singleline_whitespace_before_semicolons' => true,
    'no_spaces_after_function_name' => true,
    'no_spaces_inside_parenthesis' => true,
    'no_trailing_comma_in_list_call' => true,
    'no_trailing_whitespace' => true,
    'no_trailing_whitespace_in_comment' => true,
    'no_unneeded_control_parentheses' => true,
    'no_unreachable_default_argument_value' => true,
    'no_useless_return' => true,
    'no_whitespace_before_comma_in_array' => true,
    'no_whitespace_in_blank_line' => true,
    'normalize_index_brace' => true,
    'not_operator_with_successor_space' => false,
    'object_operator_without_whitespace' => true,
    'ordered_imports' => ['sort_algorithm' => 'alpha'],
    'phpdoc_indent' => true,
    'phpdoc_inline_tag_normalizer' => true,
    'general_phpdoc_tag_rename' => true,
    'phpdoc_tag_type' => true,
    'phpdoc_no_access' => true,
    'phpdoc_no_package' => true,
    'phpdoc_no_useless_inheritdoc' => true,
    'phpdoc_scalar' => true,
    'phpdoc_single_line_var_spacing' => true,
    'phpdoc_summary' => true,
    'phpdoc_to_comment' => true,
    'phpdoc_trim' => true,
    'phpdoc_types' => true,
    'phpdoc_var_without_name' => true,
    'increment_style' => ['style' => 'post'],
    'no_mixed_echo_print' => true,
    'psr_autoloading' => true,
    'self_accessor' => true,
    'array_syntax' => ['syntax' => 'short'],
    'simplified_null_return' => true,
    'single_blank_line_at_eof' => true,
    'single_import_per_statement' => true,
    'single_class_element_per_statement' => true,
    'single_line_after_imports' => true,
    'single_quote' => true,
    'space_after_semicolon' => true,
    'standardize_not_equals' => true,
    'switch_case_semicolon_to_colon' => true,
    'switch_case_space' => true,
    'ternary_operator_spaces' => true,
    'trailing_comma_in_multiline' => true,
    'trim_array_spaces' => true,
    'unary_operator_spaces' => true,
    'line_ending' => true,
    'whitespace_after_comma_in_array' => true,
    'fully_qualified_strict_types' => true,
    'no_unused_imports' => true,
    'logical_operators' => true,
    'short_scalar_cast' => true,
    'no_unset_cast' => true,
    'no_trailing_comma_in_singleline_array' => true,
    'single_blank_line_before_namespace' => true,
];

$finder = Finder::create()
    ->notPath('bootstrap')
    ->notPath('storage')
    ->notPath('vendor')
    ->notPath('packages')
    ->in(getcwd())
    ->name('*.php')
    ->notName('*.blade.php')
    ->notName('index.php')
    ->notName('_ide_helper.php')
    ->notName('server.php')
    ->ignoreDotFiles(true)
    ->ignoreVCS(true);

return (new Config())
    ->setFinder($finder)
    ->setRules($rules)
    ->setRiskyAllowed(true)
    ->setUsingCache(true);
