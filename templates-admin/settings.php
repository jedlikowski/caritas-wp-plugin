<div class="wrap">
  <?php settings_errors();?>
  <form action='options.php' method='POST'>

  <h1><?php echo esc_html(get_admin_page_title()); ?></h1>

  <?php settings_fields('caritas_app_settings_page');?>
  <?php do_settings_sections('caritas_app_settings_page');?>
  <?php submit_button();?>

  </form>
  <h2>Nadpisywanie widoków</h2>
  <p>Aby nadpisać szablon odpowiedzialny za wyświetlanie danego widoku należy w aktywnym motywie, w folderze <code>caritas-app-templates</code> utworzyć plik o tej samej nazwie jak szablon, który chcemy nadpisać.
  <p>Jeśli folder <code>caritas-app-templates</code> nie istnieje, należy go samodzielnie utworzyć.</p>
  <p>Pliki źródłowe znajdują się w folderze <code>templates</code> wewnątrz folderu zawierającego wtyczkę. Warto je wykorzystać jako punkt startowy przy tworzeniu własnych widoków.</p>
  <p>
      Wtyczka definiuje następujące linki oraz szablony odpowiadające za ich wyświetlanie:
  </p>
  <ul>
      <li><code><?php echo site_url('/aktualnosci'); ?></code> - <code>news.php</code> (lista artykułów)</li>
      <li><code><?php echo site_url('/aktualnosci/{id}'); ?></code> - <code>news-single.php</code> (szczegóły artykułu)</li>
      <li><code><?php echo site_url('/cele'); ?></code> - <code>targets.php</code> (lista celów)</li>
      <li><code><?php echo site_url('/cele/{id}'); ?></code> - <code>target-single.php</code> (szczegóły celu)</li>
      <li><code><?php echo site_url('/cele/{id}/wesprzyj'); ?></code> - <code>target-payment-form.php</code> (formularz płatności)</li>
      <li><code><?php echo site_url('/platnosc-zakonczona'); ?></code> - <code>payment-success.php</code> (sukces płatności)</li>
      <li><code><?php echo site_url('/blad-platnosci'); ?></code> - <code>payment-success.php</code> (błąd płatności)</li>
  </ul>
</div><!-- .wrap -->
