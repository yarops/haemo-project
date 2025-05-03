const config = {
	extends: [
		'stylelint-config-standard-scss',
		'stylelint-config-idiomatic-order'
	],
	rules: {
		'selector-pseudo-class-no-unknown': null,
		'no-descending-specificity': null,
		'no-empty-source': null,
		'scss/at-rule-no-unknown': [
			true,
			{
				'ignoreAtRules': [
					'tailwind',
					'extend',
					'at-root',
					'debug',
					'warn',
					'error',
					'if',
					'else',
					'for',
					'each',
					'while',
					'mixin',
					'include',
					'content',
					'return',
					'function',
					'tailwind',
					'apply',
					'responsive',
					'variants',
					'screen',
					'use',
					'forward'
				],
			},
		],
		'selector-type-no-unknown': [true, {
			ignore: ["custom-elements", "default-namespace"],
		}]
	},
};

export default config;