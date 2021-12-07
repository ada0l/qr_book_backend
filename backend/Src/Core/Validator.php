<?php

namespace Src\Core;

class Validator
{
  private $fields = null;
  private $prohibitOtherFields;

  public function __construct($fields, $prohibitOtherFields)
  {
    $this->fields = $fields;
    $this->prohibitOtherFields = $prohibitOtherFields;
  }

  public function check($inputJson)
  {
    $errors = array();

    // check not expected fields in input
    if ($this->prohibitOtherFields) {
      foreach (array_keys($inputJson) as $field) {
        if (!isset($this->fields[$field])) {
          array_push($errors, "{$field} field is no expected");
        }
      }
    }

    foreach ($this->fields as $field => $funcs) {
      if (!isset($inputJson[$field])) {
        array_push($errors, "{$field} field is not set");
        continue;
      }
      foreach ($funcs as $func) {
        if (is_array($func)) {
          $func_name = $func[0];
          $verdict_of_function = $this->$func_name(
            $inputJson[$field],
            ...$func[1]
          );
        } else {
          $verdict_of_function = $this->$func($inputJson[$field]);
        }
        if ($verdict_of_function != null) {
          array_push($errors, "{$field} field {$verdict_of_function}");
          break;
        }
      }
    }
    return $errors;
  }

  public static function isInt($data)
  {
    if (!filter_var($data, FILTER_VALIDATE_INT)) {
      return 'is not int';
    }
    return null;
  }

  public static function isEmail($data)
  {
    if (!filter_var($data, FILTER_VALIDATE_EMAIL)) {
      return 'is not email';
    }
    return null;
  }

  public static function lenInRange($data, $begin, $end)
  {
    return Validator::inRange(strlen($data), $begin, $end);
  }

  public static function inRange($data, $begin, $end)
  {
    if ($data > $end) {
      return "is more than {$end}";
    } else if ($data < $begin) {
      return "is smaller than {$begin}";
    }
    return null;
  }
}
