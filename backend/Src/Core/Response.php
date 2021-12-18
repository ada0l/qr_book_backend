<?php

namespace Src\Core;

class Response
{
    private mixed $status_code;
    private mixed $body;

    public function __construct($status_code = StatusCode::SUCCESS_200, $body = null)
    {
        $this->status_code = $status_code;
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

