@php
    echo "<?php".PHP_EOL;
@endphp

namespace App\Http\Requests\{{$project}};

use Illuminate\Foundation\Http\FormRequest;

class Save{{$modelName}}Request extends FormRequest
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
    public function rules(): array
    {
        return [
@foreach($tableinfo->fields as $field)
    @if(!empty($field->valadation))
        '{{$field->name}}' => "{{$field->validation}}",
    @endif
@endforeach
        ];
    }

    public function attributes(): array
    {
        return [
@foreach($tableinfo->fields as $field)
        '{{$field->name}}' => "{{$field->title}}",
@endforeach
        ];
    }
}
