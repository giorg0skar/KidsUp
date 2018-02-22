<?php

	function add_watermark($im, $name){

		// Load the photo to apply the watermark to
		if(endsWith($name, 'jpg'))
			$im = imagecreatefromjpeg($im);
		else if(endsWith($name, 'png'))
			$im = imagecreatefrompng($im);
		// First we create our stamp image manually from GD
		$stamp = imagecreatetruecolor(100, 70);
		imagefilledrectangle($stamp, 0, 0, 99, 69, 0x0000FF);
		imagefilledrectangle($stamp, 9, 9, 90, 60, 0xFFFFFF);
		imagestring($stamp, 5, 20, 20, 'Kid\'sUp', 0x0000FF);
		imagestring($stamp, 2, 20, 40, '(c) 2017-18', 0x0000FF);

		// Set the margins for the stamp and get the height/width of the stamp image
		$marge_right = 10;
		$marge_bottom = 10;
		$sx = imagesx($stamp);
		$sy = imagesy($stamp);

		// Merge the stamp onto our photo with an opacity of 50%
		imagecopymerge($im, $stamp, imagesx($im) - $sx - $marge_right, imagesy($im) - $sy - $marge_bottom, 0, 0, imagesx($stamp), imagesy($stamp), 50);
		return $im;
	}

	function endsWith($haystack, $needle)
	{
	    $length = strlen($needle);

	    return $length === 0 || 
	    (substr($haystack, -$length) === $needle);
	}

?>
