<footer>
    <div class="progress-container">
        <div class="progress-bar" id="progress-bar"></div>
        <div class="steps">
            <?php 
            $total_steps = 4; // Changed to 4 steps
            $current_step = isset($_GET['step']) ? (int) $_GET['step'] : 1; // Get current step from URL

            for ($i = 1; $i <= $total_steps; $i++) : 
                // Get current URL path
                $current_url = $_SERVER['REQUEST_URI'];
                $base_url = home_url('/');
                
                // Set specific URLs for steps 1 to 4
                if ($i == 1) {
                    $step_url = $base_url;
                } elseif ($i >= 2 && $i <= 4) {
                    $step_url = $base_url . 'step' . $i . '/';
                } else {
                    $step_url = add_query_arg('step', $i, get_permalink());
                }
                
                // Check if we're on a step page
                $is_step_page = strpos($current_url, '/step') !== false;
                
                // Make all steps active by default, except on step pages
                $active_class = $is_step_page ? ($i <= $current_step ? 'active' : '') : 'active';
            
                // Assign an ID only to Step 4 button
                $step_id = ($i == 4) ? 'id="step4-button"' : ''; 
            ?>
                <a href="<?php echo esc_url($step_url); ?>" 
                    class="step" 
                    data-step="<?php echo $i; ?>" <?php echo $step_id; ?>>
                    <?php
                    // Define icons for each step
                    switch($i) {
                        case 1:
                            echo '<i class="fas fa-rocket" title="Einleitung"></i>'; // Changed to "fas" for solid font
                            break;
                        case 2:
                            echo '<i class="fas fa-database" title="Basisdaten"></i>'; // Changed to "fas" for solid font
                            break;
                        case 3:
                            echo '<i class="fas fa-balance-scale" title="Bilanz"></i>'; // Changed to "fas" for solid font
                            break;
                        case 4:
                            echo '<i class="fas fa-chart-line" title="Prognose"></i>'; // Changed to "fas" for solid font
                            break;
                        default:
                            echo $i;
                    }
                    ?>
                </a>
            <?php endfor; ?>
        </div>
    </div>
</footer>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const step4Button = document.getElementById('step4-button');
    const submitButton = document.getElementById('submit-button');
    const progressBar = document.getElementById('progress-bar');
    const currentUrl = window.location.pathname;

    // Set progress bar to 100% if not on step1-3
    if (!currentUrl.includes('/step1') && !currentUrl.includes('/step2') && !currentUrl.includes('/step3')) {
        progressBar.style.width = '100%';
    }

    if (step4Button && submitButton) {
        step4Button.addEventListener('click', function(event) {
            event.preventDefault();
            console.log('Step 4 clicked, triggering submit button...');
            submitButton.click();
        });
    }
});
</script>

<?php wp_footer(); ?>
</body>
</html>
