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
    // Enqueue styles
    wp_enqueue_style('my-custom-theme-style', get_stylesheet_uri(), array(), null, 'all');

    // Enqueue jquery
    wp_enqueue_script('jquery'); 

    // Enqueue main theme script
    wp_enqueue_script('my-custom-theme-script', get_template_directory_uri() . '/js/custom.js', array('jquery'), null, true);

    // Enqueue KPI calculation script
    wp_enqueue_script('calculate-kpis', get_template_directory_uri() . '/js/calculate-kpis.js', array('jquery'), null, true);

    // Enqueue workflow navigation script
    wp_enqueue_script('workflow-navigation', get_template_directory_uri() . '/js/workflow-navigation.js', array('jquery'), null, true);

    // Enqueue Google Charts script
    wp_enqueue_script('google-charts', 'https://www.gstatic.com/charts/loader.js', array(), null, true);

    // Localize the AJAX URL
    wp_localize_script('workflow-navigation', 'workflowAjax', array(
        'ajaxurl' => admin_url('admin-ajax.php'), // Localized URL for AJAX
        'user_id' => get_current_user_id(), // Localized user_id
    ));
}
add_action('wp_enqueue_scripts', 'my_custom_theme_enqueue');

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

add_action('wp_ajax_save_workflow_step', 'save_workflow_step_function');
add_action('wp_ajax_nopriv_save_workflow_step', 'save_workflow_step_function');

function save_workflow_step_function() {
    error_log('save_workflow_step_function called');
    error_log('POST data: ' . print_r($_POST, true));

    if (isset($_POST['user_id']) && isset($_POST['step_number']) && isset($_POST['step_data'])) {
        $user_id = $_POST['user_id'];
        $step_number = $_POST['step_number'];
        $step_data = json_decode(stripslashes($_POST['step_data']), true);

        // Überprüfe die Eingabewerte
        error_log('user_id: ' . $user_id);
        error_log('step_number: ' . $step_number);
        error_log('step_data: ' . print_r($step_data, true));

        // Sanitize die Eingabewerte
        $step_data = array_map('sanitize_text_field', $step_data);

        // Speichern der Workflow-Schritte
        save_workflow_step($user_id, $step_number, $step_data);

        // Erfolgsantwort
        wp_send_json_success(array('message' => 'Data saved successfully.'));
    } else {
        wp_send_json_error(array('message' => 'Invalid data.'));
    }
}

add_action('wp_ajax_get_workflow_step_data', function() {
    $user_id = get_current_user_id(); // If not logged in, this returns 0
    $step_number = isset($_GET['step_number']) ? intval($_GET['step_number']) : null;

    error_log('Step number received on server: ' . $step_number . ', User ID: ' . $user_id);
    
    $data = get_workflow_step_data($user_id, $step_number);  

    wp_send_json_success(['data' => $data]);
});

add_action('wp_ajax_nopriv_get_workflow_step_data', function() { // Allow non-logged-in users
    $user_id = 0; // Explicitly set user_id = 0 for guests
    $step_number = isset($_GET['step_number']) ? intval($_GET['step_number']) : null;

    error_log('Step number received on server (nopriv): ' . $step_number . ', User ID: ' . $user_id);
    
    $data = get_workflow_step_data($user_id, $step_number);  

    wp_send_json_success(['data' => $data]);
});


function get_workflow_step_data($user_id, $step_number) {
    error_log('get_workflow_step_data called for user: ' . $user_id . ' and step: ' . $step_number);

    global $wpdb;
    $table_name = $wpdb->prefix . 'user_workflow_data';

    // Log the query for debugging
    $query = $wpdb->prepare(
        "SELECT step_data FROM $table_name WHERE user_id = %d AND step_number = %d",
        $user_id, $step_number
    );
    error_log('Prepared SQL query: ' . $query);

    // Fetch data from DB
    $result = $wpdb->get_var($query);

    error_log('get_workflow_step_data - RESULT: ' . print_r($result, true));

    return $result ? unserialize($result) : [
        'cash' => '',
        'bank' => '',
        'securities' => '',
        'investments' => '',
        'mortgages' => '',
        'consumer_loans' => ''
    ];
}


function save_workflow_step($user_id, $step_number, $step_data) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'user_workflow_data';

    error_log('save_workflow_step called');
    error_log('user_id: ' . $user_id);
    error_log('step_number: ' . $step_number);
    error_log('step_data: ' . print_r($step_data, true));

    // Daten serialisieren
    $step_data_serialized = maybe_serialize($step_data);

    // SQL-Befehl zum Einfügen oder Aktualisieren
    $sql = $wpdb->prepare(
        "INSERT INTO $table_name (user_id, step_number, step_data)
        VALUES (%d, %d, %s)
        ON DUPLICATE KEY UPDATE step_data = VALUES(step_data)",
        $user_id, $step_number, $step_data_serialized
    );

    // Query ausführen
    $wpdb->query($sql);

    // Fehlerüberprüfung
    if ($wpdb->last_error) {
        error_log('Database error: ' . $wpdb->last_error);
    }
}

?>