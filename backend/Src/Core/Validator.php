<?php

namespace Src\Core;

class Validator
{
    private $fields;
    private $prohibitOtherFields;

    public function __construct($fields, $prohibitOtherFields)
    {
        $this->fields = $fields;
        $this->prohibitOtherFields = $prohibitOtherFields;
    }

    public function check($inputJson): array
    {
        $errors = array();

        // check not expected fields in input
        if ($this->prohibitOtherFields) {
            foreach (array_keys($inputJson) as $field) {
                if (!isset($this->fields[$field])) {
                    $errors[] = "$field field is no expected";
                }
            }
        }

        foreach ($this->fields as $field => $funcs) {
            if (!isset($inputJson[$field])) {
                $errors[] = "$field field is not set";
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
                    $errors[] = "$field field $verdict_of_function";
                    break;
                }
            }
        }
        return $errors;
    }

    public static function isInt($data): ?string
    {
        if (!filter_var($data, FILTER_VALIDATE_INT)) {
            return 'is not int';
        }
        return null;
    }

    public static function isEmail($data): ?string
    {
        if (!filter_var($data, FILTER_VALIDATE_EMAIL)) {
            return 'is not email';
        }
        return null;
    }

    public static function lenInRange($data, $begin, $end): ?string
    {
        return Validator::inRange(strlen($data), $begin, $end);
    }

    public static function inRange($data, $begin, $end): ?string
    {
        if ($data > $end) {
            return "is more than $end";
        } else if ($data < $begin) {
            return "is smaller than $begin";
        }
        return null;
    }
}
