# Fragen nach Themen

[English](https://github.com/deckerweb/portfolio-content/wiki/FAQ-English) · [Anleitung](https://github.com/deckerweb/portfolio-content/wiki/Deutsch)

## Einstieg und Alltag

### Brauche ich einen Page Builder?

Nein. Die nativen Block-Vorlagen funktionieren im WordPress-Block-Editor. Ein Builder kann den Portfolio-Inhaltstyp als Quelle für ein Raster nutzen.

### Ändert das Plugin das Design meiner Website?

Die Darstellung bestimmt dein Theme oder Builder. Das Plugin registriert Inhalte und bietet bearbeitbare native Vorlagen.

### Verändert die Projektvorlage bestehende Projekte?

Nein. Sie ist optional und befüllt ausschließlich neue leere automatische Entwürfe.

### Wie zeige ich meine Projekte an?

Erstelle eine Seite und füge unter Vorlagen die Portfolio: Projektübersicht ein. Alternativ nutzt du das Theme-Archiv unter /portfolio/.

### Brauche ich ein Plugin für individuelle Felder?

Nein. Titel, Inhalt, Textauszug, Beitragsbild, Kategorien und Schlagwörter sind enthalten. Weitere Felder sind optional.

### Wie funktionieren Updates?

Öffentliche stabile GitHub-Releases erscheinen im normalen WordPress-Updatesystem. Ein zusätzliches Updater-Plugin ist nicht erforderlich.

### Was bleibt bei Deaktivierung oder Deinstallation erhalten?

Projekte, Kategorien, Schlagwörter und Bilder bleiben immer erhalten. Einstellungen bleiben standardmäßig erhalten; die Löschoption betrifft nur die Einstellungen dieser Website.

## Voraussetzungen und Einrichtung

### Welche Berechtigungen brauche ich?

Einstellungen benötigen manage_options. Portfolio-Inhalte nutzen die WordPress-Beitragsberechtigungen. Library-Installationen und Updates benötigen die jeweiligen WordPress-Pluginrechte; Netzwerkaktionen erfordern Netzwerkberechtigungen.

## Projekte und Darstellung

### Warum erscheint mein Projekt nicht in der Übersicht?

Veröffentliche das Projekt und prüfe Filter und Seitennavigation des Abfrage-Loops. Entwürfe sind nicht öffentlich sichtbar.

### Was hilft bei einem 404-Fehler?

Speichere Einstellungen → Permalinks einmal. Bei Konflikten mit einer vorhandenen /portfolio/-Seite prüfe deren Slug und die Theme-Routen.

## Multisite und Daten

### Sind die Einstellungen netzwerkweit?

Projekte, Kategorien, Schlagwörter, Bilder und Einstellungen gehören zur jeweiligen Website. Netzwerkaktivierung registriert Portfolio-Inhalte auf allen Websites des Netzwerks, auch auf neu angelegten Websites. Die Projektvorlage und die Löschoption werden pro Website eingestellt; es gibt keine gemeinsame Portfolio-Netzwerkeinstellung.

Deaktivierung erhält alle Daten. Deinstallation bereinigt eigene temporäre Update-Daten. Projekte, Begriffe und Bilder bleiben immer erhalten. Plugin-Einstellungen bleiben ebenfalls erhalten, außer die betreffende Website hat die Löschoption ausdrücklich eingeschaltet. Gemeinsame Library-Daten bleiben erhalten, solange ein weiterer Library-Host installiert ist, auch wenn er deaktiviert ist. Die Library bereinigt beim letzten Host ihre temporären Daten; ihre eigene standardmäßig ausgeschaltete Löschoption betrifft nur Library-Einstellungen.

## Updates, Library und Datenschutz

### Welche externen Verbindungen gibt es?

Keine Telemetrie. WordPress-Updateprüfungen fragen öffentliche Release-Metadaten auf api.github.com ab. Beim Update wird das Paket von GitHub heruntergeladen. Der optionale Online-Katalog ruft JSON unter raw.githubusercontent.com/deckerweb ab; Installations- und Aktivierungsaktionen prüfen die Freigabe erneut. Technisch werden IP-Adresse und übliche HTTP-Anfragedaten an den jeweiligen Dienst übertragen, keine Portfolio-Inhalte oder persönlichen Einstellungen. Dokumentations-, Support- und Spendenlinks werden nur beim Öffnen aufgerufen. Bei nativen WordPress-Paketdownloads kann der Standard-User-Agent die WordPress-Version und die Website-Adresse enthalten.

### Warum meldet der Updater eine ältere gemeinsame Kopie?

Ein früher geladenes deckerweb Plugin kann eine ältere Updater-Klasse bereitstellen. Aktualisiere die betroffenen Plugins gemeinsam. Portfolio-Inhalte bleiben verfügbar; die inkompatible Update-Integration wird kontrolliert ausgelassen.

## Entwicklerinformationen

### Welche Kennungen und Filter bleiben bestehen?

Interne Kennungen bleiben `portfolio-content`, `portfolio-category`, `portfolio-tag`; Projekt- und Archiv-URLs bleiben unter `/portfolio/`. REST-Unterstützung und Beitragsberechtigungen bleiben erhalten. Die fünf bestehenden `pfc/...`-Filter bleiben verfügbar; der Meta-Link-Filter wird jetzt ausschließlich für die Zeile dieses Plugins aufgerufen. Eigene Sprachdateien unter `wp-content/languages/portfolio-content/`, normale WordPress-Plugin-Übersetzungen und mitgelieferte Sprachdateien werden unterstützt.
