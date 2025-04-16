<?php
/**
 * Template Name: Aktiva Passiva Dashboard
 * Description: A custom template that displays Aktiva and Passiva with navigation sections
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

<div class="site-content">

<div class="summary-row">
    <div class="summary-item-aktiven activa-background">
        <h4 class="summary-title">Aktiven</h4>
        <span id="total-aktiven" class="total-value">
                <?php echo number_format((float)$aktiva_value, 0, '.', '.'); ?>
        </span>
    </div>
    <div class="summary-item-passiven passiva-background">
        <h4 class="summary-title">Passiven</h4>
        <span id="total-passiven" class="total-value">
            <?php echo number_format((float)$passiva_value, 0, '.', '.'); ?>
        </span>
    </div>
</div>

<!-- separator -->
<div><hr class="custom-separator">
    </div>
<!-- wp:columns -->

<div class="aktiva-passiva-dashboard">
    <div class="dashboard-container">
        <!-- Top Navigation Section -->
        <div class="nav-section nav-top">
            <div class="nav-box">
                <p><?php echo get_theme_mod('top_nav_description', "Wie steht's um deine Finanzen?"); ?></p>
                <a href="<?php echo esc_url(get_theme_mod('top_nav_link', '/finKpis')); ?>" class="nav-button">
                    <?php echo get_theme_mod('top_nav_button_text', 'Bilanzanalyse'); ?>
                </a>
            </div>
        </div>

        <!-- Navigation Section -->
        <div class="nav-section nav-bottom">
            <div class="nav-box">
                <p><?php echo get_theme_mod('bottom_nav_description', 'Entwicklung Deiner Finanzen'); ?></p>
                <a href="<?php echo esc_url(get_theme_mod('bottom_nav_link', '/invest')); ?>" class="nav-button">
                    <?php echo get_theme_mod('bottom_nav_button_text', 'Prognose'); ?>
                </a>
            </div>
        </div>

        <!-- Bottom Navigation Section -->
        <div class="nav-section nav-bottom">
            <div class="nav-box">
                <p><?php echo get_theme_mod('bottom_nav_description', 'Member Funktionen'); ?></p>
                
                <?php if (is_user_logged_in()) : ?>
                    <!-- Show buttons with links for logged-in users -->
                    <a href="<?php echo esc_url(get_theme_mod('bottom_nav_link', '/invest')); ?>" class="nav-button">
                        <?php echo get_theme_mod('bottom_nav_button_text', 'Tragbarkeit'); ?>
                    </a>
                    <a href="<?php echo esc_url(get_theme_mod('bottom_nav_link', '/invest')); ?>" class="nav-button">
                        <?php echo get_theme_mod('bottom_nav_button_text', 'Sparziele'); ?>
                    </a>
                <?php else : ?>
                    <!-- Show hidden buttons without links for guests -->
                    <a class="nav-button-hidden">
                        <?php echo get_theme_mod('bottom_nav_button_text', 'Tragbarkeit'); ?>
                    </a>
                    <a class="nav-button-hidden">
                        <?php echo get_theme_mod('bottom_nav_button_text', 'Sparziele'); ?>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
</div>

<!-- Add CSS directly in the template or preferably in a separate stylesheet -->
<style>
    .aktiva-passiva-dashboard {
        max-width: 1200px;
        margin-bottom: 80px;
        margin-top: 24px;
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
