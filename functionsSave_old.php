<?php
register_nav_menus( array(
    'menu-1' => __( 'Primary Menu', 'my-custom-theme' ),
) );

add_theme_support( 'post-thumbnails' );
add_theme_support( 'title-tag' ); 
add_image_size( 'my-custom-image-size', 640, 999 );

function my_custom_theme_enqueue() {
    wp_enqueue_style('my-custom-theme-style', get_stylesheet_uri(), array(), null, 'all');
    wp_enqueue_script('my-custom-theme-script', get_template_directory_uri() . '/js/custom.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'my_custom_theme_enqueue');


function handle_kpis_form_submission() {
    // Validate form data
    // $data = validate_kpi_inputs($_POST);

    // Collect form data
    $data = [
        'bank' => $_POST['bank'],
        'depot' => $_POST['depot'],
        'agh' => $_POST['agh'],
        's3a' => $_POST['s3a'],
        'efh' => $_POST['efh'],
        'loan' => $_POST['loan'],
        'credit' => $_POST['credit'],
        'mortgage' => $_POST['mortgage'],
        'otherDebt' => $_POST['otherDebt'],
    ];

    // Perform KPI calculations locally
    $results = calculate_kpis($data);

    // Redirect to results page with the results
    wp_redirect(add_query_arg('results', urlencode(json_encode($results)), home_url('/balance-results/')));
    exit;
}

function calculate_kpis($data) {
    $bank = floatval($data['bank']);
    $depot = floatval($data['depot']);
    $agh = floatval($data['agh']);
    $s3a = floatval($data['s3a']);
    $efh = floatval($data['efh']);
    $loan = floatval($data['loan']);
    $credit = floatval($data['credit']);
    $mortgage = floatval($data['mortgage']);
    $otherDebt = floatval($data['otherDebt']);

    // KPI Calculations
    $total_assets = $bank + $depot + $agh + $s3a + $efh;
    $total_liabilities = $loan + $credit + $mortgage + $otherDebt;
    $net_worth = $total_assets - $total_liabilities;
    $debt_ratio = $total_liabilities / $total_assets;

    // Return formatted results
    return [
        'Bruttovermögen' => number_format($total_assets, 2, '.', ',') . ' CHF',
        'Bruttoschulden' => number_format($total_liabilities, 2, '.', ',') . ' CHF',
        'Nettovermögen' => number_format($net_worth, 2, '.', ',') . ' CHF',
        'Schuldenquote' => number_format($debt_ratio * 100, 2, '.', ',') . ' %',
    ];
}

add_action('admin_post_nopriv_calculate_kpis', 'handle_kpis_form_submission');
add_action('admin_post_calculate_kpis', 'handle_kpis_form_submission');

function my_theme_google_charts() {
    wp_enqueue_script('google-charts', 'https://www.gstatic.com/charts/loader.js', array(), null, true);
}
add_action('wp_enqueue_scripts', 'my_theme_google_charts');

?>