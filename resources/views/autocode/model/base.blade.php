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

    protected function serializeDate(\DateTimeInterface $date): string
    {
        return $date->format('Y-m-d H:i:s');
    }
}
//AutoCode Created at {{$nowtime}}
