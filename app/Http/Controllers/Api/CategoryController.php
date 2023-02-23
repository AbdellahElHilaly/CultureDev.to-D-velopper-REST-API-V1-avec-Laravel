<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;

use Illuminate\Http\Response;

use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;

use App\Http\Controllers\Controller;

use App\Http\Controllers\Traits\ExceptionHandlerTrait;
use App\Http\Controllers\Traits\ApiResponceTrait;


class CategoryController extends Controller
{
    use ExceptionHandlerTrait;
    use ApiResponceTrait;
    public function index(){
        try {
            $categories = CategoryResource::collection(Category::all());
            if ($categories->isEmpty()) {
                throw new \Exception("No categories found.", Response::HTTP_NOT_FOUND);
            }
            return $this->apiResponse($categories, Response::HTTP_OK, "Successfully retrieved " . $categories->count() . " Categories");
        } catch (\Exception $e) {
            return $this->handleException($e);
        }
    }


    public function store(CategoryRequest $request){
        try {
            $data = $request->validated(); // stop code and return message error if not valide
            $category = Category::create($data);
            return $this->apiResponse(new CategoryResource($category), Response::HTTP_CREATED, "Category created successfully");
        } catch (\Exception $e) {
            return $this->handleException($e);
        }
    }


    public function show(string $id){
        try {
            $category = Category::findOrFail($id);
            return $this->apiResponse(new CategoryResource($category));
        } catch (\Exception $e) {
            return $this->handleException($e);
        }
    }

    public function update(CategoryRequest $request, string $id){
        try {
            $category = Category::findOrFail($id);
            $data = $request->validated();
            $category->update($data);
            return $this->apiResponse(new CategoryResource($category), Response::HTTP_OK, "Category updated successfully");
        } catch (\Exception $e) {
            return $this->handleException($e);
        }
    }

    public function destroy(string $id){

        if($id == "deleteAll") return $this->destroyAll();
        try {
            $category = Category::findOrFail($id);
            $category->delete();
            return $this->apiResponse(null, Response::HTTP_NO_CONTENT, "Category deleted successfully");
        } catch (\Exception $e) {
            return $this->handleException($e);
        }
    }


    private function destroyAll()
    {
        try {
            if (Category::count() == 0) {
                return $this->apiResponse(null, Response::HTTP_NOT_FOUND, "No tags found to delete");
            }

            Category::truncate();
            return $this->apiResponse(null, Response::HTTP_NO_CONTENT, "All tags deleted successfully");
        } catch (\Exception $e) {
            return $this->handleException($e);
        }
    }





}