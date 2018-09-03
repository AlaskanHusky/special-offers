<?php
/**
 * Plugin Name:     Special Offers
 * Plugin URI:      https://github.com/AlaskanHusky/special-offers
 * Description:     Plugin "Special Offers" helps to add blocks with messages about special offers.
 *                  This can be done via shortcode.
 * Version:         1.0
 * Author:          Pavel Yanushevsky
 * Author URI:      https://github.com/AlaskanHusky
 * License:         GPLv3
 */

/*  Copyright 2018  Pavel Yanushevsky  (email: pavelyanushevsky@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

register_activation_hook(__FILE__, 'specoff_plugin_activation');
register_deactivation_hook(__FILE__, 'specoff_plugin_deactivation');
// Adding plugin menu item
add_action('admin_menu', 'specoff_admin_menu');

function specoff_plugin_activation()
{
    // Check Wordpress version
    if (version_compare($GLOBALS['wp_version'], '3.1', '<')) {
        wp_die('This plugin requires WordPress version 3.1 or higher.');
    }

    specoff_create_table();
}

function specoff_plugin_deactivation()
{
    remove_menu_page('specoff');
}

function specoff_create_table()
{
    global $wpdb;
    $table_name = $wpdb->prefix . "so_offers";

    //Failed to the database connection
    if (!empty($wpdb->error)) {
        wp_die($wpdb->error);
    }

    // Create plugin table
    if ($wpdb->get_var("SHOW TABLES LIKE $table_name") != $table_name) {
        $sql = "CREATE TABLE IF NOT EXISTS `$table_name` (
	            `offer_id` INT(4) NOT NULL AUTO_INCREMENT,
	            `offer_name` VARCHAR(100) NOT NULL,
	            `offer_description` VARCHAR(500) NULL DEFAULT NULL,
	            `offer_category` VARCHAR(100) NOT NULL,
	            `offer_picture` VARCHAR(20) NOT NULL,
	            `regular_price` FLOAT UNSIGNED NOT NULL,
	            `offer_date` VARCHAR(16) NOT NULL,
	            `special_price` FLOAT UNSIGNED NOT NULL,
	            PRIMARY KEY (`offer_id`))
                COLLATE='utf8_general_ci'
                ENGINE=MyISAM;";
        $wpdb->query($sql);
    }
}

function specoff_admin_menu()
{
    add_menu_page('Special Offers', 'Special Offers', 8, 'specoff', 'specoff_plugin_page', 'dashicons-cart', "81.9");
}

function specoff_plugin_page()
{

}