<?php
/**
 * Plugin Name: Custom Workflow API
 * Description: Handles AJAX requests for KPI calculations.
 * Version: 1.0
 * Author: Your Name
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

add_action('wp_ajax_get_kpi_data', 'get_kpi_data_callback');
add_action('wp_ajax_nopriv_get_kpi_data', 'get_kpi_data_callback');

function get_kpi_data_callback() {
    $user_id = isset($_POST['user_id']) ? intval($_POST['user_id']) : 0;

    if (!$user_id) {
        wp_send_json_error(['message' => 'Invalid user ID']);
    }

    global $wpdb;
    $table_name = $wpdb->prefix . 'kpis';

    $data = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE user_id = %d", $user_id), ARRAY_A);

    if (!$data) {
        wp_send_json_error(['message' => 'No data found']);
    }

    wp_send_json_success($data);
}
