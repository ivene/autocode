<?php

use Illuminate\Support\Str;
use Ivene\AutoCode\Common\DataTable;
use Ivene\AutoCode\Common\FileSystem;
if (!function_exists('yfile')) {
    /**
     * @return FileSystem
     */
    function yfile(): FileSystem
    {
        return app(FileSystem::class);
    }
}

if (!function_exists('ytable')) {
    /**
     * @return DataTable
     */
    function ytable(): DataTable
    {
        return app(DataTable::class);
    }
}

if (!function_exists('model_name_from_table_name')) {
    function model_name_from_table_name(string $tableName): string
    {
        return Str::ucfirst(Str::camel(Str::singular($tableName)));
    }
}

if (!function_exists('create_resource_route_names')) {
    function create_resource_route_names($name, $isScaffold = false): array
    {
        $result = [
            "'index' => '$name.index'",
            "'store' => '$name.store'",
            "'show' => '$name.show'",
            "'update' => '$name.update'",
            "'destroy' => '$name.destroy'",
        ];

        if ($isScaffold) {
            $result[] = "'create' => '$name.create'";
            $result[] = "'edit' => '$name.edit'";
        }

        return $result;
    }
}
