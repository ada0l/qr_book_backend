<?php

namespace Src\QRBook\Image;

use Src\Core\Response;
use Src\Core\StatusCode;
use Src\QRBook\General\BaseControllerWithUserModel;

class ImageController extends BaseControllerWithUserModel
{
    private $imageDir = __DIR__ . "/../../../images/";

    public function __construct($db, $requestMethod, $params)
    {
        parent::__construct($db, $requestMethod, $params);
    }

    public function getMethod(): Response
    {
        header("Content-Type: image/png");
        header("Content-Transfer-Encoding: Binary");
        if (preg_match('/^[a-fA-F0-9]{32}$/', $_GET['hash'])) {
            readfile($this->getFilePathByHash($_GET['hash']));
            return new Response(StatusCode::REDIRECTION_300);
        }
        return $this->notFoundResponse();
    }

    public function postMethod(): Response
    {
        $auth = $this->getAuthorization();
        if (is_array($auth)) {
            $image = $_FILES['image'];
            $hash = $this->getHash($image);
            if (move_uploaded_file($image['tmp_name'], $this->getFilePathByHash($hash))) {
                $this->getUserModel()->setImageHash(array("hash" => $hash, "id" => $auth['id']));
                return new Response(
                    StatusCode::SUCCESS_200,
                    array(
                        "data" => array(
                            "image_hash" => $hash
                        )
                    ));
            } else {
                return $this->unprocessableEntityResponse();
            }
        }
        return $auth;
    }

    public function getHash($file)
    {
        $filename = $_FILES['name'];
        $timestamp = (new \DateTime())->getTimestamp();
        return md5("$filename$timestamp");
    }

    public function getFilePathByHash($hash): string
    {
        return $this->imageDir . $hash . ".png";
    }
}