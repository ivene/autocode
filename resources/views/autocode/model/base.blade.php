@php
    echo "<?php".PHP_EOL;
@endphp

namespace App\Models\{{$project}}\Base;


use Illuminate\Database\Eloquent\Model;

class Base{{$modelName}} extends Model
{
    protected $table='{{$tableinfo->name}}';
@if(!empty($tableinfo->conn))
    protected $connection='{{$tableinfo->conn}}';
@endif
    protected $primaryKey='{{$tableinfo->primary_key}}';
    public $timestamps = true;
    protected $fillable=[
    @foreach($tableinfo->fields as $field)
    '{{$field->name}}', //{{$field->comment}}
    @endforeach
    ];
}
//AutoCode Created at {{$nowtime}}
