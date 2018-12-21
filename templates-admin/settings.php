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
</div><!-- .wrap -->
