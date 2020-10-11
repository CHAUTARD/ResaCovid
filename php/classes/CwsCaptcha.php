<?php

/**
 * CwsCaptcha.
 *
 * @author CrazyMax
 * @copyright 2013-2018, CrazyMax
 * @license GNU LESSER GENERAL PUBLIC LICENSE
 *
 * @link https://github.com/crazy-max/CwsCaptcha
 */

class CwsCaptcha
{
    const FONT_FACTOR = 9; // font size factor [0-100]
    const IMAGE_FACTOR = 3; // image size factor [1-3]

    const FORMAT_PNG = 'png';
    const FORMAT_JPEG = 'jpeg';

    /**
     * Captcha width in px.
     *
     * @var int
     */
    private $width = 400;

    /**
     * Captcha height in px.
     *
     * @var int
     */
    private $height = 120;

    /**
     * Captcha minimum length.
     *
     * @var int
     */
    private $minLength = 6;

    /**
     * Captcha maximum length.
     *
     * @var int
     */
    private $maxLength = 10;

    /**
     * Hexadecimal background color.
     *
     * @var string
     */
    private $bgdColor = '#FFFFFF';

    /**
     * Set background transparent for PNG image type. If enabled, this will disable the background color.
     *
     * @var bool
     */
    private $bgdTransparent = false;

    /**
     * Hexadecimal foreground colors list for font letters.
     *
     * @var array
     */
    private $fgdColors = array(
        '#006ACC', // blue
        '#00CC00', // green
        '#CC0000', // red
        '#8B28FA', // purple
        '#FF7007', // orange
    );

    /**
     * Fonts definition (letter_space, min and max size, filename).
     *
     * @var array
     */
    private $fonts = array(
        array(
            'letter_space' => 1,
            'min_size'     => 14,
            'max_size'     => 20,
            'filename'     => 'BoomBox.ttf',
        ),
        array(
            'letter_space' => 0,
            'min_size'     => 22,
            'max_size'     => 38,
            'filename'     => 'Duality.ttf',
        ),
        array(
            'letter_space' => 1,
            'min_size'     => 28,
            'max_size'     => 32,
            'filename'     => 'Monof.ttf',
        ),
        array(
            'letter_space' => 0,
            'min_size'     => 22,
            'max_size'     => 28,
            'filename'     => 'OrionPax.ttf',
        ),
        array(
            'letter_space' => 0,
            'min_size'     => 26,
            'max_size'     => 34,
            'filename'     => 'Stark.ttf',
        ),
        array(
            'letter_space' => 1.5,
            'min_size'     => 24,
            'max_size'     => 30,
            'filename'     => 'StayPuft.ttf',
        ),
        array(
            'letter_space' => 1,
            'min_size'     => 12,
            'max_size'     => 18,
            'filename'     => 'VenusRisingRg.ttf',
        ),
        array(
            'letter_space' => 0.5,
            'min_size'     => 22,
            'max_size'     => 30,
            'filename'     => 'WhiteRabbit.ttf',
        )
    );

    /**
     * Max clockwise rotations for a letter.
     *
     * @var int
     */
    private $maxRotation = 7;

    /**
     * Generated image period (x, y).
     *
     * @var array
     */
    private $period = array(11, 12);

    /**
     * Generated image amplitude (x, y).
     *
     * @var array
     */
    private $amplitude = array(5, 14);

    /**
     * Add blur effect using the Gaussian method.
     *
     * @var bool
     */
    private $blur = false;

    /**
     * Add emboss effect.
     *
     * @var bool
     */
    private $emboss = false;

    /**
     * Add pixelate effect.
     *
     * @var bool
     */
    private $pixelate = false;

    /**
     * Image format.
     *
     * @var string
     */
    private $format = FORMAT_PNG;

    /**
     * The last error.
     *
     * @var string
     */
    private $error;

    /**
     * The image handler.
     *
     * @var resource
     */
    private $handler;


    /**
     * Le message.
     *
     * @var resource
     */
    private $message;
    
    public function __construct()
    {
        $this->format = self::FORMAT_PNG;
    }

