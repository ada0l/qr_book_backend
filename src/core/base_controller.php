<?php

class StatusCode
{
  public const INFORMATION_100 = 'HTTP/1.1 100 Continue';
  public const INFORMATION_101 = 'HTTP/1.1 101 Switching Protocols';
  public const INFORMATION_102 = 'HTTP/1.1 102 Processing';
  public const INFORMATION_103 = 'HTTP/1.1 103 Early Hints';

  public const SUCCESS_200 = 'HTTP/1.1 200 OK';
  public const SUCCESS_201 = 'HTTP/1.1 201 Created';
  public const SUCCESS_202 = 'HTTP/1.1 202 Accepted';
  public const SUCCESS_203 = 'HTTP/1.1 203 Non-Authoritative Information';
  public const SUCCESS_204 = 'HTTP/1.1 204 No Content';
  public const SUCCESS_205 = 'HTTP/1.1 205 Reset Content';
  public const SUCCESS_206 = 'HTTP/1.1 206 Partial Content';
  public const SUCCESS_207 = 'HTTP/1.1 207 Multi-Status';
  public const SUCCESS_208 = 'HTTP/1.1 208 Already Reported';
  public const SUCCESS_226 = 'HTTP/1.1 226 IM Used';

  public const REDIRECTION_300 = 'HTTP/1.1 300 Multiple Choices';
  public const REDIRECTION_301 = 'HTTP/1.1 301 Moved Permanently';
  public const REDIRECTION_302 = 'HTTP/1.1 302 Moved Temporarily';
  public const REDIRECTION_303 = 'HTTP/1.1 303 See Other';
  public const REDIRECTION_304 = 'HTTP/1.1 304 Not Modified';
  public const REDIRECTION_305 = 'HTTP/1.1 305 Use Proxy';
  public const REDIRECTION_307 = 'HTTP/1.1 307 Temporary Redirect';
  public const REDIRECTION_308 = 'HTTP/1.1 308 Permanent Redirect';

  public const CLIENT_ERROR_400 = 'HTTP/1.1 400 Bad Request';
  public const CLIENT_ERROR_401 = 'HTTP/1.1 401 Unauthorized';
  public const CLIENT_ERROR_402 = 'HTTP/1.1 402 Payment Required';
  public const CLIENT_ERROR_403 = 'HTTP/1.1 403 Forbidden';
  public const CLIENT_ERROR_404 = 'HTTP/1.1 404 Not Found';
  public const CLIENT_ERROR_405 = 'HTTP/1.1 405 Method Not Allowed';
  public const CLIENT_ERROR_406 = 'HTTP/1.1 406 Not Acceptable';
  public const CLIENT_ERROR_407 = 'HTTP/1.1 407 Proxy Authentication Required';
  public const CLIENT_ERROR_408 = 'HTTP/1.1 408 Request Timeout';
  public const CLIENT_ERROR_409 = 'HTTP/1.1 409 Conflict';
  public const CLIENT_ERROR_410 = 'HTTP/1.1 410 Gone';
  public const CLIENT_ERROR_411 = 'HTTP/1.1 411 Length Required';
  public const CLIENT_ERROR_412 = 'HTTP/1.1 412 Precondition Failed';
  public const CLIENT_ERROR_413 = 'HTTP/1.1 413 Payload Too Large';
  public const CLIENT_ERROR_414 = 'HTTP/1.1 414 URI Too Long';
  public const CLIENT_ERROR_415 = 'HTTP/1.1 415 Unsupported Media Type';
  public const CLIENT_ERROR_416 = 'HTTP/1.1 416 Range Not Satisfiable';
  public const CLIENT_ERROR_417 = 'HTTP/1.1 417 Expectation Failed';
  public const CLIENT_ERROR_418 = 'HTTP/1.1 418 I’m a teapot';
  public const CLIENT_ERROR_419 = 'HTTP/1.1 419 Authentication Timeout';
  public const CLIENT_ERROR_421 = 'HTTP/1.1 421 Misdirected Request';
  public const CLIENT_ERROR_422 = 'HTTP/1.1 422 Unprocessable Entity';
  public const CLIENT_ERROR_423 = 'HTTP/1.1 423 Locked';
  public const CLIENT_ERROR_424 = 'HTTP/1.1 424 Failed Dependency';
  public const CLIENT_ERROR_425 = 'HTTP/1.1 425 Too Early';
  public const CLIENT_ERROR_426 = 'HTTP/1.1 426 Upgrade Required';
  public const CLIENT_ERROR_428 = 'HTTP/1.1 428 Precondition Required';
  public const CLIENT_ERROR_429 = 'HTTP/1.1 429 Too Many Requests';
  public const CLIENT_ERROR_431 = 'HTTP/1.1 431 Request Header Fields Too Large';
  public const CLIENT_ERROR_449 = 'HTTP/1.1 449 Retry With';
  public const CLIENT_ERROR_451 = 'HTTP/1.1 451 Unavailable For Legal Reasons';
  public const CLIENT_ERROR_499 = 'HTTP/1.1 499 Client Closed Request';

