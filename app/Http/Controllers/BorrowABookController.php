<?php

namespace App\Http\Controllers;

use App\Http\Requests\BorrowABookRequest;
use App\Models\Book;
use App\Models\Member;
use App\Services\BookService;
use Illuminate\Support\Facades\DB;
use OpenApi\Annotations as OA;

class BorrowABookController extends Controller
{
    protected BookService $service;

    public function __construct(BookService $service)
    {
        $this->service = $service;
    }

    /**
     * @OA\Post(
     *      path="/api/v1/books/{book}/borrow",
     *      tags={"Books"},
     *      summary="API to borrow a book",
     *      operationId="book-borrow",
     *      @OA\Parameter(
     *           name="book",
     *           in="path",
     *           description="Book's code",
     *           required=true,
     *       ),
     *      @OA\RequestBody(
     *          @OA\JsonContent(),
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  type="object",
     *                  required={
     *                      "member",
     *                  },
     *                  @OA\Property(property="member", type="string", description="Member's code"),
     *              ),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Book borrowed successfully",
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Validation errors.",
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad request.",
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Internal server error.",
     *      ),
     * )
     */
    public function store(BorrowABookRequest $request, Book $book)
    {
        DB::beginTransaction();

        try {
            // Get the member
            $member = Member::where('code', $request->member)->first();

            // Borrow the book
            $this->service->borrow($book, $member);

            DB::commit();
            return $this->respondSuccessWithMessage('Book borrowed successfully');
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->respondError($th);
        }
    }

    /**
     * @OA\Post(
     *      path="/api/v1/books/{book}/return",
     *      tags={"Books"},
     *      summary="API to return a borrowed book",
     *      operationId="book-return",
     *      @OA\Parameter(
     *           name="book",
     *           in="path",
     *           description="Book's code",
     *           required=true,
     *       ),
     *      @OA\RequestBody(
     *          @OA\JsonContent(),
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  type="object",
     *                  required={
     *                      "member",
     *                  },
     *                  @OA\Property(property="member", type="string", description="Member's code"),
     *              ),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Book returned successfully",
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Validation errors.",
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad request.",
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Internal server error.",
     *      ),
     * )
     */
    public function update(BorrowABookRequest $request, Book $book)
    {
        DB::beginTransaction();

        try {
            // Get the member
            $member = Member::where('code', $request->member)->first();

            // Borrow the book
            $this->service->return($book, $member);

            DB::commit();
            return $this->respondSuccessWithMessage('Book returned successfully');
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->respondError($th);
        }
    }
}
