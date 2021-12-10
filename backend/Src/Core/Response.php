<?php

namespace Src\Core;

class Response
{
    private $status_code;
    private $body;

    public function __construct($status_code = null, $body = null)
    {
        $this->status_code = $status_code;
        if ($status_code == null) {
            $status_code = StatusCode::SUCCESS_200;
        }
        $this->body = $body;
        if ($body == null) {
            $this->body = json_encode("{}");
        }
    }

    public function setStatus($status_code)
    {
        $this->status_code = $status_code;
    }

    public function getStatus()
    {
        return $this->status_code;
    }

    public function setBody($body)
    {
        $this->body = $body;
    }

    public function getBody()
    {
        return $this->body;
    }
}

