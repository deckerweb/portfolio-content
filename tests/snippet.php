<?php
/** Run: php tests/snippet.php /path/to/wp-load.php /path/to/generated-snippet.json */
if(PHP_SAPI!=='cli' || count($argv)!==3){exit(1);}
define('WP_INSTALLING',true);require $argv[1];
$export=json_decode(file_get_contents($argv[2]),true);
eval($export['snippets'][0]['code']);
(new DDW_Portfolio_Content())->register_content();PFC_Editor::patterns();
if(!post_type_exists('portfolio-content') || defined('PFC_PLUGIN_FILE') || !defined('PFC_SNIPPET'))throw new RuntimeException('Snippet boot');
if(!WP_Block_Patterns_Registry::get_instance()->is_registered('portfolio-content/project-grid'))throw new RuntimeException('Snippet patterns');
add_filter('determine_locale',function(){return 'de_DE';},1000);
if(__('Save settings','portfolio-content')!=='Einstellungen speichern')throw new RuntimeException('Snippet translation');
if(PFC_Documents::url('changelog')!=='#pfc-document-changelog')throw new RuntimeException('Snippet documents');
ob_start();PFC_Documents::dialogs();$html=ob_get_clean();if(strpos($html,'Änderungsprotokoll')===false)throw new RuntimeException('Snippet embedded documents');
require dirname(__DIR__).'/portfolio-content.php';if(defined('PFC_PLUGIN_FILE'))throw new RuntimeException('Duplicate boot');
echo "PASS: standalone snippet, patterns, translations, bundled documents and duplicate guard\n";
