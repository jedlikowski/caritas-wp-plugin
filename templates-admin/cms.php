<div class="wrap">
  <style>
    #wpbody-content {
      padding-bottom: 15px !important;
    }

    .caritas-app-iframe-container {
      margin-top:10px;
      width:calc(100% - 20px);
      padding-bottom:calc(100vh - 140px);
      position:relative;
    }

    .caritas-app-iframe-container iframe {
      position:absolute;
      top:0;
      left:0;
      width:100%;
      height:100%;
      z-index: 2;
    }

    .caritas-app-iframe-container::before {
      content: 'Ładowanie widoku CMS...';
      position: absolute;
      top: 0;
      left: 0;
      display: inline-block;
      z-index: 1;
    }

    @media (max-width: 768px) {
      .caritas-app-iframe-container {
        width: 100%;
        padding-bottom:calc(100vh - 130px);
      }
    }
  </style>
  <?php do_action('admin_notices');?>
  <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
  <div class="caritas-app-iframe-container">
    <iframe src="<?php echo $iframe_url; ?>"></iframe>
  </div>
</div>