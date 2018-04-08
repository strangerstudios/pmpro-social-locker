<?php
/*
Plugin Name: Paid Memberships Pro - Social Locker Add On
Plugins URI: https://www.paidmembershipspro.com/add-ons/pmpro-social-locker/
Description: Integrate PMPro with the Social Locker plugin from OnePress.
Version: .1.1
Author: Scott Sousa, Paid Memberships Pro
Author URI: https://www.paidmembershipspro.com
*/

// Constants
//define( 'PMPROSL_FREE_LEVEL_ID', 5 );             //membership level to give access to
//define( 'PMPROSL_MEMBERSHIP_PERIOD_DAYS', 7 );    //number of days to give visitor access

/**
 * This function hooks into the AJAX action of Social Locker when a click is tracked. We're using it to set a cookie 
 * so that we can verify if a user has access to the site.
 *
 * Note: They are not using check_ajax_referer(), and there is no nonce set, therefore we cannot check here either.
 */
add_action( 'wp_ajax_sociallocker_tracking', 'pmprosl_sociallocker_tracking', 1 );
add_action( 'wp_ajax_nopriv_sociallocker_tracking', 'pmprosl_sociallocker_tracking', 1 );
function pmprosl_sociallocker_tracking() {
	// First make sure we have a valid post ID
	if ( ! ( int ) $_POST['targetId'] )
		exit;

	// Next make sure the "sender" is valid
	if ( empty( $_POST['sender'] ) || ! in_array( $_POST['sender'], array( 'button', 'timer', 'cross' ) ) )
		exit;

	// Next make sure the "senderName" is valid
	if ( empty( $_POST['senderName'] ) )
		exit;

	// Finally, make sure we haven't already set the cookie
	if( isset( $_COOKIE['pmprosl_has_access_flag'] ) && ! $_COOKIE['pmprosl_has_access_flag'] )
		exit;

	// Passed all validation checks, lets set the cookies
	setcookie( 'pmprosl_has_access', PMPROSL_FREE_LEVEL_ID, ( time() + ( 60 * 60 * 24 * PMPROSL_MEMBERSHIP_PERIOD_DAYS ) ), COOKIEPATH, COOKIE_DOMAIN, false ); // has_access cookie (expires in PMPROSL_MEMBERSHIP_PERIOD_DAYS days)
	setcookie( 'pmprosl_has_access_flag', true, ( time() + ( 60 * 60 * 24 * 10 * 365 ) ), COOKIEPATH, COOKIE_DOMAIN, false ); // has_access flag cookie used to verify if a user already had access once (expires in 10 years; i.e. never)

	return; // We're returning here because we know Social Locker's hook is coming up next
}

/**
 * This function determines if the pmprosl_has_access cookie is set and verifies if the user should have access.
 */
add_filter( 'pmpro_has_membership_access_filter', 'pmprosl_pmpro_has_membership_access_filter', 10, 4 );
function pmprosl_pmpro_has_membership_access_filter( $hasaccess, $post, $user, $post_membership_levels ) {

	// If the flag is set
	if ( isset( $_COOKIE['pmprosl_has_access'] ) && $_COOKIE['pmprosl_has_access'] )
		// Loop through post levels
		foreach ( $post_membership_levels as $level )
			// If the cookie matches one of the post levels, give them access
			if ( ( int ) $_COOKIE['pmprosl_has_access'] == $level->id ) {
				$hasaccess = true;

				break;
			}

	return $hasaccess;
}

/**
 * Function to add links to the plugin row meta
 *
 * @param array  $links Array of links to be shown in plugin meta.
 * @param string $file Filename of the plugin meta is being shown for.
 */
function pmprosl_plugin_row_meta( $links, $file ) {
	if ( strpos( $file, 'pmpro-social-locker.php' ) !== false ) {
		$new_links = array(
			'<a href="' . esc_url( 'https://www.paidmembershipspro.com/add-ons/pmpro-social-locker/' ) . '" title="' . esc_attr( __( 'View Documentation', 'pmpro-social-locker' ) ) . '">' . __( 'Docs', 'pmpro-social-locker' ) . '</a>',
			'<a href="' . esc_url( 'http://paidmembershipspro.com/support/' ) . '" title="' . esc_attr( __( 'Visit Customer Support Forum', 'pmpro-social-locker' ) ) . '">' . __( 'Support', 'pmpro-social-locker' ) . '</a>',
		);
		$links = array_merge( $links, $new_links );
	}
	return $links;
}
add_filter( 'plugin_row_meta', 'pmprosl_plugin_row_meta', 10, 2 );
