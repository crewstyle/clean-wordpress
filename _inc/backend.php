<?php

/**
 * Backend usefull hooks.
 *
 * @package CleanWordPress\Backend
 * @since Clean WordPress 1.2.0
 */

if (!defined('ABSPATH')) {
    die('You are not authorized to directly access to this page');
}


//-Backend hooks--------------------------------------------------------//

/**
 * Remove dashboard menus to editor.
 *
 * @uses current_user_can() To know if current user has permissions.
 * @uses remove_menu_page() To remove a menu page.
 * @uses remove_submenu_page() To remove a submenu page.
 *
 * @since Clean WordPress 1.2.0
 */
add_action('admin_menu', '_cw_remove_menus_for_all');
function _cw_remove_menus_for_all()
{
    //Remove WORDPRESS pages in the administration to all users, except the admin
    if (!current_user_can('edit_users')) {
        remove_submenu_page('themes.php', 'themes.php');
        remove_menu_page('plugins.php');
        remove_submenu_page('index.php', 'update-core.php');
        remove_submenu_page('options-general.php', 'options-media.php');
        remove_menu_page('link-manager.php');
        remove_menu_page('tools.php');
    }
}


/**
 * Sets up WP version check for admin panel.
 *
 * @uses current_user_can() To know if current user has permissions.
 * @uses add_action() To add a hook action.
 * @uses add_filter() To add a hook filter.
 *
 * @since Clean WordPress 1.2.0
 */
add_action('after_setup_theme', '_cw_remove_admin_wp_version_check');
function _cw_remove_admin_wp_version_check()
{
    //Remove WORDPRESS update in the administration to all users, except the admin
    if (!current_user_can('edit_users')) {
        add_action('init', create_function('$a', "remove_action('init', 'wp_version_check');"), 2);
        add_filter('pre_option_update_core', create_function('$a', "return null;"));
    }
}


/**
 * Sanitize filenames.
 *
 * @param string $filename Name of the file to sanitize
 * @uses remove_accents() Converts all accent characters to ASCII characters
 *
 * @since Clean WordPress 1.2.0
 */
