<?php
/** Run against an isolated WordPress installation: php tests/integration.php /path/to/wp-load.php */
if ( PHP_SAPI !== 'cli' || empty( $argv[1] ) ) { exit(1); }
require $argv[1];
require_once ABSPATH . 'wp-admin/includes/plugin.php';
require_once ABSPATH . 'wp-admin/includes/post.php';
require_once ABSPATH . 'wp-admin/includes/template.php';
add_filter( 'get_available_languages', function( $languages ) { return array_merge( $languages, ['de_DE', 'de_DE_formal'] ); } );
wp_set_current_user(1);
$checks = 0;
function pfc_assert( $ok, $message ) { global $checks; ++$checks; if (!$ok) { throw new RuntimeException($message); } echo "PASS: $message\n"; }
$type=get_post_type_object('portfolio-content');
pfc_assert($type && $type->public && $type->show_in_rest,'Public REST post type');
pfc_assert($type->rewrite['slug']==='portfolio' && $type->has_archive==='portfolio','Existing permalinks retained');
pfc_assert(get_taxonomy('portfolio-category')->hierarchical && !get_taxonomy('portfolio-tag')->hierarchical,'Taxonomy behavior retained');
pfc_assert(post_type_supports('portfolio-content','revisions') && post_type_supports('portfolio-content','thumbnail'),'Editor supports retained');
foreach(['pfc/post-type/params','pfc/taxonomy/params-category','pfc/taxonomy/params-tag'] as $hook){
 $callback=function($args){$args['description']='pfc-test-marker';return $args;};add_filter($hook,$callback);
 (new DDW_Portfolio_Content())->register_content();
 $object=$hook==='pfc/post-type/params'?get_post_type_object('portfolio-content'):get_taxonomy(strpos($hook,'category')!==false?'portfolio-category':'portfolio-tag');
 pfc_assert($object->description==='pfc-test-marker',"Existing filter $hook");remove_filter($hook,$callback);
}
(new DDW_Portfolio_Content())->register_content();
update_option('pfc_project_template',false);$post=new WP_Post((object)['ID'=>0,'post_type'=>'portfolio-content','post_status'=>'auto-draft']);
pfc_assert(PFC_Editor::starter('',$post)==='','Starter disabled by default');update_option('pfc_project_template',true);
pfc_assert(strpos(PFC_Editor::starter('',$post),'wp:heading')!==false,'Starter populates empty auto-draft');
pfc_assert(PFC_Editor::starter('Keep me',$post)==='Keep me','Existing content preserved');
$post->post_status='draft';pfc_assert(PFC_Editor::starter('',$post)==='','Saved draft preserved');
$post->post_status='auto-draft';$post->post_type='post';pfc_assert(PFC_Editor::starter('',$post)==='','Other post types untouched');
$post->post_type='portfolio-content';add_filter('use_block_editor_for_post_type','__return_false');
pfc_assert(strpos(PFC_Editor::starter('',$post),'<!--')===false,'Classic editor receives ordinary HTML');remove_filter('use_block_editor_for_post_type','__return_false');
$patterns=WP_Block_Patterns_Registry::get_instance();
foreach(['portfolio-content/project-story','portfolio-content/project-grid'] as $name){
 pfc_assert($patterns->is_registered($name),"Pattern registered: $name");$blocks=parse_blocks($patterns->get_registered($name)['content']);
 pfc_assert(count($blocks)>0 && $blocks[0]['blockName']!==null,"Pattern parses: $name");
}
$grid=parse_blocks($patterns->get_registered('portfolio-content/project-grid')['content']);pfc_assert($grid[0]['attrs']['query']['postType']==='portfolio-content','Overview queries portfolios only');
$id=wp_insert_post(['post_type'=>'portfolio-content','post_status'=>'publish','post_title'=>'PFC integration project','post_excerpt'=>'A test project']);
$term=wp_insert_term('PFC integration category','portfolio-category',['slug'=>'pfc-integration-category']);
wp_set_object_terms($id,[$term['term_id']],'portfolio-category');
$query=new WP_Query(['post_type'=>'portfolio-content','portfolio-category'=>'pfc-integration-category','fields'=>'ids']);
pfc_assert(in_array($id,$query->posts,true),'Category slug filters project query');
wp_delete_term($term['term_id'],'portfolio-category');
$render=do_blocks($patterns->get_registered('portfolio-content/project-grid')['content']);pfc_assert(strpos($render,'PFC integration project')!==false,'Overview renders published project');
$upload=wp_upload_bits('pfc-integration-thumb.png',null,file_get_contents(dirname(PFC_PLUGIN_FILE).'/assets/icon-256x256.png'));
$attachment=wp_insert_attachment(['post_mime_type'=>'image/png','post_title'=>'PFC test thumbnail','post_status'=>'inherit'],$upload['file'],$id);
wp_update_attachment_metadata($attachment,['width'=>256,'height'=>256,'file'=>_wp_relative_upload_path($upload['file'])]);set_post_thumbnail($id,$attachment);
ob_start();PFC_Admin::column('pfc_image',$id);$thumb=ob_get_clean();
pfc_assert(strpos($thumb,'<img')!==false && strpos($thumb,'width="64"')!==false,'Featured image column renders attachment at preview size');
wp_delete_attachment($attachment,true);wp_delete_post($id,true);
$columns=PFC_Admin::columns(['cb'=>'','title'=>'Title']);pfc_assert(array_keys($columns)===['cb','pfc_image','title'],'Thumbnail column after checkbox');
ob_start();PFC_Admin::column('pfc_image',0);$placeholder=ob_get_clean();pfc_assert(strpos($placeholder,'No featured image')!==false,'Missing thumbnail has accessible label');
ob_start();PFC_Admin::category_filter('portfolio-content','top');$select=ob_get_clean();pfc_assert(strpos($select,'name=\'portfolio-category\'')!==false || strpos($select,'name="portfolio-category"')!==false,'Category filter uses taxonomy query variable');
pfc_assert(PFC_Admin::sanitize_template('0')===false && PFC_Admin::sanitize_template('1')===true && PFC_Admin::sanitize_template(['1'])===false,'Setting rejects unexpected values');
$called=0;$callback=function($links)use(&$called){$called++;return $links;};add_filter('pfc/plugins-page/meta-links',$callback);
pfc_assert(ddw_pfc_pluginrow_meta(['x'],'other/other.php')===['x'] && $called===0,'Meta filter scoped to host plugin');
$meta=ddw_pfc_pluginrow_meta([],plugin_basename(PFC_PLUGIN_FILE));pfc_assert($called===1 && strpos(implode('',$meta),'MERGE0')===false,'Own meta filter preserved; no personal data in links');remove_filter('pfc/plugins-page/meta-links',$callback);
ob_start();PFC_Admin::page();$page=ob_get_clean();pfc_assert(strpos($page,'Your first portfolio in three steps')!==false && strpos($page,'pfc-document-changelog')!==false,'Quick start and local documents render');
wp_set_current_user(0);ob_start();PFC_Admin::page();pfc_assert(ob_get_clean()==='','Settings restricted to administrators');wp_set_current_user(1);
global $wp_locale_switcher;
remove_filter('locale', [$wp_locale_switcher, 'filter_locale']);
remove_filter('determine_locale', [$wp_locale_switcher, 'filter_locale']);
$wp_locale_switcher = new WP_Locale_Switcher(); $wp_locale_switcher->init();
switch_to_locale('de_DE');pfc_assert(__('Your projects. Ready to share.','portfolio-content')==='Deine Projekte. Bereit zum Teilen.','German locale switch');restore_previous_locale();
switch_to_locale('de_DE_formal');pfc_assert(__('Your projects. Ready to share.','portfolio-content')==='Ihre Projekte. Bereit zum Teilen.','Formal German locale switch');restore_previous_locale();
$up=new Deckerweb\PortfolioContent\GitHubUpdates();$art=$up->artwork();pfc_assert(isset($art['icons']['svg'],$art['banners']['high']),'Updater artwork map');
$args=$up->request_limits([],'https://api.github.com/repos/deckerweb/portfolio-content/releases/latest');pfc_assert($args['limit_response_size']===524288 && $args['sslverify'],'Updater bounds own metadata requests');
pfc_assert($up->request_limits(['timeout'=>20],'https://example.com')===['timeout'=>20],'Unrelated HTTP requests unchanged');
global $wp_rewrite; $wp_rewrite->set_permalink_structure('/%postname%/');
$flushes=0;$filter=function($rules)use(&$flushes){$flushes++;return $rules;};add_filter('rewrite_rules_array',$filter);
(new DDW_Portfolio_Content())->register_content();pfc_assert($flushes===0,'Normal content registration never flushes');
(new DDW_Portfolio_Content())->flush_rewrite_rules();pfc_assert($flushes>0,'Activation refreshes rewrite rules');remove_filter('rewrite_rules_array',$filter);
update_option('pfc_project_template',false);
echo "Completed $checks checks.\n";
