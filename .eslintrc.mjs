import prettier from 'eslint-plugin-prettier';
import vue from 'eslint-plugin-vue';
import js from '@eslint/js';
import tseslint from '@typescript-eslint/eslint-plugin';
import tsparser from '@typescript-eslint/parser';

export default [
	js.configs.recommended,
	...tseslint.configs.recommended,
	...vue.configs['flat/recommended'],
	{
		ignores: ['node_modules/**', 'storage/**']
	},
	{
		files: ['**/*.js', '**/*.vue'],
		languageOptions: {
			globals: {
				_: 'readonly',
				route: 'readonly',
				browser: true,
				node: true
			},
			parserOptions: {
				ecmaVersion: 12,
				sourceType: 'module',
				parser: tsparser
			}
		},
		plugins: {
			prettier
		},
		rules: {
			'vue/html-indent': 'off',
			'prettier/prettier': [
				'error',
				{
					singleAttributePerLine: true
				}
			],
			'vue/require-default-prop': 'off',
			'vue/singleline-html-element-content-newline': 'off',
			'vue/multi-word-component-names': 'off',
			'vue/component-name-in-template-casing': ['error', 'PascalCase'],
			'vue/max-attributes-per-line': [
				'error',
				{
					singleline: {
						max: 1
					},
					multiline: {
						max: 1
					}
				}
			]
		}
	}
];
