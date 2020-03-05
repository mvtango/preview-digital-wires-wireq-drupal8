# Digital Wires Import Module für Drupal 8

Dieses Modul stellt die nötige Funktionalität zur Verfügung,
um einen _Digital Wires_ Feed der dpa zu importieren.

Dazu setzt das Modul auf die von _Drupal Migrate_ zur Verfügung gestellten Funktionalitäten und Konzepte auf.


## Quick Start

- Modul aktivieren
- URL des WireQ Feeds hinterlegen in den Einstellungen hinterlegen
- Migration starten: `$ drush migrate:import digital_wires_wireq`



## Ablauf des Imports

Migrate fragt die `entries.json` der WireQ API an. Da die API eine sog. _Processing Queue_ ist, liefert die API bis zu 50 Einträge zurück, und blendet diese aus der Queue für ca. 5 Minuten aus.
Läuft die Migration erneut, würden die nächsten 50 Einträge abgefragt,… und so weiter, bis die Queue leer läuft.


## Was wird importiert

Grundsätzlich werden alle Meldungen der WireQ importiert, bis diese leer ist. Dazu muss die Migration mehrmals aufgerufen werden, am besten regelmäßig per Cron.

Die an einer Meldung enthaltenen Felder lassen sich in den Einstellungen des Moduls auf einen schon vorhandenen Drupal Inhaltstypen mappen.
Es ist dabei auch möglich, einzelne Felder zu ignorieren.

Bilder die an den Meldungen als Attachments hängen, werden ebenfalls importiert. Diese Bilder finden sich anschließend in der _Drupal 8 Media Library_.



## Aufbau des Moduls

Das Modul bringt einen eigenen Inhaltstyp _dpa Meldung_ mit. Dadurch ist das Modul nach der Installation in der Lage, direkt erste Importe durchzuführen.

Es gibt einen Connector, der die Verbindung zur WireQ API herstellt, die Einträge abfragt und importierte Einträge löscht.

Das Löschen erfolgt über einen sogenannten _Post Migration Hook_. Dieser wird von Migrate nach dem Import einer jeden Meldung aufgerufen. D.h. der Import einer Meldung wird jeweils einzeln quittiert.



## Konfigurationsmöglichkeiten

- Status: Es kann gewählt werden, ob eine Meldung direkt veröffentlicht werden soll, oder als Entwurf ins System importiert werden soll.
- Mapping:



## Dauerhaften Import einrichten

Hier empfiehlt es sich, die Migration per Cron auf dem Web-Server regelmäßig laufen zu lassen.



