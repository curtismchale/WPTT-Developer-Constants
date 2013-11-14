<?php
/*
Plugin Name: Developers Constants Plugin
Plugin URI: http://wpthemetutorial.com
Description: Defines local, live, staging constants
Version: 1.0
Author: WP Theme Tutorial, Curtis McHale
Author URI: http://sfndesign.ca
License: GPLv2 or later
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

class WPTT_Dev_Constants{

	protected $live = array(
		'http://your-live-site.com',
	);

	protected $staging = array(
		'http://your-live-site.staging',
	);

	protected $local = array(
		'http://your-live-site.local',
	);

	function __construct(){

		add_action( 'muplugins_loaded', array( $this, 'define_environment_constants' ) );

		// uncomment the line below to check for any plugins you may want on the site
		//add_action( 'admin_notices', array( $this, 'check_required_plugins' ) );

		// Register hooks that are fired when the plugin is activated, deactivated, and uninstalled, respectively.
		register_activation_hook( __FILE__, array( $this, 'activate' ) );
		register_deactivation_hook( __FILE__, array( $this, 'deactivate' ) );
		register_uninstall_hook( __FILE__, array( __CLASS__, 'uninstall' ) );

	} // construct

	/**
	 * This defines our environment constants so we can easily change configuration based
	 * on where you are running the site currently.
	 *
	 * @since 1.0
	 * @author WP Theme Tutorial, Curtis McHale
	 * @access public
	 *
	 * @uses home_url()      Returns the path to the site root (not WP root files)
	 */
	public function define_environment_constants(){

		$site = home_url();

		if ( in_array( $site, $this->live ) ){

			define( 'LIVE_ENV', true );

		} elseif ( in_array( $site, $this->staging ) ){

			// catching other users who may have the dev contstant in their wp-config file
			if( ! defined( 'DEVELOPMENT' ) ) define( 'DEVELOPMENT', true );
			define( 'STAGING_ENV', true );

		} elseif ( in_array( $site, $this->local ) ){

			// catching other users who may have the dev contstant in their wp-config file
			if( ! defined( 'DEVELOPMENT' ) ) define( 'DEVELOPMENT', true );
			define( 'LOCAL_ENV', true );

		} else {
			// nothing really
		}

	}

	/**
	 * Use the function below to check for any plugins you need on the site.
	 *
	 * @uses    function_exists     Checks for the function given string
	 * @uses    deactivate_plugins  Deactivates plugins given string or array of plugins
	 *
	 * @action  admin_notices       Provides WordPress admin notices
	 *
	 * @since   1.0
	 * @author  WP Theme Tutorial, Curtis McHale
	 */
	public function check_required_plugins(){

		// just left to show you how to do it
		if( ! is_plugin_active( 'woocommerce/woocommerce.php' ) ){ ?>

			<div id="message" class="error">
				<p>Automatic Product Purchase expects WooCommerce to be active. This plugin has been deactivated.</p>
			</div>

			<?php
			deactivate_plugins( '/auto-product-purchase/auto-product-purchase.php' );
		} // compmany team if

	} // check_required_plugins

	/**
	 * Fired when plugin is activated
	 *
	 * @param   bool    $network_wide   TRUE if WPMU 'super admin' uses Network Activate option
	 */
	public function activate( $network_wide ){

	} // activate

	/**
	 * Fired when plugin is deactivated
	 *
	 * @param   bool    $network_wide   TRUE if WPMU 'super admin' uses Network Activate option
	 */
	public function deactivate( $network_wide ){

	} // deactivate

	/**
	 * Fired when plugin is uninstalled
	 *
	 * @param   bool    $network_wide   TRUE if WPMU 'super admin' uses Network Activate option
	 */
	public function uninstall( $network_wide ){

	} // uninstall

} // WPTT_Dev_Constants

new WPTT_Dev_Constants();
