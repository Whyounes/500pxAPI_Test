<?php

use Illuminate\Support\Facades\Input;

class PXController extends BaseController {

    public function index(){
        $filters = [
            'feature'           => Input::get('feature', 'popular'),
            'sort'              => Input::get('sort', 'created_at'),
            'sort_direction'    => Input::get('sort_direction', 'desc'),
            'page'              => Input::get('page', 1)
        ];

        $result = $this->loadPhotos($filters);

        return View::make('index', ['photos' => $result['photos'], "inputs" => $filters]);
    }

    public function loadMore(){
        $filters = [
            'feature'           => Input::get('feature', 'popular'),
            'sort'              => Input::get('sort', 'created_at'),
            'sort_direction'    => Input::get('sort_direction', 'desc'),
            'page'              => Input::get('page', 1)
        ];

        $result = $this->loadPhotos($filters);

        return View::make('partials/photos', ['photos' => $result['photos']]);
    }

    private function loadPhotos($parameters){
        $parameters = array_merge(['image_size' => 3], $parameters);

        $px = App::make('pxoauth');
        $result = $px->get('photos', $parameters)->json();

        return $result;
    }

    public function photosByUser($uid){
        $px = App::make('pxoauth');

        $user = $px->get('users/show', ['id' => $uid])->json();
        $inputs = ['image_size' => 3, 'feature' => 'user', 'user_id' => $uid, 'rpp' => 100];
        $result = $this->loadPhotos($inputs);

        return View::make('user', ['photos' => $result['photos'], 'user' => $user['user']]);
    }

}

 