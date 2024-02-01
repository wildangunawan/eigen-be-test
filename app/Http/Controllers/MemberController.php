<?php

namespace App\Http\Controllers;

use App\Http\Resources\MemberResource;
use App\Models\Member;
use OpenApi\Annotations as OA;

class MemberController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/v1/members",
     *      tags={"Members"},
     *      summary="API to list all members and its borrowing status.",
     *      operationId="members-index",
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
            MemberResource::collection(Member::paginate())
                ->response()
                ->getData(true)
        );
    }
}
