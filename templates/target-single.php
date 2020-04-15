<?php
/**
 * Single Target template
 */
?>
<?php global $caritas_app_plugin;?>
<?php get_header();?>
<div class="caritas-app-container">
  <article class="caritas-app-target-single">
    <h1><?php echo $Target->name; ?></h1>
    <?php if (!empty($Target->gallery)) {?>
    <div class="caritas-app-target-gallery">
      <div class="swiper-container">
        <div class="swiper-wrapper">
          <?php foreach ($Target->gallery as $photo) {?>
          <div class="swiper-slide">
            <div class="caritas-app-target-gallery-slide" style="background-image: url('<?php echo $photo->url; ?>');">
            </div>
          </div>
          <?php }?>
        </div>

        <div class="caritas-app-target-gallery-nav swiper-button-prev">
          <span class="caritas-app-target-gallery-icon">
            &lt;
          </span>
        </div>
        <div class="caritas-app-target-gallery-nav swiper-button-next">
          <span class="caritas-app-target-gallery-icon">
            &gt;
          </span>
        </div>
      </div>
    </div>
    <?php }?>

    <div class="caritas-app-target-detailed-targets">
      <?php if (!empty($Target->target_amount)) {?>
      <div>
        Zebrano <?php echo $Target->collected_amount; ?>zł z <?php echo $Target->target_amount; ?>zł
      </div>
      <?php }?>
      <h3>Proponowane wpłaty</h3>
      <ul class="caritas-app-cards">
        <?php foreach ($Target->detailedTargets as $detailedTarget) {?>
        <li class="caritas-app-card-item">
          <a href="<?php echo $Target->getPaymentFormUrl($detailedTarget->id, $detailedTarget->price) ?>">
            <div class="caritas-app-card">

              <div class="caritas-app-card-image"
                <?php if ($detailedTarget->photo) {?>style="background-image: url('<?php echo $detailedTarget->photo->url; ?>');"
                <?php }?>>


                <span
                  class="caritas-app-card-detailed-ammount"><?php echo caritas_app_get_formatted_price($detailedTarget->price); ?>zł</span>
              </div>
              <div class="caritas-app-card-content">
                <h4 class="caritas-app-card-title"><?php echo $detailedTarget->name; ?></h4>

                <a href="<?php echo $Target->getPaymentFormUrl($detailedTarget->id, $detailedTarget->price) ?>">
                  <button class="caritas-app-btn caritas-app-card-btn">Wspieram</button>
                </a>
              </div>
            </div>
          </a>
        </li>
        <?php }?>

        <?php if ($caritas_app_plugin->customPriceEnabled) {?>
        <li class="caritas-app-card-item">
          <a href="<?php echo $Target->getPaymentFormUrl() ?>">
            <div class="caritas-app-card">
              <div class="caritas-app-card-image" <?php if ($Target->getCustomPricePhotoUrl()) {?>
                style="background-image: url('<?php echo $Target->getCustomPricePhotoUrl(); ?>');" <?php }?>>
              </div>
              <div class="caritas-app-card-content">
                <h4 class="caritas-app-card-title">Własna kwota</h4>
                <a href="<?php echo $Target->getPaymentFormUrl() ?>">
                  <button class="caritas-app-btn caritas-app-card-btn">Wspieram</button>
                </a>
              </div>
            </div>
          </a>
        </li>
        <?php }?>

      </ul>


    </div>
    <div class="caritas-app-description">
      <h3>Opis</h3>
      <p><?php echo apply_filters('the_content', $Target->description); ?></p>
    </div>


  </article>
</div>
<?php get_footer();?>