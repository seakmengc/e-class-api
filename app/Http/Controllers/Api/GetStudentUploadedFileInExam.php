<?php

namespace App\Http\Controllers\Api;

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

        return response()->download($media->getPath(), $media->file_name);
    }
}
