<div class="wrap">
  <?php settings_errors();?>
  <form action='options.php' method='POST'>

    <h1><?php echo esc_html(get_admin_page_title()); ?></h1>

    <?php settings_fields('caritas_app_settings_page');?>
    <?php do_settings_sections('caritas_app_settings_page');?>
    <?php submit_button();?>

  </form>
</div><!-- .wrap -->