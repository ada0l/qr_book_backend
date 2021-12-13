<?php

namespace Src\QRBook\Comment;

use Src\Core\Validator;

class CreateCommentValidator extends Validator
{
    public function __construct()
    {
        parent::__construct(array(
            'text' => array(["lenInRange", [3, 255]]),
            'mark' => array(["inRange", [1, 5]])
        ), true);
    }
}
