<?php

use Illuminate\Support\Facades\Input;

class PXController extends BaseController {

    public function index(){
        $inputs = Input::only('feature', 'sort', 'sort_direction');
        $inputs['page'] = 1;

        $result = $this->loadPhotos($inputs);

        return View::make('index', ['photos' => $result->photos, "inputs" => $inputs]);
    }

    public function loadMore(){
        $inputs = Input::only('feature', 'sort', 'sort_direction', 'page');

        $result = $this->loadPhotos($inputs);

        return View::make('partials/photos', ['photos' => $result->photos]);
    }

    private function loadPhotos($parameters){
        $postFields = array_merge(['image_size' => 3], $parameters);

        $px = App::make('pxoauth');
        $result = $px->get('photos', $postFields);

        return $result;
    }

    public function photosByUser($uid){
        $px = App::make('pxoauth');
        $user = $px->get('users/show', ['id' => $uid]);
        $inputs = ['image_size' => 3, 'feature' => 'user', 'user_id' => $uid, 'rpp' => 100];
        $result = $this->loadPhotos($inputs);

        return View::make('user', ['photos' => $result->photos, 'user' => $user->user]);
    }

}

 