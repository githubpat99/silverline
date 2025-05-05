<?php
/*
Template Name: Balance Template
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

?>

<div class="site-content">

<div class="summary-row">
    <div class="summary-item-aktiven activa-background">
        <h4 class="summary-title">Aktiven</h4>
        <span id="total-aktiven" class="total-value">45'000</span>
    </div>
    <div class="summary-item-passiven passiva-background">
        <h4 class="summary-title">Passiven</h4>
        <span id="total-passiven" class="total-value">45'000</span>
    </div>
</div>

<!-- separator -->
<div><hr class="custom-separator">
    </div>
<!-- wp:columns -->

<div class="wp-block-columns">

    <!-- Left Column -->
    <div class="wp-block-column has-text-color has-background has-link-color activa-background">
        <!-- wp:heading {"level":4} -->
        <h4 class="wp-block-heading">kurzfristig <span id="total-kurzfristig" class="total-value">0</span></h4>
        <!-- /wp:heading -->

        <!-- wp:table {"className":"is-style-regular"} -->
        <figure class="wp-block-table is-style-regular">
            <table class="has-fixed-layout">
                <tbody>
                    <tr>
                        <td><span class="table-heading">Bargeld</span></td>
                        <td><input type="text" placeholder="Wert 3" value="<?php echo esc_attr($values['cash']); ?>" class="formatted-input" data-group="kurzfristig" maxlength="11" readonly></td>
                    </tr>
                    <tr>
                        <td><span class="table-heading">Bankkonto</span></td>
                        <td><input type="text" placeholder="Wert 1" value="<?php echo esc_attr($values['bank']); ?>" class="formatted-input" data-group="kurzfristig" maxlength="11" readonly></td>
                    </tr>
                    <tr>
                        <td><span class="table-heading">Depot</span></td>
                        <td><input type="text" placeholder="Wert 2" value="<?php echo esc_attr($values['depot']); ?>" class="formatted-input" data-group="kurzfristig" maxlength="11" readonly></td>
                    </tr>
                </tbody>
            </table>
        </figure>
        <!-- /wp:table -->

        <!-- wp:heading {"level":4} -->
        <h4 class="wp-block-heading">langfristig <span id="total-langfristig" class="total-value">0</span></h4>
        <!-- /wp:heading -->

        <!-- wp:table -->
        <figure class="wp-block-table">
            <table class="has-fixed-layout">
                <tbody>
                    <tr>
                        <td><span class="table-heading">Immobilien</span></td>
                        <td><input type="text" placeholder="Wert 4" value="<?php echo esc_attr($values['immo']); ?>" class="formatted-input" data-group="langfristig" maxlength="11" readonly></td>
                    </tr>
                    <tr>
                        <td><span class="table-heading">Private Vorsorge</span></td>
                        <td><input type="text" placeholder="Wert 5" value="<?php echo esc_attr($values['priv']); ?>" class="formatted-input" data-group="langfristig" maxlength="11" readonly></td>
                    </tr>
                    <tr>
                        <td><span class="table-heading">Altersguthaben</span></td>
                        <td><input type="text" placeholder="Wert 6" value="<?php echo esc_attr($values['agh']); ?>" class="formatted-input" data-group="langfristig" maxlength="11" readonly></td>
                    </tr>
                </tbody>
            </table> 
        </figure>
        <!-- /wp:table --> 
    </div>
    <!-- /wp:column -->
     
    <!-- separator -->
    <div><hr class="custom-separator">
    </div>

    <!-- Right Column -->
    <div class="wp-block-column has-text-color has-background has-link-color passiva-background">
        <!-- wp:heading {"level":4} -->
        <h4 class="wp-block-heading">kurzfristig <span id="total-kurzfristig-passiven" class="total-value">0</span></h4>
        <!-- /wp:heading -->

        <!-- wp:table -->
        <figure class="wp-block-table">
            <table class="has-fixed-layout">
                <tbody>
                    <tr>
                        <td><span class="table-heading">Kreditkarte</span></td>
                        <td><input type="text" placeholder="Wert 7" value="<?php echo esc_attr($values['ccard']); ?>" class="formatted-input" data-group="kurzfristig-passiven" maxlength="11" readonly></td>
                    </tr>
                    <tr>
                        <td><span class="table-heading">Kredit</span></td>
                        <td><input type="text" placeholder="Wert 8" value="<?php echo esc_attr($values['credit']); ?>" class="formatted-input" data-group="kurzfristig-passiven" maxlength="11" readonly></td>
                    </tr>
                    <tr>
                        <td><span class="table-heading">Weitere</span></td>
                        <td><input type="text" placeholder="Wert 9" value="<?php echo esc_attr($values['pkfr']); ?>" class="formatted-input" data-group="kurzfristig-passiven" maxlength="11" readonly></td>
                    </tr>
                </tbody>
            </table>
        </figure>
        <!-- /wp:table -->

        <!-- wp:heading {"level":4} -->
        <h4 class="wp-block-heading">langfristig <span id="total-langfristig-passiven" class="total-value">0</span></h4>
        <!-- /wp:heading -->

        <!-- wp:table -->
        <figure class="wp-block-table">
            <table class="has-fixed-layout">
                <tbody>
                    <tr>
                        <td><span class="table-heading">Hypotheken</span></td>
                        <td><input type="text" placeholder="Wert 10" value="<?php echo esc_attr($values['hypo']); ?>" class="formatted-input" data-group="langfristig-passiven" maxlength="11" readonly></td>
                    </tr>
                    <tr>
                        <td><span class="table-heading">Darlehen</span></td>
                        <td><input type="text" placeholder="Wert 11" value="<?php echo esc_attr($values['darlehen']); ?>" class="formatted-input" data-group="langfristig-passiven" maxlength="11" readonly></td>
                    </tr>
                    <tr>
                        <td><span class="table-heading">Weitere</span></td>
                        <td><input type="text" placeholder="Wert 12" value="<?php echo esc_attr($values['plfr']); ?>" class="formatted-input" data-group="langfristig-passiven" maxlength="11" readonly></td>
                    </tr>
                </tbody>
            </table>
        </figure>
        <!-- /wp:table -->
    </div>
    <!-- /wp:column -->
</div>
</div>

<!-- Custom CSS -->
<style>
    td, th, h2, h4 {
        padding-left: 10px;
    }
    .wp-block-heading {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin: 0; /* Remove default margin */
        padding: 5px 0; /* Add padding to reduce space */
    }

</style>

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