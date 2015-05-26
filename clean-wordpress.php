<?php
/**
 * Plugin Name: Clean WordPress
 *
 * Description: Remove unnecessary metatags informations from head tag, close DB connections, and more.
 * Author: Achraf Chouk <ach@takeatea.com>
 * Version: 1.2.0 ~ "SOGEKING!" (One Piece)
 *
 * Author URI: http://www.takeatea.com/
 * Plugin URI: http://www.takeatea.com/
 * License: The MIT License (MIT)
 * License URI: http://opensource.org/licenses/MIT
 *
 * @author Achraf Chouk <ach@takeatea.com>
 * @copyright Copyright (c) 2015, Take a tea.
 * @license MIT
 * @package CleanWordPress\Frontend
 * @since Clean WordPress 1.2.0
 */

if (!defined('ABSPATH')) {
    die('You are not authorized to directly access to this page');
}

//Check Back~Frontend website
if (is_admin()) {
    include(__DIR__.'/_inc/backend.php');
} else {
    include(__DIR__.'/_inc/frontend.php');
}


//-All common hooks--------------------------------------------------------//

/**
 * Close DB connection simply.
 *
 * @uses mysql_close() To close all DB connections.
 *
 * @since Clean WordPress 1.2.0
 */
add_action('shutdown', '_cw_close_db_link', 99);
function _cw_close_db_link()
{
    global $wpdb;
    unset($wpdb);
}
