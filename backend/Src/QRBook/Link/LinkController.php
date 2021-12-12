<?php

namespace Src\QRBook\Link;

use Src\Core\Response;
use Src\QRBook\General\BaseControllerWithUserModel;
use Src\QRBook\QRCode\QRCodeModel;

class LinkController extends BaseControllerWithUserModel
{
    private $qrCodeModel;
    public function __construct($db, $requestMethod, $params)
    {
        parent::__construct($db, $requestMethod, $params);
        $this->qrCodeModel = new QRCodeModel($this->getDB());
    }

    public function getMethod(): Response
    {
        $qrCode = $this->qrCodeModel->findByUUID(array('uuid' => $_GET['uuid']));
        if ($qrCode) {
            $this->redirect($qrCode['text']);
        } else {
            return $this->notFoundResponse();
        }
    }
}