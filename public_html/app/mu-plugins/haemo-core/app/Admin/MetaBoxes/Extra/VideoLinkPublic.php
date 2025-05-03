<?php

/**
 * Get public link class
 *
 * @author Yaroslav Popov <ed.creater@gmail.com>
 * @package HaemoCore
 */

namespace HaemoCore\Admin\MetaBoxes\Extra;

use JetBrains\PhpStorm\NoReturn;

/**
 * Class for register meta boxes for video post type
 */
class VideoLinkPublic
{
    /**
     * Add action for register meta boxes
     */
    public function __construct()
    {
        // Ajax actions
        add_action('wp_ajax_get_video_link', [$this, 'ajaxFillPublicLink']);

        // Admin actions
        add_action(
            'acf/render_field/key=haemo_video_link',
            [$this, 'renderGetButton']
        );
    }

    /**
     * Display button
     *
     * @return void
     */
    public function renderGetButton(): void
    {
        echo '<a href="#" class="acf-button button js-get-public-video">Get public link</a>';
        echo $this->buttonJs();
    }

    /**
     * Add js action
     *
     * @return string
     */
    public function buttonJs(): string
    {
        $res = <<<JS
        <script>
            
        </script>
        JS;

        return $res;
    }

    /**
     * Fill public link
     *
     * @return void
     */
    #[NoReturn] public function ajaxFillPublicLink(): void
    {
        $data = json_decode(stripcslashes($_POST['data']), true);

        if (!empty($data['postId']) && !empty($data['link'])) {
            $getfileLink = stripcslashes('https://getfile.dokpub.com/yandex/get/' . $data['link']);

            $response = wp_remote_get(
                $getfileLink,
                [
                    'redirection' => 0,
                    'timeout' => 10,
                ]
            );

            if (!is_wp_error($response)) {
                $headers = wp_remote_retrieve_headers($response);

                $data = [
                    'status'      => 'success',
                    'public_link' => $headers['location'],
                ];

                wp_send_json($data);
            } else {
                error_log($response->get_error_message());
            }
        }

        wp_die();
    }
}
