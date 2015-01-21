<?php

/**
 * Functions for handling how comments are displayed and used on the site. This allows more precise 
 * control over their display and makes more filter and action hooks available to developers to use in their 
 * customizations.
 *
 * @package    TSATU Homelayout
 */
function tsatu_homelayout_customize_register($wp_customize) {

    $widget_areas_names = array(
        __('One', 'tsatu-homelayout'),
        __('Two', 'tsatu-homelayout'),
        __('Three', 'tsatu-homelayout'),
        __('Four', 'tsatu-homelayout'),
        __('Five', 'tsatu-homelayout')
    );

    // Front Page
    $wp_customize->add_panel('pront_page_panel', array(
        'priority' => 107,
        'title' => __('Front Page', 'tsatu-homelayout')
    ));

    $wp_customize->add_section('general_widget_areas', array(
        'title' => __('General', 'tsatu-homelayout'),
        'priority' => 5,
        'panel' => 'pront_page_panel',
    ));

    $wp_customize->add_setting('tsatu_show_widget_areas', array(
        'default' => 0,
        'type' => 'option',
        'capability' => 'manage_options',
    ));

    $wp_customize->add_control('tsatu_show_widget_areas', array(
        'label' => __('Show customizable widget areas on Front Page', 'tsatu-homelayout'),
        'section' => 'general_widget_areas',
        'type' => 'checkbox'
    ));

    $wp_customize->add_setting('tsatu_page_content', array(
        'default' => 0,
        'type' => 'option',
        'capability' => 'manage_options',
    ));

    $wp_customize->add_control('tsatu_page_content', array(
        'label' => __('Remove content of the static page', 'tsatu-homelayout'),
        'section' => 'general_widget_areas',
        'type' => 'checkbox'
    ));

    for ($widget_area = 1; $widget_area <= 5; $widget_area++) {

        $wp_customize->add_section('widget_area_' . $widget_area, array(
            'priority' => $widget_area * 10,
            'title' => sprintf(__('Widget Area %s', 'tsatu-homelayout'), $widget_areas_names[$widget_area - 1]),
            'panel' => 'pront_page_panel'
        ));

        $wp_customize->add_setting('tsatu_columns_' . $widget_area, array(
            'default' => 0,
            'type' => 'option',
            'capability' => 'manage_options',
        ));

        $wp_customize->add_control('tsatu_columns_' . $widget_area, array(
            'label' => __('Number of columns', 'tsatu-homelayout'),
            'priority' => 5,
            'section' => 'widget_area_' . $widget_area,
            'type' => 'select',
            'choices' => array(1, 2, 3, 4, 5, 6),
        ));

        for ($col = 1; $col <= 6; $col++) {

            $wp_customize->add_setting('tsatu_home_area_' . $widget_area . '_' . $col, array(
                'default' => 5,
                'type' => 'option',
                'capability' => 'manage_options',
            ));

            $wp_customize->add_control('tsatu_home_area_' . $widget_area . '_' . $col, array(
                'label' => sprintf(__('Widget Area %1$s - %2$s/6', 'tsatu-homelayout'), $widget_areas_names[$widget_area - 1], $col),
                'priority' => $col * 10,
                'section' => 'widget_area_' . $widget_area,
                'type' => 'select',
                'choices' => array('1/12', '2/12', '3/12', '4/12', '5/12', '6/12', '7/12', '8/12', '9/12', '10/12', '11/12', '12/12'),
            ));
        }
    }
}

add_action('customize_register', 'tsatu_homelayout_customize_register');
