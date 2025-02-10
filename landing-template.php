<?php
/*
Template Name: Landing Template
*/

get_header();
?>

<div class="site-content">
    <h1><?php the_title(); ?></h1>
</div>

<!-- wp:heading {"level":3,"style":{"elements":{"link":{"color":{"text":"#182155"}}},"color":{"text":"#182155"}}} -->
<h3 class="wp-block-heading has-text-color has-link-color" style="color:#182155">Herzlich Willkommen...</h3>
<!-- /wp:heading -->

<!-- wp:spacer {"height":"31px"} -->
<div style="height:31px" aria-hidden="true" class="wp-block-spacer"></div>
<!-- /wp:spacer -->

<!-- wp:heading {"level":3,"style":{"color":{"text":"#182155"},"elements":{"link":{"color":{"text":"#182155"}}}}} -->
<h3 class="wp-block-heading has-text-color has-link-color" style="color:#182155">Wir möchten gerne auf wichtige Fragen rund um Deine private Vermögenssituation eingehen.</h3>
<!-- /wp:heading -->

<!-- wp:spacer {"height":"26px"} -->
<div style="height:26px" aria-hidden="true" class="wp-block-spacer"></div>
<!-- /wp:spacer -->

<!-- wp:heading {"level":4,"style":{"color":{"text":"#182155"},"elements":{"link":{"color":{"text":"#182155"}}}}} -->
<h4 class="wp-block-heading has-text-color has-link-color" style="color:#182155"><strong>Reicht mein Altersguthaben um meinen Lebensstandard halten zu können? </strong></h4>
<!-- /wp:heading -->

<!-- wp:paragraph {"style":{"color":{"text":"#182155"},"elements":{"link":{"color":{"text":"#182155"}}}}} -->
<p class="has-text-color has-link-color" style="color:#182155"><strong>Kann ich in meinem Einfamilienhaus bleiben? </strong></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"style":{"color":{"text":"#182155"},"elements":{"link":{"color":{"text":"#182155"}}}}} -->
<p class="has-text-color has-link-color" style="color:#182155"><strong>Wie sehen meine persönlichen Finanzen aktuell und in Zukunft aus?</strong></p>
<!-- /wp:paragraph -->

<!-- wp:spacer -->
<div style="height:100px" aria-hidden="true" class="wp-block-spacer"></div>
<!-- /wp:spacer -->

<div class="wp-block-buttons">
    <div class="wp-block-button">
        <a href="<?php echo esc_url(home_url('/pure-gutenberg-bilanz/')); ?>" class="back-button">Private Bilanz</a>
    </div>
</div>

<?php
get_footer();
?>