<?php
/*
Template Name: Landing Template
*/

get_header();

// Get the current user info
$current_user = wp_get_current_user();
$button_text = 'Allgemeine Analyse';

if (is_user_logged_in()) {
    global $wpdb;
    $user_name = $current_user->user_login;

    // Prepare the SQL query
    $sql = $wpdb->prepare("
        SELECT m.first_name 
        FROM {$wpdb->prefix}swpm_members_tbl m
        JOIN {$wpdb->prefix}users u ON m.user_name = u.user_login
        WHERE u.user_login = %s
    ", $user_name);

    // Log the SQL query for verification
    error_log('SQL Query: ' . $sql);

    // Retrieve the user's first name from the swpm_members_tbl table
    $first_name = $wpdb->get_var($sql);

    // Fallback to display name if first name is not set
    if (empty($first_name)) {
        $first_name = $current_user->display_name;
    }

    $button_text = $first_name . "'s persönliche Analyse";
}
?>

<div class="site-content">
    <h1><?php the_title(); ?></h1>
</div>

<!-- wp:heading {"level":4,"style":{"color":{"text":"#182155"},"elements":{"link":{"color":{"text":"#182155"}}}}} -->
<h4 class="wp-block-heading has-text-color has-link-color" style="color:#182155">Wir möchten Dir gerne dabei helfen, Deine Finanzen besser zu verstehen.</h4>
<!-- /wp:heading -->

<!-- wp:heading {"level":3,"style":{"color":{"text":"#182155"},"elements":{"link":{"color":{"text":"#182155"}}}}} -->
<h3 class="wp-block-heading has-text-color has-link-color" style="color:#182155; padding-left: 30px">Bist Du dabei?</h3>
<!-- /wp:heading -->

<!-- wp:heading {"level":5,"style":{"color":{"text":"#182155"},"elements":{"link":{"color":{"text":"#182155"}}}}} -->
<h5 class="wp-block-heading has-text-color has-link-color" style="color:#182155">
  In weniger Schritten zu Deiner Finanzanalyse.<br /><br />
  Das wird Dir bestimmt dabei helfen, die folgenden Fragen besser beantworten zu können.
</h5>
<!-- /wp:heading -->

<!-- wp:spacer -->
<!-- <div style="height:6px" aria-hidden="true" class="wp-block-spacer"></div> -->
<!-- /wp:spacer -->

<!-- wp:heading {"level":5,"style":{"color":{"text":"#182155"},"elements":{"link":{"color":{"text":"#182155"}}}}} -->
<h5 class="wp-block-heading has-text-color has-link-color" style="color:#182155">
    &#8226 Reicht mein Altersguthaben um meinen Lebensstandard halten zu können?
</h5>
<!-- /wp:heading -->

<!-- wp:heading {"level":5,"style":{"color":{"text":"#182155"},"elements":{"link":{"color":{"text":"#182155"}}}}} -->
<h5 class="wp-block-heading has-text-color has-link-color" style="color:#182155">
    &#8226 Kann ich in meinem Einfamilienhaus bleiben? 
</h5>
<!-- /wp:heading -->

<!-- wp:heading {"level":5,"style":{"color":{"text":"#182155"},"elements":{"link":{"color":{"text":"#182155"}}}}} -->
<h5 class="wp-block-heading has-text-color has-link-color" style="color:#182155">
    &#8226 Wie sehen meine persönlichen Finanzen aktuell und in Zukunft aus?
</h5>
<!-- /wp:heading -->

<!-- wp:spacer -->
<div style="height:18px" aria-hidden="true" class="wp-block-spacer"></div>
<!-- /wp:spacer -->

<div class="wp-block-buttons">
    <div class="wp-block-button">
        <a href="<?php echo esc_url(home_url('/step2/')); ?>" class="back-button"><?php echo esc_html($button_text); ?></a>
    </div>
</div>

<?php
get_footer();
?>