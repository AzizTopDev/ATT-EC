<?php

Route::group(['middleware' => ['web']], function () {
    Route::get('/admin/email-cms', 'Motocle\Email\Http\Controllers\EmailController@index')->name('motocle.cms.email.admin.index');
    Route::get('/admin/email-cms/edit/{system_email}', 'Motocle\Email\Http\Controllers\EmailController@edit')->name('motocle.cms.email.admin.edit');
    Route::post('/admin/email-cms/edit/{system_email}', 'Motocle\Email\Http\Controllers\EmailController@update')->name('motocle.cms.email.admin.update');
});
