<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function insert_homelayout($content)
{
    if (is_front_page() && !is_home() && (get_option('page_on_front') == get_the_ID()) && get_option('tsatu_show_widget_areas')) {
        
        ob_start();

        echo '<section class="home-section">';

        for ($wa = 1; $wa <= 5; $wa++) {

            if (!get_option('tsatu_columns_' . $wa)) {
                $col_n = 1;
            } else {
                $col_n = get_option('tsatu_columns_' . $wa) + 1;
            }
            echo '<div class="row home-area-' . $wa . '">';

            for ($cl = 1; $cl <= $col_n; $cl++) {

                if (!get_option('tsatu_home_area_' . $wa . '_' . $cl)) {
                    $col_width = 6;
                } else {
                    $col_width = (get_option('tsatu_home_area_' . $wa . '_' . $cl) + 1);
                }
                echo '<div class="col-md-' . $col_width . '">';
                dynamic_sidebar(sanitize_title('sidebar-home-' . $wa . '-' . $cl));
                echo '</div>';
            }
            echo '<div class="clear"></div></div>';

        }
        echo '</section>';

        if (get_option('tsatu_page_content')) {
            $content = ob_get_clean();
        } else {
            $content .= ob_get_clean();
        }
    }

    return $content;
}

add_filter('the_content', 'insert_homelayout');
