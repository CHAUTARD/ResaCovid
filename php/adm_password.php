<?php
/** adm_password.php
 * 
 *  Envoi d'un email avec le password
 *  
 *      @version : 1.0.2
 *      @date : 2020-10-19
 *
 */

// Recherche si le joueur existe
$database->query("SELECT Admin, Prenom FROM res_licenciers WHERE (Actif = 'Oui') AND Email=:Email");
$database->bind(':Email', $_GET['email']);
$result = $database->single();

// Le code ne correspond pas !
if( $result === false)
{
    die ('Pas de licencié avec cet email !');
}

require_once 'php/classes/CwsCaptcha.php';

require_once 'php/classes/PHPMailler/PHPMailer.php';

// Création du capcha
$cwsCaptcha = new CwsCaptcha();
$cwsCaptcha->setMessage($result['Admin']);
$cwsCaptcha->process();

// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(false);

// To load the French version
$mail->setLanguage('fr', 'php/classes/PHPMailler/language/');

try {
    //Server settings
    $mail->SMTPDebug = false;  //SMTP::DEBUG_SERVER;            // Enable verbose debug output
    $mail->CharSet = 'UTF-8';
    $mail->isSMTP();                                            // Send using SMTP
    $mail->Host       = SMTP_SERVEUR;                           // Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = SMTP_USERNAME;                          // SMTP username
    $mail->Password   = SMTP_PASSWORD;                          // SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    $mail->Port       = SMTP_PORT;                              // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
    
    //Recipients
    $mail->setFrom( EMAIL_FROM, EMAIL_ALIAS);
    $mail->addAddress($_GET['email']);     // Add a recipient
    
    // Attachments
    $mail->addAttachment(EMAIL_PNG);         // Add attachments
    
    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = EMAIL_SUBJECT;
    $mail->Body    = str_replace('{$Prenom}', $result['Prenom'], EMAIL_BODY);
    $mail->AltBody = str_replace('{$Prenom}', $result['Prenom'], EMAIL_ALTBODY);
    
    
    $mail->send();
    
    die ('Email envoyé !');
} catch (Exception $e) {
    die('Erreur à l\'envoi du mail, Erreur : ' . $mail->ErrorInfo);
}
?>