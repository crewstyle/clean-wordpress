<?php
/**
 * Plugin Name: Clean WordPress
 *
 * Description: Remove unnecessary metatags informations from head tag, close DB connections, and more.
 * Author: Achraf Chouk <achrafchouk@gmail.com>
 * Version: 1.3.1 ~ "Sogeking no shima deeeeeee - One Piece"
 *
 * Author URI: https://github.com/crewstyle
 * Plugin URI: https://github.com/crewstyle/clean-wordpress
 * License: The MIT License (MIT)
 * License URI: http://opensource.org/licenses/MIT
 *
 * @author Achraf Chouk <achrafchouk@gmail.com>
 * @copyright Copyright (c) 20xx, Achraf Chouk.
 * @license MIT
 * @package CleanWordPress
 * @since Clean WordPress 1.3.1
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
