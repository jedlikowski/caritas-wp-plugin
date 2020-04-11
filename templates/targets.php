<?php
/**
 * Targets listing template
 */
?>
<?php get_header();?>
<div class="caritas-app-container">
  <section class="caritas-app-targets-list">
    <h1 class="caritas-app-title">Cele</h1>
    <ul class="caritas-app-cards">
      <?php foreach ($TargetsList->targets as $item) {?>
      <li class="caritas-app-card-item">
        <a href="<?php echo site_url('/cele/' . $item->id); ?>" title="<?php echo $item->name; ?>">
          <div class="caritas-app-card">
            <?php if ($item->photo) {?>
            <div class="caritas-app-card-image" style="background-image: url('<?php echo $item->photo->url; ?>');">
            </div>
            <?php }?>
            <div class="caritas-app-card-content">
              <h2 class="caritas-app-card-title"><?php echo $item->name; ?></h2>
              <div class="caritas-app-card-text">
                <?php echo apply_filters('the_content', $item->summary); ?>
              </div>
              <div class="caritas-app-btn-container">
                <a href="<?php echo site_url('/cele/' . $item->id); ?>" title="<?php echo $item->name; ?>">
                  <button class="caritas-app-btn caritas-app-card-btn">Wspieram</button>
                </a>
              </div>
            </div>
          </div>
        </a>
      </li>
      <?php }?>
    </ul>
  </section>
</div>
<?php get_footer();?>