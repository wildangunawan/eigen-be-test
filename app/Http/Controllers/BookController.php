<?php

namespace App\Http\Controllers;

use App\Http\Resources\BookResource;
use App\Models\Book;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

class BookController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/v1/books",
     *      tags={"Books"},
     *      summary="API to list all available books and its borrowing status.",
     *      operationId="books-index",
     *      security={{"sanctum":{}}},
     *      @OA\Parameter(
     *          name="per_page",
     *          in="query",
     *          description="Number of items per page",
     *          required=false,
     *          @OA\Schema(
     *             type="string",
     *             default="10"
     *          ),
     *      ),
     *      @OA\Parameter(
     *          name="page",
     *          in="query",
     *          description="Page #",
     *          required=false,
     *          @OA\Schema(
     *             type="string",
     *             default="1"
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Return books data",
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Internal server error.",
     *      ),
     * )
     */
    public function index()
    {
        return $this->respondSuccess(
            BookResource::collection(Book::paginate())
                ->response()
                ->getData(true)
        );
    }
}
