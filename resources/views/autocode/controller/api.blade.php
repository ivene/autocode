@php
    echo "<?php".PHP_EOL;
@endphp
namespace {{$config->namespace->api_controller}};

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Create{{$modelName}}Request;
use App\Http\Requests\Api\Update{{$modelName}}Request;
use App\Models\{{$project}}\Base\Base{{$modelName}};
use App\Models\{{$project}}\{{$modelName}};
use App\Services\{{$project}}\{{$modelName}}Services;
use App\Tools\Constant;
use App\Tools\Result;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class {{$modelName}}ApiController extends Controller
{
    protected {{$modelName}}Services ${{$objectName}}Services;

    public function __construct({{$modelName}}Services ${{$objectName}}Services)
    {

        $this->{{$objectName}}Services = ${{$objectName}}Services;
    }

    /**
     * 创建{{$modelName}}
     *
     * AutoCode自动生成 未完善
     *
     * @group {{$modelName}}
     * @param Create{{$modelName}}Request $request
     * @return JsonResponse
     * @author YaoYao
     * @time {{$nowtime}}
     */
    public function createNew(Create{{$modelName}}Request $request): JsonResponse
    {
        Log::info("创建{{$modelName}}信息 =".json_encode($request->all(),256));

        $result =  $this->{{$objectName}}Services->saveData($request->uid,$request->all(),0);
        return response()->json(fixResult($result));
    }

    /**
     * 更新{{$modelName}}信息
     *
     * AutoCode自动生成 未完善
     *
     * @group {{$modelName}}
     * @param Update{{$modelName}}Request $request
     * @return JsonResponse
     * @author YaoYao
     * @time {{$nowtime}}
     */
    public function updateById(Update{{$modelName}}Request $request): JsonResponse
    {
        Log::info("更新{{$modelName}}信息 =".json_encode($request->all(),256));
        $result =  $this->{{$objectName}}Services->saveData($request->uid,$request->all(),$request->id);
        return response()->json(fixResult($result));
    }

    /**
     * 删除{{$modelName}}
     *
     *
     * AutoCode自动生成 未完善
     *
     * @group {{$modelName}}
     *
     * @queryParam id int required 记录唯一ID. Example:1
     * @queryParam uid int required 用户ID. Example:1
     * @param Request $request
     * @return JsonResponse
     * @author YaoYao
     * @time {{$nowtime}}
     */
    public function deleteById(Request $request): JsonResponse
    {
        Log::info("删除{{$modelName}}信息 =".json_encode($request->all(),256));

        $result =  $this->{{$objectName}}Services->deleteById($request->uid,$request->id);

        return response()->json(fixResult($result));
    }

    /**
     * 获得{{$modelName}}信息
     *
     * AutoCode自动生成 未完善
     *
     * @queryParam id int required 记录唯一ID. Example:1
     * @queryParam uid int required 用户编号. Example:1

     * @group {{$modelName}}
     * @param Request $request
     * @return JsonResponse
     * @author YaoYao
     * @time 2023/9/8 17:47
     */
    public function getInfo(Request $request): JsonResponse
    {
        Log::info("获得{{$modelName}}信息 =".json_encode($request->all(),256));
        $result =  $this->{{$objectName}}Services->getInfoById($request->uid,$request->id);
        return response()->json(fixResult($result));
    }
}
