<?php
$pixelsX = [4, 5, 4, 4, 5, 4, 5, 4, 5, 4, 5, 4, 4, 5, 4, 5, 4, 5, 4, 5, 4, 4, 5, 4, 5, 4, 5, 4, 5, 4, 5, 4];
$pixelsY = [4, 5, 4, 4, 5, 4, 5, 4, 5, 4, 5, 4, 4, 5, 4, 5, 4, 5, 4, 5, 4, 4, 5, 4, 5, 4, 5, 4, 5, 4, 5, 4];
$startX = 250;
$startY = 25;
foreach (glob("img-src/*.png") as $filepath) {
	$srcImg = imagecreatefrompng($filepath);
	$outImg = imagecreatetruecolor(32, 32);
	$srcX = $startX;
	$srcY = $startY;
	$x = 0;
	$y = 0;
	foreach ($pixelsX as $pixelX) {
		foreach ($pixelsY as $pixelY) {
			$rgb = imagecolorat($srcImg, $srcX, $srcY);
			$r = ($rgb >> 16) & 0xFF;
			$g = ($rgb >> 8) & 0xFF;
			$b = $rgb & 0xFF;
			$color = imagecolorallocate($outImg, $r, $g, $b);
			imagefilledrectangle($outImg, $x, $y, $x, $y, $color);
			$srcY += $pixelY;
			$y++;
		}
		$srcX += $pixelX;
		$x++;
		$srcY = $startY;
		$y = 0;
	}
	imagepng($outImg, "img-out/" . basename($filepath), 0);
	imagedestroy($outImg);
}
