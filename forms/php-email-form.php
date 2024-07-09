<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  echo "Formulario recibido";
  
  // Recibe los datos del formulario
  $name = strip_tags(trim($_POST["name"]));
  $name = str_replace(array("\r","\n"),array(" "," "),$name);
  $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
  $subject = trim($_POST["subject"]); // Añadido para incluir el asunto
  $message = trim($_POST["message"]);

  // Verifica que todos los campos del formulario estén completos
  if (empty($name) OR empty($subject) OR empty($message) OR !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo "Por favor completa el formulario e inténtalo de nuevo.";
    exit;
  }

  // Configuración del correo electrónico
  $recipient = "jessicaesme21@gmail.com"; // Reemplazar con tu dirección de correo electrónico
  $email_subject = "Nuevo mensaje de contacto de $name: $subject"; // Añadido el asunto del correo
  $email_content = "Nombre: $name\n";
  $email_content .= "Email: $email\n\n";
  $email_content .= "Asunto: $subject\n\n"; // Añadido el asunto en el contenido del correo
  $email_content .= "Mensaje:\n$message\n";

  // Encabezados del correo
  $email_headers = "From: $name <$email>";

  // Envía el correo electrónico
  if (mail($recipient, $email_subject, $email_content, $email_headers)) {
    http_response_code(200);
    echo "¡Gracias! Tu mensaje ha sido enviado.";
  } else {
    http_response_code(500);
    echo "Oops! Hubo un problema al enviar tu mensaje. Por favor, inténtalo de nuevo.";
  }

} else {
  http_response_code(403);
  echo "Hubo un problema con tu envío, por favor inténtalo de nuevo.";
}
?>
