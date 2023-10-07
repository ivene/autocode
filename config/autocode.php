<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Templates
    |--------------------------------------------------------------------------
    |
    */

    'project' => 'Ouroots',

    /*
    |--------------------------------------------------------------------------
    | Paths
    |--------------------------------------------------------------------------
    |
    */

    'path' => [

        'migration'         => database_path('migrations/'),
        'model'             => app_path('Models/'),
        'services'          => app_path('Services/'),
        'datatables'        => app_path('DataTables/'),
        'repository'        => app_path('Repositories/'),
        'routes'            => base_path('routes/web.php'),
        'api_routes'        => base_path('routes/api.php'),
        'request'           => app_path('Http/Requests/'),
        'api_request'       => app_path('Http/Requests/Api/'),
        'controller'        => app_path('Http/Controllers/'),
        'api_controller'    => app_path('Http/Controllers/Api/'),
        'api_resource'      => app_path('Http/Resources/'),
        'schema_files'      => resource_path('model_schemas/'),
        'seeder'            => database_path('seeders/'),
        'database_seeder'   => database_path('seeders/DatabaseSeeder.php'),
        'factory'           => database_path('factories/'),
        'view_provider'     => app_path('Providers/ViewServiceProvider.php'),
        'tests'             => base_path('tests/'),
        'repository_test'   => base_path('tests/Repositories/'),
        'api_test'          => base_path('tests/Apis/'),
        'views'             => resource_path('views/'),
        'menu_file'         => resource_path('views/layouts/menu.blade.php'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Namespaces
    |--------------------------------------------------------------------------
    |
    */

    'namespace' => [
        'services'          => 'App\Services',
        'model'             => 'App\Models',
        'datatables'        => 'App\DataTables',
        'repository'        => 'App\Repositories',
        'controller'        => 'App\Http\Controllers',
        'api_controller'    => 'App\Http\Controllers\Api',
        'api_resource'      => 'App\Http\Resources',
        'request'           => 'App\Http\Requests',
        'api_request'       => 'App\Http\Requests\Api',
        'seeder'            => 'Database\Seeders',
        'factory'           => 'Database\Factories',
        'tests'             => 'Tests',
        'repository_test'   => 'Tests\Repositories',
        'api_test'          => 'Tests\APIs',
    ],
];
