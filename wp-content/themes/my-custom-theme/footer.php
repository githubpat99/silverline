<footer>
    <div class="progress-container">
        <div class="progress-bar" id="progress-bar"></div>
        <div class="steps">
            <?php 
            $total_steps = 3; // Define the number of steps
            $current_step = isset($_GET['step']) ? (int) $_GET['step'] : 1; // Get current step from URL

            for ($i = 1; $i <= $total_steps; $i++) : 
                $active_class = ($i <= $current_step) ? 'active' : '';
            
                // Get the base URL dynamically
                $base_url = home_url('/');
            
                // Set specific URLs for steps 1 to 4
                if ($i == 1) {
                    $step_url = $base_url;
                } elseif ($i >= 2 && $i <= 4) {
                    $step_url = $base_url . 'step' . $i . '/';
                } else {
                    $step_url = add_query_arg('step', $i, get_permalink());
                }
            
                // Assign an ID only to Step 4 button
                $step_id = ($i == 4) ? 'id="step4-button"' : ''; 
            ?>
                <a href="<?php echo esc_url($step_url); ?>" class="step <?php echo $active_class; ?>" data-step="<?php echo $i; ?>" <?php echo $step_id; ?>>
                    <?php echo $i; ?>
                </a>
            <?php endfor; ?>
        </div>
    </div>
</footer>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const step4Button = document.getElementById('step4-button'); // Now correctly assigned in PHP
    const submitButton = document.getElementById('submit-button'); // Ensure this ID exists in your form

    if (step4Button && submitButton) {
        step4Button.addEventListener('click', function(event) {
            event.preventDefault(); // Prevents navigation
            console.log('Step 4 clicked, triggering submit button...');
            submitButton.click(); // Simulates form submission
        });
    }
});
</script>

<?php wp_footer(); ?>
</body>
</html>
