<?php require '../config.php'; ?>

<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// // Load Composer's autoloader
require "../vendor/autoload.php";

// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    $rules = [
        "name" => "present|minlength:7|maxlength:64",
        "email" => "present|email|minlength:7|maxlength:64",
        "subject" => "present|minlength:9|maxlength:64",
        "message" => "present|minlength:6|maxlength:1030"
    ];
    $request->validate($rules);
    if(!$request->is_valid()) {
        throw new Exception("Please complete the form");
    }
    $name = $request->input("name");
    $email = $request->input("email");
    $subject = $request->input("subject");
    $message = $request->input("message");

    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
    $mail->isSMTP();                                            // Send using SMTP
    $mail->Host       = 'smtp.mailtrap.io';                     // Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = $_ENV["MAILTRAP_USERNAME"];               // SMTP username
    $mail->Password   = $_ENV["MAILTRAP_PASSWORD"];             // SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    $mail->Port       = 2525;                                   // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

    //Recipients
    $mail->setFrom($email, $name);
    $mail->addAddress('info@bookworms.com', 'Information');           // Add a recipient

    // Attachments
    // $mail->addAttachment('/var/tmp/file.tar.gz');            // Add attachments
    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');       // Optional name

    // Content
    $mail->isHTML(false);                                        // Set email format to HTML
    $mail->Subject = $subject;
    $mail->Body    = $message;
    $mail->AltBody = $message;

    $mail->send();

    $request->session()->set("flash_message","Message has been sent");
    $request->session()->set("flash_message_class", "alert-info");
    $request->session()->forget("flash_data");
    $request->session()->forget("flash_errors");
  
    $request->redirect("/views/contact.php");  
  
  }
  catch(Exception $ex) {
    $request->session()->set("flash_message", $ex->getMessage());
    $request->session()->set("flash_message_class", "alert-warning");
    $request->session()->set("flash_data", $request->all());
    $request->session()->set("flash_errors", $request->errors());
  
    $request->redirect("/views/contact.php");  
  }
  ?>