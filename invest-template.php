<?php
/*
Template Name: Invest Template
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
$vfLiq = $values['liquiditaet'] - $values['liq_quote'] - $values['depot'];

?>

<div class="site-content">
</div>

<h4 class="summary-title">Investitionsplan</h4>

<table class="has-fixed-layout">
    <tbody>
        <tr>
            <td><span class="table-heading">Sparquote</span></td>
            <td><input type="text" placeholder="Wert 3" value="<?php echo esc_attr($values['spar_quote']); ?>" class="formatted-input" data-group="kurzfristig" maxlength="11"></td>
        </tr>
        <tr>
            <td><span class="table-heading">Liquiditätsquote</span></td>
            <td><input type="text" placeholder="Wert 1" value="<?php echo esc_attr($values['liq_quote']); ?>" class="formatted-input" data-group="kurzfristig" maxlength="11"></td>
        </tr>
        <tr>
            <td><span class="table-heading">Liquidität</span></td>
            <td><input type="text" placeholder="Wert 2" value="<?php echo esc_attr($values['liquiditaet']); ?>" class="formatted-input" data-group="kurzfristig" maxlength="11"></td>
        </tr>
        <tr>
            <td><span class="table-heading">Investments</span></td>
            <td><input type="text" placeholder="Wert 2" value="<?php echo esc_attr($values['depot']); ?>" class="formatted-input" data-group="kurzfristig" maxlength="11"></td>
        </tr>
        <tr>
            <td><span class="table-heading">verfügbare Liquidität</span></td>
            <td><input type="text" placeholder="Wert 2" value="<?php echo esc_attr($vfLiq); ?>" class="formatted-input" data-group="kurzfristig" maxlength="11"></td>
        </tr>
        <tr>
            <td><span class="table-heading">Risikoquote</span></td>
            <td><input type="text" placeholder="Wert 2" value="<?php echo esc_attr($values['risk_quote']); ?>" class="formatted-input" data-group="kurzfristig" maxlength="11"></td>
        </tr>
    </tbody>
</table>

<div class="chart-container" id="googleChart"></div>

<script type="text/javascript">
document.addEventListener('DOMContentLoaded', function() {
    google.charts.load('current', {'packages':['corechart', 'line']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var availableLiquidity = <?php echo json_encode($vfLiq); ?>;
        var riskQuote = <?php echo json_encode($values['risk_quote']); ?>;
        var averageRiskQuote = 30; // Example for the average value

        var annualGrowthRate = riskQuote / 100;
        var averageAnnualGrowthRate = averageRiskQuote / 100;

        var userData = [];
        var averageData = [];
        var years = 5;

        for (var year = 0; year <= years; year++) {
            var userPotential = Math.round(availableLiquidity * Math.pow(1 + annualGrowthRate, year));
            var averagePotential = Math.round(availableLiquidity * Math.pow(1 + averageAnnualGrowthRate, year));

            userData.push([year, userPotential]);
            averageData.push([year, averagePotential]);
        }

        var data = new google.visualization.DataTable();
        data.addColumn('number', 'Jahr');
        data.addColumn('number', 'Potential');
        data.addColumn('number', 'Ø Potential');

        for (var i = 0; i < userData.length; i++) {
            data.addRow([userData[i][0], userData[i][1], averageData[i][1]]);
        }

        var options = {
            width: window.innerWidth * 1.1, // Set width to 80% of the window's width
            height: document.getElementById('googleChart').offsetHeight,
            hAxis: { textPosition: 'none' }, // ❌ Hides H-axis labels
            legend: { position: 'top' },
            series: {
                0: { pointSize: 6, lineWidth: 3, color: '#0073aa' },
                1: { pointSize: 6, lineWidth: 3, color: '#5b5e5d' }
            }
        };

        var chart = new google.visualization.LineChart(document.getElementById('googleChart'));
        chart.draw(data, options);

        // 📌 Table Below the Chart
        var tableHTML = '<div style="overflow-x:auto; margin-top: 20px;">';
        tableHTML += '<table style="width: 100%; border-collapse: collapse; text-align: center; font-size: 10px; table-layout: fixed;">';
        tableHTML += '<tr><th style="border: 1px solid #ddd; padding: 8px;"></th>';

        for (var year = 0; year <= years; year++) {
            tableHTML += '<th style="border: 1px solid #ddd; padding: 8px; white-space: nowrap;">J +' + year + '</th>';
        }

        tableHTML += '</tr>';

        // 🔹 User Investment Potential
        tableHTML += '<tr><td style="border: 1px solid #ddd; padding: 8px;">Pot.</td>';
        for (var i = 0; i <= years; i++) {
            tableHTML += '<td style="border: 1px solid #ddd; padding: 8px;">' + formatNumber(userData[i][1]) + '</td>';
        }
        tableHTML += '</tr>';

        // 🔹 Average Investment Potential
        tableHTML += '<tr><td style="border: 1px solid #ddd; padding: 8px;">Ø</td>';
        for (var i = 0; i <= years; i++) {
            tableHTML += '<td style="border: 1px solid #ddd; padding: 8px;">' + formatNumber(averageData[i][1]) + '</td>';
        }
        tableHTML += '</tr>';

        tableHTML += '</table>';
        tableHTML += '</div>';

        // Add Table Below Chart
        document.getElementById('googleChart').insertAdjacentHTML('afterend', tableHTML);
    }

    // 📌 Format Numbers (Remove punctuation, ensure no decimals)
    function formatNumber(number) {
        return number.toLocaleString('de-DE'); // Format with thousands separator (e.g., "10.000")
    }

    // 📌 Format Input Values on Page Load
    function formatInputValues() {
        const inputs = document.querySelectorAll('.formatted-input');
        inputs.forEach(function(input) {
            input.value = formatNumber(input.value.replace(/\D/g, '')); // Format the value
        });
    }

    // 📌 Event Listener to format values when user changes them
    document.querySelectorAll('.formatted-input').forEach(function(input) {
        input.addEventListener('input', function() {
            // Only format the digits (remove non-numeric characters)
            input.value = formatNumber(input.value.replace(/\D/g, ''));
        });
    });

    // 📌 Call to format the input fields when the page loads
    formatInputValues();
});


</script>


<?php
get_footer();
?>

