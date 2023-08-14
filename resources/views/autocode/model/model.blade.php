@php
    echo "<?php".PHP_EOL;
@endphp
namespace App\Models\{{$project}};

use App\Models\{{$project}}\Base\Base{{$modelName}};
use App\MyTrait\ScopeId;
use App\MyTrait\ScopeIsValid;
use App\MyTrait\ScopeListAll;

class {{$modelName}} extends Base{{$modelName}}
{
    use ScopeId,ScopeListAll,ScopeIsValid;

    protected function serializeDate(\DateTimeInterface $date): string
    {
        return $date->format('Y-m-d H:i:s');
    }

    protected $appends = ["status_str"];

    public function getStatusStrAttribute(): string
    {
        if($this->status ==0){
            return "禁止";
        }else if($this->status == 1){
            return "正常";
        }else{
            return "未知状态";
        }
    }
    public function getIsShowStrAttribute(): string
    {
        if($this->is_show ==0){
            return "未上架";
        }else if($this->status == 1){
            return "已上架";
        }else{
            return "未知状态";
        }
    }
}
