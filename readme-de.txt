=== Portfolio Content ===
Contributors: deckerweb
Tags: portfolio, projects, custom post type, block patterns
Requires at least: 6.7
Requires PHP: 8.1
Tested up to: 7.1.3
Stable tag: 1.3.2
License: GPL-2.0-or-later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Deine Projekte. Bereit zum Teilen.

== Description ==

Ein schlankes Portfolio-Plugin von David Decker – DECKERWEB: Projekte anlegen, übersichtlich verwalten und mit deinem Theme oder Builder präsentieren.

Portfolio-Projekte mit Kategorien und Schlagwörtern für den Block-Editor oder deinen Page Builder. Das Theme bestimmt die Darstellung. Keine eigenen Frontend-Skripte, Galerie-Engine oder verpflichtenden Feld-Plugins.

- Schnellstart unter Einstellungen → Portfolio Content und Portfolio → Schnellstart.
- Beitragsbild-Vorschau und Kategorienfilter in der Projektliste.
- Optionale bearbeitbare Projektvorlage: Aufgabe, Umsetzung, Ergebnis und Galerie.
- Zwei native Block-Vorlagen: Projektvorstellung und responsive Projektübersicht mit Seitennavigation.
- deckerweb GitHub Release Updater 2.2.1 und deckerweb Plugin Library 1.1.0 enthalten.
- Oberfläche auf Englisch, Deutsch und formellem Deutsch; lokalisierte Update-Banner.
- Einrichtungscheck, manuelles Einfügen der Vorlage in leere Entwürfe, anklickbare native Kategorie-Filter, Filter zurücksetzen und hilfreiche leere Ansichten.

Standardmäßig ausgeschaltet. Nach dem Einschalten werden nur neue leere automatische Entwürfe vorbelegt. Bestehende Projekte und bereits befüllte Vorgaben bleiben unverändert. Alle Inhalte sind frei bearbeitbar. Im klassischen WordPress-Editor werden Überschriften und Absätze ohne Block-Markup eingefügt. Im Projekteditor lässt sich die Projektvorlage auch manuell in leere Entwürfe einfügen, unabhängig von der automatischen Einstellung. Aktuelle ungespeicherte Inhalte bleiben geschützt; erst das Speichern übernimmt die Änderung.

Updates aus öffentlichen stabilen GitHub-Releases erscheinen im normalen WordPress-Updatesystem. Automatische Updates werden nicht eingeschaltet. Der enthaltene deckerweb Updater 2.2.1 prüft Pakete zusammen mit dem Plugin auf Identität, angebotene Version und passende WordPress-/PHP-Anforderungen. Icons und Banner werden lokal ausgeliefert.

Die deckerweb Library 1.1.0 ergänzt einen Katalog unter Plugins → Installieren. Installation und Aktivierung sind getrennte Entscheidungen. WordPress.org bleibt der Standard. Der Online-Katalog ist freiwillig und standardmäßig ausgeschaltet. 

Projekte, Kategorien, Schlagwörter, Bilder und Einstellungen gehören zur jeweiligen Website. Netzwerkaktivierung registriert Portfolio-Inhalte auf allen Websites des Netzwerks, auch auf neu angelegten Websites. Die Projektvorlage und die Löschoption werden pro Website eingestellt; es gibt keine gemeinsame Portfolio-Netzwerkeinstellung.

Deaktivierung erhält alle Daten. Deinstallation bereinigt eigene temporäre Update-Daten. Projekte, Begriffe und Bilder bleiben immer erhalten. Plugin-Einstellungen bleiben ebenfalls erhalten, außer die betreffende Website hat die Löschoption ausdrücklich eingeschaltet. Gemeinsame Library-Daten bleiben erhalten, solange ein weiterer Library-Host installiert ist, auch wenn er deaktiviert ist. Die Library bereinigt beim letzten Host ihre temporären Daten; ihre eigene standardmäßig ausgeschaltete Löschoption betrifft nur Library-Einstellungen.

