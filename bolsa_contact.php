<?php
/**
 * EDIT THE VALUES BELOW THIS LINE TO ADJUST THE CONFIGURATION
 * EACH OPTION HAS A COMMENT ABOVE IT WITH A DESCRIPTION
 */
/**
 * Specify the email address to which all mail messages are sent.
 * The script will try to use PHP's mail() function,
 * so if it is not properly configured it will fail silently (no error).
 */
$mailTo     = 'matias.rodgian@gmail.com';

/**
 * Set the message that will be shown on success
 */
$successMsg = 'Gracias por su mensaje. En breve nos pondremos en contacto con usted.';

/**
 * Set the message that will be shown if not all fields are filled
 */
$fillMsg    = 'Por favor llene todos los campos.';

/**
 * Set the message that will be shown on error
 */
$errorMsg   = 'Ocurrió un error al enviar su mensaje. Por favor, intente más tarde.';

/**
 * DO NOT EDIT ANYTHING BELOW THIS LINE, UNLESS YOU'RE SURE WHAT YOU'RE DOING
 */

?>
<?php
if(
    !isset($_POST['contact-name']) ||	
	!isset($_POST['contact-email']) ||
	!isset($_POST['contact-message']) ||
    empty($_POST['contact-name']) ||
    empty($_POST['contact-email']) ||	
	empty($_POST['contact-message'])
	
) {
	
	if( empty($_POST['contact-name']) && empty($_POST['contact-email']) && empty($_POST['contact-message']) ) {
		$json_arr = array( "type" => "error", "msg" => $fillMsg );
		echo json_encode( $json_arr );		
	} else {

		$fields = "";
		if( !isset( $_POST['contact-name'] ) || empty( $_POST['contact-name'] ) ) {
			$fields .= "Name";
		}
		
		if( !isset( $_POST['contact-email'] ) || empty( $_POST['contact-email'] ) ) {
			if( $fields == "" ) {
				$fields .= "Phone";
			} else {
				$fields .= ", Phone";
			}
		}		
		if( !isset( $_POST['contact-message'] ) || empty( $_POST['contact-message'] ) ) {
			if( $fields == "" ) {
				$fields .= "Message";
			} else {
				$fields .= ", Message";
			}		
		}	
		$json_arr = array( "type" => "error", "msg" => "Por favor complete los siguientes campos:".$fields."");
		echo json_encode( $json_arr );
		}
	

} else {

	// Validate e-mail
	if (!filter_var($_POST['contact-email'], FILTER_VALIDATE_EMAIL) === false) {
		
		$msg = "Name: ".strtoupper($_POST['contact-name'])."\r\n";		
		$msg .= "Email: ".$_POST['contact-email']."\r\n";		
		$msg .= "Message: ".$_POST['contact-message']."\r\n";
		
		$success = @mail($mailTo, $_POST['contact-email'], $msg, 'From: ' . $_POST['contact-name'] . '<' . $_POST['contact-email'] . '>');
		
		if ($success) {

      echo "<style>";
      include 'success_message.css';
      echo "</style>";
      echo "<img src=\"images/custom/5f87ca_21c878b2ee434039926b293ef1bca0e5.png\" alt=\"logo\" width=\"360\" height=\"auto\">";
      echo "<div class=\"success__message\"><h1>$successMsg</h1></div>";
      echo "<a href=\"index.html\">Inicio</a>";

			//$json_arr = array( "type" => "success", "msg" => $successMsg );
			//echo json_encode( $json_arr );

		} else {
			$json_arr = array( "type" => "error", "msg" => $errorMsg );
			echo json_encode( $json_arr );
		}
		
	} else {
 		$json_arr = array( "type" => "error", "msg" => "Please enter valid email address!" );
		echo json_encode( $json_arr );	
	}

}
