<?php

/**
 * Created by Ed.Creater<ed.creater@gmail.com>.
 * Site: CodeSweet.ru
 * Date: 01.08.2016
 */
namespace HaemoCore\Shortcodes;

class CS_Grid_Shortcodes {

    public $params;

    function __construct() {

        add_shortcode('bs_row', array( $this, 'bs_row' ));
        add_shortcode( 'bs-col-3', array( $this, 'bs_col_3' ) );
        add_shortcode( 'bs-col-2', array( $this, 'bs_col_2' ) );

        add_filter('the_content', array( $this, 'bs_fix_shortcodes'));

	    /**
	     * Add admin button
	     */
	    add_filter('mce_external_plugins', array($this, 'csShortcodes_register'));
	    add_filter('mce_buttons', array($this, 'csShortcodes_add_button'), 0);

    }


    function bs_fix_shortcodes($content){
        $array = array (
            '<p>[' => '[',
            ']</p>' => ']',
            ']<br />' => ']',
            ']<br>' => ']'
        );

        $content = strtr($content, $array);
        return $content;
    }

    function bs_row( $params, $content=null ) {
        $class = '';

        extract( shortcode_atts( array(
            'class' => 'l-grid'
        ), $params ) );
        $content = preg_replace( '/<br class="nc".\/>/', '', $content );
        $result = '<div class="' . $class . '">';
        $result .= do_shortcode( $content );
        $result .= '</div>';
        return force_balance_tags( $result );
    }

    function bs_col_2( $params, $content=null ) {
        $class = '';

        extract( shortcode_atts( array(
            'class' => 'l-col-6'
        ), $params ) );

        $result = '<div class="' . $class . '">';
        $result .= do_shortcode( $content );
        $result .= '</div>';
        return force_balance_tags( $result );
    }

    function bs_col_3( $params, $content=null ) {
        $class = '';

        extract( shortcode_atts( array(
            'class' => 'l-col-4'
        ), $params ) );

        $result = '<div class="' . $class . '">';
        $result .= do_shortcode( $content );
        $result .= '</div>';
        return force_balance_tags( $result );
    }

	function csShortcodes_add_button($buttons)
	{
		array_push($buttons, "separator", "csShortcodes");
		return $buttons;
	}

	function csShortcodes_register($plugin_array)
	{
		$url = trim(CSCORE_SHORTCODES_DIR_URI . '/assets/mceShortcodes.js');

		$plugin_array['csShortcodes'] = $url;
		return $plugin_array;
	}

}