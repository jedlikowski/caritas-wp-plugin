<div class="wrap">
  <style>
    #wpbody-content {
      padding-bottom: 15px !important;
    }
  </style>
  <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
  <div style="margin-top:10px;width:calc(100% - 20px);padding-bottom:calc(100vh - 140px);position:relative;">
    <iframe
      style="position:absolute;top:0;left:0;width:100%;height:100%;"
      src="<?php echo $iframe_url; ?>"
    >
    </iframe>
  </div>
</div>