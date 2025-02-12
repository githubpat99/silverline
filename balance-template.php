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
    'bank' => '12500',
    'depot' => '25000',
    'akfr' => '0',
    'immo' => '850000',
    'priv' => '35000',
    'agh' => '680000',
    'ccard' => '750',
    'credit' => '1500',
    'pkfr' => '0',
    'hypo' => '480000',
    'darlehen' => '0',
    'plfr' => '2500',
);

// Merge stored values with default values
$values = array_merge($default_values, $stored_values ? $stored_values : array());

?>

<div class="site-content">
</div>

<div class="summary-row">
    <div class="summary-item-aktiven" style="color:#0b3b66;background:linear-gradient(134deg,rgb(202,248,128) 32%,rgb(113,206,126) 85%)">
        <h4 class="summary-title">Aktiven</h4>
        <span id="total-aktiven" class="total-value">45'000</span>
    </div>
    <div class="summary-item-passiven" style="color:#50528c;background:linear-gradient(135deg,rgb(254,205,165) 62%,rgb(254,45,45) 100%,rgb(107,0,62) 100%)">
        <h4 class="summary-title">Passiven</h4>
        <span id="total-passiven" class="total-value">45'000</span>
    </div>
</div>

<!-- wp:columns -->
<div class="wp-block-columns">
    <!-- Left Column -->
    <div class="wp-block-column has-text-color has-background has-link-color" style="color:#0b3b66;background:linear-gradient(134deg,rgb(202,248,128) 32%,rgb(113,206,126) 85%)">
        <!-- wp:heading {"level":4} -->
        <h4 class="wp-block-heading">kurzfristig <span id="total-kurzfristig" class="total-value">0</span></h4>
        <!-- /wp:heading -->

        <!-- wp:table {"className":"is-style-regular"} -->
        <figure class="wp-block-table is-style-regular">
            <table class="has-fixed-layout">
                <tbody>
                    <tr>
                        <td><span class="table-heading">Bankkonto</span></td>
                        <td><input type="text" placeholder="Wert 1" value="<?php echo esc_attr($values['bank']); ?>" class="formatted-input" data-group="kurzfristig" maxlength="11"></td>
                    </tr>
                    <tr>
                        <td><span class="table-heading">Depot</span></td>
                        <td><input type="text" placeholder="Wert 2" value="<?php echo esc_attr($values['depot']); ?>" class="formatted-input" data-group="kurzfristig" maxlength="11"></td>
                    </tr>
                    <tr>
                        <td><span class="table-heading">Weitere</span></td>
                        <td><input type="text" placeholder="Wert 3" value="<?php echo esc_attr($values['akfr']); ?>" class="formatted-input" data-group="kurzfristig" maxlength="11"></td>
                    </tr>
                </tbody>
            </table>
        </figure>
        <!-- /wp:table -->

        <!-- wp:separator -->
        <hr class="wp-block-separator has-alpha-channel-opacity"/>
        <!-- /wp:separator -->

        <!-- wp:heading {"level":4} -->
        <h4 class="wp-block-heading">langfristig <span id="total-langfristig" class="total-value">0</span></h4>
        <!-- /wp:heading -->

        <!-- wp:table -->
        <figure class="wp-block-table">
            <table class="has-fixed-layout">
                <tbody>
                    <tr>
                        <td><span class="table-heading">Immobilien</span></td>
                        <td><input type="text" placeholder="Wert 4" value="<?php echo esc_attr($values['immo']); ?>" class="formatted-input" data-group="langfristig" maxlength="11"></td>
                    </tr>
                    <tr>
                        <td><span class="table-heading">Private Vorsorge</span></td>
                        <td><input type="text" placeholder="Wert 5" value="<?php echo esc_attr($values['priv']); ?>" class="formatted-input" data-group="langfristig" maxlength="11"></td>
                    </tr>
                    <tr>
                        <td><span class="table-heading">Altersguthaben</span></td>
                        <td><input type="text" placeholder="Wert 6" value="<?php echo esc_attr($values['agh']); ?>" class="formatted-input" data-group="langfristig" maxlength="11"></td>
                    </tr>
                </tbody>
            </table> 
        </figure>
        <!-- /wp:table --> 
    </div>
    <!-- /wp:column -->

    <!-- Right Column -->
    <div class="wp-block-column has-text-color has-background has-link-color" style="color:#50528c;background:linear-gradient(135deg,rgb(254,205,165) 62%,rgb(254,45,45) 100%,rgb(107,0,62) 100%)">
        <!-- wp:heading {"level":4} -->
        <h4 class="wp-block-heading">kurzfristig <span id="total-kurzfristig-passiven" class="total-value">0</span></h4>
        <!-- /wp:heading -->

        <!-- wp:table -->
        <figure class="wp-block-table">
            <table class="has-fixed-layout">
                <tbody>
                    <tr>
                        <td><span class="table-heading">Kreditkarte</span></td>
                        <td><input type="text" placeholder="Wert 7" value="<?php echo esc_attr($values['ccard']); ?>" class="formatted-input" data-group="kurzfristig-passiven" maxlength="11"></td>
                    </tr>
                    <tr>
                        <td><span class="table-heading">Kredit</span></td>
                        <td><input type="text" placeholder="Wert 8" value="<?php echo esc_attr($values['credit']); ?>" class="formatted-input" data-group="kurzfristig-passiven" maxlength="11"></td>
                    </tr>
                    <tr>
                        <td><span class="table-heading">Weitere</span></td>
                        <td><input type="text" placeholder="Wert 9" value="<?php echo esc_attr($values['pkfr']); ?>" class="formatted-input" data-group="kurzfristig-passiven" maxlength="11"></td>
                    </tr>
                </tbody>
            </table>
        </figure>
        <!-- /wp:table -->

        <!-- wp:separator -->
        <hr class="wp-block-separator has-alpha-channel-opacity"/>
        <!-- /wp:separator -->

        <!-- wp:heading {"level":4} -->
        <h4 class="wp-block-heading">langfristig <span id="total-langfristig-passiven" class="total-value">0</span></h4>
        <!-- /wp:heading -->

        <!-- wp:table -->
        <figure class="wp-block-table">
            <table class="has-fixed-layout">
                <tbody>
                    <tr>
                        <td><span class="table-heading">Hypotheken</span></td>
                        <td><input type="text" placeholder="Wert 10" value="<?php echo esc_attr($values['hypo']); ?>" class="formatted-input" data-group="langfristig-passiven" maxlength="11"></td>
                    </tr>
                    <tr>
                        <td><span class="table-heading">Darlehen</span></td>
                        <td><input type="text" placeholder="Wert 11" value="<?php echo esc_attr($values['darlehen']); ?>" class="formatted-input" data-group="langfristig-passiven" maxlength="11"></td>
                    </tr>
                    <tr>
                        <td><span class="table-heading">Weitere</span></td>
                        <td><input type="text" placeholder="Wert 12" value="<?php echo esc_attr($values['plfr']); ?>" class="formatted-input" data-group="langfristig-passiven" maxlength="11"></td>
                    </tr>
                </tbody>
            </table>
        </figure>
        <!-- /wp:table -->
    </div>
    <!-- /wp:column -->
