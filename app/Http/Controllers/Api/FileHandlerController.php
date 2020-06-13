<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Identity;
use App\Models\User;
use Arr;
use Illuminate\Support\Str;

class FileHandlerController extends Controller
{
    public function __invoke(Request $request)
    {
        $params = array_filter(explode('/', $request->getRequestUri()), fn ($value) => !empty($value));

        if (reset($params) === 'portraits') {
            $media = Identity::whereUserId(next($params))->firstOrFail()->getFirstMedia();
            return response()->file($media->getPath('thumb'));
        }
    }
}
