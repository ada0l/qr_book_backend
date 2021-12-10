<?php

namespace Src\QRBook\General;

use Src\Core\BaseController;
use Src\Core\Response;

class NotFoundController extends BaseController
{
    public function __construct($db, $requestMethod, $params)
    {
        parent::__construct($db, $requestMethod, $params);
    }

    public function getResponse(): Response
    {
        return $this->notFoundResponse();
    }
}
