<?php $name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$formcontent="Nombre del interesado: $name \nPhone: $phone";
$recipient = "matias.rodgian@gmail.com";
$subject = "Bolsa de trabajo de orionconsultores.com.mx";
$mailheader = "Enviado por: $email \r\n";
mail($recipient, $subject, $formcontent, $mailheader) or die("Error!");
echo "Tu mensaje se ha enviado, gracias.";
?>
