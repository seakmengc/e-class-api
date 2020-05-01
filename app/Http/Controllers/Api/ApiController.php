<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as  BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ApiController extends BaseController
{
    protected function created($data)
    {
        return response()->json(['data' => $data], Response::HTTP_CREATED);
    }

    protected function updated($data)
    {
        return response()->json(['data' => $data], Response::HTTP_OK);
    }

    protected function deleted()
    {
        return response()->json([], Response::HTTP_NO_CONTENT);
    }

    protected function ok_with_data($data = null)
    {
        return response()->json(['data' => $data], Response::HTTP_OK);
    }

    protected function ok_with_msg($msg)
    {
        return response()->json([
            'message' => $msg
        ], Response::HTTP_OK);
    }

    protected function msg_with_code($msg, $code)
    {
        return response()->json(['message' => $msg], $code);
    }

    protected function errors($errors)
    {
        return response()->json([
            'message' => 'The given data was invalid.',
            'errors' => $errors
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
