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
            <td>
                <div class="slider-row">
                    <span class="table-heading">Risikoquote</span>
                    <input type="range" id="riskSlider" min="0" max="100" step="5" value="<?php echo esc_attr($values['risk_quote']); ?>" class="risk-slider">
                </div>
            </td>
            <td><input type="text" id="riskValue" value="<?php echo esc_attr($values['risk_quote']); ?>%" class="formatted-input" readonly></td>
        </tr>
        <tr>
            <td><span class="table-heading">verfügbare Liquidität</span></td>
            <td><input type="text" placeholder="Wert 2" value="<?php echo esc_attr($vfLiq); ?>" class="formatted-input" data-group="kurzfristig" maxlength="11" readonly></td>
        </tr>
    </tbody>
</table>

<div class="chart-container" id="googleChart"></div>

<div class="final-values">
    <div class="value-box">
        <span class="value-label">Potential nach 5 Jahren</span>
        <span class="value-amount" id="userFinalValue"></span>
    </div>
    <div class="value-box">
        <span class="value-label">Ø Potential mit 30% Risiko</span>
        <span class="value-amount" id="averageFinalValue"></span>
    </div>
</div>

<style>
.slider-container {
    display: flex;
    align-items: center;
    gap: 10px;
    width: 100%;
}

.slider-container .formatted-input {
    width: 80px;
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

.has-fixed-layout {
    width: 100%;
    max-width: 800px;
    margin: 20px auto;
    border-collapse: collapse;
    table-layout: fixed;
}

.has-fixed-layout td {
    padding: 4px;
    vertical-align: middle;
}

/* Add top margin for verfügbare Liquidität row */
.has-fixed-layout tr:nth-child(5) td {
    padding-top: 15px;
}

/* Style for primary color rows */
.has-fixed-layout tr:nth-child(5) .table-heading,
.has-fixed-layout tr:nth-child(6) .table-heading {
    color: var(--primary-color);
}

.has-fixed-layout tr:nth-child(5) .formatted-input,
.has-fixed-layout tr:nth-child(6) .formatted-input {
    color: var(--primary-color);
    border-color: var(--primary-color);
}

.has-fixed-layout td:first-child {
    width: 100%;
}

.has-fixed-layout td:last-child {
    width: 35%;
    text-align: right;
}

.has-fixed-layout tr:last-child td:last-child {
    width: 66%;
}

.table-heading {
    display: inline-block;
    width: 100%;
    text-align: left;
    font-size: 14px;
    padding-left: 15px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.final-values {
    width: 100%;
    max-width: 800px;
    margin: 20px auto 60px auto;
    display: flex;
    justify-content: center;
    gap: 15px;
}

.value-box {
    text-align: center;
}

.value-label {
    display: block;
    font-size: 13px;
    color: #666;
    margin-bottom: 5px;
}

.value-amount {
    display: block;
    font-size: 20px;
    font-weight: 600;
    color: #333;
}

.value-box:first-child .value-amount {
    color: var(--primary-color);
}

@media screen and (max-width: 600px) {

    .has-fixed-layout td:last-child {
        width: 40%;
    }

    .has-fixed-layout tr:last-child td:last-child {
        width: 70%;
    }

    .slider-container .formatted-input {
        width: 70px;
    }
}

@media screen and (max-width: 480px) {

    .has-fixed-layout td:last-child {
        width: 45%;
    }

    .has-fixed-layout tr:last-child td:last-child {
        width: 75%;
    }

    .slider-container .formatted-input {
        width: 60px;
    }
}

@media screen and (max-width: 360px) {

    .has-fixed-layout td:last-child {
        width: 50%;
    }

    .has-fixed-layout tr:last-child td:last-child {
        width: 80%;
    }

    .slider-container .formatted-input {
        width: 50px;
    }
}

.slider-row {
    display: flex;
    align-items: center;
    width: 100%;
}

.slider-row .table-heading {
    min-width: 100px;
    padding-left: 15px;
}

.slider-row .risk-slider {
    flex: 1;
    height: 8px;
    -webkit-appearance: none;
    background: #ddd;
    border-radius: 4px;
    outline: none;
}

.slider-row .risk-slider::-webkit-slider-thumb {
    -webkit-appearance: none;
    width: 20px;
    height: 20px;
    background: #0073aa;
    border-radius: 50%;
    cursor: pointer;
    transition: background 0.3s ease;
}

.slider-row .risk-slider::-webkit-slider-thumb:hover {
    background: #005177;
}

</style>

<script type="text/javascript">
document.addEventListener('DOMContentLoaded', function() {
    google.charts.load('current', {'packages':['corechart', 'line']});
    google.charts.setOnLoadCallback(drawChart);

    let chart = null;
    let data = null;

    function updateFinalValues(userData, averageData) {
        const finalUserValue = userData[userData.length - 1][1];
        const finalAverageValue = averageData[averageData.length - 1][1];
        
        document.getElementById('userFinalValue').textContent = formatNumber(finalUserValue);
        document.getElementById('averageFinalValue').textContent = formatNumber(finalAverageValue);
    }

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

        // Update the final values
        updateFinalValues(userData, averageData);

        data = new google.visualization.DataTable();
        data.addColumn('number', 'Jahr');
        data.addColumn('number', 'Potential');
        data.addColumn('number', 'Ø Potential (30%)');

        for (var i = 0; i < userData.length; i++) {
            data.addRow([userData[i][0], userData[i][1], averageData[i][1]]);
        }

        var options = {
            width: '100%',
            height: Math.max(200, Math.min(400, window.innerWidth * 0.4)),
            hAxis: { 
                ticks: [0, 1, 2, 3, 4, 5],
                gridlines: { color: '#f0f0f0' },
                textStyle: {
                    fontSize: 12
                }
            },
            vAxis: {
                gridlines: { color: '#f0f0f0' },
                textStyle: {
                    fontSize: 12
                }
            },
            legend: { 
                position: 'top',
                textStyle: {
                    fontSize: 12
                }
            },
            series: {
                0: { 
                    pointSize: 6, 
                    lineWidth: 3, 
                    color: '#0073aa' 
                },
                1: { 
                    pointSize: 6, 
                    lineWidth: 3, 
                    color: '#5b5e5d' 
                }
            },
            backgroundColor: '#d1f3ce',
            chartArea: {
                width: '80%',
                height: '70%',
                backgroundColor: '#d1f3ce',
                left: '10%',
                top: '15%'
            }
        };

        if (!chart) {
            chart = new google.visualization.LineChart(document.getElementById('googleChart'));
        }
        chart.draw(data, options);
    }

    // Format Numbers
    function formatNumber(number) {
        return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    // Format Input Values on Page Load
    function formatInputValues() {
        const inputs = document.querySelectorAll('.formatted-input');
        inputs.forEach(function(input) {
            const value = input.value.replace(/\D/g, '');
            input.value = formatNumber(value);
        });
    }

    // Event Listener for slider
    document.getElementById('riskSlider').addEventListener('input', function() {
        // Round to nearest 5
        const value = Math.round(this.value / 5) * 5;
        this.value = value;
        document.getElementById('riskValue').value = value + '%';
        drawChart();
    });

    // Format inputs on page load
    formatInputValues();
    // Add % sign to risk value on page load and round to nearest 5
    const initialValue = Math.round(document.getElementById('riskSlider').value / 5) * 5;
    document.getElementById('riskSlider').value = initialValue;
    document.getElementById('riskValue').value = initialValue + '%';

    // Handle window resize with debounce
    let resizeTimeout;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(function() {
            if (chart && data) {
                drawChart();
            }
        }, 250);
    });
});
</script>


<?php
get_footer();
?>

