<?php
/**
 * Single news article template
 */
?>
<?php get_header();?>
<div class="caritas-app-container">
  <article class="caritas-app-news-single">
    <h1><?php echo $News->title; ?></h1>
    <span class="caritas-app-news-date">
      <?php echo $News->created_at; ?>
    </span>
    <?php if (!empty($News->gallery)) {?>
      <div class="caritas-app-news-gallery">
        <?php foreach ($News->gallery as $photo) {?>
          <img src="<?php echo $photo->url; ?>" />
        <?php }?>
      </div>
    <?php }?>
    <div class="caritas-app-news-single-content">
      <?php echo apply_filters('the_content', $News->content); ?>
    </div>
  </article>
</div>
<?php get_footer();?>
