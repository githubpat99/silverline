<?php
// Include WordPress functions
require_once('../../../wp-load.php');

// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    global $wpdb;

    // Get the current user ID
    $user_id = get_current_user_id();

    // Get the data from the POST request
    $data = json_decode(file_get_contents('php://input'), true);

    // Prepare the data for insertion or update
    $table_name = $wpdb->prefix . 'kpis';
    $data_to_insert = array(
        'user_id' => $user_id,
        'bank' => sanitize_text_field($data['bank']),
        'depot' => sanitize_text_field($data['depot']),
        'akfr' => sanitize_text_field($data['akfr']),
        'immo' => sanitize_text_field($data['immo']),
        'priv' => sanitize_text_field($data['priv']),
        'agh' => sanitize_text_field($data['agh']),
        'ccard' => sanitize_text_field($data['ccard']),
        'credit' => sanitize_text_field($data['credit']),
        'pkfr' => sanitize_text_field($data['pkfr']),
        'hypo' => sanitize_text_field($data['hypo']),
        'darlehen' => sanitize_text_field($data['darlehen']),
        'plfr' => sanitize_text_field($data['plfr']),
        'liquiditaet' => sanitize_text_field($data['Liquidität']),
        'schuldenquote' => sanitize_text_field($data['Schuldenquote']),
        'message' => sanitize_text_field($data['message']),
    );

    // Log the data to be inserted
    error_log('Data to insert: ' . print_r($data_to_insert, true));

    // Check if a record for the current user already exists
    $existing_record = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE user_id = %d", $user_id));

    if ($existing_record) {
        // Update the existing record
        $wpdb->update($table_name, $data_to_insert, array('user_id' => $user_id));
        $response_message = 'Data updated successfully.';
    } else {
        // Insert a new record
        $wpdb->insert($table_name, $data_to_insert);
        $response_message = 'Data saved successfully.';
    }

    // Log the last query for debugging
    error_log('Last query: ' . $wpdb->last_query);

    // Return a response
    echo json_encode(array('status' => 'success', 'message' => $response_message));
    exit;
}

// Return an error response if the request is not a POST request
echo json_encode(array('status' => 'error', 'message' => 'Invalid request.'));
exit;
?>