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

    private function getForeignIdError($errorMessage)
    {
        preg_match('/FOREIGN KEY \(`([^\)]+)\) REFERENCES/', $errorMessage, $matches);
        if (count($matches) >= 2) {
            return "foreign key error : " . $matches[1] . " not found !";
        }
        return null;
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
                return $this->apiResponse(null, Response::HTTP_CONFLICT, "Database error : $modelName already exists");
            } else if ($e->errorInfo[1] == 2002) {
                return $this->apiResponse(null, Response::HTTP_INTERNAL_SERVER_ERROR, "Unable to connect to database");
            } else if ($e->errorInfo[1] == 1701) {
                return $this->apiResponse(null, Response::HTTP_INTERNAL_SERVER_ERROR, "Cannot truncate a table referenced in a foreign key constraint");
            } else if ($e->errorInfo[1] == 1452) {
                return $this->apiResponse(null, Response::HTTP_INTERNAL_SERVER_ERROR, $this->getForeignIdError($e->getMessage()));
            }
        }

        return $this->apiResponse(null, Response::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
    }
}
