<?php

namespace Src\QRBook\QRCode;

use Src\QRBook\General\BaseControllerWithItemModel;

class QRCodeController extends BaseControllerWithItemModel
{
    public function __construct($db, $requestMethod, $params)
    {
        parent::__construct($db, $requestMethod, $params, "Src\QRBook\QRCode\QRCodeModel");
    }

}
