<?php
/**
 * Plugin Name:     Special Offers
 * Plugin URI:      https://github.com/AlaskanHusky/special-offers
 * Description:     Plugin "Special Offers" helps to add blocks with messages about special offers. This can be done via shortcode.
 * Version:         0.8
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

require_once __DIR__ . '/includes/SpecialOffers.php';

register_activation_hook(__FILE__, ['SpecialOffers', 'pluginActivation']);
register_deactivation_hook(__FILE__, ['SpecialOffers', 'pluginDeactivation']);
add_action('init', ['SpecialOffers', 'init']);