Keine Telemetrie. WordPress-Updateprüfungen fragen öffentliche Release-Metadaten auf api.github.com ab. Beim Update wird das Paket von GitHub heruntergeladen. Der optionale Online-Katalog ruft JSON unter raw.githubusercontent.com/deckerweb ab; Installations- und Aktivierungsaktionen prüfen die Freigabe erneut. Technisch werden IP-Adresse und übliche HTTP-Anfragedaten an den jeweiligen Dienst übertragen, keine Portfolio-Inhalte oder persönlichen Einstellungen. Dokumentations-, Support- und Spendenlinks werden nur beim Öffnen aufgerufen. Bei nativen WordPress-Paketdownloads kann der Standard-User-Agent die WordPress-Version und die Website-Adresse enthalten.

Fehler und Fragen (https://github.com/deckerweb/portfolio-content/issues) · Discussions (https://github.com/deckerweb/portfolio-content/discussions)

Sicherheitslücken bitte vertraulich melden: Security reporting (https://github.com/deckerweb/portfolio-content/security/advisories/new). Keine Zugangsdaten oder vertraulichen Kundeninhalte senden. Hinweise: Sicherheit (SECURITY-de.md).

Ko-fi (https://ko-fi.com/deckerweb) · Buy Me a Coffee (https://buymeacoffee.com/daveshine) · PayPal (https://paypal.me/deckerweb)

© 2019–2026 David Decker – DECKERWEB · GPL v2 oder neuer (LICENSE).

Enthält deckerweb Library 1.1.0 und deckerweb Updater 2.2.1 von David Decker, jeweils GPL-2.0-or-later. Admin-Stile und Dialogverhalten wurden aus Brand Admin Schemes von David Decker übernommen und angepasst, GPL-2.0-or-later. Grafiken: freigegebenes Portfolio-Content-Design A von DECKERWEB; SVG-Quelldateien und PNG-Exporte werden mit GPL-2.0-or-later bereitgestellt. Systemschriften werden referenziert; Schriftdateien werden nicht mitgeliefert.

GitHub Pages nutzt das Cayman-Theme (CC0-1.0); die lokale Vorlage verwendet Systemschriften.

Library (https://github.com/deckerweb/deckerweb-plugin-library) · Updater (https://github.com/deckerweb/deckerweb-updater) · Brand Admin Schemes (https://github.com/deckerweb/brand-admin-schemes) · Cayman (https://github.com/pages-themes/cayman)

== Installation ==

1. portfolio-content-1.3.2.zip unter Plugins → Installieren → Plugin hochladen installieren und aktivieren.
2. Einstellungen → Portfolio Content öffnen. Bei Bedarf die Projektvorlage einschalten.
3. Ein Projekt mit Titel, Beitragsbild und Textauszug anlegen und veröffentlichen.
4. Eine Seite erstellen. Im Block-Inserter unter Vorlagen Portfolio Content → Portfolio: Projektübersicht wählen.
5. Die Seite veröffentlichen und zur Navigation hinzufügen.

Die Übersicht nutzt den WordPress-Abfrage-Loop: sechs Projekte, neueste zuerst, drei Spalten und Seitennavigation. Diese Einstellungen lassen sich im Editor ändern. Das Theme gestaltet die Ansicht. Das Archiv unter /portfolio/ verwendet die Archivvorlage des Themes und kann anders aussehen als die Übersichtsseite.

Im Page Builder wählst du portfolio-content als Inhaltsquelle des Beitragsrasters und konfigurierst Bild, Titel und Textauszug. Individuelle Felder ergänzt dein bevorzugtes Feld-Plugin. Spezielle Integrationen für kommerzielle Builder sind nicht enthalten und werden nicht als getestet beworben.

== Frequently Asked Questions ==

= Brauche ich einen Page Builder? =

Nein. Die nativen Block-Vorlagen funktionieren im WordPress-Block-Editor. Ein Builder kann den Portfolio-Inhaltstyp als Quelle für ein Raster nutzen.

= Ändert das Plugin das Design meiner Website? =

Die Darstellung bestimmt dein Theme oder Builder. Das Plugin registriert Inhalte und bietet bearbeitbare native Vorlagen.

= Verändert die Projektvorlage bestehende Projekte? =

Nein. Sie ist optional und befüllt ausschließlich neue leere automatische Entwürfe.

= Wie zeige ich meine Projekte an? =

Erstelle eine Seite und füge unter Vorlagen die Portfolio: Projektübersicht ein. Alternativ nutzt du das Theme-Archiv unter /portfolio/.

= Brauche ich ein Plugin für individuelle Felder? =

Nein. Titel, Inhalt, Textauszug, Beitragsbild, Kategorien und Schlagwörter sind enthalten. Weitere Felder sind optional.

= Wie funktionieren Updates? =

Öffentliche stabile GitHub-Releases erscheinen im normalen WordPress-Updatesystem. Ein zusätzliches Updater-Plugin ist nicht erforderlich.

= Was bleibt bei Deaktivierung oder Deinstallation erhalten? =

Projekte, Kategorien, Schlagwörter und Bilder bleiben immer erhalten. Einstellungen bleiben standardmäßig erhalten; die Löschoption betrifft nur die Einstellungen dieser Website.

Fragen nach Themen: https://github.com/deckerweb/portfolio-content/wiki/FAQ-Deutsch

== Changelog ==

= 1.3.2 — 23.10.2026 =

- Behoben: deckerweb Updater auf 2.2.1 aktualisiert; die Updateversorgung bleibt auch neben einer älteren geladenen Updater-Kopie verfügbar.

= 1.3.1 — 21.10.2026 =

- Verbessert: deckerweb Library auf 1.1.0 und Updater auf 2.2.0 aktualisiert.
- Behoben: Lokalen Änderungsverlauf robuster gestaltet; Dokumentationslinks bleiben bei Öffnungsfehlern nutzbar.
- Sonstiges: PHP 8.1 oder neuer ist jetzt erforderlich; WordPress 6.7 bleibt unterstützt.

= 1.3.0 — 08.10.2026 =

- Neu: Einrichtungscheck mit direkten Projekt- und Archivaktionen sowie Einstieg in native Block-Vorlagen ergänzt.
- Neu: Projektvorlage manuell in leere Entwürfe im Block- und klassischen Editor einfügen; ungespeicherte Inhalte bleiben geschützt.
- Verbessert: Filter zurücksetzen, verständliche Hinweise bei fehlendem Bild und hilfreiche Aktionen für leere Projektlisten und Suchergebnisse ergänzt.
- Verbessert: deckerweb Plugin Library auf 0.8.1 und Updater auf 2.1.0 aktualisiert, einschließlich Host-Übersetzungen und Kompatibilitätsbehandlung.
- Verbessert: Englische/deutsche Dokumentation, FAQ, Grafiken und sämtliche deutschen Oberflächentexte aktualisiert.
- Behoben: Netzwerkaktivierung und neu angelegte Websites erhalten Portfolio-Permalink-Regeln, ohne Website-Einstellungen zu verändern.
- Behoben: Update-Paketprüfung einschließlich nativer Sammelupdates verbessert; Host-Übersetzungen bleiben beim Laden der Komponentensprachen erhalten.
- Sonstiges: Optionale Löschung der Plugin-Einstellungen beim Deinstallieren ergänzt; Portfolio-Inhalte und Medien bleiben immer erhalten.

= 1.2.0 — 01.10.2026 =

- Neu: Schnellstart, Beitragsbild-Spalte und Portfolio-Kategorienfilter ergänzt.
- Neu: Optionale Projektvorlage und zwei native Block-Vorlagen ergänzt.
- Neu: deckerweb Updater v2 und optionale Library 0.2.0 integriert.
- Verbessert: Bestehende Inhaltskennungen und Erweiterungsfilter bleiben erhalten.
- Verbessert: Dokumentation und deutsche Übersetzungen aktualisiert.
- Behoben: WordPress-Mindestversion im Header, Sprachauswahl, Schreibfehler und Plugin-Meta-Links korrigiert.
- Behoben: Vorausgefüllte persönliche Daten aus dem Newsletter-Link entfernt.

= 1.1.0 — 07.04.2025 =

- Neu: Plugin-Links und Snippet-Verteilung ergänzt.
- Verbessert: Portfolio-Projekte nutzen die gewohnten WordPress-Bearbeitungsfunktionen und Berechtigungen.
- Verbessert: Permalink-Regeln ausschließlich beim Aktivieren erneuern.

= 1.0.0 — 09.05.2019 =

- Neu: Erste öffentliche Version.
