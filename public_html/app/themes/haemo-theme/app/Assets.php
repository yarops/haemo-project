<?php

/**
 * Include assets
 *
 * @category WordPress theme
 * @package haemo
 */

namespace App;

use HaemoCore\Utils\Functions;

class Assets {


	/**
	 * Initialise assets hooks.
	 */
	public function __construct() {
		add_filter( 'script_loader_tag', array( $this, 'add_module_attr' ), 10, 3 );

		add_action( 'wp_enqueue_scripts', array( $this, 'provide_styles' ) );

		if (
			isset( $GLOBALS['pagenow'] ) &&
			! in_array( $GLOBALS['pagenow'], array( 'wp-login.php', 'wp-register.php' ), true )
		) {
			if ( ! is_admin() ) {
				add_action( 'wp_enqueue_scripts', array( $this, 'provide_scripts' ) );
			}
		}

		add_action( 'wp_print_scripts', array( $this, 'remove_scripts' ), 99 );
		add_action( 'wp_print_styles', array( $this, 'remove_styles' ), 99 );

		// Admin.
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts_admin' ) );
	}

	/**
	 * Setup styles/scripts in footer
	 *
	 * @return void
	 */
	public function provide_styles(): void {

		/** Custom Style */
		wp_register_style(
			'custom',
			get_template_directory_uri() . '/style.css',
			array(),
			app()->env->key,
			'all'
		);
		wp_enqueue_style( 'custom' );

		/** App Style */
		wp_register_style(
			'app',
			get_template_directory_uri() . '/dist/css/app.css',
			array(),
			app()->env->key,
			'all'
		);

		// Development.
		if ( app()->env->mode === 'development' ) {
			wp_deregister_style( 'app' );
		}

		wp_enqueue_style( 'app' );
	}

	/**
	 * Setup scripts
	 *
	 * @return void
	 */
	public function provide_scripts(): void {
		// wp_deregister_script('jquery');

		wp_register_script(
			'app',
			get_template_directory_uri() . '/dist/js/app.js',
			null,
			app()->env->key,
			true
		);

		// Development scripts.
		if ( app()->env->mode === 'development' ) {
			wp_deregister_script( 'app' );

			wp_enqueue_script(
				'vite',
				'https://localhost:8081/@vite/client',
				array(),
				time(),
				array(
					'in_footer' => true,
				)
			);

			wp_register_script(
				'app',
				'https://localhost:8081/src/ts/app.ts',
				null,
				app()->env->key,
				true
			);
		}

		wp_enqueue_script( 'app' );
		wp_localize_script(
			'app',
			'app',
			array(
				'url'   => admin_url( 'admin-ajax.php' ),
				'nonce' => wp_create_nonce( 'app-nonce' ),
				'rekey' => Functions::getSetting( 'haemo_recaptcha_key' ),
			)
		);
	}

	/**
	 * Hook for removing scripts
	 *
	 * @return void
	 */
	public function remove_scripts(): void {
		if ( ! is_admin() && isset( $scripts->registered['jquery'] ) ) {
			$script = $scripts->registered['jquery'];
			if ( $script->deps ) {
				$script->deps = array_diff( $script->deps, array( 'jquery-migrate' ) );
			}
		}
	}

	/**
	 * Hook for removing styles
	 *
	 * @return void
	 */
	public function remove_styles(): void {
		wp_deregister_style( 'redux-extendify-styles' );
	}

	public function enqueue_scripts_admin( $hook ): void {

		if ( $hook != 'post.php' ) {
			return;
		}
	}

	public function add_module_attr( string $tag, string $handle, string $src ) {
		if ( in_array( $handle, array( 'vite', 'app' ) ) ) {
			return '<script type="module" src="' . esc_url( $src ) . '" defer></script>';
		}
		return $tag;
	}
}
