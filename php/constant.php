<?php
/** constant.php
  @version : 1.0.3
  @date : 2020-10-14
*/

// Acces à la base de données
define('DB_HOST', 'vsttreservation.mysql.db');
define('DB_DBNAME', 'vsttreservation'); // the database name to be used
define('DB_USERNAME', 'vsttreservation'); // the username to be used with the database
define('DB_PASSWORD', 'resVSTT01'); // the password to be used with the username

// Paramètre du site
define('LOGO_TITLE', 'Le logo de VSTT');
define('NOMBRE_EQUIPE', 9);
define('NUMERO_CLUB', '08930113'); // FFTT

// Nombre et nom des salles
define('NBR_SALLE', 2);
define('SALLE1', 'Copée');
define('SALLE2', 'Tcheuméo');

// Date de début de saison et de fin de saison
define('ANNEE_SAISON', 2020);
define('DATE_DEBUT_SAISON', '09-01');
define('DATE_FIN_SAISON', '09-30');

// Utilisateur par défault
define('USER_NAME', 'ADMIN'); // En majuscule obligatoirement
define('USER_PWD', '#Admin<..>');

// Pour l'envoi des emails
define('SMTP_SERVEUR', 'smtp.free.fr');
define('SMTP_USERNAME', 'patrick.chautard@free.fr');
define('SMTP_PASSWORD', '#Henri.1957');
define('SMTP_PORT', 587);
define('EMAIL_FROM', 'patrick.chautard@free.fr');
define('EMAIL_ALIAS','Reservation Administration' );

// Email - Demande de mot de passe
define('EMAIL_PNG', 'templates/lostPassword.png');
define('EMAIL_SUBJECT', 'Mot de passe oublié !');
define('EMAIL_BODY', 'Bonjour {$Prenom}.<br />Vous avez oublié votre mot de passe ? Pas d\'inquiétudes, le voici dans l\'imlage jointe.<br />Penser à modifier votre mot de passe des la première connection !');
define('EMAIL_ALTBODY', 'Bonjour {$Prenom}. Vous avez oublié votre mot de passe ? Pas d\'inquiétudes, le voici dans l\'imlage jointe. Penser à modifier votre mot de passe des la première connection !');
?>