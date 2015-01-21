<?php

/**
 * Register home widget areas
 */
function tsatu_homelayout_generate() {

    $widget_areas_names = array(
        __('One', 'tsatu-homelayout'),
        __('Two', 'tsatu-homelayout'),
        __('Three', 'tsatu-homelayout'),
        __('Four', 'tsatu-homelayout'),
        __('Five', 'tsatu-homelayout')
    );

    if (get_option('tsatu_show_widget_areas')) {

        for ($wa = 1; $wa <= 5; $wa++) {

            $col_n = get_option('tsatu_columns_' . $wa) + 1;

            for ($cl = 1; $cl <= $col_n; $cl++) {

                register_sidebar(array(
                  'name'          => sprintf(__('Front Page Area %1$s - %2$s/%3$s', 'tsatu-homelayout'), $widget_areas_names[$wa - 1], $cl, $col_n),
                  'id'            => 'sidebar-home-' . $wa . '-' . $cl,
                  'before_widget' => '<section class="widget %1$s %2$s">',
                  'after_widget'  => '</section>',
                  'before_title'  => '<h3>',
                  'after_title'   => '</h3>',
                ));

            }

        }
    
    }
  
}
add_action('widgets_init', 'tsatu_homelayout_generate');

