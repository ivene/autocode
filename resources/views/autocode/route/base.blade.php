<?php

Route::prefix("gamemap")->group(function (){
    Route::controller({{$modelName}}Controller::class)->group(function (){
        Route::get("list","getList");
        Route::post("listData","getListData");
        Route::post("save","save");
    });
});
