<?php 

class LameSpace {

	// Our Controller class, imports Model and View

	// Constructor function
	function __construct ( $model=null, $view=null ) {

		// Save local reference to Model and View

		$this->model = $model;

		$this->view = $view;

		// Load errors into here, process after each routing.

		$this->errors = array();

		echo 'I\'m in LameSpace construct function<br>';

	}

	/** 
	 * get any errors
	 */
	function get_errors () {

		return $this->errors;

	}

	/** 
	 * get the (sanitized) $_POST array
	 */
	function get_posts () {

		$posts = array();

		if ( isset( $_POST ) ) {

			foreach ( $_POST as $key => $value ) {

				$posts[ $key ] = filter_var( $_POST[ $key ], FILTER_SANITIZE_STRING );

			}

			return $posts;

		}

		return false;

	}

	/** 
	 * make a PHP array into a string which can be echoed as a JavaScript array.
	 * @param {Array} arr the PHP array.
	 * @param {String} arrName the name of the resulting JavaScript array.
	 */
	function make_js_array ( $arr, $arrName ) {

		$js = '<script> var ' . $arrName . ' = [];' . "\n";

		foreach ( $arr as $key => $value ) {

			$js .= $arrName . '["' . $key . '"] =' . '"' . $value . '"' . "\n";

		}

		$js .= '</script>';

		return $js;

	}

	/** 
	 * route form data sent with $_POST
	 */
	function route_posts () {

		if ( isset( $_POST ) ) { // only process if $_POST exists

			if ( count( $_POST ) < 1 ) { // only process if $_POST has > 0 values

				echo 'NO $_POST VALUES<br>';

			} else {

				echo 'HAVE $_POST VALUES<br>';

				/////////////////
				if ( isset( $_POST[ 'ls_registration_form'] ) ) {

					// Sanitize input.

					$ls_user_first_name = filter_var( $_POST[ 'ls_user_first_name' ], FILTER_SANITIZE_STRING );

					$ls_user_last_name = filter_var( $_POST[ 'ls_user_last_name' ], FILTER_SANITIZE_STRING );

					$ls_user_email = filter_var( $_POST[ 'ls_user_email' ], FILTER_SANITIZE_STRING );
					
					$ls_username = filter_var( $_POST[ 'ls_username' ], FILTER_SANITIZE_STRING );

					$ls_password = filter_var( $_POST[ 'ls_password' ], FILTER_SANITIZE_STRING );


					// Validate input, return if data is invalid.

					if ( empty( $ls_user_first_name ) || empty( $ls_user_last_name ) ) {

						$this->errors[ 'ls_user_first_name' ] = 'ERROR, INVALID FIRST OR LAST NAME:' . $ls_user_first_name . ',' . $ls_user_last_name;

						return 'register'; // invalid registration, return to registration form

					}

					// Validate email 

					if ( ! filter_var( $ls_user_email, FILTER_VALIDATE_EMAIL ) ) {

  						$this->errors[ 'ls_user_email'] = 'ERROR, INVALID EMAIL: ' . $ls_user_email;

  						return 'register'; // invalid registration, return to registration form

					}

					// Validate username must be > 5 characters

					if ( strlen( $ls_username ) < 5 ) {

						$this->errors[ 'ls_username' ] = 'ERROR, INVALID USERNAME: ' . $ls_username . ' (too short)';

						return 'register'; // invalid registration

					}

					// Validate password

					// Validate password must be > 5 characters

					if ( strlen( $ls_password ) < 5 ) {

						$this->errors[ 'ls_password'] = 'ERROR, INVALID PASSWORD: ' . $ls_password . ' (too short)';

						return 'register'; // invalid registration

					}

					// Try to register the user, return to registration form if fail.

					if( $this->model->process_registration( 
						$ls_user_first_name, 
						$ls_user_last_name,
						$ls_user_email,
						$ls_username,
						$ls_password,
						$this->errors
					) ) {

						return 'home'; // Registration OK, View should load home page

					} else {

						return 'register'; // Registration failed, View should load Registration form.

					}

					// ask the Model to process the registration form data

				} else if ( isset( $_POST[ 'ls_login_form' ] ) ) {

					echo 'LOGIN FORM WAS SUBMITTED!!!!!<br>';

					$ls_username = filter_var( $_POST[ 'ls_username' ], FILTER_SANITIZE_STRING );

					$ls_password = filter_var( $_POST[ 'ls_password' ], FILTER_SANITIZE_STRING );

					// Validate username must be > 5 characters

					if ( strlen( $ls_username ) < 5 ) {

						$this->errors[ 'ls_username' ] = 'ERROR, INVALID USERNAME: ' . $ls_username . ' (too short)';

						return 'login'; // bad login data, return to login form

					}

					// Validate password

					// Validate password must be > 5 characters

					if ( strlen( $ls_password ) < 5 ) {

						$this->errors[ 'ls_password'] = 'ERROR, INVALID PASSWORD: ' . $ls_password . ' (too short)';

						return 'login'; // bad login data, return to login form

					}

					// username and password provided, try to log the user in.

					echo "ABOUT TO TRY model->process_login with $ls_username and $ls_password<br>";

					if ( $this->model->process_login( 
						$ls_username,
						$ls_password,
						$this->errors
					) ) {

						$_SESSION[ 'logged_in' ] = 'ok';

						return 'member'; // login OK, return to member's page.

					} else {

						$_SESSION[ 'logged_in' ] = false;

						return 'login'; // login failed, return to login form page.

					}

				} else if ( isset( $_POST[ 'ls_picture_upload_form' ] ) ) {

					// ask the Model to process the picture upload form

				} else {

					// Error, we should NEVER go here.

					echo 'ERROR: INVALID FORM SUBMIT!!!!';

				}

				////////////////

				foreach ( $_POST as $key => $val ) { // loop through all $_POST variables

					echo "post key:".$key." value:".$val."<br>"; 

				} // end of foreach() loop

			} // end of else (have $_POST values)

		} // end of isset( $_POST )

		return false; // Return NOTHING, let use the $_GET value since there is no $_POST

	} // end of route_posts()

	/** 
	 * route to different pages, based on value of $_GET
	 * @param {String} $post_result the page to load, as specified by $this->route_posts();
	 */
	function route_page ( $post_result ) {

		// Check to see if the user selected a menu item.

		if ( $post_result ) {

			$ls_which_menu = $post_result; // value returned is which page to go to.

			$this->view->load_page_by_name( $ls_which_menu ); // load based on $_POST result

			echo "lamespace::route_page(), JUST CALLED VIEW BASED ON _POST RESULT";

		} else {

			if ( isset( $_GET[ 'pg' ] ) ) {

				$ls_which_menu = htmlspecialchars( $_GET[ 'pg' ] );

				if ( $ls_which_menu == 'logout' ) {

					$_SESSION[ 'logged_in' ] = false;

					session_destroy();

					$ls_which_menu = 'home'; // change from logout to 'home' (we don't define a 'logout' page)

				}

			} else {

				$ls_which_menu = 'home';

			}

			// Have the View draw the correct page for this menu

			$this->view->load_page_by_name( $ls_which_menu ); // load based on $_GET result

			echo "lamespace::route_page(), JUST CALLED VIEW BASED ON _GET RESULT";

		}


	} // end of route_page

} // end of class LameSpace