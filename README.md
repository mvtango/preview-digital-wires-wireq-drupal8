# Digital Wires Import Module für Drupal 8

Dieses Modul stellt die nötige Funktionalität zur Verfügung,
um einen _Digital Wires_ Feed der dpa zu importieren.

Dazu setzt das Modul auf die von [Drupal Migrate](https://www.drupal.org/docs/8/api/migrate-api) zur Verfügung gestellten Funktionalitäten und Konzepte auf.

----

## Überblick

### Quick Start

- Modul aktivieren
- URL des WireQ Feeds aus dem dpa API Portal in den Modul-Einstellungen hinterlegen
- Migration starten: `$ drush migrate:import digital_wires_wireq`


### Ablauf des Imports

Migrate fragt die `entries.json` der WireQ API an. Da die API eine sog. _Processing Queue_ ist, liefert die API bis zu 50 Einträge zurück, und blendet diese aus der Queue für ca. 5 Minuten aus.

Läuft die Migration erneut, würden die nächsten 50 Einträge abgefragt,… und so weiter, bis die Queue leer läuft.

Nach erfolgreichem Import eines Eintrages quittiert das Modul das _WireQ Receipt_ bei der WireQ API und entfernt es so dauerhaft aus der Processing Queue.


### Was wird importiert

Grundsätzlich werden alle Meldungen der WireQ importiert, bis diese leer ist. Dazu muss die Migration mehrmals aufgerufen werden, am besten regelmäßig per Cron.

Bilder die an den Meldungen als Attachments hängen, werden ebenfalls importiert. Diese Bilder finden sich anschließend in der _Drupal 8 Media Library_ wieder. Beim Import der Bilder wird überprüft, ob ein Bild mit einer identischen dpa-ID bereits vorhanden ist, so dass durch den Import keine doppelten Bilder die Media Library überfluten.


### Sonderfall: Zurückgezogene Meldung

Tritt der seltene Fall ein, dass eine Meldung zurückgezogen wird, so berücksichtigt das Modul dies auch, sofern in der API der _Publishing Status_ auf _canceled_ gesetzt wurde. Die Meldung wird in Drupal vom Status »veröffentlicht« auf »Entwurf« geändert, was zu einer Depublizierung der Meldung führt. Um die Meldung explizit zu kennzeichnen wird der Titel um das Präfix »ACHTUNG! Zurückgezogen!« erweitert.


----


## Modul-Verwendung

Das Modul bringt einen eigenen Inhaltstyp _dpa Meldung_ mit. Dadurch ist das Modul nach der Installation in der Lage, direkt erste Importe durchzuführen.



### Konfigurationsmöglichkeiten

- Status: Es kann gewählt werden, ob eine Meldung direkt veröffentlicht werden soll, oder als Entwurf ins System importiert werden soll.
- Mapping: Die an einer Meldung enthaltenen Felder lassen sich in den Einstellungen des Moduls auf einen schon vorhandenen Drupal Inhaltstypen mappen. Es ist dabei auch möglich, einzelne Felder zu ignorieren.



### Dauerhaften Import einrichten

Hier empfiehlt es sich, die Migration per Cron auf dem Web-Server regelmäßig laufen zu lassen. Dazu würde man die Migration im Cron in der gewünschten Frequenz laufen lassen.

```cron
5 * * * * ~/drupal/docroot/vendor/bin/drush migrate:import dpa_digital_wires
```



### Tests

Die Tests werden über PhpUnit gestartet. Diese werden im Ordner `core` von Drupal ausgeführt.

```bash
$ cd docroot/core
$ ../../vendor/bin/phpunit --group dpa_digital_wires
```

Derzeit bestehen Tests für die folgenden Fälle:

- Veröffentlichungsstatus aus den Modul-Einstellungen
- Artikel zurückziehen
- Doppelte Bilder
- Aktualisierung von Artikeln


**Anmerkung:** Dies sind bisher ausschließlich Kernel-Tests. (Zur Unterscheidung der Testtypen in Drupal [siehe diese Übersicht](https://www.drupal.org/docs/8/testing/types-of-tests-in-drupal-8).)
