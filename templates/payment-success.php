<?php
/**
 * Payment success template
 */
?>
<?php get_header();?>
<div class="caritas-app-container">
  <div class="caritas-app-target-payment-methods">
    <div>
      <span>Dziękujemy za Twoje wsparcie.</span>

      <p>Wpłata została zakończona: <span class="caritas-app-success">sukcesem</span></p>

    </div>
    <hr>
    <?php include "payment-result-footer.php";?>
  </div>
</div>
<?php get_footer();?>
