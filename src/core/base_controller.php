<?php

class StatusCode
{
  public const OK_200 = 'HTTP/1.1 200 OK';
  public const OK_201 = 'HTTP/1.1 201 Created';
  public const ERROR_401 = 'HTTP/1.0 401 Unauthorized';
  public const ERROR_422 = 'HTTP/1.1 422 Unprocessable Entity';
  public const ERROR_404 = 'HTTP/1.1 404 Not Found';
}

class Response
{
  private $status_code;
  private $body;

  public function __construct($status_code = null, $body = null)
  {
    $this->status_code = $status_code;
    if ($status_code == null) {
      $status_code = StatusCode::OK_200;
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

class BaseController
{
  private $db;
  private $requestMethod;

  public function __construct($db, $requestMethod)
  {
    $this->db = $db;
    $this->requestMethod = $requestMethod;
  }

  public function processRequest()
  {
    switch ($this->getMethod()) {
      case 'GET':
        $response = $this->get_method();
        break;
      case 'HEAD':
        $response = $this->head_method();
        break;
      case 'POST':
        $response = $this->post_method();
        break;
      case 'PUT':
        $response = $this->put_method();
        break;
      case 'DELETE':
        $response = $this->delete_method();
        break;
      case 'CONNECT':
        $response = $this->connect_method();
        break;
      case 'OPTIONS':
        $response = $this->options_method();
        break;
      case 'TRACE':
        $response = $this->trace_method();
        break;
      case 'PATCH':
        $response = $this->patch_method();
        break;
      default:
        $response = $this->notFoundResponse();
        break;
    }
    header($response->getStatus());
    if ($response->getBody()) {
      echo $response->getBody();
    }
  }

  public function get_method()
  {
    return $this->notFoundResponse();
  }

  public function head_method()
  {
    return $this->notFoundResponse();
  }

  public function post_method()
  {
    return $this->notFoundResponse();
  }

  public function put_method()
  {
    return $this->notFoundResponse();
  }

  public function delete_method()
  {
    return $this->notFoundResponse();
  }

  public function connect_method()
  {
    return $this->notFoundResponse();
  }

  public function options_method()
  {
    return $this->notFoundResponse();
  }

  public function trace_method()
  {
    return $this->notFoundResponse();
  }

  public function patch_method()
  {
    return $this->notFoundResponse();
  }

  public function unprocessableEntityResponse()
  {
    $response = new Response(StatusCode::ERROR_422, [
      'error' => 'Invalid input'
    ]);
    return $response;
  }

  public function notFoundResponse()
  {
    $response = new Response(StatusCode::ERROR_404, null);
    return $response;
  }

  public function getDatabase()
  {
    return $this->db;
  }

  public function getMethod()
  {
    return $this->requestMethod;
  }

  public function getData()
  {
    return (array) json_decode(file_get_contents('php://input'));
  }
}
