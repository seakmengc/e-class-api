<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Exceptions\CustomException;

class GetPortrait extends Controller
{
    public function __invoke(User $user)
    {
        $media = $user->identity->getFirstMedia();

        if (!$media)
            throw new CustomException('File not found');

        return response()->download($media->getPath('thumb'), $media->file_name);
    }
}
