<?php
/*
Template Name: Balance Results
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
    'inherit' => '0'
);

// Merge stored values with default values
$values = array_merge($default_values, $stored_values ? $stored_values : array());

// Calculate Aktiva (Assets)
$aktiva = $values['cash'] + $values['bank'] + $values['depot'] + $values['immo'] + $values['priv'] + $values['agh'];

// Calculate Passiva (Liabilities)
$passiva = $values['ccard'] + $values['credit'] + $values['pkfr'] + $values['hypo'] + $values['darlehen'] + $values['plfr'];

// Calculate Schuldenquote with proper error handling
$schuldenquote = 0;
if ($aktiva > 0) {
    $schuldenquote = ($passiva / $aktiva) * 100;
}

// Get the liquiditaet value
$liquiditaet = isset($values['liquiditaet']) ? (float)$values['liquiditaet'] : 0;
$message = isset($values['message']) ? $values['message'] : '';
?>

<?php if (!empty($message)) : ?>
    <p class="result-message"><?php echo esc_html($message); ?></p>
<?php endif; ?>

<div class="result-table">
    <table>
        <tr>
            <td><span class="result-label">Liquidität:</span></td>
            <td><span class="result-value"><?php echo number_format($liquiditaet, 0, '.', '.'); ?> CHF</span></td>
        </tr>
        <tr>
            <td><span class="result-label">Schuldenquote:</span></td>
            <td><span class="result-value"><?php echo number_format($schuldenquote, 1, '.', '.'); ?> %</span></td>
        </tr>
    </table>
</div>



<div class="chart-container" id="googleChart"></div>

<script type="text/javascript">
document.addEventListener('DOMContentLoaded', function() {
    google.charts.load('current', {'packages':['corechart', 'bar']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        // Get the schuldenquote value from PHP and ensure it's a number
        var schuldenquote = parseFloat(<?php echo json_encode($schuldenquote); ?>);
        var averageSchuldenquote = 49.9;  // Static average value for now

        // Prepare data for Google Chart with style roles for colors
        var data = google.visualization.arrayToDataTable([
            ['Kategorie', 'Wert in %', { role: 'style' }],
            ['Schuldenquote', schuldenquote, '#0073aa'], // Custom color for Schuldenquote
            ['Schweiz Ø - Quelle Blick(2024)', averageSchuldenquote, '#5b5e5d'] // Custom color for Durchschnitt Schweiz
        ]);

        // Chart options
        var options = {
            chart: {
                title: 'Schuldenquote vs. Average Schuldenquote',
                subtitle: 'Comparison of personal and average debt ratio',
            },
            bars: 'vertical',
            vAxis: {minValue: 0}, // Removed title
            hAxis: {}, // Removed title
            legend: { position: 'none' }, // Disable legend
            chartArea: {
                width: '80%',
                height: '70%',
                backgroundColor: '#f8f9fa'  // Same as results-container background
            },
            backgroundColor: '#f8f9fa',     // Chart background
            width: '100%',
            height: '100%',
            colors: ['#0073aa', '#5b5e5d'] // Match your theme colors
        };

        // Create and draw the chart
        var chart = new google.visualization.ColumnChart(document.getElementById('googleChart'));
        chart.draw(data, options);

        // Redraw chart when window is resized
        window.addEventListener('resize', function() {
            chart.draw(data, options);
        });
    }
});
</script>

<style>
.results-container {
    max-width: 800px;
    margin: 40px auto;
    padding: 20px;
    background-color: #f8f9fa;
    border-radius: 8px;
    display: flex;
    justify-content: space-around;
    flex-wrap: wrap;
    gap: 20px;
}

.result-item {
    text-align: center;
    padding: 15px 25px;
    background-color: white;
    border-radius: 6px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    min-width: 200px;
}

.result-key {
    display: block;
    color: #2c3e50;
    font-size: 16px;
    margin-bottom: 5px;
}

.back-button {
    display: inline-block;
    margin: 20px auto;
    padding: 10px 20px;
    background-color: #2c3e50;
    color: white;
    text-decoration: none;
    border-radius: 5px;
    font-weight: bold;
    transition: background-color 0.3s ease;
}

.back-button:hover {
    background-color: #1a2530;
}



.result-label {
    display: inline-block;
    width: 100%;
    text-align: left;
    font-size: 14px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.chart-container {
    width: 100%;
    max-width: 800px;
    height: 400px;
    margin: 40px auto;
    padding: 20px;
    border-radius: 8px;
    position: relative;
    overflow: hidden;
}

@media screen and (max-width: 782px) {
    .chart-container {
        height: 250px;
        margin: 20px auto;
        padding: 15px;
    }
}

@media screen and (max-width: 600px) {
    .chart-container {
        height: 200px;
        margin: 15px auto;
        padding: 10px;
    }
}

@media screen and (max-width: 480px) {
    .chart-container {
        padding: 0;
    }
}
</style>

<?php
get_footer();
?>
