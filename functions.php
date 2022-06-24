<?php

/**
 * 不要なコード削除
 */
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles', 10);
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head');
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'wp_shortlink_wp_head');
remove_action('wp_head', 'dashicons-css');

/**
 * global-styles-inline-cssを無効化
 */
add_action('wp_enqueue_scripts', 'remove_global_styles');
function remove_global_styles()
{
  wp_dequeue_style('global-styles');
}

/**
 * wp-block-library-cssを無効化
 */
add_action('wp_enqueue_scripts', 'remove_block_library_style');
function remove_block_library_style()
{
  wp_dequeue_style('wp-block-library');
  wp_dequeue_style('wp-block-library-theme');
}

/**
 * メニューの位置　追加
 */
function register_my_menus()
{
  register_nav_menus(
    array(
      'gnav' => 'グローバルナビ',
    )
  );
}
add_action('after_setup_theme', 'register_my_menus');

/**
 * メニューのクラス名を削除
 */
/*function remove_nav_class($class) {
  return $class = array();
}
add_filter("nav_menu_css_class", "remove_nav_class");*/

/**
 * メニューのid名を削除
 */
function remove_nav_id($id)
{
  return $id = array();
}
add_filter("nav_menu_item_id", "remove_nav_id");

/**
 * ファイル読み込み
 */
define('THEME_URL', get_template_directory_uri());
define('THEME_DIR', get_template_directory());
define('THEME_CHILD_DIR', get_stylesheet_directory_uri());

function add_file()
{
  wp_enqueue_style('googlefont', 'https://fonts.googleapis.com/css2?family=M+PLUS+Rounded+1c:wght@400;500;700&family=Noto+Sans+JP:wght@400;500;700&display=swap', array());
  wp_enqueue_style('reset', THEME_URL . '/assets/css/reset.css', array());
  wp_enqueue_style('common-style', THEME_URL . '/assets/css/style.css', array(), filemtime(get_theme_file_path('/assets/css/style.css')));

  wp_enqueue_script('jquery-new', 'https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js', array(), "3.6.0", true);
  wp_enqueue_script('fontplus', 'https://webfont.fontplus.jp/accessor/script/fontplus.js?h23gZcXZHkY%3D&box=654acllvQ-k%3D&aa=1&ab=2', array(), "", true);
  wp_enqueue_script('fontawesome', 'https://kit.fontawesome.com/2cd5839d8f.js', array(), "v6", true);
  wp_enqueue_script('main-js', THEME_URL . '/assets/js/common.js', array(), filemtime(get_theme_file_path('/assets/js/common.js')), true);
}
add_action("wp_enqueue_scripts", "add_file");

/**
 * アーカイブの抜粋長さの変更
 */
function custom_excerpt_length($length)
{
  return 100;
}
add_filter('excerpt_length', 'custom_excerpt_length', 999);

/**
 * read moreリンクの生成
 */
function new_excerpt_more($more)
{
  return '…　<a class="read-more" href="' . get_permalink(get_the_ID()) . '">続きを読む ＞</a>';
}
add_filter('excerpt_more', 'new_excerpt_more');

/**
 *  editor-style.cssの追加
 */
add_editor_style('assets2022/css/style.css');

/**
 * editorのbodyにid、classを付与
 */
if (!isset($content_width)) $content_width = 580;
function custom_editor_settings($initArray)
{
  $initArray['body_id'] = 'renewal2022'; // id の場合はこれ
  return $initArray;
}
add_filter('tiny_mce_before_init', 'custom_editor_settings');

/**
 *  editor-style.cssのキャッシュクリア
 */
function extend_tiny_mce_before_init($mce_init)
{
  $mce_init['cache_suffix'] = 'v=' . time();
  return $mce_init;
}
add_filter('tiny_mce_before_init', 'extend_tiny_mce_before_init');

/**
 *  span消えるの防止
 */
function my_tiny_mce_before_init($init_array)
{
  $init_array['valid_elements']          = '*[*]';
  $init_array['extended_valid_elements'] = '*[*]';
  return $init_array;
}
add_filter('tiny_mce_before_init', 'my_tiny_mce_before_init');

/**
 *  ダッシュボードで不要な項目を非表示
 */
function remove_dashboard_widget()
{
  //remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' ); // 概要
  //remove_meta_box( 'dashboard_activity', 'dashboard', 'normal' ); // アクティビティ
  //remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' ); // クイックドラフト
  remove_meta_box('dashboard_primary', 'dashboard', 'side'); // WordPressニュース
}
add_action('wp_dashboard_setup', 'remove_dashboard_widget');

/**
 *  アイキャッチ
 */
add_theme_support('post-thumbnails');
