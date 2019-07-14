<?php
$resizeInfo = [
	640 => [1136 => ['startX' => 250, 'startY' => 25, 'iconsize' => 142]],
	750 => [1334 => ['startX' => 294, 'startY' => 30, 'iconsize' => 166]],
	1125 => [2436 => ['startX' => 441, 'startY' => 146, 'iconsize' => 250]],
];
foreach (glob("img-src/*.png") as $filepath) {
	$size = getimagesize($filepath);
	$sizeX = $size[0];
	$sizeY = $size[1];
	echo "Input image:$filepath ($sizeX*$sizeY)\n";
	if (!array_key_exists($sizeX, $resizeInfo)
			|| !array_key_exists($sizeY, $resizeInfo[$sizeX])) {
		echo "Setting undefined. " . $sizeX . "*" . $sizeY . "\n";
		continue;
	}
	$srcImg = imagecreatefrompng($filepath);
	$outImg = imagecreatetruecolor(32, 32);
	$startX = $resizeInfo[$sizeX][$sizeY]['startX'];
	$startY = $resizeInfo[$sizeX][$sizeY]['startY'];
	$pixelLen = $resizeInfo[$sizeX][$sizeY]['iconsize'] / 32;
	for ($i = 0; $i < 32; $i++) {
		for ($j = 0; $j < 32; $j++) {
			$srcX = round($startX + $pixelLen * $i);
			$srcY = round($startY + $pixelLen * $j);
			$rgb = imagecolorat($srcImg, $srcX, $srcY);
			$r = ($rgb >> 16) & 0xFF;
			$g = ($rgb >> 8) & 0xFF;
			$b = $rgb & 0xFF;
			$color = imagecolorallocate($outImg, $r, $g, $b);
			imagefilledrectangle($outImg, $i, $j, $i, $j, $color);
		}
	}
	imagepng($outImg, "img-out/" . basename($filepath), 0);
	imagedestroy($outImg);
}
