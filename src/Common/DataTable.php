<?php
/**
 * @description
 * @author YaoYao
 * @time 2023/8/15 11:33
 */

namespace Ivene\AutoCode\Common;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Ivene\AutoCode\DTO\TableField;
use Ivene\AutoCode\DTO\TableInfo;

class DataTable
{
    function getTableInfo($table_name,$conn=""): TableInfo
    {
        $table_info =  new TableInfo();
        $show_info= ["created_at"=>"创建时间","updated_at"=>"更新时间","status"=>"状态","id"=>"编号","deleted_at"=>"删除时间"];
        $table_info->conn = $conn;
        if(!empty($conn)){
            $conn =  DB::connection($conn);
            $cols=  $conn->select(" SHOW FULL FIELDS FROM  `".$table_name."`");
        }else{
            $cols=  DB::select(" SHOW FULL FIELDS FROM  `".$table_name."`");
        }
        $field_str = "";
        $fields = [];




        foreach ($cols as  $col){
            $enums = collect();

            if($col->Key == 'PRI'){
                Log::info("表主键".json_encode($col));
                $table_info->primary_key = $col->Field;
            }else{
                $field_str .="        '".$col->Field."', // ".$col->Comment."\n";
                $field =  new TableField();
                $field->name = $col->Field;
                $field->comment = $col->Comment;
                $field->type = $col->Type;

                $field->validation = "required|";
                if(Str::contains('int',$col->Type)){
                    $field->validation .= "numeric|";
                }
                if(Str::contains('varchar',$col->Type)){
                    $field->validation .= "string|";
                }

                if(!empty($col->Comment)){
                    $temp =  explode(" ",$col->Comment);
                    $field->title =$temp[0];

                    $enum_result = [] ;
                    preg_match_all("/(?:\{enum:)(.*)(?:\})/i",$col->Comment,$enum_result);
                    if(array_key_exists(1,$enum_result) && array_key_exists(0,$enum_result[1])){
                        $enum_info = $enum_result[1][0];
                        if(!empty($enum_info)){
                            $temp_enums = explode(';',$enum_info);
                            if(!empty($temp_enums)){
                                foreach ($temp_enums as $temp_enum){
                                    $temp = [];

                                    if(!empty($temp_enum)) {
                                        $temp[] = explode(",", $temp_enum);
                                        if(count($temp)>1){
                                            $enums->push(collect(['key' => $temp[0], 'value' => $temp[1]]));
                                        }
                                    }
                                }
                            }
                        }
                    }
                    $field->enums = $enums;
//                    $field->enums = $enums->toArray();





                }else{
                    $field->title = "";
                }
                if(array_key_exists($field->name,$show_info)){
                    $field->title =  $show_info[$field->name];
                }
                $fields[] = $field;
            }
        }
        $table_info->name = $table_name;
        $table_info->field_str = $field_str;
        $table_info->fields = $fields;
        $table_info->title = model_name_from_table_name($table_name);
        return $table_info;

    }
}
