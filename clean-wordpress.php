<?php
/*
 * Plugin Name: Clean WP Head
 *
 * Description: Remove unnecessary metatags informations from head tag.
 * Author: Achraf Chouk <ach@takeatea.com>
 * Version: 1.0
 *
 * Author URI: http://www.takeatea.com/
 * Plugin URI: http://www.takeatea.com/
 * License: The MIT License (MIT)
 * License URI: http://opensource.org/licenses/MIT
 *
 * @package crewstyle\CleanWPhead
 * @author Achraf Chouk <ach@takeatea.com>
 * @copyright Copyright (c) 2015, Take a tea.
 * @license MIT
 */

//Check Frontend website
if (is_admin()) {
    return;
}

//Remove automatic feed links since WP v.3.x
remove_theme_support('automatic-feed-links');

//Remove Shortlink Link Rel Hook
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);

//Remove i18n styles
remove_action('wp_head', 'wp_dlmp_l10n_style');

//Remove admin bar since v3.1
add_filter('show_admin_bar', '__return_false');
remove_action('init', 'wp_admin_bar_init');

//Windows Live Writter support.
//<link rel="wlwmanifest" type="application/wlwmanifest+xml" href="__SITE_URL__" />
remove_action('wp_head', 'wlwmanifest_link');

//Really Simple Discovery support.
//<link rel="EditURI" type="application/rsd+xml" title="RSD" href="__SITE_URL__" />
remove_action('wp_head', 'rsd_link');

//Link to adjacent posts.
//<link rel="prev" title="adjacent_posts_rel_link" href="__SITE_URL__" />
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);

//Remove WORDPRESS version.
//<meta name="generator" content="WordPress __WP_VERSION__" />
remove_action('wp_head', 'wp_generator');

//Link to blog index.
//<link rel="index" title="__SITE_NAME__" href="__SITE_URL__" />
remove_action('wp_head', 'index_rel_link');

//Last actions
remove_action('wp_head', 'feed_links', 2);
remove_action('wp_head', 'feed_links_extra', 3);
remove_action('wp_head', 'parent_post_rel_link', 10, 0);
remove_action('wp_head', 'start_post_rel_link', 10, 0);
