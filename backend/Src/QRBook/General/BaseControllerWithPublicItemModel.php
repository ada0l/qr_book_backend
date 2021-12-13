<?php

namespace Src\QRBook\General;

use Src\Core\Response;
use Src\Core\StatusCode;

class BaseControllerWithPublicItemModel extends BaseControllerWithItemModel
{
    private $itemModel;

    public function __construct($db, $requestMethod, $params, $itemModelString, $onlyOneItem)
    {
        parent::__construct($db, $requestMethod, $params, $itemModelString, $onlyOneItem);
        $this->itemModel = new $itemModelString($this->getDB());
    }

    public function setItemMode($itemModelString)
    {
        $this->$itemModelString = $itemModelString;
    }

    /**
     * @throws Exception
     */
    public function getMethod(): Response
    {
        if ($_GET['id']) {
            $object = $this->itemModel->find(array('id' => $_GET['id']));
            if ($object == null) {
                return new Response(
                    StatusCode::CLIENT_ERROR_404,
                    array("data" => "This object is not exist")
                );
            }
            return new Response(
                StatusCode::SUCCESS_200,
                array("data" => $object)
            );
        }
        $input = array();
        $this->beforeFindAll(array(), $input);
        return new Response(
            StatusCode::SUCCESS_200,
            array(
                "data" => $this->itemModel->findAll($input)
            )
        );
    }
}