<?php
/*
Template Name: Balance Template
*/

get_header();
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
                        <td><input type="text" placeholder="Wert 1" value="12.000" class="formatted-input" data-group="kurzfristig" maxlength="11"></td>
                    </tr>
                    <tr>
                        <td><span class="table-heading">Depot</span></td>
                        <td><input type="text" placeholder="Wert 2" value="25.000" class="formatted-input" data-group="kurzfristig" maxlength="11"></td>
                    </tr>
                    <tr>
                        <td><span class="table-heading">Weitere</span></td>
                        <td><input type="text" placeholder="Wert 3" value="1.500" class="formatted-input" data-group="kurzfristig" maxlength="11"></td>
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
                        <td><input type="text" placeholder="Wert 4" value="850.000" class="formatted-input" data-group="langfristig" maxlength="11"></td>
                    </tr>
                    <tr>
                        <td><span class="table-heading">Private Vorsorge</span></td>
                        <td><input type="text" placeholder="Wert 5" value="60.000" class="formatted-input" data-group="langfristig" maxlength="11"></td>
                    </tr>
                    <tr>
                        <td><span class="table-heading">Alterguthaben</span></td>
                        <td><input type="text" placeholder="Wert 6" value="750.000" class="formatted-input" data-group="langfristig" maxlength="11"></td>
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
                        <td><input type="text" placeholder="Wert 7" value="500" class="formatted-input" data-group="kurzfristig-passiven" maxlength="11"></td>
                    </tr>
                    <tr>
                        <td><span class="table-heading">Kredit</span></td>
                        <td><input type="text" placeholder="Wert 8" value="1.000" class="formatted-input" data-group="kurzfristig-passiven" maxlength="11"></td>
                    </tr>
                    <tr>
                        <td><span class="table-heading">Weitere</span></td>
                        <td><input type="text" placeholder="Wert 9" value="1.500" class="formatted-input" data-group="kurzfristig-passiven" maxlength="11"></td>
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
                        <td><input type="text" placeholder="Wert 10" value="400.000" class="formatted-input" data-group="langfristig-passiven" maxlength="11"></td>
                    </tr>
                    <tr>
                        <td><span class="table-heading">Darlehen</span></td>
                        <td><input type="text" placeholder="Wert 11" value="0" class="formatted-input" data-group="langfristig-passiven" maxlength="11"></td>
                    </tr>
                    <tr>
                        <td><span class="table-heading">Weitere</span></td>
                        <td><input type="text" placeholder="Wert 12" value="3.000" class="formatted-input" data-group="langfristig-passiven" maxlength="11"></td>
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
<div class="wp-block-buttons">
    <!-- wp:button -->
    <div class="wp-block-button">
        <a class="back-button">Submit</a>
    </div>
    <!-- /wp:button -->
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

<!-- Custom JavaScript -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const inputs = document.querySelectorAll('.formatted-input');

        inputs.forEach(input => {
            input.addEventListener('input', function() {
                let value = input.value.replace(/\./g, '');
                if (!isNaN(value) && value !== '') {
                    if (Number(value) > 999999999) {
                        value = '999999999';
                    }
                    input.value = Number(value).toLocaleString('de-DE');
                }
                updateTotal(input);
            });
        });

        function updateTotal(input) {
            const table = input.closest('table');
            const inputValues = table.querySelectorAll('.formatted-input');
            let total = 0;

            inputValues.forEach(input => {
                let value = input.value.replace(/\./g, '');
                if (!isNaN(value) && value !== '') {
                    total += Number(value);
                }
            });

            const group = input.dataset.group;
            document.querySelector(`#total-${group}`).textContent = total.toLocaleString('de-DE');

            updateOverallTotal();
        }

        function updateOverallTotal() {
            const totalAktiven = document.querySelector('#total-aktiven');
            const totalPassiven = document.querySelector('#total-passiven');
            const kurzfristigAktivenInputs = document.querySelectorAll('.formatted-input[data-group="kurzfristig"]');
            const langfristigAktivenInputs = document.querySelectorAll('.formatted-input[data-group="langfristig"]');
            const kurzfristigPassivenInputs = document.querySelectorAll('.formatted-input[data-group="kurzfristig-passiven"]');
            const langfristigPassivenInputs = document.querySelectorAll('.formatted-input[data-group="langfristig-passiven"]');
            let aktivenTotal = 0;
            let passivenTotal = 0;

            kurzfristigAktivenInputs.forEach(input => {
                let value = input.value.replace(/\./g, '');
                if (!isNaN(value) && value !== '') {
                    aktivenTotal += Number(value);
                }
            });

            langfristigAktivenInputs.forEach(input => {
                let value = input.value.replace(/\./g, '');
                if (!isNaN(value) && value !== '') {
                    aktivenTotal += Number(value);
                }
            });

            kurzfristigPassivenInputs.forEach(input => {
                let value = input.value.replace(/\./g, '');
                if (!isNaN(value) && value !== '') {
                    passivenTotal += Number(value);
                }
            });

            langfristigPassivenInputs.forEach(input => {
                let value = input.value.replace(/\./g, '');
                if (!isNaN(value) && value !== '') {
                    passivenTotal += Number(value);
                }
            });

            totalAktiven.textContent = aktivenTotal.toLocaleString('de-DE');
            totalPassiven.textContent = passivenTotal.toLocaleString('de-DE');
        }

        // Initial calculation of totals
        inputs.forEach(input => updateTotal(input));
    });
</script>

<?php
get_footer();
?>