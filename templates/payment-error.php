<?php
/**
 * Payment error template
 */
?>
<?php get_header();?>
<div class="caritas-app-container">
  <div class="caritas-app-target-payment-methods">
    <div>
      <span>Dziękujemy za Twoje wsparcie.</span>

      <p>Wpłata została zakończona: <span class="caritas-app-error">niepowodzeniem</span></p>

    </div>
    <hr>
    <?php include "payment-result-footer.php";?>
  </div>
</div>
<?php get_footer();?>