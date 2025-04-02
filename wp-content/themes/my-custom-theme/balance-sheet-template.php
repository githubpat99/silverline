<?php
/**
 * Template Name: Aktiva Passiva Dashboard
 * Description: A custom template that displays Aktiva and Passiva with navigation sections
 */

get_header();
?>

<div class="aktiva-passiva-dashboard">
    <div class="dashboard-container">
        <!-- Top Navigation Section -->
        <div class="nav-section nav-top">
            <div class="nav-box">
                <h3><?php echo get_theme_mod('top_nav_title', 'Finanzanalyse'); ?></h3>
                <p><?php echo get_theme_mod('top_nav_description', 'Die Finanzanalyse zeigt dir, wie es um Deine Finanzen steht.'); ?></p>
                <a href="<?php echo esc_url(get_theme_mod('top_nav_link', '/finKpis')); ?>" class="nav-button">
                    <?php echo get_theme_mod('top_nav_button_text', 'Analyse'); ?>
                </a>
            </div>
        </div>

        <div class="main-content-row">
            <!-- Left Navigation Section -->
            <div class="nav-section nav-left">
                <div class="nav-box">
                    <h3><?php echo get_theme_mod('left_nav_title', 'Transactions'); ?></h3>
                    <p><?php echo get_theme_mod('left_nav_description', 'Manage your financial transactions'); ?></p>
                    <a href="<?php echo esc_url(get_theme_mod('left_nav_link', '#')); ?>" class="nav-button">
                        <?php echo get_theme_mod('left_nav_button_text', 'Open Transactions'); ?>
                    </a>
                </div>
            </div>

            <!-- Main Balance Sheet Display -->
            <div class="balance-sheet">
                <?php
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
                $aktiva_value = $values['cash'] + $values['bank'] + $values['depot'] + $values['immo'] + $values['priv'] + $values['agh'];

                // Calculate Passiva (Liabilities)
                $passiva_value = $values['ccard'] + $values['credit'] + $values['pkfr'] + $values['hypo'] + $values['darlehen'] + $values['plfr'];

                // Calculate Schuldenquote with proper error handling
                $schuldenquote = 0;
                if ($aktiva_value > 0) {
                    $schuldenquote = ($passiva_value / $aktiva_value) * 100;
                }

                // Get the results from the database
                $liquiditaet = isset($values['liquiditaet']) ? $values['liquiditaet'] : 0;
                ?>
                
                <div class="balance-container">
                    <div class="aktiva-section">
                        <h2>Aktiva</h2>
                        <a href="<?php echo esc_url(home_url('/step3/')); ?>" class="value-display">
                            <?php echo number_format((float)$aktiva_value, 0, '.', ','); ?> CHF
                        </a>
                    </div>
                    
                    <div class="balance-divider"></div>
                    
                    <div class="passiva-section">
                        <h2>Passiva</h2>
                        <a href="<?php echo esc_url(home_url('/step3/')); ?>" class="value-display">
                            <?php echo number_format((float)$passiva_value, 0, '.', ','); ?> CHF
                        </a>
                    </div>
                </div>

                <!-- Results Section -->
                <div class="results-container">
                    <div class="result-item">
                        <span class="result-key">Liquidität:</span>
                        <span class="result-value"><?php echo number_format((float)$liquiditaet, 0, '.', ','); ?> CHF</span>
                    </div>
                    <div class="result-item">
                        <span class="result-key">Schuldenquote:</span>
                        <span class="result-value"><?php echo number_format((float)$schuldenquote, 1, '.', ','); ?> %</span>
                    </div>
                </div>
            </div>

            <!-- Right Navigation Section -->
            <div class="nav-section nav-right">
                <div class="nav-box">
                    <h3><?php echo get_theme_mod('right_nav_title', 'Vorsorge Plan'); ?></h3>
                    <p><?php echo get_theme_mod('right_nav_description', 'Plane Deine finanzielle Vorsorge'); ?></p>
                    <a href="<?php echo esc_url(get_theme_mod('right_nav_link', '#')); ?>" class="nav-button">
                        <?php echo get_theme_mod('right_nav_button_text', 'Vorsorge'); ?>
                    </a>
                </div>
            </div>
        </div>

        <!-- Bottom Navigation Section -->
        <div class="nav-section nav-bottom">
            <div class="nav-box">
                <h3><?php echo get_theme_mod('bottom_nav_title', 'Entwicklungs Prognose'); ?></h3>
                <p><?php echo get_theme_mod('bottom_nav_description', 'Entwicklung Deiner Finanzen'); ?></p>
                <a href="<?php echo esc_url(get_theme_mod('bottom_nav_link', '/invest')); ?>" class="nav-button">
                    <?php echo get_theme_mod('bottom_nav_button_text', 'Prognose'); ?>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Add CSS directly in the template or preferably in a separate stylesheet -->
