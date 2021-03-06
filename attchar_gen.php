<?php
/*
Copyright (c) 2016-2017 ZettaScript, Pascal Engélibert
This file is part of ATTCHAR.

	ATTCHAR is free software: you can redistribute it and/or modify
	it under the terms of the GNU Lesser General Public License as published by
	the Free Software Foundation, either version 3 of the License, or
	(at your option) any later version.

	ATTCHAR is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU Lesser General Public License for more details.

	You should have received a copy of the GNU Lesser General Public License
	along with ATTCHAR.  If not, see <http://www.gnu.org/licenses/>.
*/

usleep(rand(5000,10000));// bruteforce / bdd saturation
$alpha = '012345689ABCDEFX';
$code = '';
$i = 0;
while($i < 8) {// code generation
	$code .= $alpha[rand(0, 15)];
	$i ++;
}

try {$c = $_GET['c'];}
catch(Exception $e) {die('Error : ' . $e->getMessage());}

require_once('database.php');

$req = $attchar_bdd->prepare('INSERT INTO `attchar` (`hashcode`, `expire`, `haship`, `code`) VALUES (?, ?, ?, ?)');
$req->execute(array(sha1($code).$c, time()+3600, sha1($_SERVER['REMOTE_ADDR']), $code));

header('Content-type: image/jpeg');// this is an image
$image = imagecreate(256, 96);
$fonts = array(0=>'BioRhymeExpanded-Light.ttf','coiny-regular.ttf','Digory_Doodles_PS.ttf','Domine-Regular.ttf','DroidSerif-Italic.ttf','Eczar-SemiBold.ttf','FreeMonoBold.ttf','ProzaLibre-LightItalic.ttf','Ritaglio.ttf','soria-font.ttf','SpaceMono-Regular.ttf');// load fonts
$nbfonts = count($fonts)-1;
$copyfont = 'fonts/EBGaramond08-Regular.ttf';
$color_bg = imagecolorallocate($image, 0, 0, 0);
$color_copy = imagecolorallocate($image, rand(24,32), rand(24,32), rand(24,32));

$x = rand(-32, 32);
while($x < 256) {
	imagettftext($image, rand(16,18), rand(25,40), $x, 82+rand(0,8), $color_copy, $copyfont, '(c) ATTCHAR');
	$x += 96;
}

$x = 14;
$i = 0;
while($i < 8) {
	imagettftext($image, rand(22,26), rand(-20,20), $x+rand(-3,3), rand(56,76), imagecolorallocate($image, rand(64,255), rand(64,255), rand(64,255)), 'fonts/'.$fonts[rand(0,$nbfonts)], $code[$i]);
	$x += 30;
	$i ++;
}

$i = rand(0,1);
while($i < 4) {
	$y1 = rand(16,80);
	$y2 = rand(16,80);
	imageline($image, rand(0,14), $y1, rand(242,256), $y2, imagecolorallocate($image, rand(0,255), rand(0,255), rand(0,255)));
	imageline($image, rand(0,14), 48-($y1-48), rand(242,256), 48-($y2-48), imagecolorallocate($image, rand(0,255), rand(0,255), rand(0,255)));
	$i ++;
}
imagefilter($image, IMG_FILTER_SMOOTH, rand(20,36));

for($i=0;$i<200;$i++) {
	$color = imagecolorallocate($image, rand(0,255), rand(0,255), rand(0,255));
	imagesetpixel($image, rand(0,255), rand(0,95), $color);
	imagesetpixel($image, rand(0,255), rand(0,95), $color);
}

imagejpeg($image, NULL, 70);
imagedestroy($image);
echo "\x00\x00Copyright (c) 2016-2017 ATTCHAR\x00";
?>