    /**
     * Start process.
     */
    public function process()
    {
        $this->destroy();

        // create a blank image
        $this->handler = imagecreatetruecolor($this->width * self::IMAGE_FACTOR, $this->height * self::IMAGE_FACTOR);

        // background color
        if ($this->bgdTransparent) {
            // disable blending
            imagealphablending($this->handler, false);

            // allocate a transparent color
            $trans_color = imagecolorallocatealpha($this->handler, 0, 0, 0, 127);

            // fill the image with the transparent color
            imagefill($this->handler, 0, 0, $trans_color);

            // save full alpha channel information
            imagesavealpha($this->handler, true);
            
        } elseif (!empty($this->bgdColor)) {
            // allocate background color
            $rgbBgdColor = $this->getRgbFromHex($this->bgdColor);
            $bgdColor = imagecolorallocate($this->handler, $rgbBgdColor[0], $rgbBgdColor[1], $rgbBgdColor[2]);
            imagefill($this->handler, 0, 0, $bgdColor);
        }

        // allocate foreground color
        $rgbFgdColor = $this->getRgbFromHex($this->fgdColors[mt_rand(0, count($this->fgdColors) - 1)]); // pick a random color
        $fgd_color = imagecolorallocate($this->handler, $rgbFgdColor[0], $rgbFgdColor[1], $rgbFgdColor[2]);

        // write text on image
        $this->writeText( $this->getMessage(), $fgd_color);

        // distorted and add effects
        $this->distortImage();
        $this->addEffects();

        // resampled image
        $this->resampledImage();

        // write image
        $this->writeImage();

        $this->destroy();
    }

    /**
     * Display image.
     */
    private function writeImage()
    {
        if ($this->format == self::FORMAT_PNG && function_exists('imagepng')) {
            //$this->writeHeaders();

            //header('Content-type: image/png');
            if ($this->bgdTransparent) {
                imagealphablending($this->handler, false);
                imagesavealpha($this->handler, true);
            }
            unlink ('templates/lostPassword.png');
            imagepng($this->handler, 'templates/lostPassword.png');
        } else {
            $this->writeHeaders();

            header('Content-type: image/jpeg');
            imagejpeg($this->handler, null, 90);
        }
    }

    /**
     * Write custom headers to clear cache.
     */
    private function writeHeaders()
    {
        $expires = 'Thu, 01 Jan 1970 00:00:00 GMT';
        $lastModified = gmdate('D, d M Y H:i:s', time()).' GMT';
        $cacheNoStore = 'no-store, no-cache, must-revalidate';
        $cachePostCheck = 'post-check=0, pre-check=0';
        $cacheMaxAge = 'max-age=0';
        $pragma = 'no-cache';
        $etag = microtime();

        header('Expires: '.$expires); // already expired
        header('Last-Modified: '.$lastModified); // always modified
        header('Cache-Control: '.$cacheNoStore); // HTTP/1.1
        header('Cache-Control: '.$cachePostCheck, false); // HTTP/1.1
        header('Cache-Control: '.$cacheMaxAge, false); // HTTP/1.1
        header('Pragma: '.$pragma); // HTTP/1.0
        header('Etag: '.$etag); // generate a unique etag each time
    }

    /**
     * Insert text.
     *
     * @param string $text  : the random string
     * @param int    $color : color identifier representing the color composed of the given RGB color
     */
    private function writeText($text, $color)
    {
        $font = $this->fonts[array_rand($this->fonts)];
        $fontPath = 'fonts/'.$font['filename'];

        $fontSizeFactor = 1 + (($this->maxLength - strlen($text)) * (self::FONT_FACTOR / 100));
        $coordX = 40 * self::IMAGE_FACTOR;
        $coordY = round(($this->height * 27 / 40) * self::IMAGE_FACTOR);

        for ($i = 0; $i < strlen($text); $i++) {
            $angle = rand($this->maxRotation * -1, $this->maxRotation);
            $fontSize = rand($font['min_size'], $font['max_size']) * self::IMAGE_FACTOR * $fontSizeFactor;
            $letter = substr($text, $i, 1);

            $coords = imagettftext($this->handler, $fontSize, $angle, $coordX, $coordY, $color, $fontPath, $letter);
            $coordX += ($coords[2] - $coordX) + ($font['letter_space'] * self::IMAGE_FACTOR);
        }
    }

