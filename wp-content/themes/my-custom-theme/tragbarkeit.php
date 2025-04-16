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
    <div class="summary-container">

        <table class="has-fixed-layout">
            <p class="summary-title">Tragbarkeit prüfen</p>
            <tbody>
                <tr>
                    <td><span class="table-heading">Liquidität</span></td>
                    <td><input type="text" placeholder="Wert 2" value="<?php echo esc_attr($values['liquiditaet']); ?>" class="formatted-input" data-group="kurzfristig" maxlength="11" readonly></td>
                </tr>
                <tr>
                    <td><span class="table-heading">Depot</span></td>
                    <td><input type="text" placeholder="Wert 2" value="<?php echo esc_attr($values['depot']); ?>" class="formatted-input" data-group="kurzfristig" maxlength="11" readonly></td>
                </tr>
                <tr>
                    <td><span class="table-heading">Liquiditätsquote</span></td>
                    <td><input type="text" placeholder="Wert 1" value="<?php echo esc_attr($values['liq_quote']); ?>" class="formatted-input" data-group="kurzfristig" maxlength="11" readonly></td>
                </tr>
                <tr>
                    <td><span class="table-heading">verfügbare Liquidität</span></td>
                    <td><input type="text" placeholder="Wert 2" value="<?php echo esc_attr($vfLiq); ?>" class="formatted-input" data-group="kurzfristig" maxlength="11" readonly></td>
                </tr>
                <tr>
                    <td><span class="table-heading">Sparquote / Monat</span></td>
                    <td><input type="text" placeholder="Wert 3" value="<?php echo esc_attr($values['spar_quote']); ?>" class="formatted-input" data-group="kurzfristig" maxlength="11" readonly></td>
                </tr>
                <tr>
                    <td>
                        <div class="slider-row">
                            <span class="table-heading">Risikoquote</span>
                            <input type="range" id="riskSlider" min="0" max="100" step="5" value="<?php echo esc_attr($values['risk_quote']); ?>" class="risk-slider">
                        </div>
                    </td>
                    <td><input type="text" id="riskValue" value="<?php echo esc_attr($values['risk_quote']); ?>%" class="formatted-input" readonly></td>
                </tr>
                
            </tbody>
        </table>
    </div>

</div>

<?php
get_footer();
?>

