@php
    echo "<?php".PHP_EOL;
@endphp

/**
 * @description AutoCode
 * @author YaoYao
 * @time {{$nowtime}}
 */
namespace App\Services\{{$project}};


use App\Models\{{$project}}\Base\Base{{$modelName}};
use App\Models\{{$project}}\{{$modelName}};
use App\Tools\Constant;
use App\Tools\Result;

class {{$modelName}}Services
{

    /**
     * 保存{{$modelName}}信息
     *
     * AutoCode自动生成 未完善
     *
     * @param $uid
     * @param $data
     * @param int $id
     * @return Result
     * @author YaoYao
     * @time {{$nowtime}}
     */
    public function saveData($uid, $data, int $id=0): Result
    {
        $result = new Result();
        if($id == 0){
            $info =  new Base{{$modelName}}();
        }else{
            $info = {{$modelName}}::id($id)->uid($uid)->first();
            if(empty($info)){
                $result->msg = trans('sys.信息不存在');
                return fixResult($result);
            }
        }
        $info->fill($data);
        $info->save();
        $result->code = Constant::OK;
        return fixResult($result);
    }

    /**
     * 删除{{$modelName}}
     *
     *
     * AutoCode自动生成 未完善
     *
     * @param $uid
     * @param $id
     * @return Result
     * @author YaoYao
     * @time {{$nowtime}}
     */
    public function deleteById($uid,$id): Result
    {
        $result = new Result();
        $info = {{$modelName}}::id($id)->uid($uid)->delete();
        $result->code = Constant::OK;
        return fixResult($result);
    }

    /**
     * 获取{{$modelName}}信息
     *
     * AutoCode自动生成 未完善
     *
     * @param $uid
     * @param $id
     * @return Result
     * @author YaoYao
     * @time {{$nowtime}}
     */
    public function getInfoById($uid,$id): Result
    {
        $result = new Result();
        $info = {{$modelName}}::id($id)->uid($uid)->first();
        if(!empty($info)){
            $result->data = $info;
            $result->code = Constant::OK;
        }else{
            $result->msg = trans('sys.信息不存在');
        }
        return fixResult($result);
    }

 }