    /**
     * Reduce the image to the standard size.
     */
    private function resampledImage()
    {
        $resampled = imagecreatetruecolor($this->width, $this->height);
        if ($this->bgdTransparent) {
            imagealphablending($resampled, false);
        }

        imagecopyresampled($resampled, $this->handler, 0, 0, 0, 0,
            $this->width, $this->height, $this->width * self::IMAGE_FACTOR, $this->height * self::IMAGE_FACTOR
        );

        if ($this->bgdTransparent) {
            imagealphablending($resampled, true);
        }

        $this->destroy();
        $this->handler = $resampled;
    }

    /**
     * Message à codé.
     *
     * @return string
     */
    private function getMessage() { return $this->message; }
    public function setMessage($msg) { $this->message = $msg; }
    
    /**
     * Distort filter.
     */
    private function distortImage()
    {
        $xAxis = $this->period[0] * rand(1, 3) * self::IMAGE_FACTOR;
        $yAxis = $this->period[1] * rand(1, 2) * self::IMAGE_FACTOR;

        // X process
        $rand = rand(0, 100);
        for ($i = 0; $i < ($this->width * self::IMAGE_FACTOR); $i++) {
            imagecopy($this->handler, $this->handler,
                $i - 1, sin($rand + $i / $xAxis) * ($this->amplitude[0] * self::IMAGE_FACTOR),
                $i, 0, 1, $this->height * self::IMAGE_FACTOR);
        }

        // Y process
        $rand = rand(0, 100);
        for ($i = 0; $i < ($this->height * self::IMAGE_FACTOR); $i++) {
            imagecopy($this->handler, $this->handler,
                sin($rand + $i / $yAxis) * ($this->amplitude[1] * self::IMAGE_FACTOR), $i - 1,
                0, $i, $this->width * self::IMAGE_FACTOR, 1);
        }
    }

    /**
     * Add some effects to the image.
     */
    private function addEffects()
    {
        // add blur effect
        if ($this->blur)
            imagefilter($this->handler, IMG_FILTER_GAUSSIAN_BLUR);

        // add emboss effect
        if ($this->emboss)
            imagefilter($this->handler, IMG_FILTER_EMBOSS);

        // add pixelate effect
        if ($this->pixelate)
            imagefilter($this->handler, IMG_FILTER_PIXELATE);
    }

    /**
     * Destroy the image.
     */
    private function destroy()
    {
        if (!empty($this->handler)) {
            imagedestroy($this->handler);
            unset($this->handler);
        }
    }

    /**
     * Convert hexadecimal color to RGB type.
     *
     * @param string $hex : hexadecimal color
     *
     * @return array
     */
    private function getRgbFromHex($hex)
    {
        $hex = str_replace('#', '', $hex);

        if (strlen($hex) == 3) {
            $r = hexdec(substr($hex, 0, 1).substr($hex, 0, 1));
            $g = hexdec(substr($hex, 1, 1).substr($hex, 1, 1));
            $b = hexdec(substr($hex, 2, 1).substr($hex, 2, 1));
        } else {
            $r = hexdec(substr($hex, 0, 2));
            $g = hexdec(substr($hex, 2, 2));
            $b = hexdec(substr($hex, 4, 2));
        }

        return array($r, $g, $b);
    }

    /**
     * Getters and setters.
     */

    /**
     * Captcha width in px.
     *
     * @return int $width
     */
    public function getWidth() { return $this->width; }

    /**
     * Set the captcha width in px.
     * default 250.
     *
     * @param int $width
     */
    public function setWidth($width) { $this->width = $width; }

    /**
     * Captcha height in px.
     *
     * @return int $height
     */
    public function getHeight() { return $this->height; }

    /**
     * Set the captcha height in px.
     * default 60.
     *
     * @param number $height
     */
    public function setHeight($height) { $this->height = $height; }

    /**
     * Captcha minimum length.
     *
     * @return int $minLength
     */
    public function getMinLength() { return $this->minLength; }

    /**
     * Set the captcha minimum length.
     * default 6.
     *
     * @param number $minLength
     */
    public function setMinLength($minLength) { $this->minLength = $minLength; }

    /**
     * Captcha maximum length.
     *
     * @return int $maxLength
     */
    public function getMaxLength() { return $this->maxLength; }

