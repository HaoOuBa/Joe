<?php
session_start();

header("Content-type: image/png");

$image = imagecreatetruecolor(85, 25);
$bgcolor = imagecolorallocate($image, 255, 255, 255);
imagecolortransparent($image, $bgcolor);
imagefill($image, 0, 0, $bgcolor);

$content = "0123456789";

$captcha = "";

/* 绘制干扰点 */
for ($i = 0; $i < 80; $i++) {
    $pointColor = imagecolorallocate($image, rand(100, 255), rand(100, 255), rand(100, 255));
    imagesetpixel($image, rand(0, 85), rand(0, 25), $pointColor);
}

/* 绘制验证码 */
for ($i = 0; $i < 4; $i++) {
    $fontSize = 10;
    $fontColor = imagecolorallocate($image, 155, 155, 155);
    $fontContent = rand(0, 9);
    $captcha .= $fontContent;
    $x = ($i * 85 / 4) + 7;
    $y = rand(3, 8);
    imagestring($image, $fontSize, $x, $y, $fontContent, $fontColor);
}

$_SESSION["captcha"] = $captcha;

imagepng($image);
imagedestroy($image);
