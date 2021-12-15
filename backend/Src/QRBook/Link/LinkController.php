<?php

namespace Src\QRBook\Link;

use Src\Core\Response;
use Src\QRBook\General\BaseControllerWithUserModel;
use Src\QRBook\QRCode\QRCodeModel;
use Src\QRBook\QRCode\ScanModel;

class LinkController extends BaseControllerWithUserModel
{
    private $qrCodeModel;
    private $scanModel;

    public function __construct($db, $requestMethod, $params)
    {
        parent::__construct($db, $requestMethod, $params);
        $this->qrCodeModel = new QRCodeModel($this->getDB());
        $this->scanModel = new ScanModel($this->getDB());
    }

    /**
     * @throws \Exception
     */
    public function getMethod(): Response
    {
        $qrCode = $this->qrCodeModel->findByUUID(array('uuid' => $_GET['uuid']));
        if ($qrCode) {
            $this->scanModel->insert(array("card_id" => $qrCode['id']));
            return $this->redirectResponse($qrCode['text']);
        }
        return $this->notFoundResponse();
    }
}