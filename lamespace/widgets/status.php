						<div class="status">

							<!-- conditionally show a tiny login icon, or 
							a link that lets users log in. -->

							<!--link to log in-->

							<?php
								if ( isset( $_SESSION ) && isset( $_SESSION[ 'logged_in' ] ) && $_SESSION[ 'logged_in' ] == 'ok') {

									echo '<p class="status-msg">Logged In<a href="index.php?pg=logout">Log Out</a></p>';

									echo '<p class="status-img"><img width="20" height="20">';

								} else {

									echo '<p class="status-msg">Not Logged In.<a href="index.php?pg=login">Log In</a></p>';

								}
							?>

						</div>