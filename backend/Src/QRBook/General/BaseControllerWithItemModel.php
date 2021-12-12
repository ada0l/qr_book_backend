<?php

namespace Src\QRBook\General;

use Src\Core\Response;
use Src\Core\StatusCode;
use Src\QRBook\General\BaseControllerWithUserModel;

class BaseControllerWithItemModel extends BaseControllerWithUserModel
{
    private $itemModel;

    public function __construct($db, $requestMethod, $params, $itemModelString)
    {
        parent::__construct($db, $requestMethod, $params);
        $this->itemModel = new $itemModelString($this->getDB());
    }

    public function setItemMode($itemModelString) {
        $this->$itemModelString = $itemModelString;
    }

    /**
     * @throws Exception
     */
    public function getMethod(): Response
    {
        $auth = $this->getAuthorization();
        if (is_array($auth)) if ($_GET['id']) {
            $object = $this->itemModel->find(array('id' => $_GET['id']));
            if ($object == null) {
                return new Response(
                    StatusCode::CLIENT_ERROR_404,
                    array("data" => "This object is not exist")
                );
            }
            if ($object['email'] != $auth['email']) {
                return new Response(
                    StatusCode::CLIENT_ERROR_403,
                    array("data" => "You dont have access to this object")
                );
            }
            return new Response(
                StatusCode::SUCCESS_200,
                array("data" => $object)
            );
        } else {
            return new Response(
                StatusCode::SUCCESS_200,
                array(
                    "data" => $this->itemModel->findAll(array('email' => $auth['email']))
                )
            );
        }
        return $auth;
    }
}