</div>
<!-- /wp:columns -->

<!-- wp:buttons -->
<div>
    
        <button class="back-button" id="submit-button">Submit</button>
    
</div>
<!-- /wp:buttons -->

<!-- wp:paragraph -->
<p></p>
<!-- /wp:paragraph -->

<!-- Custom CSS -->
<style>
    .summary-row {
        display: flex;
        justify-content: space-between;
        background-color: #f0f0f0;
        margin-bottom: 5px;
    }
    .summary-title {
        margin: 5px;
    }
    .summary-item-aktiven {
        flex: 1;
        text-align: center;
        background-color: rgba(113, 206, 126);
        border-radius: 5px;
    }
    .summary-item-passiven {
        flex: 1;
        text-align: center;
        background-color: rgb(231, 119, 119);
        border-radius: 5px;
    }
    .summary-item h2 {
        margin: 0;
    }
    .formatted-input {
        border: none;
        color: rgb(24, 18, 104);
        padding: 5px;
        box-sizing: border-box;
        width: 160px; /* Adjust the width as needed */
        height: 30px;
        font-size: 16px;
        text-align: right;
    }
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
    .wp-block-heading span {
        margin-left: 0px;
    }
    .total-value {
        padding: 0 10px;
    }
    .total-cell {
        text-align: center;
    }
    .table-heading {
        display: inline-block;
    }
    .wp-container-core-columns-is-layout-1 {
        flex-wrap: wrap;
    }
    body .is-layout-flex {
        display: block;
    }
    /* Responsive design */
    @media (max-width: 768px) {
        .wp-block-column {
            width: 100%;
        }
        .formatted-input {
            max-width: 100px; /* Adjust the width for mobile devices */
        }
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