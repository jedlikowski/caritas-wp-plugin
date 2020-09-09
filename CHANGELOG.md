# 1.4.2

- Dodanie możliwości wyłączenia modułu płatności
- Dodanie możliwości ręcznego wpisania ID oddziału (dla zaawansowanych użytkowników)
- Aktualizacja zależności
- Czytelniejszy panel ustawień

# 1.4.1

- Dodanie możliwości wyboru obrazka widocznego na kafelku "własna kwota".

# 1.4.0

- Dodanie domyślnych styli do widoku listy celów, pojedynczego celu oraz procesu płatności.

# 1.3.3

- Dodanie informacji o ilości wpłat na dany cel, dostępnej w modelu szczegółów i listy celów pod atrybutem `payments`

# 1.3.2

- wersja testująca możliwość aktualizacji wtyczki z poziomu zarządzania wtyczkami w panelu WordPressa

# 1.3.0 oraz 1.3.1

- dodanie informacji o postępie zbiórki na dany cel: obiekty klasy Target oraz TargetListItem zostały wyposażone w dwa nowe atrybuty:

`target_amount` - docelowa kwota zbiórki, w groszach

`collected_amount` - już uzbierana kwota na dany cel, w groszach

- dodanie możliwości aktualizacji wtyczki z poziomu panelu wtyczek WordPressa
- zmiana struktury kodu i wykorzystanie narzędzia composer do zarządzania zależnościami
- zmiana głównego namespace kodu z CaritasApp na IndicoPlus\CaritasApp

# 1.2.0

- Początkowy release wtyczki z możliwością pobierania informacji o liście i szczegółach celów oraz aktualności dla danej Caritas, wybranej po instalacji w panelu administratora.
