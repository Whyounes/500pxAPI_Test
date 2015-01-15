<?php

Route::get('/', ['uses' => 'PXController@index']);

Route::get('/ajax/index_more', ['uses' => 'PXController@loadMore']);

Route::get('/user/{id}', ['uses' => 'PXController@photosByUser']);