add_filter('sanitize_file_name', '_cw_sanitize_filename', 10);
function _cw_sanitize_filename($filename)
{
    //Invalid characters
    $invalid = array(
        'Ã€'=>'A', 'Ã'=>'A', 'Ã‚'=>'A', 'Ãƒ'=>'A', 'Ä€'=>'A', 'Ä‚'=>'A', 'È¦'=>'A', 'Ã„'=>'A', 'áº¢'=>'A', 'Ã…'=>'A', 'Ç'=>'A', 'È€'=>'A', 'È‚'=>'A', 'Ä„'=>'A', 'áº '=>'A', 'á¸€'=>'A', 'áº¦'=>'A', 'áº¤'=>'A', 'áºª'=>'A', 'áº¨'=>'A', 'áº°'=>'A', 'áº®'=>'A', 'áº´'=>'A', 'áº²'=>'A', 'Ç '=>'A', 'Çž'=>'A', 'Çº'=>'A', 'áº¬'=>'A', 'áº¶'=>'A',
        'Ã†'=>'AE', 'Ç¼'=>'AE', 'Ç¢'=>'AE',
        'á¸‚'=>'B', 'Æ'=>'B', 'á¸„'=>'B', 'á¸†'=>'B', 'Æ‚'=>'B', 'Æ„'=>'B', 'Ãž'=>'B',
        'Äˆ'=>'C', 'ÄŠ'=>'C', 'ÄŒ'=>'C', 'Æ‡'=>'C', 'Ã‡'=>'C', 'á¸ˆ'=>'C',
        'á¸Š'=>'D', 'ÆŠ'=>'D', 'á¸Œ'=>'D', 'á¸Ž'=>'D', 'á¸'=>'D', 'á¸’'=>'D', 'ÄŽ'=>'D',
        'Ä'=>'Dj', 'Æ‰'=>'Dj',
        'Ãˆ'=>'E', 'Ã‰'=>'E', 'ÃŠ'=>'E', 'áº¼'=>'E', 'Ä’'=>'E', 'Ä”'=>'E', 'Ä–'=>'E', 'Ã‹'=>'E', 'áºº'=>'E', 'Äš'=>'E', 'È„'=>'E', 'È†'=>'E', 'áº¸'=>'E', 'È¨'=>'E', 'Ä˜'=>'E', 'á¸˜'=>'E', 'á¸š'=>'E', 'á»€'=>'E', 'áº¾'=>'E', 'á»„'=>'E', 'á»‚'=>'E', 'á¸”'=>'E', 'á¸–'=>'E', 'á»†'=>'E', 'á¸œ'=>'E', 'ÆŽ'=>'E', 'Æ'=>'E',
        'á¸ž'=>'F', 'Æ‘'=>'F',
        'Ç´'=>'G', 'Äœ'=>'G', 'á¸ '=>'G', 'Äž'=>'G', 'Ä '=>'G', 'Ç¦'=>'G', 'Æ“'=>'G', 'Ä¢'=>'G', 'Ç¤'=>'G',
        'Ä¤'=>'H', 'á¸¦'=>'H', 'Èž'=>'H', 'Ç¶'=>'H', 'á¸¤'=>'H', 'á¸¨'=>'H', 'á¸ª'=>'H', 'Ä¦'=>'H',
        'ÃŒ'=>'I', 'Ã'=>'I', 'ÃŽ'=>'I', 'Ä¨'=>'I', 'Äª'=>'I', 'Ä¬'=>'I', 'Ä°'=>'I', 'Ã'=>'I', 'á»ˆ'=>'I', 'Ç'=>'I', 'á»Š'=>'I', 'Ä®'=>'I', 'Èˆ'=>'I', 'ÈŠ'=>'I', 'á¸¬'=>'I', 'Æ—'=>'I', 'á¸®'=>'I',
        'Ä²'=>'IJ',
        'Ä´'=>'J',
        'á¸°'=>'K', 'Ç¨'=>'K', 'á¸´'=>'K', 'Æ˜'=>'K', 'á¸²'=>'K', 'Ä¶'=>'K', 'Ä¹'=>'L', 'á¸º'=>'L', 'á¸¶'=>'L', 'Ä»'=>'L', 'á¸¼'=>'L', 'Ä½'=>'L', 'Ä¿'=>'L', 'Å'=>'L', 'á¸¸'=>'L',
        'á¸¾'=>'M', 'á¹€'=>'M', 'á¹‚'=>'M', 'Æœ'=>'M', 'Ã‘'=>'N', 'Ç¸'=>'N', 'Åƒ'=>'N', 'Ã‘'=>'N', 'á¹„'=>'N', 'Å‡'=>'N', 'ÅŠ'=>'N', 'Æ'=>'N', 'á¹†'=>'N', 'Å…'=>'N', 'á¹Š'=>'N', 'á¹ˆ'=>'N', 'È '=>'N',
        'Ã’'=>'O', 'Ã“'=>'O', 'Ã”'=>'O', 'Ã•'=>'O', 'ÅŒ'=>'O', 'ÅŽ'=>'O', 'È®'=>'O', 'Ã–'=>'O', 'á»Ž'=>'O', 'Å'=>'O', 'Ç‘'=>'O', 'ÈŒ'=>'O', 'ÈŽ'=>'O', 'Æ '=>'O', 'Çª'=>'O', 'á»Œ'=>'O', 'ÆŸ'=>'O', 'Ã˜'=>'O', 'á»’'=>'O', 'á»'=>'O', 'á»–'=>'O', 'á»”'=>'O', 'È°'=>'O', 'Èª'=>'O', 'È¬'=>'O', 'á¹Œ'=>'O', 'á¹'=>'O', 'á¹’'=>'O', 'á»œ'=>'O', 'á»š'=>'O', 'á» '=>'O', 'á»ž'=>'O', 'á»¢'=>'O', 'Ç¬'=>'O', 'á»˜'=>'O', 'Ç¾'=>'O', 'Æ†'=>'O', 'Å’'=>'OE',
        'á¹”'=>'P', 'á¹–'=>'P', 'Æ¤'=>'P',
        'Å”'=>'R', 'á¹˜'=>'R', 'Å˜'=>'R',   'È'=>'R', 'È’'=>'R', 'á¹š'=>'R', 'Å–'=>'R', 'á¹ž'=>'R', 'á¹œ'=>'R', 'Æ¦'=>'R',
        'Åš'=>'S', 'Åœ'=>'S', 'á¹ '=>'S', 'Å '=>'S', 'á¹¢'=>'S', 'È˜'=>'S', 'Åž'=>'S', 'á¹¤'=>'S', 'á¹¦'=>'S', 'á¹¨'=>'S',
        'á¹ª'=>'T', 'Å¤'=>'T', 'Æ¬'=>'T', 'Æ®'=>'T', 'á¹¬'=>'T', 'Èš'=>'T', 'Å¢'=>'T', 'á¹°'=>'T', 'á¹®'=>'T', 'Å¦'=>'T',
        'Ã™'=>'U', 'Ãš'=>'U', 'Ã›'=>'U', 'Å¨'=>'U', 'Åª'=>'U', 'Å¬'=>'U', 'Ãœ'=>'U', 'á»¦'=>'U', 'Å®'=>'U', 'Å°'=>'U', 'Ç“'=>'U', 'È”'=>'U', 'È–'=>'U', 'Æ¯'=>'U', 'á»¤'=>'U', 'á¹²'=>'U', 'Å²'=>'U', 'á¹¶'=>'U', 'á¹´'=>'U',   'á¹¸'=>'U', 'á¹º'=>'U', 'Ç›'=>'U', 'Ç—'=>'U', 'Ç•'=>'U', 'Ç™'=>'U', 'á»ª'=>'U',     'á»¨'=>'U', 'á»®'=>'U', 'á»¬'=>'U', 'á»°'=>'U',
        'á¹¼'=>'V', 'á¹¾'=>'V', 'Æ²'=>'V',
        'áº€'=>'W', 'áº‚'=>'W', 'Å´'=>'W', 'áº†'=>'W', 'áº„'=>'W', 'áºˆ'=>'W',
        'áºŠ'=>'X', 'áºŒ'=>'X',
        'á»²'=>'Y', 'Ã'=>'Y', 'Å¶'=>'Y', 'á»¸'=>'Y', 'È²'=>'Y', 'áºŽ'=>'Y', 'Å¸'=>'Y', 'á»¶'=>'Y', 'Æ³'=>'Y', 'á»´'=>'Y',
        'Å¹'=>'Z', 'áº'=>'Z', 'Å»'=>'Z', 'Å½'=>'Z', 'È¤'=>'Z', 'áº’'=>'Z', 'áº”'=>'Z', 'Æµ'=>'Z',
        'Ã '=>'a', 'Ã¡'=>'a', 'Ã¢'=>'a', 'Ã£'=>'a', 'Ä'=>'a', 'Äƒ'=>'a', 'È§'=>'a', 'Ã¤'=>'a', 'áº£'=>'a', 'Ã¥'=>'a', 'ÇŽ'=>'a', 'È'=>'a', 'Ä…'=>'a', 'áº¡'=>'a', 'á¸'=>'a', 'áºš'=>'a', 'áº§'=>'a', 'áº¥'=>'a', 'áº«'=>'a', 'áº©'=>'a', 'áº±'=>'a', 'áº¯'=>'a', 'áºµ'=>'a', 'áº³'=>'a', 'Ç¡'=>'a', 'ÇŸ'=>'a', 'Ç»'=>'a', 'áº­'=>'a', 'áº·'=>'a',
        'Ã¦'=>'ae', 'Ç½'=>'ae', 'Ç£'=>'ae',
        'á¸ƒ'=>'b', 'É“'=>'b', 'á¸…'=>'b', 'á¸‡'=>'b', 'Æ€'=>'b', 'Æƒ'=>'b', 'Æ…'=>'b', 'Ã¾'=>'b',
        'Ä‡'=>'c', 'Ä‰'=>'c', 'Ä‹'=>'c', 'Ä'=>'c', 'Æˆ'=>'c', 'Ã§'=>'c', 'á¸‰'=>'c',
        'á¸‹'=>'d', 'É—'=>'d', 'á¸'=>'d', 'á¸'=>'d', 'á¸‘'=>'d', 'á¸“'=>'d', 'Ä'=>'d', 'Ä‘'=>'d', 'ÆŒ'=>'d', 'È¡'=>'d',
        'Ä‘'=>'dj',
        'Ã¨'=>'e', 'Ã©'=>'e', 'Ãª'=>'e', 'áº½'=>'e', 'Ä“'=>'e', 'Ä•'=>'e', 'Ä—'=>'e', 'Ã«'=>'e', 'áº»'=>'e', 'Ä›'=>'e', 'È…'=>'e', 'È‡'=>'e', 'áº¹'=>'e', 'È©'=>'e', 'Ä™'=>'e', 'á¸™'=>'e', 'á¸›'=>'e', 'á»'=>'e', 'áº¿'=>'e',             'á»…'=>'e', 'á»ƒ'=>'e', 'á¸•'=>'e', 'á¸—'=>'e', 'á»‡'=>'e', 'á¸'=>'e', 'Ç'=>'e', 'É›'=>'e',
        'á¸Ÿ'=>'f', 'Æ’'=>'f',
        'Çµ'=>'g', 'Ä'=>'g', 'á¸¡'=>'g', 'ÄŸ'=>'g', 'Ä¡'=>'g', 'Ç§'=>'g', 'É '=>'g', 'Ä£'=>'g', 'Ç¥'=>'g',
        'Ä¥'=>'h', 'á¸£'=>'h', 'á¸§'=>'h', 'ÈŸ'=>'h', 'Æ•'=>'h', 'á¸¥'=>'h', 'á¸©'=>'h', 'á¸«'=>'h', 'áº–'=>'h', 'Ä§'=>'h',
        'Ã¬'=>'i', 'Ã­'=>'i', 'Ã®'=>'i', 'Ä©'=>'i', 'Ä«'=>'i', 'Ä­'=>'i', 'Ä±'=>'i', 'Ã¯'=>'i', 'á»‰'=>'i', 'Ç'=>'i', 'á»‹'=>'i', 'Ä¯'=>'i', 'È‰'=>'i', 'È‹'=>'i', 'á¸­'=>'i',  'É¨'=>'i', 'á¸¯'=>'i',
        'Ä³'=>'ij',
        'Äµ'=>'j', 'Ç°'=>'j',
        'á¸±'=>'k', 'Ç©'=>'k', 'á¸µ'=>'k', 'Æ™'=>'k', 'á¸³'=>'k', 'Ä·'=>'k',
        'Äº'=>'l', 'á¸»'=>'l', 'á¸·'=>'l', 'Ä¼'=>'l', 'á¸½'=>'l', 'Ä¾'=>'l', 'Å€'=>'l', 'Å‚'=>'l', 'Æš'=>'l', 'á¸¹'=>'l', 'È´'=>'l',
        'á¸¿'=>'m', 'á¹'=>'m', 'á¹ƒ'=>'m', 'É¯'=>'m',
        'Ç¹'=>'n', 'Å„'=>'n', 'Ã±'=>'n', 'á¹…'=>'n', 'Åˆ'=>'n', 'Å‹'=>'n', 'É²'=>'n', 'á¹‡'=>'n', 'Å†'=>'n', 'á¹‹'=>'n', 'á¹‰'=>'n', 'Å‰'=>'n', 'Æž'=>'n', 'Èµ'=>'n',
        'Ã²'=>'o', 'Ã³'=>'o', 'Ã´'=>'o', 'Ãµ'=>'o', 'Å'=>'o', 'Å'=>'o', 'È¯'=>'o', 'Ã¶'=>'o', 'á»'=>'o', 'Å‘'=>'o', 'Ç’'=>'o', 'È'=>'o', 'È'=>'o', 'Æ¡'=>'o', 'Ç«'=>'o', 'á»'=>'o', 'Éµ'=>'o', 'Ã¸'=>'o', 'á»“'=>'o', 'á»‘'=>'o', 'á»—'=>'o', 'á»•'=>'o', 'È±'=>'o', 'È«'=>'o', 'È­'=>'o', 'á¹'=>'o', 'á¹'=>'o', 'á¹‘'=>'o', 'á¹“'=>'o', 'á»'=>'o', 'á»›'=>'o', 'á»¡'=>'o', 'á»Ÿ'=>'o', 'á»£'=>'o', 'Ç­'=>'o', 'á»™'=>'o', 'Ç¿'=>'o', 'É”'=>'o',
        'Å“'=>'oe',
        'á¹•'=>'p', 'á¹—'=>'p', 'Æ¥'=>'p',
        'Å•'=>'r', 'á¹™'=>'r', 'Å™'=>'r', 'È‘'=>'r', 'È“'=>'r', 'á¹›'=>'r', 'Å—'=>'r', 'á¹Ÿ'=>'r', 'á¹'=>'r',
        'Å›'=>'s', 'Å'=>'s', 'á¹¡'=>'s', 'Å¡'=>'s', 'á¹£'=>'s', 'È™'=>'s', 'ÅŸ'=>'s', 'á¹¥'=>'s', 'á¹§'=>'s', 'á¹©'=>'s', 'Å¿'=>'s', 'áº›'=>'s',
        'ÃŸ'=>'Ss',
        'á¹«'=>'t', 'áº—'=>'t', 'Å¥'=>'t', 'Æ­'=>'t', 'Êˆ'=>'t', 'Æ«'=>'t', 'á¹­'=>'t', 'È›'=>'t', 'Å£'=>'t', 'á¹±'=>'t', 'á¹¯'=>'t', 'Å§'=>'t', 'È¶'=>'t',
        'Ã¹'=>'u', 'Ãº'=>'u', 'Ã»'=>'u', 'Å©'=>'u', 'Å«'=>'u', 'Å­'=>'u', 'Ã¼'=>'u', 'á»§'=>'u', 'Å¯'=>'u', 'Å±'=>'u', 'Ç”'=>'u', 'È•'=>'u', 'È—'=>'u', 'Æ°'=>'u', 'á»¥'=>'u', 'á¹³'=>'u', 'Å³'=>'u', 'á¹·'=>'u', 'á¹µ'=>'u', 'á¹¹'=>'u', 'á¹»'=>'u', 'Çœ'=>'u', 'Ç˜'=>'u', 'Ç–'=>'u', 'Çš'=>'u', 'á»«'=>'u', 'á»©'=>'u', 'á»¯'=>'u', 'á»­'=>'u', 'á»±'=>'u',
        'á¹½'=>'v', 'á¹¿'=>'v',
        'áº'=>'w', 'áºƒ'=>'w', 'Åµ'=>'w', 'áº‡'=>'w', 'áº…'=>'w', 'áº˜'=>'w', 'áº‰'=>'w',
        'áº‹'=>'x', 'áº'=>'x',
        'Ã½'=>'y', 'Ã½'=>'y', 'á»³'=>'y', 'Ã½'=>'y', 'Å·'=>'y', 'È³'=>'y', 'áº'=>'y', 'Ã¿'=>'y', 'Ã¿'=>'y', 'á»·'=>'y', 'áº™'=>'y', 'Æ´'=>'y', 'á»µ'=>'y',
        'Åº'=>'z', 'áº‘'=>'z', 'Å¼'=>'z', 'Å¾'=>'z', 'È¥'=>'z', 'áº“'=>'z', 'áº•'=>'z', 'Æ¶'=>'z',
        'â„–'=>'No',
        'Âº'=>'o',
        'Âª'=>'a',
        'â‚¬'=>'E',
        'Â©'=>'C',
        'â„—'=>'P',
        'â„¢'=>'tm',
        'â„ '=>'sm'
    );

    //Make the magic
    $sanitized_filename = str_replace(array_keys($invalid), array_values($invalid), $filename);
    $sanitized_filename = remove_accents($sanitized_filename);
    $sanitized_filename = preg_replace('/[^a-zA-Z0-9-_\.]/', '', strtolower($sanitized_filename));

    //Return the new name
    return $sanitized_filename;
}


