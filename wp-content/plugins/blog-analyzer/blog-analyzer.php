<?php
/*
Plugin Name: Blog Analyzer
Description: Analyzes posts for word count and density for a specific keyword
Version: 1.0
Author: Stefan Mitrevski
*/

require_once plugin_dir_path(__FILE__) . 'includes/main.php';
require_once plugin_dir_path(__FILE__) . 'includes/api.php';

function ba_enqueue_scripts() {
    wp_enqueue_script('jquery');
    wp_enqueue_script('jquery-datatables', 'https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js', array('jquery'), '1.10.22', true);
    wp_enqueue_style('jquery-datatables', 'https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css');
    wp_enqueue_script('ba-custom-script', plugin_dir_url(__FILE__) . 'js/ba-custom-script.js', array('jquery', 'jquery-datatables'), '1.0', true);
}
add_action('admin_enqueue_scripts', 'ba_enqueue_scripts');

function ba_add_menu_item() {
    add_menu_page('Blog Analyzer', 'Blog Analyzer', 'manage_options', 'blog-analyzer', 'ba_display_page');
}
add_action('admin_menu', 'ba_add_menu_item');
