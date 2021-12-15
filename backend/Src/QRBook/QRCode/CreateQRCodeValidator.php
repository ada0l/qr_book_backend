<?php

namespace Src\QRBook\QRCode;

use Src\Core\Validator;

class CreateQRCodeValidator extends Validator
{
    public function __construct()
    {
        parent::__construct(array(
            'title' => array(["lenInRange", [3, 50]]),
            'text' => array(["lenInRange", [3, 255]]),
            'isURL' => array('isBool'),
            'light_color' => array('isColorRGB'),
            'dark_color' => array('isColorRGB'),
            'frame_id' => array(['inRange', [1, 4]]),
            'frame_text' => array(['lenInRange', [1, 32]]),
            'frame_color' => array('isColorRGB'),
            'frame_text_color' => array('isColorRGB'),
            'quality' => array(['in', [["L", "M", "Q", "H"]]])
        ), true);
    }
}