  public const SERVER_ERROR_500 = 'HTTP/1.1 500 Internal Server Error';
  public const SERVER_ERROR_501 = 'HTTP/1.1 501 Not Implemented';
  public const SERVER_ERROR_502 = 'HTTP/1.1 502 Bad Gateway';
  public const SERVER_ERROR_503 = 'HTTP/1.1 503 Service Unavailable';
  public const SERVER_ERROR_504 = 'HTTP/1.1 504 Gateway Timeout';
  public const SERVER_ERROR_505 = 'HTTP/1.1 505 HTTP Version Not Supported';
  public const SERVER_ERROR_506 = 'HTTP/1.1 506 Variant Also Negotiates';
  public const SERVER_ERROR_507 = 'HTTP/1.1 507 Insufficient Storage';
  public const SERVER_ERROR_508 = 'HTTP/1.1 508 Loop Detected';
  public const SERVER_ERROR_509 = 'HTTP/1.1 509 Bandwidth Limit Exceeded';
  public const SERVER_ERROR_510 = 'HTTP/1.1 510 Not Extended';
  public const SERVER_ERROR_511 = 'HTTP/1.1 511 Network Authentication Required';
  public const SERVER_ERROR_520 = 'HTTP/1.1 520 Unknown Error';
  public const SERVER_ERROR_521 = 'HTTP/1.1 521 Web Server Is Down';
  public const SERVER_ERROR_522 = 'HTTP/1.1 522 Connection Timed Out';
  public const SERVER_ERROR_523 = 'HTTP/1.1 523 Origin Is Unreachable';
  public const SERVER_ERROR_524 = 'HTTP/1.1 524 A Timeout Occurred';
  public const SERVER_ERROR_525 = 'HTTP/1.1 525 SSL Handshake Failed';
  public const SERVER_ERROR_526 = 'HTTP/1.1 526 Invalid SSL Certificate';
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
  private $params;

  public function __construct($db, $requestMethod, $params)
  {
    $this->db = $db;
    $this->requestMethod = $requestMethod;
    $this->params = $params;
  }

  public function processRequest()
  {
    $response = $this->getResponse();
    header($response->getStatus());
    if ($response->getBody()) {
      echo $response->getBody();
    }
  }

  public function getResponse() {
    switch ($this->getMethod()) {
      case 'GET':
        $response = $this->getMethod();
        break;
      case 'HEAD':
        $response = $this->headMethod();
        break;
      case 'POST':
        $response = $this->postMethod();
        break;
      case 'PUT':
        $response = $this->putMethod();
        break;
      case 'DELETE':
        $response = $this->deleteMethod();
        break;
      case 'CONNECT':
        $response = $this->connectMethod();
        break;
      case 'OPTIONS':
        $response = $this->optionsMethod();
        break;
      case 'TRACE':
        $response = $this->traceMethod();
        break;
      case 'PATCH':
        $response = $this->patchMethod();
        break;
      default:
        $response = $this->methodNotAllowedResponse();
        break;
    }
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
    return new Response(StatusCode::ERROR_422, array(
      'data' => 'Invalid input'
    ));
  }

  public function notFoundResponse()
  {
    return new Response(StatusCode::CLIENT_ERROR_404, array(
      'data' => 'Not Found'
    ));
  }

  public function methodNotAllowedResponse()
  {
    return new Response(StatusCode::CLIENT_ERROR_405, array(
      'data' => 'Method Not Allowed'
    ));
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
}
