<!doctype html>

<html lang="en">

	<head>

		<meta charset="UTF-8">

		<!--Search Engine Optimization (SEO) -->
  		<meta name="description" content="Lamespace is a social network for really lame people only.">

  		<meta name="author" content="Slam Thunderhide">

  		<!--shim old Internet Explorer-->
  		<!--[if lt IE 9]>
    	<script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script>
  		<![endif]-->

  		<!--touch icons for mobile devices-->
		<link rel="apple-touch-icon" sizes="180x180" href="img/icons/apple-touch-icon.png">
		<link rel="icon" type="image/png" href="img/icons/favicon-32x32.png" sizes="32x32">
		<link rel="icon" type="image/png" href="/favicon-16x16.png" sizes="16x16">
		<link rel="manifest" href="/manifest.json">
		<link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
		<meta name="theme-color" content="#ffffff">

		<!--load CSS files-->
		<link rel="stylesheet" href="css/bootstrap.css">

		<link rel="stylesheet" href="css/lamespace.css">

		<!--load Modernizr for feature detection-->
		<script src="js/modernizr-custom.js"></script>

		<title>Lamespace - A Place for Lamers</title>

	</head>

	<body>

		<header>

			<div id="identity-row">

			<div id="identity" class="top-row">

				<h1>Lamespace - A Place for Lamers</h1>

			</div>

			<nav id="top-menu" class="top-row">

				<h3 class="hide-ui">Status and Search</h3>

				<ul>

					<li>

						<?php require( 'widgets/search-form.php' ); ?>

					</li>

					<li>

						<?php require( 'widgets/status.php' ); ?>

					</li>

				</ul>

			</nav>

			</div><!--end of identity row-->

			<nav id="main-menu" class="second-row horiz-menu">
				<h3 class="hide-ui">Site Pages</h3>
				<?php require( 'widgets/site-menu.php' ); ?>

			</nav>

		</header>