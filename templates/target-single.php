<?php
/**
 * Single Target template
 */
?>
<?php get_header();?>
<div class="caritas-app-container">
  <article class="caritas-app-target-single">
    <h1><?php echo $Target->name; ?></h1>
    <?php if (!empty($Target->gallery)) {?>
    <div class="caritas-app-target-gallery">
      <?php foreach ($Target->gallery as $photo) {?>
      <img src="<?php echo $photo->url; ?>" />
      <?php }?>
    </div>
    <?php }?>
    <div class="caritas-app-target-detailed-targets">
      <h3>Proponowane wpłaty</h3>
      <?php if (!empty($Target->target_amount)) {?>
      <div>
        Zebrano <?php echo caritas_app_get_formatted_price($Target->collected_amount); ?>zł z
        <?php echo caritas_app_get_formatted_price($Target->target_amount); ?>zł
      </div>
      <?php }?>
      <div>
        <?php foreach ($Target->detailedTargets as $detailedTarget) {?>
        <div class="caritas-app-target-detailed-target">
          <h5><?php echo $detailedTarget->name; ?></h5>
          <?php if ($detailedTarget->photo) {?>
          <img src="<?php echo $detailedTarget->photo->url; ?>" />
          <?php }?>
          <span class="caritas-app-target-detailed-target-price">
            <?php echo caritas_app_get_formatted_price($detailedTarget->price); ?>zł
          </span>
          <a href="<?php echo $Target->getPaymentFormUrl($detailedTarget->id, $detailedTarget->price) ?>">
            Wesprzyj
          </a>
        </div>
        <?php }?>
        <div class="caritas-app-target-detailed-target">
          <h5>Własna kwota</h5>
          <?php if ($Target->getCustomPricePhotoUrl()) {?>
          <img src="<?php echo $Target->getCustomPricePhotoUrl(); ?>" />
          <?php }?>
          <span class="caritas-app-target-detailed-target-price">
            Własna kwota
          </span>
          <a href="<?php echo $Target->getPaymentFormUrl() ?>">
            Wesprzyj
          </a>
        </div>
      </div>
    </div>
    <div><?php echo apply_filters('the_content', $Target->description); ?></div>
  </article>
</div>
<?php get_footer();?>