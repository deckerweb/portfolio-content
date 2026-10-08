# Prüfungen

Die Skripte unter tests/ benötigen eine separate, entbehrliche WordPress-Installation. Sie verändern eigene Testinhalte und Einstellungen und dürfen nicht auf produktiven Websites ausgeführt werden.

Integration prüft Inhaltstyp, Taxonomien, Vorlagen, Listenverwaltung, Übersetzungen und Paketgrenzen. lifecycle.php prüft Aktivierung, Deaktivierung und Datenhaltung; für Netzwerkfälle eine separate Multisite verwenden. Library-Prüfungen benötigen den Admin-Kontext.

Beispiel: `php tests/integration.php /pfad/zur/testinstallation/wp-load.php`. Weitere Prüfungen: `tests/update-package.php`, `tests/library.php`, `tests/lifecycle.php` und `tests/verification.php`.

`python3 tools/build-docs.py` erzeugt die öffentlichen Sprachfassungen aus docs/content.json. `python3 tools/localize.py` prüft und kompiliert die Sprachressourcen. `python3 tools/build.py --output /pfad/zur/ausgabe` erzeugt ausschließlich das Plugin-ZIP.

[English](TESTING.md)
