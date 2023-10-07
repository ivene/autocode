@php
    echo "<?php".PHP_EOL;
@endphp

namespace {{$config->namespace->api_request}};

use App\Http\Requests\ApiRequest;

class Update{{$modelName}}Request extends ApiRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
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
            'id' => 'required|integer|min:1',
@foreach($tableinfo->fields as $field)
@if(!empty($field->validation))
            '{{$field->name}}' => "{{$field->validation}}",
@endif
@endforeach
        ];
    }

    public function bodyParameters(): array
    {
        return [
            'id' => [
                'description' => '记录唯一ID',
                'example' => '1',
            ],
@foreach($tableinfo->fields as $field)
@if(!empty($field->validation))
            '{{$field->name}}' => [
                'description' => '{{$field->title}}',
                'example' => '{{$field->example}}',
            ],
@endif
@endforeach
        ];
    }
}
