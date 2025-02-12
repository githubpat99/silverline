<?php
// Register navigation menus
register_nav_menus( array(
    'menu-1' => __( 'Primary Menu', 'my-custom-theme' ),
) );

// Add theme support
add_theme_support( 'post-thumbnails' );
add_theme_support( 'title-tag' );
add_image_size( 'my-custom-image-size', 640, 999 );

// Enqueue scripts and styles
function my_custom_theme_enqueue() {
    wp_enqueue_style('my-custom-theme-style', get_stylesheet_uri(), array(), null, 'all');
    wp_enqueue_script('my-custom-theme-script', get_template_directory_uri() . '/js/custom.js', array('jquery'), null, true);
    wp_enqueue_script('calculate-kpis', get_template_directory_uri() . '/js/calculate-kpis.js', array('jquery'), null, true);

    error_log('LOGGING - SERVER-SIDE Enqueue scripts and styles');
}
add_action('wp_enqueue_scripts', 'my_custom_theme_enqueue');

error_log('LOGGING - SERVER-SIDE GENERAL FUNCTIONS');

// Enqueue Google Charts script
function my_theme_google_charts() {
    wp_enqueue_script('google-charts', 'https://www.gstatic.com/charts/loader.js', array(), null, true);
}
add_action('wp_enqueue_scripts', 'my_theme_google_charts');

function create_kpi_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'kpis';

    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        user_id bigint(20) NOT NULL,
        bank varchar(255) NOT NULL,
        depot varchar(255) NOT NULL,
        akfr varchar(255) NOT NULL,
        immo varchar(255) NOT NULL,
        priv varchar(255) NOT NULL,
        agh varchar(255) NOT NULL,
        ccard varchar(255) NOT NULL,
        credit varchar(255) NOT NULL,
        pkfr varchar(255) NOT NULL,
        hypo varchar(255) NOT NULL,
        darlehen varchar(255) NOT NULL,
        plfr varchar(255) NOT NULL,
        liquiditaet varchar(255) NOT NULL,
        schuldenquote varchar(255) NOT NULL,
        message varchar(255) NOT NULL,
        PRIMARY KEY  (id),
        UNIQUE KEY user_id (user_id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}
add_action('after_switch_theme', 'create_kpi_table');
?>