<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../../vendor/autoload.php';

class MailService
{
    public static function envoyer($destinataire, $sujet, $corpsHtml)
    {
        $config = require __DIR__ . '/../../config/mail.php';
        $mail = new PHPMailer(true); // true = lance des exceptions

        try {
            $mail->isSMTP();
            $mail->Host       = $config['host'];
            $mail->SMTPAuth   = true;
            $mail->Username   = $config['username'];
            $mail->Password   = $config['password'];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = $config['port'];
            $mail->CharSet    = 'UTF-8'; // pour les accents

            $mail->setFrom($config['from'], $config['fromName']);
            $mail->addAddress($destinataire);

            $mail->isHTML(true);
            $mail->Subject = $sujet;
            $mail->Body    = $corpsHtml;
            $mail->AltBody = strip_tags($corpsHtml); // version texte

            $mail->send();
            return true;
        } catch (Exception $e) {
            error_log("Erreur mail : " . $mail->ErrorInfo);
            return false;
        }
    }
}
