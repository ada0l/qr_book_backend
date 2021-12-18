<?php

namespace Src\QRBook\Comment;

use Src\QRBook\General\BaseControllerWithPublicItemModel;

class CommentController extends BaseControllerWithPublicItemModel
{
    public function __construct($db, $requestMethod, $params)
    {
        parent::__construct($db, $requestMethod, $params, "Src\QRBook\Comment\CommentModel", true);
        $this->addMethodValidator("POST", "Src\QRBook\Comment\CreateCommentValidator");
        $this->addMethodValidator("PUT", "Src\QRBook\Comment\CreateCommentValidator");
    }
}