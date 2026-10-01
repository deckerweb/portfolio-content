<?php
/** Run: php tests/update-package.php /path/to/wp-load.php */
if ( PHP_SAPI !== 'cli' || empty( $argv[1] ) ) { exit(1); }
require $argv[1];require_once ABSPATH.'wp-admin/includes/file.php';WP_Filesystem();
$updater=new Deckerweb\PortfolioContent\GitHubUpdates();
$context=['plugin'=>plugin_basename(PFC_PLUGIN_FILE),'type'=>'plugin','action'=>'update'];
$dir=sys_get_temp_dir().'/pfc-update-'.uniqid();mkdir($dir);
function check_update($ok,$label){if(!$ok)throw new RuntimeException($label);echo "PASS: $label\n";}
function candidate($dir,$version='1.3.0',$name='Portfolio Content',$php='7.4',$wp='6.7'){
 file_put_contents($dir.'/portfolio-content.php',"<?php\n/*\nPlugin Name: $name\nVersion: $version\nUpdate URI: https://github.com/deckerweb/portfolio-content\nRequires PHP: $php\nRequires at least: $wp\n*/\n");
}
$original=get_site_transient('update_plugins');$offered=(object)['response'=>[plugin_basename(PFC_PLUGIN_FILE)=>(object)['new_version'=>'1.3.0']]];set_site_transient('update_plugins',$offered);
try{
 candidate($dir);check_update($updater->validate_source($dir,'',null,$context)===$dir,'Matching newer package accepted');
 candidate($dir,'1.1.0');check_update(is_wp_error($updater->validate_source($dir,'',null,$context)),'Downgrade rejected');
 candidate($dir,'1.3.0','Other plugin');check_update(is_wp_error($updater->validate_source($dir,'',null,$context)),'Wrong package identity rejected');
 candidate($dir,'1.4.0');check_update(is_wp_error($updater->validate_source($dir,'',null,$context)),'Version differing from offered update rejected');
 candidate($dir,'1.3.0','Portfolio Content','99.0');check_update(is_wp_error($updater->validate_source($dir,'',null,$context)),'Incompatible PHP requirement rejected');
 candidate($dir,'1.3.0','Portfolio Content','7.4','99.0');check_update(is_wp_error($updater->validate_source($dir,'',null,$context)),'Incompatible WordPress requirement rejected');
 candidate($dir,'1.3.0','Portfolio Content','','6.7');check_update(is_wp_error($updater->validate_source($dir,'',null,$context)),'Missing requirement rejected');
 check_update($updater->validate_source($dir,'',null,['plugin'=>'other/other.php','type'=>'plugin','action'=>'update'])===$dir,'Other plugins untouched');
 check_update(is_wp_error($updater->validate_source(new WP_Error('ddw_ghru_archive','original'),'',null,$context)),'Shared updater errors preserved and localized');
 unlink($dir.'/portfolio-content.php');check_update(is_wp_error($updater->validate_source($dir,'',null,$context)),'Missing plugin main file rejected');
}finally{set_site_transient('update_plugins',$original);if(is_file($dir.'/portfolio-content.php'))unlink($dir.'/portfolio-content.php');rmdir($dir);}
