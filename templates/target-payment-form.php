<?php
/**
 * Single Target Payment methods list template
 */
?>
<?php get_header();?>
<div class="caritas-app-container">
  <div class="caritas-app-target-payment-methods">
    <span>Wspierasz:</span>
    <h1><?php echo $TargetPaymentMethods->target; ?></h1>
    <?php if (!empty($TargetPaymentMethods->detailed_target)) {?>
      <h2><?php echo $TargetPaymentMethods->detailed_target; ?></h2>
    <?php }?>
    <form action="<?php echo site_url('/bank-transfer-payment'); ?>" method="POST">
      <input
        type="hidden"
        name="payment_url"
        value="<?php echo $paymentUrl; ?>"
      />
      <div>
        <label>Kwota</label>
        <input
        type="number"
        min="1"
        step="1"
        name="price"
        required
        placeholder="Kwota"
        value="<?php echo !empty($_GET['price']) ? caritas_app_get_formatted_price(intval($_GET['price'])) : ''; ?>"
      />
      </div>
      <div>
        <label>Imię i nazwisko</label>
        <input type="text" name="name" required placeholder="Imię i nazwisko" />
      </div>
      <div>
        <label>Email</label>
        <input type="email" name="email" required placeholder="Email" />
      </div>
      <div>
        <input type="checkbox" id="tos_accept" name="accept_tos" required />
        <label for="tos_accept">
          Wyrażam zgodę na przetwarzanie danych osobowych w celu realizacji płatności
          <a target="_blank" href="<?php echo $TargetPaymentMethods->tos_url; ?>" title="czytaj całość">
            (czytaj całość)
          </a>
        </label>
      </div>
      <div>
        <button type="submit">Zapłać</button>
      </div>
    </form>
  </div>
</div>
<?php get_footer();?>