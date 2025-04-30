<?php
/**
 * Multi Textarea Field.
 *
 * @package     ReduxFramework/Fields
 * @author      Dovy Paukstys & Kevin Provance (kprovance)
 * @version     4.0.0
 */

defined( 'ABSPATH' ) || exit;

// Don't duplicate me!
if ( ! class_exists( 'ReduxFramework_multi_textarea', false ) ) {

    /**
     * Main Redux_multi_textarea class
     *
     * @since       1.0.0
     */
    class ReduxFramework_multi_textarea {

        /**
         * Field Constructor.
         *
         * Required - must call the parent constructor, then assign field and value to vars, and obviously call the render field function
         *
         * @since       1.0.0
         * @access      public
         * @return      void
         */
        function __construct( $field = array(), $value ='', $parent ) {


            $this->parent = $parent;
            $this->field = $field;
            $this->value = $value;

            if ( empty( $this->extension_dir ) ) {
                $this->extension_dir = trailingslashit( str_replace( '\\', '/', dirname( __FILE__ ) ) );
                $this->extension_url = site_url( str_replace( trailingslashit( str_replace( '\\', '/', ABSPATH ) ), '', $this->extension_dir ) );
            }

            // Set default args for this field to avoid bad indexes. Change this to anything you use.
            $defaults = array(
                'options'           => array(),
                'stylesheet'        => '',
                'output'            => true,
                'enqueue'           => true,
                'enqueue_frontend'  => true,
                'show_empty' => true,
                'add_text'   => esc_html__( 'Add More', 'redux-framework' ),
            );
            $this->field = wp_parse_args( $this->field, $defaults );

        }

        /**
         * Field Render Function.
         * Takes the vars and outputs the HTML for the field in the settings
         *
         * @since       1.0.0
         * @access      public
         * @return      void
         */
        public function render() {
            echo '<ul id="' . esc_attr( $this->field['id'] ) . '-ul" class="redux-multi-textarea ' . esc_attr( $this->field['class'] ) . '">';

            if ( isset( $this->value ) && is_array( $this->value ) ) {
                foreach ( $this->value as $k => $value ) {
                    if ( '' !== $value || ( true === $this->field['show_empty'] ) ) {
                        echo '<li>';
                        echo '<textarea
								id="' . esc_attr( $this->field['id'] . '-' . $k ) . '"
								name="' . esc_attr( $this->field['name'] . $this->field['name_suffix'] ) . '[]"
								rows="5"
								class="regular-text">' . esc_attr( $value ) . '</textarea> ';

                        echo '<a
								data-id="' . esc_attr( $this->field['id'] ) . '-ul"
								href="javascript:void(0);"
								class="deletion redux-multi-textarea-remove">' .
                            esc_html__( 'Remove', 'redux-framework' ) . '</a>';
                        echo '</li>';
                    }
                }
            } elseif ( true === $this->field['show_empty'] ) {
                echo '<li>';
                echo '<textarea
						id="' . esc_attr( $this->field['id'] . '-0' ) . '"
						name="' . esc_attr( $this->field['name'] . $this->field['name_suffix'] ) . '[]"
						rows="5"
						class="regular-text"></textarea> ';

                echo '<a
						data-id="' . esc_attr( $this->field['id'] ) . '-ul"
						href="javascript:void(0);"
						class="deletion redux-multi-textarea-remove">' .
                    esc_html__( 'Remove', 'redux-framework' ) . '</a>';

                echo '</li>';
            }

            $the_name = '';
            if ( isset( $this->value ) && empty( $this->value ) && false === $this->field['show_empty'] ) {
                $the_name = $this->field['name'] . $this->field['name_suffix'];
            }

            echo '<li style="display:none;">';
            echo '<textarea
					id="' . esc_attr( $this->field['id'] ) . '"
					name="' . esc_attr( $the_name ) . '"
					rows="5"
					class="regular-text"></textarea> ';

            echo '<a
					data-id="' . esc_attr( $this->field['id'] ) . '-ul"
					href="javascript:void(0);"
					class="deletion redux-multi-textarea-remove">' .
                esc_html__( 'Remove', 'redux-framework' ) . '</a>';

            echo '</li>';
            echo '</ul>';

            echo '<span style="clear:both;display:block;height:0;"></span>';
            $this->field['add_number'] = ( isset( $this->field['add_number'] ) && is_numeric( $this->field['add_number'] ) ) ? $this->field['add_number'] : 1;
            echo '<a href="javascript:void(0);" class="button button-primary redux-multi-textarea-add" data-add_number="' . esc_attr( $this->field['add_number'] ) . '" data-id="' . esc_attr( $this->field['id'] ) . '-ul" data-name="' . esc_attr( $this->field['name'] . $this->field['name_suffix'] ) . '">' . esc_html( $this->field['add_text'] ) . '</a><br/>';
        }

        /**
         * Enqueue Function.
         * If this field requires any scripts, or css define this function and register/enqueue the scripts/css
         *
         * @since       1.0.0
         * @access      public
         * @return      void
         */
        public function enqueue() {
            wp_enqueue_script(
                'redux-field-multi-textarea-js',
                $this->extension_url . 'redux-multi-textarea.js',
                array( 'jquery', 'redux-js' ),
                time(),
                true
            );

            if ( $this->parent->args['dev_mode'] ) {
                wp_enqueue_style(
                    'redux-field-multi-textarea-css',
                    $this->extension_url . 'redux-multi-textarea.css',
                    array(),
                    time(),
                );
            }
        }
    }
}