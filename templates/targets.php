<?php
/**
 * Targets listing template
 */
?>
<?php get_header();?>
<div class="caritas-app-container">
  <section class="caritas-app-targets-list">
    <h1>Cele</h1>
    <?php foreach ($TargetsList->targets as $item) {?>
      <article class="caritas-app-targets-list-item">
        <?php if ($item->photo) {?>
          <img src="<?php echo $item->photo->url; ?>" />
        <?php }?>
        <h2>
          <a href="<?php echo site_url('/cele/' . $item->id); ?>" title="<?php echo $item->name; ?>">
            <?php echo $item->name; ?>
          </a>
        </h2>
        <p><?php echo apply_filters('the_content', $item->summary); ?></p>
      </article>
    <?php }?>
  </section>
</div>
<?php get_footer();?>