<style>
    .aktiva-passiva-dashboard {
        max-width: 1200px;
        margin-top: 80px;
        margin-bottom: 80px;
        font-family: Arial, sans-serif;
    }
    
    .dashboard-container {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }
    
    .main-content-row {
        display: flex;
        gap: 20px;
    }
    
    .nav-section:hover {
        transform: translateY(-5px);
    }
    
    .nav-top, .nav-bottom {
        width: 90%;
    }
    
    .nav-left, .nav-right {
        width: 25%;
    }
    
    .nav-box {
        text-align: center;
    }
    
    .nav-box h3 {
        color: #333;
        margin-bottom: 10px;
    }
    
    .nav-box p {
        color: #666;
        margin-bottom: 15px;
    }
    
    .nav-button {
        display: inline-block;
        background-color: #2c3e50;
        color: white;
        padding: 10px 20px;
        border-radius: 5px;
        text-decoration: none;
        font-weight: bold;
        transition: background-color 0.3s ease;
    }
    
    .nav-button:hover {
        background-color: #1a2530;
    }
    
    .balance-container {
        display: flex;
        justify-content: space-between;
        align-items: stretch;
        height: 100%;
    }
    
    .aktiva-section, .passiva-section {
        width: 48%;
        text-align: center;
        display: flex;
        flex-direction: column;
    }
    
    .balance-divider {
        width: 2px;
        background-color: #ddd;
        margin: 0 10px;
    }
    
    .aktiva-section h2, .passiva-section h2 {
        color: #2c3e50;
        font-size: 24px;
        margin-bottom: 20px;
    }
    
    .value-display {
        font-size: 32px;
        font-weight: bold;
        color: #27ae60;
        padding: 15px;
        margin: auto;
        background-color: #f9f9f9;
        border-radius: 8px;
        box-shadow: inset 0 2px 5px rgba(0,0,0,0.05);
    }
    
    .passiva-section .value-display {
        color: #e74c3c;
    }
    
    .details-link {
        margin-top: 20px;
    }
    
    .details-link a {
        color: #3498db;
        text-decoration: none;
        font-size: 14px;
    }
    
    .details-link a:hover {
        text-decoration: underline;
    }
    
    .results-container {
        margin-top: 20px;
        padding: 15px;
        background-color: #f8f9fa;
        border-radius: 8px;
        display: flex;
        justify-content: space-around;
        flex-wrap: wrap;
        gap: 20px;
    }
    
    .result-item {
        text-align: center;
        padding: 10px 20px;
        background-color: white;
        border-radius: 6px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }

    
    /* Responsive adjustments */
    @media (max-width: 992px) {
        .main-content-row {
            flex-direction: column;
        }
        
        .nav-left, .nav-right {
            width: 90%;
        }
        
        .balance-container {
            flex-direction: column;
            gap: 20px;
        }
        
        .aktiva-section, .passiva-section {
            width: 100%;
        }
        
        .balance-divider {
            width: 100%;
            height: 2px;
            margin: 10px 0;
        }
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
