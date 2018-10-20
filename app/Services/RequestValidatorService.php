<?php

namespace App\Services;

use Illuminate\Http\Request;

/**
 * Class RequestValidator
 * @package App\Services
 */
class RequestValidatorService
{
    /**
     * Check rules from request
     * @param $request
     * @param $rulesFields
     * @return bool
     *
     * @uses required
     * @uses string
     * @uses numeric
     * @uses required_without
     */
    public function validate(Request $request, array $rulesFields) : bool
    {
        foreach ($rulesFields as $field => $rulesField) {
            $rules = explode("|", $rulesField);
            foreach ($rules as $rule) {
                $params = explode(":", $rule);
                $func = array_shift($params);

                if (!$this->$func($request, $field, $params)) {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * @param $request
     * @param $field
     * @return bool
     */
    private function required($request, $field, $params = []) : bool
    {
        return !empty($request->get($field));
    }

    /**
     * @param $request
     * @param $field
     * @return bool
     */
    private function string($request, $field, $params = []) : bool
    {
        return !$request->get($field) || is_string($request->get($field));
    }

    /**
     * @param $request
     * @param $field
     * @return bool
     */
    private function numeric($request, $field, $params = []) : bool
    {
        return $request->get($field) || is_int($request->get($field));
    }

    /**
     * @param $request
     * @param $field
     * @param array $params
     * @return bool
     */
    private function required_without($request, $field, $params = []) : bool
    {
        $emptyParams = false;
        foreach ($params as $param) {
            if (empty($request->get($param))) {
                $emptyParams = true;
                break;
            }
        }

        return $emptyParams
            ? !empty($request->get($field))
            : true;
    }
}