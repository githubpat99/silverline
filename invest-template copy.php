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
            <td><input type="text" placeholder="Wert 3" value="<?php echo esc_attr($values['spar_quote']); ?>" class="formatted-input" data-group="kurzfristig" maxlength="11" readonly></td>
        </tr>
        <tr>
            <td><span class="table-heading">Liquiditätsquote</span></td>
            <td><input type="text" placeholder="Wert 1" value="<?php echo esc_attr($values['liq_quote']); ?>" class="formatted-input" data-group="kurzfristig" maxlength="11" readonly></td>
        </tr>
        <tr>
            <td><span class="table-heading">Liquidität</span></td>
            <td><input type="text" placeholder="Wert 2" value="<?php echo esc_attr($values['liquiditaet']); ?>" class="formatted-input" data-group="kurzfristig" maxlength="11" readonly></td>
        </tr>
        <tr>
            <td><span class="table-heading">Investments</span></td>
            <td><input type="text" placeholder="Wert 2" value="<?php echo esc_attr($values['depot']); ?>" class="formatted-input" data-group="kurzfristig" maxlength="11" readonly></td>
        </tr>
        <tr>
            <td><span class="table-heading">verfügbare Liquidität</span></td>
            <td><input type="text" placeholder="Wert 2" value="<?php echo esc_attr($vfLiq); ?>" class="formatted-input" data-group="kurzfristig" maxlength="11" readonly></td>
        </tr>
        <tr>
            <td><span class="table-heading">Risikoquote</span></td>
            <td>
                <div class="slider-container">
                    <input type="range" id="riskSlider" min="0" max="100" value="<?php echo esc_attr($values['risk_quote']); ?>" class="risk-slider">
                    <input type="text" id="riskValue" value="<?php echo esc_attr($values['risk_quote']); ?>" class="formatted-input" readonly>
                </div>
            </td>
        </tr>
    </tbody>
</table>

<div class="chart-container" id="googleChart"></div>

<style>
.chart-container {
    width: 100%;
    max-width: 800px;
    margin: 20px auto;
    padding: 15px;
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.slider-container {
    display: flex;
    align-items: center;
    gap: 10px;
}

.risk-slider {
    flex: 1;
    height: 8px;
    -webkit-appearance: none;
    background: #ddd;
    border-radius: 4px;
    outline: none;
}

.risk-slider::-webkit-slider-thumb {
    -webkit-appearance: none;
    width: 20px;
    height: 20px;
    background: #0073aa;
    border-radius: 50%;
    cursor: pointer;
    transition: background 0.3s ease;
}

.risk-slider::-webkit-slider-thumb:hover {
    background: #005177;
}

.formatted-input {
    background-color: #f8f9fa;
    border: 1px solid #ddd;
    border-radius: 4px;
    padding: 5px 10px;
    width: 120px;
    text-align: right;
}

@media (max-width: 768px) {
    .chart-container {
        padding: 10px;
    }
    
    .formatted-input {
        width: 100px;
    }
}
</style>

<script type="text/javascript">
document.addEventListener('DOMContentLoaded', function() {
    google.charts.load('current', {'packages':['corechart', 'line']});
    google.charts.setOnLoadCallback(drawChart);

    let chart = null;
    let data = null;

    function drawChart() {
        var availableLiquidity = <?php echo json_encode($vfLiq); ?>;
        var riskQuote = parseFloat(document.getElementById('riskSlider').value);
        var averageRiskQuote = 30;

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

        data = new google.visualization.DataTable();
        data.addColumn('number', 'Jahr');
        data.addColumn('number', 'Potential');
        data.addColumn('number', 'Ø Potential');

        for (var i = 0; i < userData.length; i++) {
            data.addRow([userData[i][0], userData[i][1], averageData[i][1]]);
        }

        var options = {
            width: '100%',
            height: 400,
            hAxis: { 
                textPosition: 'none',
                gridlines: { color: '#f0f0f0' }
            },
            vAxis: {
                gridlines: { color: '#f0f0f0' }
            },
            legend: { position: 'top' },
            series: {
                0: { pointSize: 6, lineWidth: 3, color: '#0073aa' },
                1: { pointSize: 6, lineWidth: 3, color: '#5b5e5d' }
            },
            backgroundColor: '#ffffff',
            chartArea: {
                width: '80%',
                height: '70%',
                backgroundColor: '#ffffff'
            }
        };

        if (!chart) {
            chart = new google.visualization.LineChart(document.getElementById('googleChart'));
        }
        chart.draw(data, options);

        // Update table
        updateTable(userData, averageData);
    }

    function updateTable(userData, averageData) {
        let existingTable = document.querySelector('.chart-table');
        if (existingTable) {
            existingTable.remove();
        }

        var tableHTML = '<div class="chart-table" style="overflow-x:auto; margin-top: 20px;">';
        tableHTML += '<table style="width: 100%; border-collapse: collapse; text-align: center; font-size: 10px; table-layout: fixed;">';
        tableHTML += '<tr><th style="border: 1px solid #ddd; padding: 8px;"></th>';

        for (var year = 0; year <= 5; year++) {
            tableHTML += '<th style="border: 1px solid #ddd; padding: 8px; white-space: nowrap;">J +' + year + '</th>';
        }

        tableHTML += '</tr>';

        tableHTML += '<tr><td style="border: 1px solid #ddd; padding: 8px;">Pot.</td>';
        for (var i = 0; i <= 5; i++) {
            tableHTML += '<td style="border: 1px solid #ddd; padding: 8px;">' + formatNumber(userData[i][1]) + '</td>';
        }
        tableHTML += '</tr>';

        tableHTML += '<tr><td style="border: 1px solid #ddd; padding: 8px;">Ø</td>';
        for (var i = 0; i <= 5; i++) {
            tableHTML += '<td style="border: 1px solid #ddd; padding: 8px;">' + formatNumber(averageData[i][1]) + '</td>';
        }
        tableHTML += '</tr>';

        tableHTML += '</table>';
        tableHTML += '</div>';

        document.getElementById('googleChart').insertAdjacentHTML('afterend', tableHTML);
    }

    // Format Numbers
    function formatNumber(number) {
        return number.toLocaleString('de-DE');
    }

    // Format Input Values on Page Load
    function formatInputValues() {
        const inputs = document.querySelectorAll('.formatted-input');
        inputs.forEach(function(input) {
            input.value = formatNumber(input.value.replace(/\D/g, ''));
        });
    }

    // Event Listener for slider
    document.getElementById('riskSlider').addEventListener('input', function() {
        document.getElementById('riskValue').value = this.value;
        drawChart();
    });

    // Format inputs on page load
    formatInputValues();

    // Handle window resize
    window.addEventListener('resize', function() {
        if (chart && data) {
            chart.draw(data, chart.getOptions());
        }
    });
});
</script>


<?php
get_footer();
?>

