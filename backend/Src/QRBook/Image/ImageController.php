<?php

namespace Src\QRBook\Image;

use DateTime;
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
        $hash = preg_replace("/-/", '', $_GET['hash']);
        if (preg_match('/^[a-fA-F0-9]{32}$/', $hash)) {
            $file = $this->getFilePathByHash($hash);
            if (file_exists($file)) {
                header("Content-Type: image/png");
                header("Content-Transfer-Encoding: Binary");
                readfile($this->getFilePathByHash($hash));
                return new Response(StatusCode::REDIRECTION_300);
            }
        }
        return $this->notFoundResponse();
    }

    public function postMethod(): Response
    {
        $auth = $this->getAuthorization();
        if (is_array($auth)) {
            $image = $_FILES['image'];
            $fInfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime = finfo_file($fInfo, $_FILES['image']['tmp_name']);
            $hash = $this->getHash($image);
            finfo_close($fInfo);
            $allowed_types = array('image/jpeg', 'image/png');
            if (in_array($mime, $allowed_types) && move_uploaded_file($image['tmp_name'], $this->getFilePathByHash($hash))) {
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
        $timestamp = (new DateTime())->getTimestamp();
        return md5("$filename$timestamp");
    }

    public function getFilePathByHash($hash): string
    {
        return $this->imageDir . $hash . ".png";
    }
}