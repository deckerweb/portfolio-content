from pathlib import Path
import re,json,ast,subprocess
p=Path(__file__).resolve().parents[1]; files=[p/'portfolio-content.php']+list((p/'includes').glob('class*.php'))
subprocess.run(['xgettext','--language=PHP','--from-code=UTF-8','--keyword=__','--keyword=_x:1,2c','--keyword=esc_html__','--keyword=esc_attr__','--keyword=esc_html_x:1,2c','--keyword=esc_attr_x:1,2c','--package-name=Portfolio Content','--package-version=1.2.0','-o','languages/portfolio-content.pot']+[str(f.relative_to(p)) for f in files],check=True,cwd=p)
def entries(text):
 result=[]
 for block in text.split('\n\n'):
  item={}; field=None
  for line in block.splitlines():
   m=re.match(r'(msgctxt|msgid|msgstr) (".*")$',line)
   if m: field=m[1];item[field]=ast.literal_eval(m[2])
   elif line.startswith('"') and field: item[field]+=ast.literal_eval(line)
  if 'msgid' in item: result.append(item)
 return result
extra={
'Edit Portfolio':'Portfolio bearbeiten','Portfolio Content':'Portfolio Content','Save settings':'Einstellungen speichern','All Portfolios':'Alle Portfolios','Image':'Bild','No featured image':'Kein Beitragsbild','All portfolio categories':'Alle Portfolio-Kategorien','Quick start':'Schnellstart','Your projects. Ready to share.':'Deine Projekte. Bereit zum Teilen.',
'The challenge':'Die Aufgabe','The approach':'Die Umsetzung','The result':'Das Ergebnis',
'What did the client need? Describe the goal and starting point.':'Was wurde gebraucht? Beschreibe das Ziel und die Ausgangslage.',
'Explain your contribution and the steps that made the project work.':'Beschreibe deinen Beitrag und die Schritte, die das Projekt erfolgreich gemacht haben.',
'Show the outcome and what improved for the client.':'Zeige das Ergebnis und die Verbesserungen für den Kunden.',
'Portfolio: project story':'Portfolio: Projektvorstellung','A project story with challenge, approach, result and a gallery.':'Eine Projektvorstellung mit Aufgabe, Umsetzung, Ergebnis und Galerie.',
'Your published projects will appear here.':'Hier erscheinen deine veröffentlichten Projekte.',
'Portfolio: project overview':'Portfolio: Projektübersicht','A responsive project grid using native WordPress blocks and your theme styles.':'Ein responsives Projektraster mit WordPress-Blöcken und den Stilen deines Themes.',
'Your first portfolio in three steps':'Dein erstes Portfolio in drei Schritten',
'1. Add your first project':'1. Erstes Projekt anlegen',
'Add a title, featured image and a short excerpt. Categories help visitors find related work.':'Ergänze Titel, Beitragsbild und einen kurzen Textauszug. Kategorien helfen Besuchern, ähnliche Arbeiten zu finden.',
'Add project':'Projekt anlegen','2. Create your overview':'2. Übersicht erstellen',
'Create a page, open Patterns and choose Portfolio Content → Portfolio: project overview. The grid automatically shows your published projects.':'Erstelle eine Seite, öffne die Vorlagen und wähle Portfolio Content → Portfolio: Projektübersicht. Das Raster zeigt automatisch deine veröffentlichten Projekte.',
'In your page builder, add a post grid and select Portfolio Content as its content source. Choose your image, title and excerpt layout.':'Füge in deinem Page Builder ein Beitragsraster ein und wähle Portfolio Content als Inhaltsquelle. Lege das Layout für Bild, Titel und Textauszug fest.',
'Create page':'Seite erstellen','3. Review and share':'3. Prüfen und teilen',
'Publish your project and check its public view. The archive layout is provided by your theme; add your overview page to your navigation when ready.':'Veröffentliche dein Projekt und prüfe die öffentliche Ansicht. Dein Theme gestaltet das Archiv. Füge deine Übersichtsseite zur Navigation hinzu, sobald sie fertig ist.',
'View portfolio archive':'Portfolio-Archiv ansehen','View projects':'Projekte ansehen','Project starter template':'Projektvorlage',
'Start new projects with editable sections for the challenge, approach, result and images. Existing projects are never changed.':'Beginne neue Projekte mit bearbeitbaren Abschnitten für Aufgabe, Umsetzung, Ergebnis und Bilder. Bestehende Projekte bleiben unverändert.',
'Use the starter template for new projects':'Projektvorlage für neue Projekte verwenden','Make it yours':'Gestalte dein Portfolio',
'The block editor includes two Portfolio Content patterns: a project story and a project overview. Use your theme styles to adjust the design. With a classic editor or page builder, use the project content and its native post grid instead.':'Im Block-Editor findest du zwei Portfolio-Content-Vorlagen: Projektvorstellung und Projektübersicht. Passe das Design mit den Stilen deines Themes an. Bei einem klassischen Editor oder Page Builder nutzt du die Projektinhalte und das dortige Beitragsraster.',
'Custom fields can be added with your preferred field plugin. Portfolio Content keeps your content independent of its presentation.':'Individuelle Felder kannst du mit deinem bevorzugten Feld-Plugin ergänzen. Portfolio Content hält deine Inhalte unabhängig von ihrer Darstellung.',
'Plugin information':'Plugin-Informationen','Version':'Version','Changelog':'Änderungsprotokoll','Documentation':'Dokumentation','Plugin website':'Plugin-Website','Donate':'Spenden','Join our Newsletter':'Newsletter abonnieren','Close':'Schließen',
'Portfolio projects, categories and tags with a quick start, project template and native block patterns.':'Portfolio-Projekte, Kategorien und Schlagwörter mit Schnellstart, Projektvorlage und nativen Block-Vorlagen.',
'The update filesystem is unavailable. Please try again.':'Das Dateisystem für Updates ist nicht verfügbar. Bitte versuche es erneut.',
'The GitHub package does not contain the Portfolio Content plugin file.':'Das GitHub-Paket enthält nicht die Plugin-Datei von Portfolio Content.',
'The GitHub package could not be prepared. The installed version has been kept.':'Das GitHub-Paket konnte nicht vorbereitet werden. Die installierte Version bleibt erhalten.',
'The update package could not be checked.':'Das Update-Paket konnte nicht geprüft werden.',
'The package identity or version does not match a newer Portfolio Content release.':'Identität oder Version des Pakets stimmen nicht mit einer neueren Portfolio-Content-Version überein.',
'The package version differs from the offered update. Please check for updates again.':'Die Paketversion weicht vom angebotenen Update ab. Bitte prüfe erneut auf Updates.',
'The update package has missing or invalid WordPress/PHP requirements.':'Das Update-Paket enthält fehlende oder ungültige WordPress-/PHP-Anforderungen.',
'This release requires a newer WordPress or PHP version. The installed version has been kept.':'Diese Version benötigt eine neuere WordPress- oder PHP-Version. Die installierte Version bleibt erhalten.',
}
source=entries((p/'languages/portfolio-content.pot').read_text())
for locale in ['de_DE','de_DE_formal']:
 old={(e.get('msgctxt',''),e['msgid']):e.get('msgstr','') for e in entries((p/f'languages/portfolio-content-{locale}.po').read_text())}
 header=f'Project-Id-Version: Portfolio Content 1.2.0\nLanguage: {locale}\nLast-Translator: David Decker – DECKERWEB\nLanguage-Team: German\nMIME-Version: 1.0\nContent-Type: text/plain; charset=UTF-8\nContent-Transfer-Encoding: 8bit\nPlural-Forms: nplurals=2; plural=(n != 1);\nPO-Revision-Date: 2026-10-01 12:00+0200\n'
 lines=['msgid ""','msgstr '+json.dumps(header,ensure_ascii=False)];messages={};missing=[]
 for e in source:
  if not e['msgid']:continue
  en=e['msgid'];de=extra.get(en,old.get((e.get('msgctxt',''),en),''))
  if not de: missing.append(en)
  if locale=='de_DE_formal' and en in extra:
   for a,b in [('deines','Ihres'),('deiner','Ihrer'),('Deine','Ihre'),('deine','Ihre'),('Dein','Ihr'),('dein','Ihr'),('deinem','Ihrem'),('deinen','Ihren')]:de=re.sub(r'\b'+re.escape(a)+r'\b',b,de)
   for a,b in [('Gestalte','Gestalten Sie'),('Beschreibe','Beschreiben Sie'),('beschreibe','beschreiben Sie'),('Zeige','Zeigen Sie'),('Erstelle','Erstellen Sie'),('öffne','öffnen Sie'),('wähle','wählen Sie'),('Ergänze','Ergänzen Sie'),('Füge','Fügen Sie'),('Lege','Legen Sie'),('Veröffentliche','Veröffentlichen Sie'),('prüfe','prüfen Sie'),('Beginne','Beginnen Sie'),('Passe','Passen Sie'),('findest du','finden Sie'),('nutzt du','nutzen Sie'),('kannst du','können Sie'),('Bitte versuche','Bitte versuchen Sie')]:de=re.sub(r'\b'+re.escape(a)+r'\b',b,de)
  lines+=['']
  if 'msgctxt' in e:lines+=['msgctxt '+json.dumps(e['msgctxt'],ensure_ascii=False)]
  lines+=['msgid '+json.dumps(en,ensure_ascii=False),'msgstr '+json.dumps(de,ensure_ascii=False)]
  messages[(e.get('msgctxt','')+'\x04' if e.get('msgctxt') else '')+en]=de
 if missing:raise Exception(missing)
 po=p/f'languages/portfolio-content-{locale}.po';po.write_text('\n'.join(lines)+'\n');subprocess.run(['msgfmt','--check','-o',str(po.with_suffix('.mo')),str(po)],check=True)
 def phpq(s):return "'"+s.replace('\\','\\\\').replace("'","\\'")+"'"
 l10n="<?php\nreturn ['project-id-version' => 'Portfolio Content 1.2.0', 'language' => "+phpq(locale)+", 'plural-forms' => 'nplurals=2; plural=(n != 1);', 'messages' => [\n"+''.join(phpq(k)+' => '+phpq(v)+",\n" for k,v in messages.items())+"]];\n"
 po.with_suffix('.l10n.php').write_text(l10n)
 print(locale,len(messages),'translated strings')
