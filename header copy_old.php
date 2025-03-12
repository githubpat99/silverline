<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <!--
  <meta name="viewport" content="width=device-width, initial-scale=1">  -->
  
  <link rel="profile" href="https://gmpg.org/xfn/11">
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

  <header class="site-header container">
    <p class="site-title">
      <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
        <?php bloginfo('name'); ?>
      </a>
    </p>

    <p class="site-description"><?php bloginfo('description'); ?></p>

    <!-- Menu Toggle Button -->
    <button class="menu-toggle" id="menu-toggle">
      <span></span>
      <span></span>
      <span></span>
    </button>

    <!-- Navigation Menu -->
    <nav class="nav-menu">
      <?php
      wp_nav_menu(array(
          'theme_location' => 'menu-1',
          'menu_class'     => 'nav-menu',
      ));
      ?>
    </nav>
  </header>

</body>
</html>