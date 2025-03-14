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
        'homeUrl' => home_url() // Localized home URL
    ));
}
add_action('wp_enqueue_scripts', 'my_custom_theme_enqueue');

function create_kpi_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'kpis';

    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE `wp_1162188_kpis` (
            `id` mediumint(9) NOT NULL AUTO_INCREMENT,
            `user_id` bigint(20) NOT NULL,
            `cash` varchar(255) NOT NULL,
            `bank` varchar(255) NOT NULL,
            `depot` varchar(255) NOT NULL,
            `immo` varchar(255) NOT NULL,
            `priv` varchar(255) NOT NULL,
            `agh` varchar(255) NOT NULL,
            `ccard` varchar(255) NOT NULL,
            `credit` varchar(255) NOT NULL,
            `pkfr` varchar(255) NOT NULL,
            `hypo` varchar(255) NOT NULL,
            `darlehen` varchar(255) NOT NULL,
            `plfr` varchar(255) NOT NULL,
            `purchase` varchar(100) NOT NULL DEFAULT '0',
            `inherit` varchar(100) NOT NULL DEFAULT '0',
            `liq_quote` varchar(100) NOT NULL DEFAULT '0',
            `spar_quote` varchar(100) NOT NULL DEFAULT '0',
            `risk_quote` varchar(100) NOT NULL DEFAULT '0',
            `divers_quote` varchar(100) NOT NULL DEFAULT 'E',
            `liquiditaet` varchar(255) NOT NULL,
            `schuldenquote` varchar(255) NOT NULL,
            `message` varchar(255) NOT NULL,
            PRIMARY KEY (`id`),
            UNIQUE KEY `user_id` (`user_id`)
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
    $table_name = $wpdb->prefix . 'kpis';

    // Fetch user data from the kpis table
    $query = $wpdb->prepare("SELECT * FROM $table_name WHERE user_id = %d", $user_id);
    error_log('Prepared SQL query: ' . $query);

    $result = $wpdb->get_row($query, ARRAY_A);

    error_log('get_workflow_step_data - RESULT: ' . print_r($result, true));

    // Default empty response
    $default = [
        'cash' => '',
        'bank' => '',
        'depot' => '',
        'immo' => '',
        'priv' => '',
        'agh' => '',
        'ccard' => '',
        'credit' => '',
        'pkfr' => '',
        'hypo' => '',
        'darlehen' => '',
        'plfr' => '',
        'purchase' => '',
        'inherit' => '',
        'liq_quote' => '',
        'spar_quote' => '',
        'risk_quote' => '',
        'divers_quote' => '',
        'liquidity' => '',
        'schuldenquote' => '',
        'message' => ''
    ];


    // Return relevant data based on the step number
    if (!$result) {
        return $default;
    }

    switch ($step_number) {
        case 1: // Step 1: Personal financial situation
            return [
                'cash'        => $result['cash'],
                'bank'        => $result['bank'],
                'depot'       => $result['depot'],
                'immo'        => $result['immo']
            ];
        case 2: // Step 2: Debts & Mortgages
            return [
                'credit' => $result['credit'],
                'ccard' => $result['ccard'],
                'hypo'  => $result['hypo']
            ];
        case 3: // Step 3: Future income/expenses
            return [
                'priv'  => $result['priv'],
                'agh' => $result['agh']
            ];
        case 4: // Step 4: Investment goal
            return [
                'purchase' => $result['purchase'],
                'inherit' => $result['inherit']
            ];
        case 5: // Step 5: Preferred/Avoided Investments
            return [
                'risk_quote' => $result['risk_quote'],
                'divers_quote' => $result['divers_quote']
            ];
        case 6: // Step 6: Liquidität
            return [
                'spar_quote' => $result['spar_quote'],
                'liq_quote' => $result['liq_quote']
            ];
        default:
            return $default;
    }
}

