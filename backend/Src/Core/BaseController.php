<?php

namespace Src\Core;

class BaseController
{
    private $db;
    private $requestMethod;
    private $methodsFunctions;
    private $methodsValidators;
    private $params;

    public function __construct($db, $requestMethod, $params)
    {
        $this->db = $db;
        $this->requestMethod = $requestMethod;
        $this->params = $params;
        $this->methodsFunctions = array(
            'GET' => "getMethod",
            'HEAD' => "headMethod",
            'POST' => "postMethod",
            'PUT' => "putMethod",
            'DELETE' => "deleteMethod",
            'CONNECT' => "connectMethod",
            'OPTIONS' => "optionsMethod",
            'TRACE' => "traceMethod",
            'PATCH' => "patchMethod"
        );
        $this->methodsValidators = array();
    }

    public function processRequest()
    {
        $response = $this->getResponse();
        header($response->getStatus());
        if ($response->getBody()) {
            echo(json_encode($response->getBody()));
        }
    }

    public function getResponse(): Response
    {
        if (array_key_exists(
            $this->requestMethod,
            $this->methodsValidators
        )) {
            $validatorClass =
                $this->methodsValidators[$this->requestMethod];
            $verdict = (new $validatorClass())->check($this->getData());
            if ($verdict) {
                return new Response(
                    StatusCode::CLIENT_ERROR_400,
                    json_encode(array(
                        "data" => $verdict
                    ))
                );
            }
        }
        $functionMethod = $this->methodsFunctions[$this->requestMethod]
            ?? "methodNotAllowedResponse";
        return $this->$functionMethod();
    }

    public function getMethod(): Response
    {
        return $this->methodNotAllowedResponse();
    }

    public function postMethod(): Response
    {
        return $this->methodNotAllowedResponse();
    }

    public function putMethod(): Response
    {
        return $this->methodNotAllowedResponse();
    }

    public function deleteMethod(): Response
    {
        return $this->methodNotAllowedResponse();
    }

    public function connectMethod(): Response
    {
        return $this->methodNotAllowedResponse();
    }

    public function optionsMethod(): Response
    {
        return $this->methodNotAllowedResponse();
    }

    public function traceMethod(): Response
    {
        return $this->methodNotAllowedResponse();
    }

    public function patchMethod(): Response
    {
        return $this->methodNotAllowedResponse();
    }

    public function unprocessableEntityResponse(): Response
    {
        return new Response(
            StatusCode::CLIENT_ERROR_422,
            array(
                'data' => 'Invalid input'
            )
        );
    }

    public function notFoundResponse(): Response
    {
        return new Response(
            StatusCode::CLIENT_ERROR_404,
            array(
                'data' => 'Not Found'
            )
        );
    }

    public function methodNotAllowedResponse(): Response
    {
        return new Response(
            StatusCode::CLIENT_ERROR_405,
            array(
                'data' => 'Method Not Allowed'
            )
        );
    }

    public function getDatabase()
    {
        return $this->db;
    }

    public function getData(): array
    {
        return (array)json_decode(file_get_contents('php://input'));
    }

    public function getDB()
    {
        return $this->db;
    }

    public function addMethodFunction($methodKey, $methodFunction)
    {
        $this->methodsFunctions[$methodKey] = $methodFunction;
    }

    public function addMethodValidator($methodKey, $methodValidator)
    {
        $this->methodsValidators[$methodKey] = $methodValidator;
    }

    public function redirect($url)
    {
        header('Location: https://' . preg_replace(array('/^https:/', '/^http/',), '', $url));
    }
}
