<?php
/**
 * Custom Nav Walker for Mobile Menu (No Children)
 */

if ( ! class_exists( 'Resplandor_Mobile_No_Children_Walker' ) ) {
    class Resplandor_Mobile_No_Children_Walker extends Walker_Nav_Menu {
        public function start_lvl( &$output, $depth = 0, $args = null ) {
            // No drop-downs allowed
        }

        public function end_lvl( &$output, $depth = 0, $args = null ) {
            // No drop-downs allowed
        }

        public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
            if ( $depth > 0 ) return; // Skip sub-levels

            $classes = empty( $item->classes ) ? array() : (array) $item->classes;
            $has_children = in_array( 'menu-item-has-children', $classes );
            
            if ( $has_children ) {
                return; // Skip items with children entirely
            }

            $title = apply_filters( 'the_title', $item->title, $item->ID );
            
            $atts = array();
            $atts['href']   = ! empty( $item->url ) ? $item->url : '';
            if ( ! empty( $item->target ) ) $atts['target'] = $item->target;
            if ( ! empty( $item->xfn ) )    $atts['rel']    = $item->xfn;

            $attributes = '';
            foreach ( $atts as $attr => $value ) {
                if ( ! empty( $value ) ) {
                    $value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
                    $attributes .= ' ' . $attr . '="' . $value . '"';
                }
            }
            
            $icon_src = esc_url( get_template_directory_uri() ) . '/img/bala.svg';
            
            $output .= '<a class="drawer-link"' . $attributes . '>';
            $output .= '<img src="' . $icon_src . '" class="drawer-icon" alt="" aria-hidden="true" />';
            $output .= '<span>' . $title . '</span>';
        }

        public function end_el( &$output, $item, $depth = 0, $args = null ) {
            if ( $depth > 0 ) return;
            $classes = empty( $item->classes ) ? array() : (array) $item->classes;
            $has_children = in_array( 'menu-item-has-children', $classes );
            
            if ( $has_children ) return;

            $output .= "</a>\n";
        }
    }
}
