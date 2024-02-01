<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;
use OpenApi\Annotations as OA;
use Throwable;

/**
 * @OA\Info(title="Eigen - BE Test Case", version="1.0.0", description="When integrating with other client, set header Accept: application/json for every request, otherwise API may not behave correctly.")
 */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    const RESPONSE_STATUS_SUCCESS = 1;
    const RESPONSE_STATUS_FAIL = 0;

    /**
     * @param Throwable $err
     * @param array $data
     * @return JsonResponse
     */
    protected function respondError(Throwable $err, array $data = []): JsonResponse
    {

        $class = get_class($err);
        if ($class == ModelNotFoundException::class) {
            createLog($err, 'warning');
            return $this->respondNotFound();
        } else if ($class == QueryException::class) {
            $error = $err->errorInfo;
            if ($error[1] == 1451) {
                createLog($err);
                return $this->respondIntegrityConstraintViolation();
            }
        } else if ($class == \Exception::class) {
            createLog($err, 'warning');
            return response()->json([
                'status' => self::RESPONSE_STATUS_FAIL,
                'message' => $err->getMessage(),
                'data' => $data,
            ], $err->getCode() !== 0 ? $err->getCode() : 400);
        }

        createLog($err);

        if (app()->environment('local') || app()->environment('testing')) {
            return response()->json([
                'status' => self::RESPONSE_STATUS_FAIL,
                'message' => $err->getMessage(),
                'file' => $err->getFile(),
                'line' => $err->getLine(),
                'data' => [],
                'traceAsString' => $err->getTraceAsString(),
            ], array_key_exists($err->getCode(), Response::$statusTexts) ? $err->getCode() : 500);
        } else {
            return response()->json([
                'status' => self::RESPONSE_STATUS_FAIL,
                'message' => 'Something went wrong in processing request.',
            ], array_key_exists($err->getCode(), Response::$statusTexts) ? $err->getCode() : 500);
        }
    }

    /**
     * @param string $msg
     *
     * @return JsonResponse
     */
    protected function respondNotFound(string $msg = 'Data Not Found'): JsonResponse
    {
        return response()->json([
            'status' => self::RESPONSE_STATUS_FAIL,
            'message' => $msg,
        ], 404);
    }

    /**
     *
     * @return JsonResponse
     */
    protected function respondIntegrityConstraintViolation(): JsonResponse
    {
        return response()->json([
            'status' => self::RESPONSE_STATUS_FAIL,
            'message' => 'Cannot delete this data because it is used in other data',
        ], 400);
    }

    /**
     * @param mixed $data
     * @param string $msg
     *
     * @return JsonResponse
     */
    protected function respondSuccess(mixed $data, string $msg = ''): JsonResponse
    {
        return response()->json([
            'status' => self::RESPONSE_STATUS_SUCCESS,
            'message' => $msg,
            'data' => $data,
        ], 200);
    }

    /**
     * @param null $msg
     *
     * @return JsonResponse
     */
    protected function respondUnauthorized($msg = null): JsonResponse
    {
        return response()->json([
            'status' => self::RESPONSE_STATUS_FAIL,
            'message' => $msg ?? 'Unauthorized',
            'data' => [],
        ], 401);
    }

    /**
     * @param string $msg
     *
     * @return JsonResponse
     */
    protected function respondSuccessWithMessage(string $msg): JsonResponse
    {
        return response()->json([
            'status' => self::RESPONSE_STATUS_SUCCESS,
            'message' => $msg,
        ], 200);
    }

    /**
     * @param string $msg
     *
     * @return JsonResponse
     */
    protected function respondErrorWithMessage(string $msg): JsonResponse
    {
        return response()->json([
            'status' => self::RESPONSE_STATUS_FAIL,
            'message' => $msg,
        ], 400);
    }

    /**
     * @param string $msg
     * @param int $code
     *
     * @return JsonResponse
     */
    protected function respondCustomError(string $msg = 'Some error occurs', int $code = 400): JsonResponse
    {
        return response()->json([
            'status' => self::RESPONSE_STATUS_FAIL,
            'message' => $msg,
        ], $code);
    }
}
