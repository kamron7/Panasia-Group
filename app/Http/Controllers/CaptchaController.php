<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CaptchaController extends Controller
{
    public function generateCaptcha($type = 'create')
    {
        $captchaCode = substr(md5(rand()), 0, 5);
        Session::put('captcha_code', $captchaCode);

        $imageWidth = 400; // 85 * 4
        $imageHeight = 120; // 30 * 4
        $image = imagecreatetruecolor($imageWidth, $imageHeight);

        // Enable transparency
        imagealphablending($image, false);
        $transparent = imagecolorallocatealpha($image, 0, 0, 0, 127);
        imagefill($image, 0, 0, $transparent);
        imagesavealpha($image, true);

        // Text color (dark gray with some transparency)
        $textColor = imagecolorallocate($image, 50, 50, 50);

        // Path to your font file
        $fontPath = public_path('assets/admin/newlogin/Poppins-Regular.ttf');

        // Larger font size for high resolution (40 = 10 * 4)
        $fontSize = 40;

        // Calculate text position (centered)
        $textBox = imagettfbbox($fontSize, 0, $fontPath, $captchaCode);
        $textWidth = $textBox[2] - $textBox[0];
        $textHeight = $textBox[1] - $textBox[7];
        $x = ($imageWidth - $textWidth) / 2;
        $y = ($imageHeight - $textHeight) / 2 + $textHeight;

        // Add some subtle distortion to make it harder for bots
        for ($i = 0; $i < strlen($captchaCode); $i++) {
            $char = substr($captchaCode, $i, 1);
            $angle = rand(-10, 10);
            $yOffset = rand(-5, 5);
            imagettftext($image, $fontSize, $angle, $x, $y + $yOffset, $textColor, $fontPath, $char);
            $x += ($textWidth / strlen($captchaCode));
        }

        if ($type == 'create') {
            header('Content-type: image/png');
            imagepng($image, null, 9, PNG_ALL_FILTERS);
            imagedestroy($image);
        } else {
            return $image;
        }
    }

    public function recap()
    {
        ob_start();
        imagepng($this->generateCaptcha('recap'), null, 9, PNG_ALL_FILTERS);
        $imageData = ob_get_clean();
        return response()->json(base64_encode($imageData));
    }
}
