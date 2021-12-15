<?php

namespace Src\QRBook\General;

use Src\Core\BaseController;
use Src\Core\Response;
use Src\Core\StatusCode;
use Src\QRBook\User\UserModel;

class BaseControllerWithUserModel extends BaseController
{
    private $userModel;

    public function __construct($db, $requestMethod, $params)
    {
        parent::__construct($db, $requestMethod, $params);
        $this->userModel = new UserModel($db);
    }

    public function getUserModel(): UserModel
    {
        return $this->userModel;
    }

    public function getAuthorization()
    {
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            return new Response(
                StatusCode::CLIENT_ERROR_401,
                array("data" => "You are not loggined")
            );
        }

        $user = $this->getUserModel()->verify(array(
            "email" => $_SERVER["PHP_AUTH_USER"],
            "password" => $_SERVER["PHP_AUTH_PW"]
        ));

        if ($user) {
            return $user;
        } else {
            return new Response(
                StatusCode::CLIENT_ERROR_401,
                array("data" => "Incorrect email or password")
            );
        }
    }
}
