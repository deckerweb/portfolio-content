# Prüfung — Portfolio Content 1.2.0

Stand: 01.10.2026. Lokal geprüft mit PHP 8.4.5 und isolierten WordPress-Installationen 6.7 und 7.1.2. Die Testdatenbanken verwenden den SQLite-Integration-Adapter. Ein produktiver MySQL-/MariaDB-Host und eine netzwerkweite Aktivierung wurden nicht geprüft. ClassicPress wird nicht offiziell getestet oder unterstützt.

## Bestandene Prüfungen

- Je 36 WordPress-Integrationstests: Inhaltsregistrierung, bestehende Filter und URLs, Editor-Funktionen, optionale Projektvorlage, Erhalt bestehender Inhalte, klassischer Editor, Block-Vorlagen und gerenderte Übersicht, echtes Vorschaubild, Kategorienabfrage, Einstellungssanitierung, Berechtigungen, Plugin-Meta-Links, Deutsch und formelles Deutsch, Updater-Grafiken und HTTP-Grenzen sowie Permalink-Erneuerung ausschließlich bei Aktivierung.
- 10 Update-Pakettests: passende neue Version, Identität, Downgrade, Abweichung vom angebotenen Update, fehlende Hauptdatei oder Anforderungen, inkompatibles PHP/WordPress, Fehlerbehandlung und Isolation gegenüber anderen Plugins.
- Eigenständiger Snippet-Export: Start, Vorlagen, eingebettete Übersetzungen und Dokumente sowie Schutz vor doppeltem Plugin-/Snippet-Start.
- Library 0.2.0: Auswahl der eingebetteten Implementierung, Host-Registrierung und Katalog-Tab. Zu Beginn auch zusammen mit der vorhandenen Brand-Admin-Schemes-Library geladen, ohne doppelte Laufzeitinstanz.
- PHP-Syntax aller Plugin-, Library-, Updater- und Sprachdateien sowie des erzeugten Snippets.
- 117 übersetzte Einträge je deutschem Sprachkatalog; Gettext-Kompilierung bestanden.

## Oberfläche

Die Einstellung lässt sich über das echte WordPress-Formular speichern. Englisch und Deutsch wurden angezeigt; der deutsche Admin-Screenshot stammt aus WordPress 7.1.2. Die mobile Schnellstart-Ansicht bei 390 Pixeln hat keinen horizontalen Überlauf. Der Dokumentdialog öffnet und schließt und stellt den Fokus wieder her. Im aktuellen Editor zeigt die Dokumentübersicht Aufgabe, Umsetzung, Ergebnis, Absätze und Galerie ohne JavaScript-Fehler.

Die gerenderte Editor-Canvas im iframe war dem Browser-Testwerkzeug nicht zugänglich. Deshalb wurden die Dokumentübersicht und das serverseitige Block-Rendering geprüft. Es wurden keine kommerziellen Builder mit Lizenz getestet.

## Wiederholen und veröffentlichen

Befehle und Voraussetzungen siehe TESTING.md. Nur eine separate Testinstallation verwenden: Die Tests legen eigene Inhalte an und entfernen sie wieder, ändern die Projektvorlagen-Option und die Permalink-Struktur. Die GitHub-Actions-Matrix für PHP 7.4/8.0/8.3/8.4 ist vorbereitet, wurde in diesem lokalen Auftrag aber nicht remote ausgeführt. Die optionale Library wird unter PHP 7.4 nicht geladen und ist dort von der Syntaxprüfung ausgenommen.

Vor Veröffentlichung: finale Grafik wählen, Zielhost mit MySQL/MariaDB und bei Bedarf Multisite prüfen, stabiles GitHub-Release mit endgültigem ZIP erstellen. Erst dessen genaue URL, Version und Prüfsumme dürfen in einen freigegebenen Library-Katalogeintrag gelangen. Der mitgelieferte Library-Katalog wurde unverändert übernommen. Ein echter GitHub-Download/Update sowie FTP-/SSH-Dateisystemzugriff wurden nicht ausgeführt.
