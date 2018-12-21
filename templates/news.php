<?php
/**
 * News listing template
 */
?>
<?php get_header();?>
<div class="caritas-app-container">
  <section class="caritas-app-news-list">
    <h1>Aktualności</h1>
    <?php foreach ($NewsList->data as $article) {?>
      <article class="caritas-app-news-list-article">
        <h2>
          <a href="<?php echo site_url('/aktualnosci/' . $article->id); ?>" title="<?php echo $article->title; ?>">
            <?php echo $article->title; ?>
          </a>
        </h2>
        <?php if ($article->photo) {?>
          <img src="<?php echo $article->photo->url; ?>" />
        <?php }?>
      </article>
    <?php }?>
  </section>
</div>
<?php get_footer();?>