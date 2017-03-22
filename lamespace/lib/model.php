<?php 
class LS_Model {

	// Database methods go here.

	function __construct () {

		echo 'I am in Model';

	}

	function connect_db () {

		$this->link = mysqli_connect( 'localhost', 'root', '', 'lamespace' );

		if ( $this->link === false ) {

    		die("ERROR: Could not connect. " . mysqli_connect_error());

		} else {

			echo '<br><b>CONNECTED TO MYSQL.......</b><br>';

		}

		return $this->link;

	}

	/** 
	 * Check if username and password are both correct.
	 */
	function password_matches_username( $ls_username, $ls_password, $link ) {

		$sql = "SELECT * from `users` WHERE `username` LIKE '$ls_username' AND `password` LIKE '$ls_password'";

		echo 'sql='.$sql;

		$result = mysqli_query( $link, $sql );

		if ( $result ) {

			echo 'password_matches_username returned a result';

			if ( mysqli_num_rows( $result ) > 0 ) {

				echo 'username '.$ls_username . ' and password ' . $ls_password . ' are correct!';

				return true; //user should be allowed to log in.

			}


		}

		return false;

	}

	/** 
	 * check if the username is in our database.
	 */
	function username_in_db ( $ls_username, $link ) {

		echo 'in username_in_db:: username:'. $ls_username . '<br>';

		$sql = "SELECT * FROM `users` WHERE `username` LIKE '$ls_username'";

		echo 'sql='.$sql."<br>";

		$result = mysqli_query( $link, $sql );

		if ( $result ) {

			echo 'username_in_db:: query returned result<br>';

    		if ( mysqli_num_rows( $result ) > 0) {

    			echo 'username_in_db: username '.$ls_username.' found in database<br>';

    			return true;

    		}
    	}

    	echo 'username_in_db: username '.$ls_username.' NOT found in database<br>';

		return false;

	}

	/** 
	 * Process registration, making sure people can't register twice.
	 * @link http://www.tutorialrepublic.com/php-tutorial/php-mysql-insert-query.php
	 */
	function process_registration ( 
		$ls_user_first_name, $ls_user_last_name, 
		$ls_user_email, $ls_username, $ls_password,
		$errors ) {

		// Connect to MySQL database.

		$link = $this->connect_db();

		// Username must be unique, don't register the same person twice.

		if ( $this->username_in_db( $ls_username, $link ) ) {

			$errors['process_registration'] = 'error: user already in database';

			return false;

		}

		//echo '<span style="color:green">I am in the Model->process_registration() method</span><br>';

		$sql = "INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `username`, `password`, `profile_picture`) VALUES (NULL, '$ls_user_first_name', '$ls_user_last_name', '$ls_user_email', '$ls_username', '$ls_password', '' )";

		//echo 'SQL STRING:'.$sql."<br>";

		// Try to insert the data via MySQL

		if( mysqli_query( $link, $sql ) ) {

    		//echo "Records inserted successfully.";

		} else {

    		$errors['process_registration'] = "ERROR: Could not able to execute $sql. " . mysqli_error( $link );

			// Close connection

			mysqli_close( $this->link );

    		return false;

		}

		// Close connection

		mysqli_close( $this->link );

		return true;

	}

	/**
	 * Process logins, with error messages for login fail.
	 */
	function process_login ( $ls_user_name, $ls_user_password ) {

		// Connect to MySQL database.

		echo "I'm in model::process_login()";

		$link = $this->connect_db();

		if ( $this->username_in_db( $ls_user_name, $link ) ) {

			echo "username $ls_user_name was in database, try checking password<br>";

			if ( $this->password_matches_username( $ls_user_name, $ls_user_password, $link ) ) {

				mysqli_close( $link );

				return true; // LOG USER IN!!!

			} else {

				$errors[ 'process_login' ] = 'error: invalid password';

			}

		} else {

			$errors[ 'process_login' ] = 'error: invalid username';

		}

		mysqli_close( $link );

		return false;

	}

	/** 
	 * Process the user trying to upload an Avatar picture.
	 */
	function process_picture_upload () {

		echo '<span style="color:green">I am in Model->process_picture_upload() method</span><br>';

	}


} // end of class




