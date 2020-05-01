<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\ApiController;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;

class Controller extends ApiController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
