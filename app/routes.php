<?php

App::bind('oauth', function(){
    $consumer_key = 'TxNYEWxvU26cylAkxTc1KgNmXCPvFc1EazhIk5Po';
    $consumer_secret = 'n88vhgVgpkaCr3I0h1yB1bmkhy72jPzhhzFSbpYI';

    $oauth = new PxOAuth($consumer_key, $consumer_secret);

    return $oauth;
});

Route::get('/', ['uses' => 'PXController@index']);

Route::get('/ajax/index_more', ['uses' => 'PXController@loadMore']);

Route::get('/upload', ['uses' => 'PagesController@photoUpload']);

Route::post('/photo/upload', ['as' => 'photo.upload', 'uses' => 'PXController@upload']);
