<div class="caritas-app-target-detailed-targets">
  <ul class="caritas-app-cards">
    <?php foreach ($detailed_targets as $detailed_target) {?>
    <li class="caritas-app-card-item">
      <a href="<?php echo $target->getPaymentFormUrl($detailed_target->id, $detailed_target->price) ?>">
        <div class="caritas-app-card">

          <div class="caritas-app-card-image"
            <?php if ($detailed_target->photo) {?>style="background-image: url('<?php echo $detailed_target->photo->url; ?>');"
            <?php }?>>
            <span class="caritas-app-card-detailed-ammount">
              <?php echo caritas_app_get_formatted_price($detailed_target->price); ?>zł
            </span>
          </div>
          <div class="caritas-app-card-content">
            <h4 class="caritas-app-card-title"><?php echo $detailed_target->name; ?></h4>

            <?php if (!empty($payment_button_text)) {?>
            <a href="<?php echo $target->getPaymentFormUrl($detailed_target->id, $detailed_target->price) ?>">
              <button class="caritas-app-btn caritas-app-card-btn">
                <?php echo $payment_button_text; ?>
              </button>
            </a>
            <?php }?>
          </div>
        </div>
      </a>
    </li>
    <?php }?>

    <?php if ($custom_price_enabled) {?>
    <li class="caritas-app-card-item">
      <a href="<?php echo $target->getPaymentFormUrl() ?>">
        <div class="caritas-app-card">
          <div class="caritas-app-card-image" <?php if ($target->getCustomPricePhotoUrl()) {?>
            style="background-image: url('<?php echo $target->getCustomPricePhotoUrl(); ?>');" <?php }?>>
          </div>
          <div class="caritas-app-card-content">
            <h4 class="caritas-app-card-title">Własna kwota</h4>
            <?php if (!empty($payment_button_text)) {?>
            <a href="<?php echo $target->getPaymentFormUrl() ?>">
              <button class="caritas-app-btn caritas-app-card-btn">
                <?php echo $payment_button_text; ?>
              </button>
            </a>
            <?php }?>
          </div>
        </div>
      </a>
    </li>
    <?php }?>
  </ul>
</div>
