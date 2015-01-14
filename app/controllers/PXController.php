<?php

class PXController extends BaseController {

    public function index(){
        $px = App::make('pxoauth');
        $result = $px->get('photos', ['image_size' => 3]);

        return View::make('index', ['photos' => $result->photos]);
    }

    public function loadMore(){
        $page = Input::get('page');

        $px = App::make('pxoauth');
        $result = $px->get('photos', ['image_size' => 3, 'page' => $page]);

        return View::make('partials/photos', ['photos' => $result->photos]);
    }

    public function photosByUser($uid){
        $px = App::make('pxoauth');
        $user = $px->get('users/show', ['id' => $uid]);
        $result = $px->get('photos', ['image_size' => 3, 'feature' => 'user', 'user_id' => $uid]);

        return View::make('user', ['photos' => $result->photos, 'user' => $user->user]);
    }

    public function upload(){
        $px = App::make('pxoauth');

        $result = $px->upload('photos/upload', [
            'name'          => Input::get('name'),
            'description'   => Input::get('description'),
            'file'          => $_FILES['photo']['tmp_name'],
        ]);
        //var_dump('@' . $_FILES['photo']['tmp_name']);
        dd($result);

        return "";
    }

}

 