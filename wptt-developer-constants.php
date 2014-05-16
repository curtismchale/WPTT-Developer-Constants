<?php
/*
Plugin Name: Developers Plugin
Plugin URI: http://rapidminer.com
Description: Defines our local, live, staging url's and sets some constants that deal with configuration.
Version: 1.1
Author: SFNdesign, Curtis McHale
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
		'http://yourlivesite.com'
	);

	protected $staging = array(
		'http://yourstagingsite.com',
	);

	protected $local = array(
		'http://yourlocalsite.com',
	);

	function __construct(){

		// Register hooks that are fired when the plugin is activated, deactivated, and uninstalled, respectively.
		register_activation_hook( __FILE__, array( $this, 'activate' ) );
		register_deactivation_hook( __FILE__, array( $this, 'deactivate' ) );
		register_uninstall_hook( __FILE__, array( __CLASS__, 'uninstall' ) );

		// these make WPTT Email Logging use the conditionals defined here
		add_filter( 'wptt_email_logging_is_local', array( $this, 'is_local' ) );
		add_filter( 'wptt_email_logging_is_staging', array( $this, 'is_staging' ) );
		add_filter( 'wptt_email_logging_is_live', array( $this, 'is_live' ) );

	} // construct

	/**
	 * Returns true if the current home_url matches with our local var urls
	 *
	 * @since 1.1
	 * @author SFNdesign, Curtis McHale
	 * @access public
	 *
	 * @uses home_url()       Returns the home_url of the WordPress site
	 */
	public function is_local(){

		$site = home_url();

		$local = unserialize( LOCAL_ENV );

		if ( empty( $local ) ){
			$local = $this->local;
		}

		if ( in_array( $site, $local ) ){
			return true;
		}

		return false;

	} // is_local

	/**
	 * Returns true if the current home_url matches with our staging var urls
	 *
	 * @since 1.1
	 * @author SFNdesign, Curtis McHale
	 * @access public
	 *
	 * @uses home_url()       Returns the home_url of the WordPress site
	 */
	public function is_staging(){

		$site = home_url();

		$staging = unserialize( STAGING_ENV );

		if ( empty( $staging ) ){
			$staging = $this->staging;
		}

		if ( in_array( $site, $staging ) ){
			return true;
		}

		return false;

	} // is_staging

	/**
	 * Returns true if the current home_url matches with our live var urls
	 *
	 * @since 1.1
	 * @author SFNdesign, Curtis McHale
	 * @access public
	 *
	 * @uses home_url()       Returns the home_url of the WordPress site
	 */
	public function is_live(){

		$site = home_url();

		if ( in_array( $site, $this->live ) ) return true;

		return false;

	} // is_live

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

/**
 * Wraps the is_local function. Returns true if site matches local defined sites
 *
 * @since 1.1
 * @author SFNdesign, Curtis McHale
 *
 * @uses WPTT_Dev_Constants->is_local()      Returns true if home_url matches defined local sites
 */
function wptt_is_local(){
	$var = new WPTT_Dev_Constants();
	return $var->is_local();
} // wptt_is_local

/**
 * Wraps the is_staging function. Returns true if site matches staging defined sites
 *
 * @since 1.1
 * @author SFNdesign, Curtis McHale
 *
 * @uses WPTT_Dev_Constants->is_staging()      Returns true if home_url matches defined staging sites
 */
function wptt_is_staging(){
	$var = new WPTT_Dev_Constants();
	return $var->is_staging();
} // wptt_is_staging

/**
 * Wraps the is_live function. Returns true if site matches live defined sites
 *
 * @since 1.1
 * @author SFNdesign, Curtis McHale
 *
 * @uses WPTT_Dev_Constants->is_live()      Returns true if home_url matches defined live sites
 */
function wptt_is_live(){
	$var = new WPTT_Dev_Constants();
	return $var->is_live();
} // wptt_is_live
