<?php 
	session_start();
	require_once( 'lib/model.php' );
	require_once( 'lib/view.php' );
	require_once( 'lib/lamespace.php' );

	$model = new LS_Model();
	$view = new LS_View();
	$lamespace = new LameSpace( $model, $view ); // create a PHP object

	$posts = $lamespace->get_posts();

	// Inject our $_POST values for use later 

	echo $lamespace->make_js_array( $posts, 'posts' );

?>

<?php require_once( 'header.php' ); ?>

		<main>

		<section id="content">
		<?php 

			$result = $lamespace->route_posts(); // if a form was clicked ($_POST), route it

			echo "RESULT FROM ROUTE_POSTS:" . $result . "<br>";

			$result = $lamespace->route_page( $result ); // otherwise, route $_GET

			echo "RESULT FROM ROUTE_PAGES:" . $result . "<br>";

			$errors = $lamespace->get_errors();

			echo $lamespace->make_js_array( $errors, 'errors' );

		?>
		</section>

		</main>

<?php require_once( 'footer.php' ); ?>







