<?php
/**
 * Frontend usefull hooks.
 *
 * @package CleanWordPress\Frontend
 * @since Clean WordPress 1.2.0
 */

if (!defined('ABSPATH')) {
    die('You are not authorized to directly access to this page');
}


//-Admin bar--------------------------------------------------------//

//Remove admin bar since v3.1
add_filter('show_admin_bar', '__return_false');
remove_action('init', 'wp_admin_bar_init');


//-Feeds--------------------------------------------------------//

//Remove automatic feed links since WP v.3.x
remove_theme_support('automatic-feed-links');

//Remove feed links
//<link rel="alternate" type="application/rss+xml" title="__SITE_NAME__ &raquo; Comments Feed" href="__SITE_URL__/comments/feed/" />
remove_action('wp_head', 'feed_links', 2);

//Remove extra feed links, such as categories, tags, etc.
//<link rel="alternate" type="application/rss+xml" title="__SITE_NAME__ &raquo; Comments Feed" href="__SITE_URL__/category/__CAT__/feed/" />
remove_action('wp_head', 'feed_links_extra', 3);


//-Generator--------------------------------------------------------//

//Remove WORDPRESS version.
//<meta name="generator" content="WordPress __WP_VERSION__" />
remove_action('wp_head', 'wp_generator');

/**
 * Remove WORDPRESS generator info.
 *
 * @since Clean WordPress 1.1.0
 */
add_filter('the_generator', '_cw_remove_version');
function _cw_remove_version()
{
    return '';
}


//-Links--------------------------------------------------------//

//Link to adjacent posts.
//<link rel="prev" title="adjacent_posts_rel_link" href="__SITE_URL__" />
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);

//Link to blog index.
//<link rel="index" title="__SITE_NAME__" href="__SITE_URL__" />
remove_action('wp_head', 'index_rel_link');

//Really Simple Discovery support.
//<link rel="EditURI" type="application/rsd+xml" title="RSD" href="__SITE_URL__" />
remove_action('wp_head', 'rsd_link');

//Remove Shortlink Link Rel Hook
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);

//Windows Live Writter support.
//<link rel="wlwmanifest" type="application/wlwmanifest+xml" href="__SITE_URL__" />
remove_action('wp_head', 'wlwmanifest_link');

//Others
remove_action('wp_head', 'parent_post_rel_link', 10, 0);
remove_action('wp_head', 'start_post_rel_link', 10, 0);


//-i18n--------------------------------------------------------//

//Remove i18n styles
remove_action('wp_head', 'wp_dlmp_l10n_style');


//-Frontend hooks--------------------------------------------------------//

/**
 * Delete Wordpress auto-formatting.
 *
 * @uses wptexturize()
 * @uses wpautop() To format content
 *
 * @since Clean WordPress 1.2.0
 */
remove_filter('the_content', 'wpautop');
remove_filter('the_content', 'wptexturize');
add_filter('the_content', '_wc_shortcode_formatter', 99);
function _wc_shortcode_formatter($content)
{
    $new_content = '';
    $pattern_full = '{(\[raw\].*?\[/raw\])}is';
    $pattern_contents = '{\[raw\](.*?)\[/raw\]}is';
    $pieces = preg_split($pattern_full, $content, -1, PREG_SPLIT_DELIM_CAPTURE);

    //Make the magic
    foreach ($pieces as $piece) {
        if (preg_match($pattern_contents, $piece, $matches)) {
            $new_content .= $matches[1];
        } else {
            $new_content .= wptexturize(wpautop($piece));
        }
    }

    return $new_content;
}
