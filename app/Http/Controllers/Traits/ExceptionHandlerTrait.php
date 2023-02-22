<?php

namespace App\Http\Controllers\Traits;

use Illuminate\Http\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
trait ExceptionHandlerTrait
{
    private function getModelName(): string
    {
        $fullClassName = get_class($this);
        $classNameParts = explode('\\', $fullClassName);
        $controllerName = end($classNameParts);
        return str_replace("Controller", "", $controllerName);
    }


    private function handleException(\Exception $e)
    {
        $modelName = $this->getModelName();

        if ($e instanceof ModelNotFoundException) {
            return $this->apiResponse(null, Response::HTTP_NOT_FOUND, "$modelName not found");
        } else if ($e instanceof ValidationException) {
            return $this->apiResponse(null, Response::HTTP_UNPROCESSABLE_ENTITY, $e->getMessage());
        } else if ($e instanceof QueryException) {
            if ($e->errorInfo[1] == 1062) {
                return $this->apiResponse(null, Response::HTTP_CONFLICT, "$modelName already exists");
            } else if ($e->errorInfo[1] == 2002) {
                return $this->apiResponse(null, Response::HTTP_INTERNAL_SERVER_ERROR, "Unable to connect to database");
            }
        }
        return $this->apiResponse(null, Response::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
    }
}

