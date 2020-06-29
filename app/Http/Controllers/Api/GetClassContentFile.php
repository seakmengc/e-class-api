<?php

namespace App\Http\Controllers\Api;

use App\Models\Classes;
use App\Models\ClassContent;
use App\Http\Controllers\Controller;
use App\Exceptions\CustomException;

class GetClassContentFile extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(ClassContent $classContent)
    {
        $media = $classContent->getFirstMedia('class-content');

        if (!$media)
            throw new CustomException('File not found');

        return response()->download($media->getPath(), $media->file_name);
    }
}
