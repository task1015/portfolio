<?php get_header();

global $post;
$slug = $post->post_name;
?>

<main id="<?php echo $slug; ?>">
  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
      <?php the_content(); ?>
  <?php endwhile;
  endif; ?>
</main>

<?php get_footer(); ?>