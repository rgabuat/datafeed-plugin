<?php
/**
 * @package datafeedrCustomPlugin
 */
/*
Plugin Name: Datafeedr Custom Code
Description: Custom code to use with the Datafeedr plugins. Don't delete me!
Version: 1.0
License: GPL v3

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

/** Add your custom code BELOW this line **/

// if(! defined('ABSPATH'))
// {
//     die;
// }

// Make sure we don't expose any info if called directly
if ( !function_exists( 'add_action' ) ) {
	echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
	exit;
}

define('DTFRC_PLUGIN_PATH',dirname(__FILE__));//get plugin filepath
define( 'DTFRC_PLUGIN_BASENAME', basename( dirname( __FILE__ ) ) . '/' . basename( __FILE__ ) ); //plugin base name
define( 'DTFRC_URL', plugins_url( '', DTFRC_PLUGIN_BASENAME ) ); //plugin url


require_once plugin_dir_path(__FILE__) . 'class.dtfc.php' ;
require_once plugin_dir_path(__FILE__) . 'functions.php' ;

//activation
register_activation_hook(__FILE__, array($dtfc_plugin,'activate'));

//deactivation
register_deactivation_hook(__FILE__,array($dtfc_plugin,'deactivate'));

//uninstall
register_uninstall_hook(__FILE__,array($dtfc_plugin,'uninstall'));








