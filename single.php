<?php get_header();

global $post;
$slug = $post->post_name;
?>

<main id="<?php echo $slug; ?>">
  <div class="box1">
    <?php
    if (have_posts()) :
      while (have_posts()) : the_post(); ?>
        <article class="block_blog">
          <h2 class="tit18"><span><?php the_title(); ?></span></h2>
          <div class="post_info_date_edit"><time>公開日:<?php the_time('Y/m/d'); ?></time></div>
          <?php the_content(); ?>
        </article>
      <?php endwhile; ?>
    <?php endif; ?>
  </div>
</main>

<?php get_footer(); ?>