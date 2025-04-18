<?php

/**
 * App App class file
 *
 * @author Yaroslav Popov <ed.creater@gmail.com>
 * @package olo-stick
 */

namespace App;

use App\Controllers\LibraryController;
use App\Modules\Images;
use App\Modules\Likes;
use App\Modules\Promo;
use App\Modules\Rating;
use App\Modules\Related;

/**
 * App class of App
 */
class App
{
    /**
     * Environment object
     *
     * @var object
     */
    public $env;

    /**
     * Images object
     *
     * @var images
     */
    public $images;

    /**
     * Comments object
     *
     * @var object
     */
    public $comments;

    /**
     * Recaptcha object
     *
     * @var object
     */
    public $recaptcha;

    /**
     * Rating object
     *
     * @var object
     */
    public $rating;

    /**
     * Likes object
     *
     * @var likes
     */
    public $likes;

    /**
     * Instance of app.
     *
     * @var object
     */
    private static $instance;

    /**
     * Construct instance off App class
     */
    public function __construct()
    {
        require_once "Utils/theme-functions.php";

        $this->env = new Env();
        $this->images = new Images();
        $this->comments = new Comments();
        $this->recaptcha = new Recaptcha();
        $this->rating = new Rating();
        $this->likes = new Likes();

        new LibraryController();
        new Assets();
        new Mailsender();

        add_action('after_setup_theme', [$this, 'load_textdomain']);
        add_action('template_redirect', [$this, 'template_loaders']);
    }

    /**
     * Access method for the plugin.
     *
     * @return App
     */
    public static function instance()
    {
        if (is_null(static::$instance)) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    /**
     * Load theme textdomain
     *
     * @return void
     */
    function load_textdomain()
    {
        load_theme_textdomain('haemo', get_template_directory() . '/languages');
    }

    /**
     * Load objects after WP query
     *
     * @return void
     */
    function template_loaders()
    {

    }
}
