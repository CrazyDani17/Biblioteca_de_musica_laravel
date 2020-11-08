<?php

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => [
        config('backpack.base.web_middleware', 'web'),
        config('backpack.base.middleware_key', 'admin'),
    ],
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    Route::crud('address', 'AddressCrudController');
    Route::crud('customer', 'CustomerCrudController');
    Route::crud('document_type', 'Document_typeCrudController');
    Route::crud('manifest', 'ManifestCrudController');
    Route::crud('sector', 'SectorCrudController');
    Route::crud('attendance', 'AttendanceCrudController');
    Route::crud('employee', 'EmployeeCrudController');
    Route::crud('identification_document_type', 'Identification_document_typeCrudController');
    Route::crud('area', 'AreaCrudController');
}); // this should be the absolute last line of this file

Route::get('api/address', 'App\Http\Controllers\Api\AddressController@index');
Route::get('api/address/{id}', 'App\Http\Controllers\Api\AddressController@show');
