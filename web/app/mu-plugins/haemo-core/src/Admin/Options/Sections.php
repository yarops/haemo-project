<?php

/**
 * Mail Options
 */

$this->sections[] = [
    'title'  => esc_html__('Mail', 'haemo-core'),
    'icon'   => 'el-icon-credit-card',
    'fields' => [
        [
            'id'      => 'haemo_mail',
            'type'    => 'text',
            'title'   => __('Mail', 'haemo-core'),
            'default' => '',
        ],
        [
            'id'      => 'haemo_recaptcha_key',
            'type'    => 'text',
            'title'   => __('Key', 'haemo-core'),
            'default' => '',
        ],
        [
            'id'      => 'haemo_recaptcha_secret',
            'type'    => 'text',
            'title'   => __('Secret key', 'haemo-core'),
            'default' => '',
        ],
    ],
];

/**
 * Header Options
 */
$this->sections[] = [
    'title'  => esc_html__('Header', 'haemo-core'),
    'icon'   => 'el-icon-credit-card',
    'fields' => [
        [
            'id'    => 'haemo_cookies_page',
            'type'  => 'select',
            'data'  => 'pages',
            'title' => __('Cookies page', 'haemo-core'),
        ],
    ],
];

/**
 * Privacy Options
 */
$this->sections[] = [
    'title'  => esc_html__('Privacy box', 'haemo-core'),
    'icon'   => 'el-icon-credit-card',
    'fields' => [
        [
            'id'    => 'haemo_privacy_content',
            'type'  => 'editor',
            'title' => __('Content', 'haemo-core'),
        ],
    ],
];

/**
 * 404 Options
 */
$this->sections[] = [
    'title'  => esc_html__('404', 'haemo-core'),
    'icon'   => 'el-icon-credit-card',
    'fields' => [
        [
            'id'      => 'haemo_404_title',
            'type'    => 'text',
            'title'   => __('404 title', 'haemo-core'),
            'default' => 'Error 404',
        ],
        [
            'id'      => 'haemo_404_content',
            'type'    => 'editor',
            'title'   => __('404 content', 'haemo-core'),
            'default' => 'Page not found',
        ],
    ],
];

/**
 * Footer
 *
 * @author Chinh Duong Manh
 */
$this->sections[] = [
    'title'  => esc_html__('Footer', 'haemo-core'),
    'icon'   => 'el-icon-credit-card',
    'fields' => [
        [
            'id'      => 'haemo_copyright',
            'type'    => 'text',
            'title'   => __('Copyright', 'haemo-core'),
            'default' => '',
        ],
        [
            'id'      => 'haemo_counters',
            'type'    => 'textarea',
            'title'   => __('Counters', 'haemo-core'),
            'default' => '',
        ],

    ],
];
