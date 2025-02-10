<?php
/*
Template Name: Balance Results
*/

get_header();
?>

<div class="site-content">
    <h1><?php the_title(); ?></h1>

    <?php
    $schuldenquote_value = 0; // Default value

    if (isset($_GET['results'])) {
        $results = json_decode(stripslashes(urldecode($_GET['results'])), true);

        if (is_array($results) && !empty($results)) {
            echo '<div class="results-container">';
            foreach ($results as $key => $value) {
                echo '<div class="result-item">';
                echo '<span class="result-key">' . esc_html($key) . ':</span>';
                
                // Clean and format the value
                if ($key === 'Schuldenquote') {
                    // Remove non-numeric characters except for the decimal point
                    $clean_value = preg_replace('/[^\d.]/', '', $value);
                    // Format as percentage
                    $formatted_value = number_format($clean_value, 2, '.', ',') . ' %';
                    $schuldenquote_value = (float)$clean_value; // Set the schuldenquote value for JavaScript
                } else {
                    // Remove non-numeric characters except for the decimal point
                    $clean_value = preg_replace('/[^\d.]/', '', $value);
                    // Format as currency without decimal places
                    $formatted_value = number_format($clean_value, 0, '.', ',') . ' CHF';
                }
                
                echo '<span class="result-value">' . esc_html($formatted_value) . '</span>';
                echo '</div>';
            }
            echo '</div>';
        } else {
            echo '<p class="error-message">Fehler bei der Verarbeitung der Ergebnisse. Bitte erneut versuchen.</p>';
        }
    } else {
        echo '<p class="error-message">Keine Ergebnisse gefunden. Bitte das Formular ausfüllen.</p>';
    }
    ?>

    <a href="<?php echo home_url('/next-balance/'); ?>" class="back-button">Private Bilanz</a>
</div>

<div class="chart-container" id="googleChart"></div>

<script type="text/javascript">
document.addEventListener('DOMContentLoaded', function() {
    google.charts.load('current', {'packages':['corechart', 'bar']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        // Get the schuldenquote value from PHP
        var schuldenquote = <?php echo json_encode($schuldenquote_value); ?>;
        var averageSchuldenquote = 49.9;  // Static average value for now

        // Prepare data for Google Chart with style roles for colors
        var data = google.visualization.arrayToDataTable([
            ['Kategorie', 'Wert in %', { role: 'style' }],
            ['Schuldenquote', schuldenquote, '#0073aa'], // Custom color for Schuldenquote
            ['Durchschnitt Schweiz', averageSchuldenquote, '#5b5e5d'] // Custom color for Durchschnitt Schweiz
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
            width: document.getElementById('googleChart').offsetWidth,
            height: document.getElementById('googleChart').offsetHeight
        };

        // Instantiate and draw the chart
        var chart = new google.visualization.ColumnChart(document.getElementById('googleChart'));
        chart.draw(data, options);
    }
});
</script>

<?php
get_footer();
?>
