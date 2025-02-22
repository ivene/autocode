@php
    echo "<?php".PHP_EOL;
@endphp
namespace App\Http\Controllers\{{$project}};

use App\Http\Controllers\Controller;
use App\Http\Requests\{{ $project }}\Save{{ $modelName }}Request;
use App\Models\Admin\SysAdminUser;
use App\Models\{{ $project }}\Base\Base{{ $modelName }};
use App\Models\{{ $project }}\{{ $modelName }};
use App\Services\AdminUser;
use App\Tools\Constant;
use App\Tools\Result;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class {{ $modelName }}Controller extends Controller
{
    private $adminUser;
    public function __construct(AdminUser $adminUser)
    {
    $this->adminUser = $adminUser;
    }

    public function getList(): View|Factory|Application
    {
    return view("{{ strtolower($project) }}.{{$tableinfo->name}}.list");
    }

    public function getListData(): JsonResponse
    {
        $query = {{$modelName}}::listAll();
        $datatable = DataTables::eloquent($query);
        return $datatable->make();
    }


    public function disable(Request $request): JsonResponse
    {
        Log::info("禁用信息{{$modelName}}",$request->all());
        $result =new Result();
        $id = $request->id;
        if($this->adminUser->isAdmin()){
            if($request->ajax()) {
                try {
                    $info = {{$modelName}}::id($id)->first();
                    $info->status = $request->status;
                    $info->save();
                    $result->code = Constant::OK;
                    $result->msg = "操作成功";
                } catch (\Exception $e) {
                    Log::error($e);
                    Log::error("==========".$e->getFile().";".$e->getLine().";".$e->getMessage());
                    $result->msg  = "操作失败:".$e->getMessage();
                }
            }else{
                $result->msg  = "Invalid Request";
            }
        }else{
            $result->msg  = "没有权限";
        }
        return response()->json(fixResult($result));
    }


    public function save(Save{{$modelName}}Request $request): JsonResponse
    {
        Log::info("编辑信息",$request->all());
        $result =new Result();
        $id = $request->id;
        if($request->ajax()) {
            try {
                if(empty($id)){
                    $info =  new Base{{$modelName}}();
                }else{
                    $info = {{$modelName}}::id($id)->first();
                }
                $info->fill($request->all());
                $info->save();
                $result->code = Constant::OK;
                $result->msg = "操作成功";
            } catch (\Exception $e) {
                Log::error($e);
                Log::error("==========".$e->getFile().";".$e->getLine().";".$e->getMessage());
                $result->msg  = "操作失败:".$e->getMessage();
            }
        }else{
            $result->msg  = "Invalid Request";
        }
        return response()->json(fixResult($result));
    }
}
//Auto Created at {{\Carbon\Carbon::now()->toDateTimeString()}}

