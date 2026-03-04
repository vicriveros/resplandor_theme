<?php
/**
 * Custom Nav Walker for Resplandor Theme
 */

if ( ! class_exists( 'Resplandor_Nav_Walker' ) ) {
    class Resplandor_Nav_Walker extends Walker_Nav_Menu {
        public function start_lvl( &$output, $depth = 0, $args = null ) {
            $output .= "\n<div class=\"dropdown-menu\">\n";
        }

        public function end_lvl( &$output, $depth = 0, $args = null ) {
            $output .= "</div>\n";
        }

        public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
            $classes = empty( $item->classes ) ? array() : (array) $item->classes;
            $has_children = in_array( 'menu-item-has-children', $classes );
            $title = apply_filters( 'the_title', $item->title, $item->ID );
            
            if ( $depth === 0 && $has_children ) {
                $output .= '<div class="nav-dropdown">';
                $output .= '<button class="nav-link" type="button" aria-expanded="false">';
                $output .= esc_html( $title );
                $output .= ' <svg class="nav-caret" width="12" height="12" viewBox="0 0 24 24" fill="none"><path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>';
                $output .= '</button>';
            } else {
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
                
                $output .= '<a' . $attributes . '>';
                $output .= $title;
            }
        }

        public function end_el( &$output, $item, $depth = 0, $args = null ) {
            $classes = empty( $item->classes ) ? array() : (array) $item->classes;
            $has_children = in_array( 'menu-item-has-children', $classes );
            
            if ( $depth === 0 && $has_children ) {
                $output .= "</div>\n";
            } else {
                $output .= "</a>\n";
            }
        }
    }
}
