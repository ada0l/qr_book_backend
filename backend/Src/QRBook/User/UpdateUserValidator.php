<?php

namespace Src\QRBook\User;

use Src\Core\Validator;

class UpdateUserValidator extends Validator
{
    public function __construct()
    {
        parent::__construct(array(
            'email' => array("isEmail", ["lenInRange", [2, 50]]),
            'name' => array(["lenInRange", [2, 50]]),
        ), true);
    }
}