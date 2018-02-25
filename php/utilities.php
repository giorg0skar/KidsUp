<?php

require './composer/vendor/autoload.php';

function create_pdf_from_ticket($name, $activity_name , $ticket_ids)
{
    $mpdf = new \Mpdf\Mpdf();
    //The string with the ids concatenated
    $ids_string = "";
    $num_tickets = sizeof($ticket_ids);
    foreach ($ticket_ids as $tickets) {
        $ids_string = $ids_string . " " . strval($tickets);
    }
    $HTML = "<h1> Αγορά Εισιτηρίου</h1><br>
    <p> Γεια σου $name, <br>
    Εχεις αγοράσει $num_tickets εισιτήρια για την δραστηριότητα $activity_name.<br>
    Αυτά έχουν ids: $ids_string </p>
    ";
    $mpdf->WriteHTML($HTML);
    return $mpdf->Output('tickets.pdf', 'S');


}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
function send_ticket_with_email($to,$subject,$pdf)
{
    $mail = new PHPMailer(true);
    try{
        //Server Settings
        // $mail->SMTPDebug = 2;
        $mail->IsSMTP();
        $mail->Host = "smtp.gmail.com";
        $mail->SMTPAuth = true;
        $mail->Username = 'KidsUp42@gmail.com';
        $mail->Password = 'Q23G$_9#er4!';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Senders / Recipients
        $mail->setFrom("KidsUp42@gmail.com","KidsUp");
        $mail->AddAddress($to);
        //Attachments
        $mail->addStringAttachment($pdf, 'tickets.pdf',  $encoding = 'base64', $type = 'application/pdf');
        //Content
        $mail->CharSet = 'UTF-8';
        $mail->IsHTML(true);
        $mail->Subject = mb_convert_encoding($subject,mb_detect_encoding($subject, "auto"));
        $mail->Body = "<h1>KidsUp.gr: Απόδειξη εισιτηρίου</h1></p>";
        $mail->AltBody="This is the body in plain text for non-HTML mail clients";
        $mail->send();
    } catch (Exception $e){
        echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
    }
}
?>
