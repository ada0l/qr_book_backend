<?php

namespace Src\QRBook\QRCode;

use Src\QRBook\General\BaseControllerWithItemModel;

class QRCodeController extends BaseControllerWithItemModel
{
    public function __construct($db, $requestMethod, $params)
    {
        parent::__construct($db, $requestMethod, $params, "Src\QRBook\QRCode\QRCodeModel", false);
        $this->addMethodValidator("POST", "Src\QRBook\QRCode\CreateQRCodeValidator");
        $this->addMethodValidator("PUT", "Src\QRBook\QRCode\CreateQRCodeValidator");
    }

    public function beforeCreate($auth, & $input) {
        if ($input['isURL']) {
            $timestamp = (new \DateTime())->getTimestamp();
            $input['uuid'] = md5("${input['title']}${input['text']}${input['user_id']}${timestamp}");
        } else {
            $input['uuid'] = null;
        }
        unset($input['isURL']);
    }

    public function beforeUpdate($auth, & $input)
    {
        parent::beforeUpdate($auth, $input);
        $this->beforeCreate($auth, $input);
    }
}
