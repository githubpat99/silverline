<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  
  <!-- Make your site full-screen (PWA) -->
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">

  <link rel="profile" href="https://gmpg.org/xfn/11">
  
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  
  <!-- Add custom script to hide URL bar on mobile -->
  <script type="text/javascript">
    if (window.innerWidth <= 800) {
      setTimeout(function () {
        window.scrollTo(0, 1);
      }, 100);
    }
  </script>
  
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
