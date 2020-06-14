<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\CustomException;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Exam;
use App\Http\Controllers\Controller;
use App\Models\StudentExam;

class GetStudentUploadedFileInExam extends Controller
{
    public function __invoke(User $user, Exam $exam, $questionId)
    {
        $studentExam = $exam->submittings()->whereStudentId($user->id)->first();

        $media = $studentExam->getFirstMedia($exam->id . '.' . $questionId);

        if (!$media)
            throw new CustomException('File not found');

        return response()->download($media->getPath(), $media->file_name);
    }
}
