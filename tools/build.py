#!/usr/bin/env python3
"""Build direct-distribution plugin and standalone Code Snippets export."""
from pathlib import Path
import argparse,json,re,zipfile
root=Path(__file__).resolve().parents[1]
parser=argparse.ArgumentParser();parser.add_argument('--output',type=Path,required=True);args=parser.parse_args();out=args.output;out.mkdir(parents=True,exist_ok=True)
version=re.search(r'\* Version: (\S+)',(root/'portfolio-content.php').read_text()).group(1)
with zipfile.ZipFile(out/f'portfolio-content-{version}.zip','w',zipfile.ZIP_DEFLATED) as archive:
 for file in sorted(root.rglob('*')):
  if not file.is_file():continue
  rel=file.relative_to(root)
  if any(part.startswith('.') for part in rel.parts) or rel.parts[0] in ['tests','tools','vendor','node_modules']:continue
  if file.suffix in ['.scss']:continue
  archive.write(file,'portfolio-content/'+str(rel))
def php_string(text):return "'"+text.replace('\\','\\\\').replace("'","\\'")+"'"
code="""// Portfolio Content: generated from the same source as the plugin.
if ( ! defined( 'ABSPATH' ) || defined( 'PFC_BOOTED' ) ) { return; }
define( 'PFC_BOOTED', true );
define( 'PFC_SNIPPET', true );
"""
# Embed translations and docs so snippet execution never depends on plugin paths.
code+="$GLOBALS['pfc_snippet_documents'] = [\n"+''.join(php_string(str(f.relative_to(root)))+' => '+php_string(f.read_text())+",\n" for f in sorted((root/'docs').glob('*.txt')))+"];\n"
code+="$GLOBALS['pfc_snippet_translations'] = [\n"
for locale in ['de_DE','de_DE_formal']:
 text=(root/f'languages/portfolio-content-{locale}.l10n.php').read_text();array=text[text.index('return ')+7:].strip().rstrip(';');code+=php_string(locale)+' => '+array+",\n"
code+="] ;\n"
code+="""function pfc_snippet_gettext( $translated, $text, $domain ) {
    if ( 'portfolio-content' !== $domain || $translated !== $text ) { return $translated; }
    $locale = function_exists( 'determine_locale' ) ? determine_locale() : get_locale();
    return $GLOBALS['pfc_snippet_translations'][ $locale ]['messages'][ $text ] ?? $translated;
}
function pfc_snippet_gettext_context( $translated, $text, $context, $domain ) {
    if ( 'portfolio-content' !== $domain || $translated !== $text ) { return $translated; }
    $locale = function_exists( 'determine_locale' ) ? determine_locale() : get_locale();
    return $GLOBALS['pfc_snippet_translations'][ $locale ]['messages'][ $context . "\\x04" . $text ] ?? $translated;
}
add_filter( 'gettext', 'pfc_snippet_gettext', 20, 3 );
add_filter( 'gettext_with_context', 'pfc_snippet_gettext_context', 20, 4 );
"""
for name in ['class-portfolio-content.php','class-pfc-editor.php','class-pfc-documents.php','class-pfc-admin.php']:
 code+=(root/'includes'/name).read_text().removeprefix('<?php').lstrip()+'\n'
code+="PFC_Editor::register();\nPFC_Admin::register();\n"
css=(root/'assets/css/admin.css').read_text();js=(root/'assets/documentation.js').read_text()
code+="""add_action( 'admin_head', function() {
    $screen = get_current_screen();
    if ( ! $screen || ( $screen->post_type !== 'portfolio-content' && ! in_array( $screen->id, [ 'settings_page_portfolio-content', 'portfolio-content_page_pfc-quick-start' ], true ) ) ) { return; }
    echo '<style>' . """+php_string(css)+" . '</style>';\n});\n"
code+="""add_action( 'admin_footer', function() {
    $screen = get_current_screen();
    if ( ! $screen || ! in_array( $screen->id, [ 'settings_page_portfolio-content', 'portfolio-content_page_pfc-quick-start' ], true ) ) { return; }
    echo '<script>' . """+php_string(js)+" . '</script>';\n});\n"
(out/'ddw-portfolio-content.code-snippets.json').write_text(json.dumps({'generator':'Code Snippets v3','date_created':'2026-10-01 00:00','snippets':[{'name':f'Portfolio Content {version}','desc':'Portfolio content, quick start and native block patterns. Use either plugin or snippet. Save Permalinks after activation.','code':code,'scope':'global','priority':10,'active':False,'tags':['portfolio','deckerweb']}]},ensure_ascii=False,indent=2)+'\n')
print('Built plugin ZIP and snippet JSON for '+version)
