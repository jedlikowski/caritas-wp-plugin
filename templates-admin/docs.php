<div class="wrap">
  <h1>Dokumentacja wtyczki Aplikacji Caritas</h1>
  <h2>Nadpisywanie widoków</h2>
  <p>Wtyczka posiada domyślny wygląd dodawanych przez siebie podstron. Możliwe jest jednak skonfigurowanie włanego
    układu i wyglądu poprzez użycie samodzielnie skonfigurowanych plików php odpowiadających za renderowanie danych
    widoków.</p>
  <p>Aby nadpisać szablon odpowiedzialny za wyświetlanie danego widoku należy w aktywnym motywie, w folderze
    <code>caritas-app-templates</code> utworzyć plik o tej samej nazwie jak szablon, który chcemy nadpisać.
    <p>Jeśli folder <code>caritas-app-templates</code> nie istnieje, należy go samodzielnie utworzyć.</p>
    <p>Pliki źródłowe, z których domyślnie korztysta wtyczka, znajdują się w folderze <code>templates</code> wewnątrz
      folderu zawierającego wtyczkę. (standardowo wewnątrz katalogu <code>wp-content/plugins</code>) Warto je
      wykorzystać jako punkt startowy przy tworzeniu własnych widoków.</p>
    <p>
      Wtyczka definiuje następujące linki oraz szablony odpowiadające za ich wyświetlanie:
    </p>
    <ul>
      <li><code><?php echo home_url('/aktualnosci'); ?></code> - <code>news.php</code> (lista artykułów)</li>
      <li><code><?php echo home_url('/aktualnosci/{id}'); ?></code> - <code>news-single.php</code> (szczegóły artykułu)
      </li>
      <li><code><?php echo home_url('/cele'); ?></code> - <code>targets.php</code> (lista celów)</li>
      <li><code><?php echo home_url('/cele/{id}'); ?></code> - <code>target-single.php</code> (szczegóły celu)</li>
      <li><code><?php echo home_url('/cele/{id}/wesprzyj'); ?></code> - <code>target-payment-form.php</code> (formularz
        płatności)</li>
      <li><code><?php echo home_url('/platnosc-zakonczona'); ?></code> - <code>payment-success.php</code> (sukces
        płatności)</li>
      <li><code><?php echo home_url('/blad-platnosci'); ?></code> - <code>payment-error.php</code> (błąd płatności)
      </li>
    </ul>
    <h2>Dostępne funkcje:</h2>
    <p>Wtyczka definiuje również kilka przydatnych funkcji, które można wykorzystać do pobrania danych Aplikacji
      Caritas.</p>
    <h3>Cele</h3>
    <ul>
      <li style="margin-bottom:50px">
        <p>
          <code>caritas_app_get_targets_list</code> - pobranie listy celów dla wybranego w ustawieniach oddziału
          Caritas. Funkcja nie przyjmuje żadnych parametrów.
        </p>
        <p><strong>Przykład użycia:</strong></p>
        <p><code><?php echo htmlspecialchars('<?php $targets = caritas_app_get_targets_list();?>'); ?></code></p>
        <p><strong>Zwracane dane:</strong></p>
        <p>obiekt klasy <code>IndicoPlus\CaritasApp\Models\TargetsList</code></p>
      </li>
      <li style="margin-bottom:50px">
        <p>
          <code>caritas_app_get_target</code> - pobranie danych konkretnego celu. Parametry:
          <code>int $id</code> - ID celu dla którego chcemy pobrać dane.
        </p>
        <p><strong>Przykład użycia:</strong></p>
        <p><code><?php echo htmlspecialchars('<?php $target = caritas_app_get_target(22);?>'); ?></code></p>
        <p><strong>Zwracane dane:</strong></p>
        <p>obiekt klasy <code>IndicoPlus\CaritasApp\Models\Target</code></p>
      </li>
      <li style="margin-bottom:50px">
        <p>
          <code>caritas_app_get_target_payment_methods</code> - pobranie danych płatności dla konkretnego celu.
          Parametry:
          <code>int $id</code> - ID celu dla którego chcemy pobrać dane,
          <code>array $additional</code> - dodatkowe parametry do zapytania. Jest to tablica zawierająca następujące
          wartości:
          <code>detailed_target_id</code> - ID wybranego celu szczegółowego,
          <code>price</code> - predefiniowana kwota wpłaty
        </p>
        <p><strong>Przykład użycia:</strong></p>
        <p>
          <code><?php echo htmlspecialchars('
            <?php $data = caritas_app_get_target_payment_methods(22, [
                "detailed_target_id" => 10,
                "price" => 100
            ]);?>
          '); ?></code>
        </p>
        <p><strong>Zwracane dane:</strong></p>
        <p>obiekt klasy <code>stdClass</code>, zawierający:
          <br />
          - <code>TargetPaymentMethods</code> -> obiekt klasy
          <code>IndicoPlus\CaritasApp\Models\TargetPaymentMethods</code>
          <br />
          - <code>paymentUrl</code> -> link na który należy przesłać dane z formularza płatności
        </p>
      </li>
    </ul>
</div>
