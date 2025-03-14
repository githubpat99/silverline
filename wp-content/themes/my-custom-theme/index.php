<?php get_header(); ?>

<div class="site-content">
  
  <?php
  if (have_posts()) :
    while (have_posts()) :
      the_post();
  ?>
      <article <?php post_class(); ?>>

        <?php the_post_thumbnail(); ?>

        <header class="entry-header">
          <?php the_title('<h1 class="entry-title">', '</h1>'); ?>
        </header>

        <div class="entry-content">
          <?php the_content(esc_html__('Continue reading &rarr;', 'my-custom-theme')); ?>
        </div>

      </article>

  <?php
      if (comments_open() || get_comments_number()) :
        comments_template();
      endif;
    endwhile;

  else :
    get_template_part('content-none');
  endif;
  ?>

</div>

<?php get_footer(); ?>