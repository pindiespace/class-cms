<?php
class LS_View {

	// View methods go here

	function __construct () {

		echo 'I am in View ';

	}

	/** 
	 * Given a menu item, load the appropriate page.
	 */
	function load_page_by_name ( $ls_which_menu ) {

		echo 'IN MODEL, ls_which_menu is:' . $ls_which_menu . "<br>";

		switch( $ls_which_menu ) {

			case 'home':
				require( 'inc/home.php' );
				break;
			case 'about':
				require( 'inc/about.php' );
				break;
			case 'member':
				require( 'inc/member.php' );
				break;
			case 'posts':
				require( 'inc/posts.php' );
				break;
			case 'register':
				require( 'inc/register.php' );
				break;
			case 'login':
				require( 'inc/login.php' );
				break;
			case 'contact':
				require( 'inc/contact.php' );
				break;
			default:
				require( 'inc/notfound.php' ); // invalid menu selection
				break;

		} // end of switch

	} // end of load_page_by_menu

} // end of class