/**
 * Remove menu items from WordPress admin bar.
 *
 * @uses remove_menu() To remove specific menu.
 *
 * @since Clean WordPress 1.2.0
 */
add_action('wp_before_admin_bar_render', '_cw_remove_bar_icons');
function _cw_remove_bar_icons()
{
    global $wp_admin_bar;

    //Remove all useless WP bar menus
    $wp_admin_bar->remove_menu('wp-logo');
    $wp_admin_bar->remove_menu('about');
    $wp_admin_bar->remove_menu('comments');
    $wp_admin_bar->remove_menu('new-content');
    $wp_admin_bar->remove_menu('wporg');
    $wp_admin_bar->remove_menu('documentation');
    $wp_admin_bar->remove_menu('support-forums');
    $wp_admin_bar->remove_menu('feedback');
    $wp_admin_bar->remove_menu('view-site');
}


/**
 * Disable emojicons introduced with WP 4.2 in backend panel.
 *
 * @uses remove_action()
 * @uses add_filter()
 *
 * @since Clean WordPress 1.3.2
 */
add_action('init', '_cw_disable_wp_emojicons');
function _cw_disable_wp_emojicons()
{
    //All actions related to emojis
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');

    //Filter function used to remove the tinymce emoji plugin
    add_filter('tiny_mce_plugins', '_cw_disable_emojicons_tinymce');
}
function _cw_disable_emojicons_tinymce($plugins)
{
    if (is_array($plugins)) {
        return array_diff($plugins, array('wpemoji'));
    }

    return array();
}
