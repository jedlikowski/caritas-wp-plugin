<div class="wrap">
  <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
  <form action="" method="POST">
    <?php wp_nonce_field('caritas-app-division-save');?>
    <table class="form-table">
      <tbody>
        <tr>
          <th scope="row">
            <label for="division">
              Z której Caritas powinniśmy wyświetlać dane?
            </label>
          </th>
          <td>
            <select name="division" id="division" class="postform">
              <option
                value=""
                disabled
                <?php if ($selected_division === null) {?>
                    selected="selected"
                  <?php }?>
              >
                Nie wybrano
              </option>
              <?php foreach ($divisions as $division) {?>
                <option
                  value="<?php echo $division->id; ?>"
                  <?php if ($selected_division === $division->id) {?>
                    selected="selected"
                  <?php }?>
                >
                  <?php echo $division->name; ?>
                </option>
              <?php }?>
            </select>
          </td>
        </tr>
      </tbody>
    </table>
    <?php submit_button();?>
  </form>
  <h2>Nadpisywanie widoków</h2>
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
  <p>Aby nadpisać szablon odpowiedzialny za wyświetlanie danego widoku należy w aktywnym motywie, w folderze <code>caritas-app-templates</code> utworzyć plik o tej samej nazwie jak szablon, który chcemy nadpisać.
  <p>Pliki źródłowe znajdują się w folderze <code>templates</code> wewnątrz folderu zawierającego wtyczkę. Warto je wykorzystać jako punkt startowy przy tworzeniu własnych widoków.</p>
</div><!-- .wrap -->
