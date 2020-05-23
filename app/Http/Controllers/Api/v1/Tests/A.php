<?php

namespace App\Http\Controllers\Tests;

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Controller;
use App\Models\Tests\A;
use App\Http\Requests\Tests\ARequest;
use App\Http\Resources\Tests\AResource;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AController extends Controller
{
    public function index()
    {

        // $this->authorize("viewAny", A::class);

        $datas = A::get();

        $datas = (count($datas) == 0 ? ["message" => "Record not Found"] : AResource::collection($datas));

        return response()->json($datas, Response::HTTP_OK);
    }

    public function store(ARequest $request)
    {

        // $this->authorize("create", A::class);

        $data = $request->validated();

        $data = A::create($data);

        $data = new AResource($data);

        return response()->json($data, Response::HTTP_OK);
    }

    public function show(A $a)
    {

        // $this->authorize("view", A::class);

        $data = new AResource($a);

        return response()->json($data, Response::HTTP_OK);
    }

    public function update(ARequest $request, A $a)
    {

        // $this->authorize("update", A::class);

        $data = $request->validated();

        $a->update($data);

        $data = new AResource($a);

        return response()->json($data, Response::HTTP_OK);
    }

    public function destroy(A $a)
    {

        // $this->authorize("delete", A::class);

        $a->delete();

        $data = ["message" => "Data Delete successfully !!!"];

        return response()->json($data, Response::HTTP_OK);
    }

    public function restore($id)
    {

        // only super admin can access, and check with middleware at the __construct function

        $data = A::onlyTrashed()->findOrFail($id);

        $data->restore();

        $data = ["message" => "Data Restore successfully !!!"];

        return response()->json($data, Response::HTTP_OK);
    }

    public function forceDestroy($id)
    {

        // only super admin can access, and check with middleware at the __construct function

        $data = A::withTrashed()->findOrFail($id);

        $data->forceDelete();

        $data = ['message' => "Data Force Delete Successfully !!!"];

        return response()->json($data, Response::HTTP_OK);
    }
}
