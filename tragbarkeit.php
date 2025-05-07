<?php
/*
Template Name: Tragbarkeits Template
*/

get_header();

// Get the current user ID
$user_id = get_current_user_id();

// Fetch stored values from the database
global $wpdb;
$table_name = $wpdb->prefix . 'kpis';
$stored_values = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE user_id = %d", $user_id), ARRAY_A);

// Set default values if no stored values are found
$default_values = array(
    'cash' => '500',
    'bank' => '12500',
    'depot' => '25000',
    'immo' => '850000',
    'priv' => '35000',
    'agh' => '680000',
    'ccard' => '750',
    'credit' => '1500',
    'pkfr' => '0',
    'hypo' => '480000',
    'darlehen' => '0',
    'plfr' => '2500',
    'purchase' => '0',
    'purchase' => '0',
    'inherit' => '0',
    'liq_quote' => '0',
    'spar_quote' => '0',
    'risk_quote' => '0',
    'divers_quote' => '0',
    'liquiditaet' => '0',
    'schuldenquote' => '0',
    'message' => ''
);

// Merge stored values with default values
$values = array_merge($default_values, $stored_values ? $stored_values : array());
// Calculate the liquiditaet value
$values['liquiditaet'] = $values['cash'] + $values['bank'] + $values['depot'];
$vfLiq = $values['liquiditaet'] - $values['liq_quote'] - $values['depot'];
$sparquote = $values['spar_quote']; // Monthly savings amount

?>

<div class="site-content">
    <p class="summary-title">Tragbarkeit prüfen</p>
    <hr class="summary-separator">
    <p class="summary-title">Diese Funktion steht leider ausschliesslich Gold-Membern zur Verfügung - Sorry. <br><br>Irgendwie muss ich ja auch Geld verdienen. <br><br>  &#128540;</p>
    

</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const inputs = document.querySelectorAll('.formatted-input');

    inputs.forEach(input => {
        let value = input.value.replace(/\./g, '');
        if (!isNaN(value) && value !== '') {
            input.value = Number(value).toLocaleString('de-DE');
        }
    });
});
</script>

<?php
get_footer();
?>