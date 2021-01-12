<?php

Route::group(['middleware' => ['web']], function () {
    Route::get('/admin/newsletter-template', 'Motocle\Newsletter\Http\Controllers\NewsletterController@index')->name('admin.motocle.cms.dm.index');
    Route::get('/admin/newsletter-history', 'Motocle\Newsletter\Http\Controllers\NewsletterController@history')->name('admin.motocle.cms.dm.history');
    Route::get('/admin/newsletter-history/view/{newsletter}', 'Motocle\Newsletter\Http\Controllers\NewsletterController@view')->name('admin.motocle.cms.dm.history.view');
    Route::get('/admin/newsletter-template/create', 'Motocle\Newsletter\Http\Controllers\NewsletterController@create')->name('admin.motocle.cms.dm.create');
    Route::post('/admin/newsletter-template/create', 'Motocle\Newsletter\Http\Controllers\NewsletterController@store')->name('admin.motocle.cms.dm.store');
    Route::get('/admin/newsletter-template/edit/{newsletter_template}', 'Motocle\Newsletter\Http\Controllers\NewsletterController@edit')->name('admin.motocle.cms.dm.edit');
    Route::post('/admin/newsletter-template/edit/{newsletter_template}', 'Motocle\Newsletter\Http\Controllers\NewsletterController@update')->name('admin.motocle.cms.dm.update');
    Route::post('/admin/newsletter-template/delete/{newsletter_template}', 'Motocle\Newsletter\Http\Controllers\NewsletterController@destroy')->name('admin.motocle.cms.dm.destroy');
    Route::post('/admin/newsletter-template/image', 'Motocle\Newsletter\Http\Controllers\NewsletterController@uploadImage')->name('admin.motocle.cms.dm.upload-image');
});
