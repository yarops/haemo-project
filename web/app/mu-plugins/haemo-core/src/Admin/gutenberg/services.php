<?php
function loadMyBlock() {
    wp_enqueue_script(
        'services',
        CSCORE_ASSETS_DIR_URI . '/js/services.js',
        array('wp-blocks','wp-editor'),
        true
    );
}

add_action('enqueue_block_editor_assets', 'loadMyBlock');