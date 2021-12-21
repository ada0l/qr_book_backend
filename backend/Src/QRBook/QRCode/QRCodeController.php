<?php

namespace Src\QRBook\QRCode;

use DateTime;
use Src\QRBook\General\BaseControllerWithItemModel;

class QRCodeController extends BaseControllerWithItemModel
{
    public function __construct($db, $requestMethod, $params)
    {
        parent::__construct($db, $requestMethod, $params, "Src\QRBook\QRCode\QRCodeModel", false);
        $this->addMethodValidator("POST", "Src\QRBook\QRCode\CreateQRCodeValidator");
        $this->addMethodValidator("PUT", "Src\QRBook\QRCode\CreateQRCodeValidator");
    }

    public function beforeCreate($auth, &$input)
    {
        if ($input['isURL']) {
            $title = $input['title'];
            $text = $input['text'];
            $timestamp = (new DateTime())->getTimestamp();
            $input['uuid'] = md5("$title$text$timestamp");
        } else {
            $input['uuid'] = null;
        }
        unset($input['isURL']);
    }

    public function beforeUpdate($auth, &$input)
    {
        parent::beforeUpdate($auth, $input);
        unset($input['isURL']);
    }
}
