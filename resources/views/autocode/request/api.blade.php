@php
    echo "<?php".PHP_EOL;
@endphp

namespace App\Http\Requests\{{$project}};

use App\Http\Requests\ApiRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;

class {{$modleName}}ApiRequest extends ApiRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
@foreach($tableinfo->fields as $field)
            '{{$field->name}}' => "{{$field->validation}}",
@endforeach
        ];
    }

    public function bodyParameters(): array
    {
        return [
@foreach($tableinfo->fields as $field)
@if($field->type)
            '{{$field->name}}' => ['description' => '{{$field->comment}}', 'example' => '1'],
@endforeach
        ];
    }
}
