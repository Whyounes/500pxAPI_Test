<?php

class PXController extends BaseController {

    public function index(){
        $px = App::make('oauth');
        $photos = $px->get('photos', ['image_size' => 3])->photos;

        return View::make('index', ['photos' => $photos]);
    }

    public function loadMore(){
        $page = Input::get('page');

        $px = App::make('oauth');
        $photos = $px->get('photos', ['image_size' => 3, 'page' => $page])->photos;

        return View::make('partials/photos', ['photos' => $photos]);
    }

    public function upload(){
        $px = App::make('oauth');

        $result = $px->post('/photos/upload', [
            'name'          => Input::get('name'),
            'description'   => Input::get('description'),
            'file'          => '@' . $_FILES['photo']['tmp_name'],
        ]);
        //var_dump('@' . $_FILES['photo']['tmp_name']);
        dd($result);

        return "";
    }

}

 