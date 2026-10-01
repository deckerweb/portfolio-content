<?php
/** Run: php tests/library.php /path/to/wp-load.php */
if(PHP_SAPI!=='cli' || empty($argv[1])){exit(1);}require $argv[1];wp_set_current_user(1);
if(PHP_VERSION_ID<80000){if(!empty($GLOBALS['deckerweb_library_runtime_v1']))throw new RuntimeException('Unsupported Library runtime');exit;}
$runtime=$GLOBALS['deckerweb_library_runtime_v1']??null;
if(!$runtime || get_class($runtime)!=='Deckerweb\\PluginLibrary\\V0_2_0\\Library')throw new RuntimeException('Library runtime');
$tabs=apply_filters('install_plugins_tabs',['featured'=>'Featured']);
if(!isset($tabs['featured'],$tabs['deckerweb']))throw new RuntimeException('Library tab');
$candidates=$GLOBALS['deckerweb_library_candidates_v1'];
if(!in_array(PFC_PLUGIN_FILE,array_column($candidates,'host'),true))throw new RuntimeException('Library host missing');
echo "PASS: Library election, host registration and catalog tab; WordPress.org stays available\n";
