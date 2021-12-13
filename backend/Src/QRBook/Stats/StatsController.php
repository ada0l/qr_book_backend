<?php

namespace Src\QRBook\Stats;

use Src\Core\BaseController;
use Src\Core\Response;
use Src\Core\StatusCode;
use Src\QRBook\QRCode\QRCodeModel;
use Src\QRBook\User\UserModel;

class StatsController extends BaseController
{
    private $userModel;
    private $qrCodeModel;

    public function __construct($db, $requestMethod, $params)
    {
        parent::__construct($db, $requestMethod, $params);
        $this->userModel = new UserModel($this->getDB());
        $this->qrCodeModel = new QRCodeModel($this->getDB());
    }

    public function getMethod(): Response
    {
        return new Response(
            StatusCode::SUCCESS_200,
            array(
                "data" => array(
                    "count_of_users" => $this->userModel->getCount(),
                    "count_of_qrs" => $this->qrCodeModel->getCount()
                )
            )
        );
    }
}