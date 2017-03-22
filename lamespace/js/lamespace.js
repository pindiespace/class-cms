// Lamespace.js

var lamespace = ( function ( document ) {
	
	function set_reg_form_errors ( errors, posts ) {

		// if the PHP side of our program wrote an errors array 

		if ( errors ) { // PHP injected an errors array into our page

			var form = document.getElementById( 'ls_reg_form' );

			if ( form ) {

				for ( var i in errors ) {

					console.log("looking for " + i  )

					var elem = form.elements[ i ];

					console.log( "ELEM:" + elem );

					var parent = elem.parentNode;

					var spans = parent.getElementsByTagName( 'span' );

					spans[ 0 ].innerHTML = errors[ i ];

				}
			}

		}

		if ( posts ) {

			console.log("writing posts")

			for ( var i in posts ) {

				var elem = form.elements[ i ];

				elem.value = posts[ i ];

			}

		}


	}

	return {

		set_reg_form_errors: set_reg_form_errors

	};

} )( document );

// Check for error array (embedded by PHP into our HTML )

lamespace.set_reg_form_errors( errors, posts );






