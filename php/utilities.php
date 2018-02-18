<?php
//link: https://stackoverflow.com/questions/2235152/add-watermark-to-images-with-php
function add_watermark($im,$stamp)
{
    $stamp = imagecreatefrompng('stamp.png');
    $im = imagecreatefromjpeg('photo.jpeg');

    // Set the margins for the stamp and get the height/width of the stamp image
    $marge_right = 10;
    $marge_bottom = 10;
    $sx = imagesx($stamp);
    $sy = imagesy($stamp);

    // Copy the stamp image onto our photo using the margin offsets and the photo
    // width to calculate positioning of the stamp.
    imagecopy($im, $stamp, imagesx($im) - $sx - $marge_right, imagesy($im) - $sy - $marge_bottom, 0, 0, imagesx($stamp), imagesy($stamp));

    return $im
}
//link: https://stackoverflow.com/questions/5908706/creating-a-pdf-and-sending-by-email
function send_pdf_with_email($to,$subject,$pdf)
{

$att = file_get_contents( $pdf);
$att = base64_encode( $att );
$att = chunk_split( $att );

$BOUNDARY="anystring";

$headers =<<<END
From: Your Name <abc@gmail.com>
Content-Type: multipart/mixed; boundary=$BOUNDARY
END;

$body =<<<END
--$BOUNDARY
Content-Type: text/plain

See attached file!

--$BOUNDARY
Content-Type: application/pdf
Content-Transfer-Encoding: base64
Content-Disposition: attachment; filename=".$pdf."

$att
--$BOUNDARY--
END;

mail( $to, $subject, $body, $headers );
}
?>
