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

    error_log('LOGGING - SERVER-SIDE Enqueue scripts and styles');


}
add_action('wp_enqueue_scripts', 'my_custom_theme_enqueue');

// Handle the Forminator form submission via AJAX
add_action('wp_ajax_calculate_kpi', 'calculate_kpis_on_ajax');
add_action('wp_ajax_nopriv_calculate_kpi', 'calculate_kpis_on_ajax');

error_log('LOGGING - SERVER-SIDE GENERAL FUNCTIONS');

function calculate_kpis_on_ajax() {
    // Log Test
    error_log('LOGGING - SERVER-SIDE AJAX REQUEST');

    // Check if the form data is passed
    if (isset($_POST['number-1'], $_POST['number-3'], $_POST['number-9'], $_POST['number-8'], $_POST['number-5'], $_POST['number-4'], $_POST['number-2'], $_POST['number-6'], $_POST['number-7'])) {
        
        // Log the received data for debugging
        error_log('Received Data: ' . print_r($_POST, true)); // Log the entire POST array

        // Extract form data
        $data = [
            'bank' => floatval($_POST['number-1']),
            'depot' => floatval($_POST['number-3']),
            'agh' => floatval($_POST['number-9']),
            's3a' => floatval($_POST['number-8']),
            'efh' => floatval($_POST['number-5']),
            'loan' => floatval($_POST['number-4']),
            'credit' => floatval($_POST['number-2']),
            'mortgage' => floatval($_POST['number-6']),
            'otherDebt' => floatval($_POST['number-7']),
        ];

        // Log the extracted data
        error_log('Extracted Data: ' . print_r($data, true)); // Log the extracted data

        // Perform KPI calculations
        $results = calculate_kpis($data);

        // Log the calculated results
        error_log('Calculated Results: ' . print_r($results, true)); // Log the calculated results

        // Send results as JSON response
        wp_send_json_success($results); // Send the results back to the client
    } else {
        wp_send_json_error(['message' => 'Missing required form data']);
        error_log('Missing required form data');
    }

    wp_die(); // End the AJAX request properly
}



function calculate_kpis($data) {
    // Log the incoming data for the calculation
    error_log('Data for KPI calculation: ' . print_r($data, true)); // Log the data for KPI calculation

    $total_assets = $data['bank'] + $data['depot'] + $data['agh'] + $data['s3a'] + $data['efh'];
    $total_liabilities = $data['loan'] + $data['credit'] + $data['mortgage'] + $data['otherDebt'];
    $net_worth = $total_assets - $total_liabilities;
    $debt_ratio = $total_liabilities / $total_assets;

    // Log intermediate calculation results
    error_log('Total Assets: ' . $total_assets);
    error_log('Total Liabilities: ' . $total_liabilities);
    error_log('Net Worth: ' . $net_worth);
    error_log('Debt Ratio: ' . $debt_ratio);

    return [
        'kpi_result' => number_format($net_worth, 2, '.', ',') . ' CHF',
        'assets' => number_format($total_assets, 2, '.', ',') . ' CHF',
        'debts' => number_format($total_liabilities, 2, '.', ',') . ' CHF',
    ];
}


// Enqueue Google Charts script
function my_theme_google_charts() {
    wp_enqueue_script('google-charts', 'https://www.gstatic.com/charts/loader.js', array(), null, true);
}
add_action('wp_enqueue_scripts', 'my_theme_google_charts');
?>