<?php
/*
Template Name: Sparziele Template
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
    'purchase' => '30000',
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

foreach ($values as $key => $val) {
    // Ignoriere das Feld 'message', da das kein numerischer Wert ist
    if ($key !== 'message') {
        $values[$key] = floatval(str_replace('.', '', $val));
    }
}

// Calculate the liquiditaet value
$values['liquiditaet'] = $values['cash'] + $values['bank'] + $values['depot'];

$vfLiq = $values['liquiditaet'] - $values['liq_quote'] - $values['depot'];
$sparquote = $values['spar_quote']; // Monthly savings amount
$anschaffungskosten = $values['purchase']; // Target amount
$liquiditaet = $values['liquiditaet']; // Current liquidity

?>

<div class="site-content">
    <div class="summary-container">

        <table class="prognose-table">
            <p class="summary-title">Sparziel</p>
            <tbody>
                <tr>
                    <td><span class="table-heading">verfügbare Liquidität</span></td>
                    <td><input type="text" placeholder="Wert 2" value="<?php echo esc_attr($vfLiq); ?>" class="formatted-input" data-group="kurzfristig" maxlength="11" readonly></td>
                </tr>
                <tr>
                    <td><span class="table-heading">Sparquote / Monat</span></td>
                    <td><input type="text" placeholder="Wert 3" value="<?php echo esc_attr($values['spar_quote']); ?>" class="formatted-input" data-group="kurzfristig" maxlength="11" readonly></td>
                </tr>
                <tr>
                    <td colspan="2"><hr></td>
                </tr>
                <tr>

                    <td><span class="table-heading">Zinssatz / Jahr</span></td>
                    <td>
                    <div class="input-button-group">
                        <input type="number" id="zinsInput" value="5" step="1">
                        <button class="button-Count" id="zinsPlus">+</button>
                        <button class="button-Count" id="zinsMinus">−</button>
                    </div>

                    </td>
                </tr>
                <tr>
                    <td><span class="table-heading">Sparziel</span></td>
                    <td>
                        <div class="input-button-group">
                        <input type="text" id="zielInputFormatted" value="<?php echo number_format($anschaffungskosten, 0, ',', '.'); ?>">
                            <button class="button-Count" id="zielPlus">+</button>
                            <button class="button-Count" id="zielMinus">−</button>
                        </div>
                    </td>

                </tr>
            </tbody>
        </table>    
        
    </div>

<div id="zielmeldung" style="padding-left: 20px; padding-right: 20px; margin-top: 1em;"></div>

<div class="graph-wrapper">
    <div id="chart_div" style="width: 100%; height: 300px;"></div>
    <!-- <canvas id="chart_div"></canvas> -->
</div>

<div id="chart_div" style="width: 100%; height: 300px;"></div>

</div>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    google.charts.load('current', { packages: ['corechart'] });
    google.charts.setOnLoadCallback(initChart);

    function initChart() {
        const zinsInput = document.getElementById('zinsInput');
        const zielInputFormatted = document.getElementById('zielInputFormatted');

        const zielPlus = document.getElementById('zielPlus');
        const zielMinus = document.getElementById('zielMinus');
        const zinsPlus = document.getElementById('zinsPlus');
        const zinsMinus = document.getElementById('zinsMinus');

        function getZielValue() {
            const raw = zielInputFormatted.value.replace(/\./g, '');
            return parseInt(raw) || 0;
        }

        function setZielValue(val) {
            zielInputFormatted.value = val.toLocaleString('de-DE');
        }

        zielInputFormatted.addEventListener('input', () => {
            const clean = zielInputFormatted.value.replace(/\./g, '').replace(/[^0-9]/g, '');
            zielInputFormatted.value = Number(clean).toLocaleString('de-DE');
            drawChart();
        });

        zielPlus.addEventListener('click', () => {
            const current = getZielValue();
            setZielValue(current + 1000);
            drawChart();
        });

        zielMinus.addEventListener('click', () => {
            const current = getZielValue();
            setZielValue(Math.max(0, current - 1000));
            drawChart();
        });

        zinsPlus.addEventListener('click', () => {
            zinsInput.value = parseInt(zinsInput.value) + 1;
            drawChart();
        });

        zinsMinus.addEventListener('click', () => {
            zinsInput.value = Math.max(0, parseInt(zinsInput.value) - 1);
            drawChart();
        });

        zinsInput.addEventListener('input', drawChart);

        function drawChart() {
            const zinssatz = parseFloat(zinsInput.value) || 0;
            const zielbetrag = getZielValue();
            const liquiditaet = <?php echo (int)$vfLiq; ?>;
            const sparquote = <?php echo (int)$sparquote; ?>;

            const zinsMonat = Math.pow(1 + (zinssatz / 100), 1 / 12) - 1;
            let current = liquiditaet;
            let monate = 0;
            const dataArray = [['Monat', 'Gesamtbetrag']];

            while (current < zielbetrag && monate <= 360) {
                monate++;
                current = (current + sparquote) * (1 + zinsMonat);
                dataArray.push([monate, Math.round(current)]);
            }

            const data = google.visualization.arrayToDataTable(dataArray);
            const options = {
                hAxis: { title: 'Monate', format: '0', textStyle: { fontSize: 12 } },
                vAxis: { textPosition: 'none' },
                legend: 'none',
                colors: ['#0073aa'],
                pointSize: 1,
                chartArea: { width: '80%', height: '70%', top: 10, left: 10, right: 10},
                height: 250
            };

            const chart = new google.visualization.LineChart(document.getElementById('chart_div'));
            chart.draw(data, options);

            const months = monate; // kommt von deiner Berechnung
            const years = Math.floor(months / 12);
            const remainingMonths = months % 12;

            const targetReached = liquiditaet >= zielbetrag;

            let message = '';
            const maxYears = 30;

            if (targetReached) {
                message = '🎯 Du hast dein Ziel bereits erreicht.';
            } else if (years > maxYears) {
                message = `🕰️ Du würdest dein Ziel in über ${maxYears} Jahren erreichen – das ist sehr langfristig.`;
            } else {
                let formattedTime = '';

                if (years > 0 && remainingMonths > 0) {
                    formattedTime = `${years} Jahr${years > 1 ? 'en' : ''} und ${remainingMonths} Monat${remainingMonths > 1 ? 'en' : ''}`;
                } else if (years > 0) {
                    formattedTime = `${years} Jahr${years > 1 ? 'en' : ''}`;
                } else if (remainingMonths > 0) {
                    formattedTime = `${remainingMonths} Monat${remainingMonths > 1 ? 'en' : ''}`;
                } else {
                    formattedTime = 'weniger als einem Monat';
                }

                message = `Du erreichst dein Ziel voraussichtlich in etwa ${formattedTime}. 📈`;
            }

            document.getElementById('zielmeldung').textContent = message;


        }

        drawChart();
    }
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const inputs = document.querySelectorAll('.formatted-input');

    // Zahlen formatieren
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