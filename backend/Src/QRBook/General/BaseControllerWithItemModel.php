<?php

namespace Src\QRBook\General;

use Src\Core\Response;
use Src\Core\StatusCode;

class BaseControllerWithItemModel extends BaseControllerWithUserModel
{
    private $itemModel;
    private $onlyOneItem;

    public function __construct($db, $requestMethod, $params, $itemModelString, $onlyOneItem)
    {
        parent::__construct($db, $requestMethod, $params);
        $this->itemModel = new $itemModelString($this->getDB());
        $this->onlyOneItem = $onlyOneItem;
        if ($onlyOneItem) {
            $this->addMethodFunction("POST", "postMethodOnlyOneItem");
            $this->addMethodFunction("PUT", "putMethodOnlyOneItem");
        }
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
        $auth = $this->getAuthorization();
        if (is_array($auth)) if ($_GET['id']) {
            $object = $this->itemModel->find(array('id' => $_GET['id']));
            if ($object == null) {
                return new Response(
                    StatusCode::CLIENT_ERROR_404,
                    array("data" => "This object is not exist")
                );
            }
            if (!$this->access($auth, $object)) {
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

    public function postMethod(): Response
    {
        $auth = $this->getAuthorization();
        if (is_array($auth)) {
            $input = $this->getData();
            $input['user_id'] = $auth['id'];
            $this->beforeCreate($auth, $input);
            $this->itemModel->insert($input);
            return new Response(
                StatusCode::SUCCESS_201,
                array(
                    "data" => "The object is created"
                )
            );
        }
        return $auth;
    }

    public function postMethodOnlyOneItem(): Response
    {
        $auth = $this->getAuthorization();
        if (is_array($auth)) {
            $object = $this->itemModel->findByUserId(array('user_id' => $auth['id']));
            $input = $this->getData();
            if ($object) {
                $input['id'] = $object['id'];
                $this->beforeUpdate($auth, $input);
                $this->itemModel->update($input);
                return new Response(
                    StatusCode::SUCCESS_200,
                    array("data" => $this->itemModel->find(array('id' => $object['id'])))
                );
            }
            $input['user_id'] = $auth['id'];
            $this->beforeCreate($auth, $input);
            $this->itemModel->insert($input);
            return new Response(
                StatusCode::SUCCESS_201,
                array("data" => $this->itemModel->findByUserId(array('user_id' => $auth['id'])))
            );
        }
        return $auth;
    }

    public function putMethod(): Response
    {
        $auth = $this->getAuthorization();
        if (is_array($auth)) {
            $input = $this->getData();
            if ($_GET['id']) {
                $object = $this->itemModel->find(array('id' => $_GET['id']));
                if ($object == null) {
                    return new Response(
                        StatusCode::CLIENT_ERROR_404,
                        array("data" => "This object is not exist")
                    );
                }
                if (!$this->access($auth, $object)) {
                    return new Response(
                        StatusCode::CLIENT_ERROR_403,
                        array("data" => "You dont have access to this object")
                    );
                }
                $this->beforeUpdate($auth, $input);
                $this->itemModel->update($input);
                return new Response(
                    StatusCode::SUCCESS_200,
                    array("data" => $this->itemModel->find(array('id' => $_GET['id'])))
                );
            } else {
                return new Response(
                    StatusCode::CLIENT_ERROR_404,
                    array("data" => "id required")
                );
            }
        }
        return $auth;
    }

    public function putMethodOnlyOneItem(): Response
    {
        $auth = $this->getAuthorization();
        if (is_array($auth)) {
            $input = $this->getData();
            $object = $this->itemModel->findByUserId(array('user_id' => $auth['id']));
            $input['id'] = $object['id'];
            if ($object == null) {
                return new Response(
                    StatusCode::CLIENT_ERROR_404,
                    array("data" => "This object is not exist")
                );
            }
            if (!$this->access($auth, $object)) {
                return new Response(
                    StatusCode::CLIENT_ERROR_403,
                    array("data" => "You dont have access to this object")
                );
            }
            $this->beforeUpdate($auth, $input);
            $this->itemModel->update($input);
            return new Response(
                StatusCode::SUCCESS_200,
                array("data" => $this->itemModel->findByUserId(array('user_id' => $auth['id'])))
            );
        } else {
            return new Response(
                StatusCode::CLIENT_ERROR_404,
                array("data" => "id required")
            );
        }
        return $auth;
    }

    public function deleteMethod(): Response
    {
        $auth = $this->getAuthorization();
        if (is_array($auth)) {
            if ($_GET['id']) {
                $object = $this->itemModel->find(array('id' => $_GET['id']));
                if ($object == null) {
                    return new Response(
                        StatusCode::CLIENT_ERROR_404,
                        array("data" => "This object is not exist")
                    );
                }
                if (!$this->access($auth, $object)) {
                    return new Response(
                        StatusCode::CLIENT_ERROR_403,
                        array("data" => "You dont have access to this object")
                    );
                }
                $this->itemModel->delete(array("id" => $_GET['id']));
                return new Response(
                    StatusCode::SUCCESS_200,
                    array("data" => "The object is deleted")
                );
            } else {
                return new Response(
                    StatusCode::CLIENT_ERROR_404,
                    array("data" => "id required")
                );
            }
        }
        return $auth;
    }

    public function beforeCreate($auth, &$input)
    {
    }

    public function beforeUpdate($auth, &$input)
    {
        if (!$this->onlyOneItem) {
            $input['id'] = $_GET['id'];
        }
    }

    public function access($auth, &$input): bool
    {
        return $auth['id'] == $input['user_id'];
    }
}