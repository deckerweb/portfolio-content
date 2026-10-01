# Portfolio Content

![Portfolio Content](https://raw.githubusercontent.com/deckerweb/portfolio-content/master/assets/banner-de-1544x500.png)

**Deine Projekte. Bereit zum Teilen.**

**Version:** 1.2.0 · **Voraussetzungen:** WordPress 6.7+ / PHP 7.4+ · **Lizenz:** GPL v2 oder neuer

Ein schlankes Portfolio-Plugin von [David Decker – DECKERWEB](https://deckerweb.de/).
[Download](https://github.com/deckerweb/portfolio-content/releases/latest) · [Anleitung](https://github.com/deckerweb/portfolio-content/wiki/Deutsch) · [English](https://github.com/deckerweb/portfolio-content/wiki/English) · [Änderungsprotokoll](https://github.com/deckerweb/portfolio-content/wiki/Changelog-Deutsch) · [Support](https://github.com/deckerweb/portfolio-content/issues)

## Inhalt

- [Funktionen](#funktionen)
- [Voraussetzungen](#voraussetzungen)
- [Installation und Schnellstart](#installation-und-schnellstart)
- [Projektvorlage](#projektvorlage)
- [Updates und Library](#updates-und-library)
- [Alternative: Code-Snippet](#alternative-code-snippet)
- [FAQ](#faq)
- [Bestehende Integrationen](#bestehende-integrationen)
- [Entwicklung](#entwicklung)
- [Änderungsprotokoll](#änderungsprotokoll)

## Funktionen

Portfolio-Projekte mit Kategorien und Schlagwörtern für den Block-Editor oder deinen Page Builder. Das Theme bestimmt die Darstellung. Keine eigenen Frontend-Skripte, Galerie-Engine oder verpflichtenden Feld-Plugins.

- Schnellstart unter Einstellungen → Portfolio Content und Portfolio → Schnellstart.
- Beitragsbild-Vorschau und Kategorienfilter in der Projektliste.
- Optionale bearbeitbare Projektvorlage: Aufgabe, Umsetzung, Ergebnis und Galerie.
- Zwei native Block-Vorlagen: Projektvorstellung und responsive Projektübersicht mit Seitennavigation.
- deckerweb GitHub Release Updater v2 und deckerweb Plugin Library 0.2.0 enthalten.
- Oberfläche auf Englisch, Deutsch und formellem Deutsch; lokalisierte Update-Banner.

## Voraussetzungen

WordPress ab 6.7, PHP ab 7.4. Die Library läuft ab PHP 8.0; unter PHP 7.4 bleiben Portfolio und Updater ohne Library verfügbar. ClassicPress ist kein offizielles Support- oder Testziel.

## Installation und Schnellstart

1. `portfolio-content.zip` unter Plugins → Installieren → Plugin hochladen installieren und aktivieren.
2. Einstellungen → Portfolio Content öffnen. Bei Bedarf die Projektvorlage einschalten.
3. Ein Projekt mit Titel, Beitragsbild und Textauszug anlegen und veröffentlichen.
4. Eine Seite erstellen. Im Block-Inserter unter Vorlagen Portfolio Content → Portfolio: Projektübersicht wählen.
5. Die Seite veröffentlichen und zur Navigation hinzufügen.

Die Übersicht nutzt den WordPress-Abfrage-Loop: sechs Projekte, neueste zuerst, drei Spalten und Seitennavigation. Diese Einstellungen lassen sich im Editor ändern. Das Theme gestaltet die Ansicht. Das Archiv unter `/portfolio/` verwendet die Archivvorlage des Themes und kann anders aussehen als die Übersichtsseite.

Im Page Builder wählst du `portfolio-content` als Inhaltsquelle des Beitragsrasters und konfigurierst Bild, Titel und Textauszug. Individuelle Felder ergänzt dein bevorzugtes Feld-Plugin. Spezielle Integrationen für kommerzielle Builder sind nicht enthalten und werden nicht als getestet beworben.

## Projektvorlage

Standardmäßig ausgeschaltet. Nach dem Einschalten werden nur neue leere automatische Entwürfe vorbelegt. Bestehende Projekte und bereits befüllte Vorgaben bleiben unverändert. Alle Inhalte sind frei bearbeitbar. Im klassischen WordPress-Editor werden Überschriften und Absätze ohne Block-Markup eingefügt.

## Updates und Library

Der enthaltene Updater prüft öffentliche stabile GitHub-Releases über das WordPress-Updatesystem. Automatische Updates werden nicht eingeschaltet. Das Release-ZIP muss das Plugin, eine neuere stabile Version und passende Anforderungen enthalten. Icons und Banner stammen lokal aus dem Plugin; die Administratorsprache bestimmt das Banner.

Die Library ergänzt den deckerweb-Katalog unter Plugins → Installieren, mit eigenen Einstellungen, Berechtigungsprüfungen, geprüften Paketen und Netzwerk-Unterstützung. Der Freigabekatalog aus Library 0.2.0 bleibt erhalten. Ein Katalogeintrag wird getrennt anhand des öffentlichen Release-ZIPs und seiner Prüfsumme freigegeben. Online-Katalogupdates bleiben optional. Dieses Paket zur direkten Verteilung ist mit dem externen Installer nicht für eine Einreichung auf WordPress.org vorgesehen.

## Alternative: Code-Snippet

`ddw-portfolio-content.code-snippets.json` in Code Snippets importieren und überall ausführen. Entweder Plugin oder Snippet aktivieren. Das Snippet enthält Inhaltsregistrierung, Schnellstart, Block-Vorlagen und eingebettete Admin-Stile, aber keinen Plugin-Updater und keine Library. Deutsche Übersetzungen sind eingebettet. Nach Aktivierung oder Deaktivierung einmal Einstellungen → Permalinks speichern. Das Plugin erneuert die Regeln ausschließlich beim Aktivieren.

## FAQ

**Brauche ich einen Page Builder?** Nein. Die nativen Block-Vorlagen funktionieren im WordPress-Block-Editor. Ein Builder kann den Portfolio-Inhaltstyp als Quelle für ein Raster nutzen.

**Ändert das Plugin das Design meiner Website?** Die Darstellung bestimmt dein Theme oder Builder. Das Plugin registriert Inhalte und bietet bearbeitbare native Vorlagen.

**Verändert die Projektvorlage bestehende Projekte?** Nein. Sie ist optional und befüllt ausschließlich neue leere automatische Entwürfe.

**Wie zeige ich meine Projekte an?** Erstelle eine Seite und füge unter Vorlagen die Portfolio: Projektübersicht ein. Alternativ nutzt du das Theme-Archiv unter /portfolio/.

**Brauche ich ein Plugin für individuelle Felder?** Nein. Titel, Inhalt, Textauszug, Beitragsbild, Kategorien und Schlagwörter sind enthalten. Weitere Felder sind optional.

**Wie funktionieren Updates?** Öffentliche stabile GitHub-Releases erscheinen im normalen WordPress-Updatesystem. Ein zusätzliches Updater-Plugin ist nicht erforderlich.

**Kann ich stattdessen das Snippet verwenden?** Ja. Importiere die Release-JSON in Code Snippets und führe sie überall aus. Wähle Plugin oder Snippet; das Snippet enthält keinen Updater und keine Library.

[Alle Fragen nach Themen](https://github.com/deckerweb/portfolio-content/wiki/FAQ-Deutsch)

## Bestehende Integrationen

Interne Kennungen bleiben `portfolio-content`, `portfolio-category`, `portfolio-tag`; Projekt- und Archiv-URLs bleiben unter `/portfolio/`. REST-Unterstützung und Beitragsberechtigungen bleiben erhalten. Die fünf bestehenden `pfc/...`-Filter bleiben verfügbar; der Meta-Link-Filter wird jetzt ausschließlich für die Zeile dieses Plugins aufgerufen. Eigene Sprachdateien unter `wp-content/languages/portfolio-content/`, normale WordPress-Plugin-Übersetzungen und mitgelieferte Sprachdateien werden unterstützt.

## Entwicklung

`python3 tools/build.py --output /pfad/zur/ausgabe` erzeugt Plugin-ZIP und Snippet-JSON aus einer gemeinsamen Quelle. Entwicklungsdateien und Designalternativen werden nicht mitinstalliert. PHP-Prüfung und WordPress-Integrationstests siehe `docs/TESTING.md`. Version 1.2.0 vom 01.10.2026.

GPL-2.0-or-later. [Spenden](https://ko-fi.com/deckerweb) · [Newsletter](https://deckerweb.us2.list-manage.com/subscribe?u=e09bef034abf80704e5ff9809&id=380976af88)

## Änderungsprotokoll

### 1.2.0 — 01.10.2026

- **Neu:** Schnellstart, Beitragsbild-Spalte und Portfolio-Kategorienfilter ergänzt.
- **Neu:** Optionale Projektvorlage und zwei native Block-Vorlagen ergänzt.
- **Neu:** deckerweb Updater v2 und optionale Library 0.2.0 integriert.
- **Verbessert:** Inhaltsregistrierung, Administration und Editor getrennt; Kennungen und Filter erhalten.
- **Behoben:** WordPress-Mindestversion im Header, Sprachauswahl, Schreibfehler und Plugin-Meta-Links korrigiert.
- **Behoben:** Vorausgefüllte persönliche Daten aus dem Newsletter-Link entfernt.
- **Verbessert:** Dokumentation und deutsche Übersetzungen aktualisiert.

### 1.1.0 — 07.04.2025

- **Verbessert:** Neustart mit klassenbasierter Registrierung.
- **Verbessert:** Permalink-Regeln ausschließlich beim Aktivieren erneuern.
- **Neu:** Plugin-Links und Snippet-Verteilung ergänzt.

### 1.0.0 — 09.05.2019

- **Neu:** Erste öffentliche Version.

[Vollständiger Änderungsverlauf](https://github.com/deckerweb/portfolio-content/wiki/Changelog-Deutsch)
