<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Saml2Controller;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/success', function () {
    return "success";
});
Route::get('/saml/login', function () {
    return redirect()->to('saml2/okta/login');
});
Route::post('/saml2/{idpName}/acs', [Saml2Controller::class, 'acs']);
Route::get('/saml2/{idpName}/slo', '\Aacotroneo\Saml2\Http\Controllers\Saml2Controller@logout');
