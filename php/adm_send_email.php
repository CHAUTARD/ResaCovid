<?php
/** adm_send_email.php
 *      @version : 1.0.0
 *      @date : 2020-10-18
 */

require_once 'php/classes/PHPMailler/PHPMailer.php';

// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(false);

// To load the French version
$mail->setLanguage('fr', 'php/classes/PHPMailler/language/');

try {
    //Server settings
    $mail->SMTPDebug = false; // SMTP::DEBUG_SERVER;                      // Enable verbose debug output
    $mail->CharSet = 'UTF-8';
    $mail->isSMTP();                                            // Send using SMTP
    $mail->Host       = SMTP_SERVEUR;                           // Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = SMTP_USERNAME;                          // SMTP username
    $mail->Password   = SMTP_PASSWORD;                          // SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    $mail->Port       = SMTP_PORT;                              // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
    
    //Recipients
    $mail->setFrom( $_GET['email'], $_GET['nom']);
    $mail->addAddress(SMTP_USERNAME);     // Add a recipient
       
    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Contact pour le site Résservation table';
    $mail->Body    = $_GET['message'];
    $mail->AltBody = $_GET['message'];
    
    
    $mail->send();
    
    die ("Le message vient d'être envoyé.<br />Une réponse vous parviendra dans les meilleurs delais.");
} catch (Exception $e) {
    die("Erreur à l'envoi du mail, Erreur : " . $mail->ErrorInfo);
}
?>