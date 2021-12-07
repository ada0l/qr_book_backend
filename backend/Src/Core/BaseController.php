<?php

namespace Src\Core;

class BaseController
{
  private $db;
  private $requestMethod;
  private $methodsFunctions;
  private $methodsValidators;

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
      echo $response->getBody();
    }
  }

  public function getResponse()
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
    $response = $this->$functionMethod();
    return $response;
  }

  public function getMethod()
  {
    return $this->methodNotAllowedResponse();
  }

  public function headMethod()
  {
    return $this->methodNotAllowedResponse();
  }

  public function postMethod()
  {
    return $this->methodNotAllowedResponse();
  }

  public function putMethod()
  {
    return $this->methodNotAllowedResponse();
  }

  public function deleteMethod()
  {
    return $this->methodNotAllowedResponse();
  }

  public function connectMethod()
  {
    return $this->methodNotAllowedResponse();
  }

  public function optionsMethod()
  {
    return $this->methodNotAllowedResponse();
  }

  public function traceMethod()
  {
    return $this->methodNotAllowedResponse();
  }

  public function patchMethod()
  {
    return $this->methodNotAllowedResponse();
  }

  public function unprocessableEntityResponse()
  {
    return new Response(
      StatusCode::CLIENT_ERROR_422,
      json_encode(array(
        'data' => 'Invalid input'
      ))
    );
  }

  public function notFoundResponse()
  {
    return new Response(
      StatusCode::CLIENT_ERROR_404,
      json_encode(array(
        'data' => 'Not Found'
      ))
    );
  }

  public function methodNotAllowedResponse()
  {
    return new Response(
      StatusCode::CLIENT_ERROR_405,
      json_encode(array(
        'data' => 'Method Not Allowed'
      ))
    );
  }

  public function getDatabase()
  {
    return $this->db;
  }

  public function getData()
  {
    return (array) json_decode(file_get_contents('php://input'));
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
}
