<?php
/*
Template Name: Analysis Selection Template
*/

get_header();
?>

<div class="site-content">
    <h1><?php the_title(); ?></h1>
</div>

<!-- wp:heading {"level":4,"style":{"color":{"text":"#182155"},"elements":{"link":{"color":{"text":"#182155"}}}}} -->
<h4 class="wp-block-heading has-text-color has-link-color" style="color:#182155">Analyse deiner Zahlen - was möchtest du als nächstes tun.</h4>
<!-- /wp:heading -->

<div style="margin: 50px;">
    <table>

        <tr>
            <td style="padding-left: 0px"><button class="back-button" id="submit-button">New Button for Testing</button></td>

        <!-- <div class="wp-block-buttons"> 
            <td style="padding-left: 0px"><button class="back-button" id="prev-button">Zurück</button></td>
            <td style="padding-left: 0px"><button class="back-button" id="submit-button">Kennzahlen</button></td>
            <td style="padding-left: 0px"><button class="back-button" id="invest-button">Investitionsplan</button></td>
            -->
        </tr>
    </table>

    <button style="width: 200px;height: 50px;margin: 30px;">
    <a style="color: white; font-size: large" href="<?php echo home_url('/finKpis/'); ?>" class="step-button">Bilanzanalyse</a> </button>
    <button style="width: 200px;height: 50px;margin: 30px;">
    <a style="color: white; font-size: large" href="<?php echo home_url('/invest/'); ?>" class="step-button">Investitionsplan</a> </button>
    <button style="width: 200px;height: 50px;margin: 30px;">
    <a style="color: white; font-size: large" href="<?php echo home_url('/xxx/'); ?>" class="step-button">tbd...</a> </button>
</div>

<?php
get_footer();
?>