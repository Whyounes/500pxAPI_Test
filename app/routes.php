<?php

Route::get('/', ['uses' => 'PXController@index']);

Route::get('/ajax/index_more', ['uses' => 'PXController@loadMore']);

Route::get('/user/{id}', ['uses' => 'PXController@photosByUser']);

Route::post('/ajax/photo/{id}/vote', ['uses' => 'PXController@vote']);

Route::post('/ajax/photo/{id}/favorite', ['uses' => 'PXController@favorite']);

Route::get('/upload', ['uses' => 'PagesController@photoUpload']);

Route::post('/photo/upload', ['as' => 'photo.upload', 'uses' => 'PXController@upload']);