function save_workflow_step($user_id, $step_number, $step_data) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'kpis';

    error_log('save_workflow_step called');
    error_log('user_id: ' . $user_id);
    error_log('step_number: ' . $step_number);
    error_log('step_data: ' . print_r($step_data, true));

    // Helper function to clean and convert numbers
    function clean_number($value) {
        $value = str_replace(["'", ","], "", $value); // Remove thousand separators
        return floatval($value); // Convert to number
    }

    // Get existing row for this user
    $existing_entry = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE user_id = %d", $user_id), ARRAY_A);

    // Prepare updated data (keep existing values if not in step_data)
    $data = [
        'user_id'       => $user_id,
        'cash'          => isset($step_data['cash']) ? clean_number($step_data['cash']) : ($existing_entry['cash'] ?? 0),
        'bank'          => isset($step_data['bank']) ? clean_number($step_data['bank']) : ($existing_entry['bank'] ?? 0),
        'depot'         => isset($step_data['depot']) ? clean_number($step_data['depot']) : ($existing_entry['depot'] ?? 0),
        'immo'          => isset($step_data['immo']) ? clean_number($step_data['immo']) : ($existing_entry['immo'] ?? 0),
        'priv'          => isset($step_data['priv']) ? clean_number($step_data['priv']) : ($existing_entry['priv'] ?? 0),
        'agh'           => isset($step_data['agh']) ? clean_number($step_data['agh']) : ($existing_entry['agh'] ?? 0),
        'ccard'         => isset($step_data['ccard']) ? clean_number($step_data['ccard']) : ($existing_entry['ccard'] ?? 0),
        'credit'        => isset($step_data['credit']) ? clean_number($step_data['credit']) : ($existing_entry['credit'] ?? 0),
        'pkfr'          => isset($step_data['pkfr']) ? clean_number($step_data['pkfr']) : ($existing_entry['pkfr'] ?? 0),
        'hypo'          => isset($step_data['hypo']) ? clean_number($step_data['hypo']) : ($existing_entry['hypo'] ?? 0),
        'darlehen'      => isset($step_data['darlehen']) ? clean_number($step_data['darlehen']) : ($existing_entry['darlehen'] ?? 0),
        'plfr'          => isset($step_data['plfr']) ? clean_number($step_data['plfr']) : ($existing_entry['plfr'] ?? 0),
        'purchase'      => isset($step_data['purchase']) ? clean_number($step_data['purchase']) : ($existing_entry['purchase'] ?? 0),
        'inherit'       => isset($step_data['inherit']) ? clean_number($step_data['inherit']) : ($existing_entry['inherit'] ?? 0),  
        'liq_quote'     => isset($step_data['liq_quote']) ? clean_number($step_data['liq_quote']) : ($existing_entry['liq_quote'] ?? 0),
        'spar_quote'    => isset($step_data['spar_quote']) ? clean_number($step_data['spar_quote']) : ($existing_entry['spar_quote'] ?? 0),
        'risk_quote'    => isset($step_data['risk_quote']) ? clean_number($step_data['risk_quote']) : ($existing_entry['risk_quote'] ?? 0),
        'divers_quote' => isset($step_data['divers_quote']) ? sanitize_text_field($step_data['divers_quote']) : ($existing_entry['divers_quote'] ?? ''),
        'liquiditaet'   => isset($step_data['liquiditaet']) ? clean_number($step_data['liquiditaet']) : ($existing_entry['liquiditaet'] ?? 0),
        'schuldenquote' => isset($step_data['schuldenquote']) ? clean_number($step_data['schuldenquote']) : ($existing_entry['schuldenquote'] ?? 0),
        'message'       => isset($step_data['message']) ? sanitize_textarea_field($step_data['message']) : ($existing_entry['message'] ?? ''),
    ];

    error_log('data ready for update: ' . print_r($data, true));

    if ($existing_entry) {
        // Update only the changed fields
        $wpdb->update($table_name, $data, ['user_id' => $user_id]);
        error_log('Updated existing KPI entry for user_id: ' . $user_id);
    } else {
        // Insert new entry if user doesn't exist
        $wpdb->insert($table_name, $data);
        error_log('Inserted new KPI entry for user_id: ' . $user_id);
    }

    // Check for DB errors
    if ($wpdb->last_error) {
        error_log('Database error: ' . $wpdb->last_error);
    }
}

?>