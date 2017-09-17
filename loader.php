<?php

/**
 * Plugin Name: BuddyForms Private Frontend
 * Plugin URI: http://buddyforms.com/downloads/buddyforms-private-frontend/
 * Description: BuddyForms Private Frontend
 * Version: 0.1
 * Author: ThemeKraft
 * Author URI: https://themekraft.com/
 * License: GPLv2 or later
 * Network: false
 *
 *****************************************************************************
 *
 * This script is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 ****************************************************************************
 */


define( 'BUDDYFORMS_PRIVATE_FRONTEND_DIR', rtrim(plugin_dir_path(__FILE__), '/') );
define( 'BUDDYFORMS_PRIVATE_FRONTEND_INC_DIR', BUDDYFORMS_PRIVATE_FRONTEND_DIR . '/includes' );

add_action( 'init', 'buddyforms_private_frontend_init');
function buddyforms_private_frontend_init(){
	include_once( BUDDYFORMS_PRIVATE_FRONTEND_INC_DIR . '/admin.php');
	include_once( BUDDYFORMS_PRIVATE_FRONTEND_INC_DIR . '/functions.php');
}