    /**
     * Set the captcha maximum length.
     * default 10.
     *
     * @param number $maxLength
     */
    public function setMaxLength($maxLength) { $this->maxLength = $maxLength; }

    /**
     * Hexadecimal background color.
     *
     * @return string $bgdColor
     */
    public function getBgdColor() { return $this->bgdColor; }

    /**
     * Set the hexadecimal background color.
     * default '#FFFFFF'.
     *
     * @param string $bgdColor
     */
    public function setBgdColor($bgdColor) { $this->bgdColor = $bgdColor; }

    /**
     * The background transparent for PNG image type.
     *
     * @return string $bgdTransparent
     */
    public function getBgdTransparent() { return $this->bgdTransparent; }

    /**
     * Set background transparent for PNG image type.
     * If enabled, this will disable the background color.
     * default false.
     *
     * @param bool $bgdTransparent
     */
    public function setBgdTransparent($bgdTransparent) { $this->bgdTransparent = $bgdTransparent; }

    /**
     * Hexadecimal foreground colors list for font letters.
     *
     * @return string $fgdColors
     */
    public function getFgdColors() { return $this->fgdColors; }

    /**
     * Set the Hexadecimal foreground colors list for font letters.
     * default array('#006ACC', '#00CC00', '#CC0000', '#8B28FA', '#FF7007').
     *
     * @param array $fgdColors
     */
    public function setFgdColors($fgdColors) { $this->fgdColors = $fgdColors; }

    /**
     * Fonts definition (letter_space, min and max size, filename).
     *
     * @return string $fonts
     */
    public function getFonts() { return $this->fonts; }

    /**
     * Max clockwise rotations for a letter.
     *
     * @return string $maxRotation
     */
    public function getMaxRotation() { return $this->maxRotation; }

    /**
     * Set the max clockwise rotations for a letter.
     * default 7.
     *
     * @param number $maxRotation
     */
    public function setMaxRotation($maxRotation) { $this->maxRotation = $maxRotation; }

    /**
     * Generated image period (x, y).
     *
     * @return string $period
     */
    public function getPeriod() { return $this->period; }

    /**
     * Set the generated image period (x, y)
     * default array(11, 12).
     *
     * @param array $period
     */
    public function setPeriod($period) { $this->period = $period; }

    /**
     * Generated image amplitude (x, y).
     *
     * @return string $amplitude
     */
    public function getAmplitude() { return $this->amplitude; }

    /**
     * Set the generated image amplitude (x, y)
     * default array(5, 14).
     *
     * @param array $amplitude
     */
    public function setAmplitude($amplitude) { $this->amplitude = $amplitude; }

    /**
     * The blur effect using the Gaussian method.
     *
     * @return string $blur
     */
    public function getBlur() { return $this->blur; }

    /**
     * Add blur effect using the Gaussian method.
     * default false.
     *
     * @param bool $blur
     */
    public function setBlur($blur) { $this->blur = $blur; }

    /**
     * The emboss effect.
     *
     * @return string $emboss
     */
    public function getEmboss() { return $this->emboss; }

    /**
     * Add emboss effect
     * default false.
     *
     * @param bool $emboss
     */
    public function setEmboss($emboss) { $this->emboss = $emboss; }

    /**
     * The pixelate effect.
     *
     * @return string $pixelate
     */
    public function getPixelate() { return $this->pixelate; }

    /**
     * Add pixelate effect
     * default false.
     *
     * @param bool $pixelate
     */
    public function setPixelate($pixelate) { $this->pixelate = $pixelate; }

    /**
     * Image format.
     *
     * @return string $format
     */
    public function getFormat() { return $this->format; }

    /**
     * Set the png image format.
     */
    public function setPngFormat() { $this->setFormat(self::FORMAT_PNG); }

    /**
     * Set the jpeg image format.
     */
    public function setJpegFormat() { $this->setFormat(self::FORMAT_JPEG); }

    /**
     * Set the image format
     * default FORMAT_PNG.
     *
     * @param string $format
     */
    private function setFormat($format) { $this->format = $format; }

    /**
     * The last error.
     *
     * @return string $error
     */
    public function getError() { return $this->error; }
}
?>