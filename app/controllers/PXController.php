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

    public function favorite($photoId){
        $px = App::make('pxoauth');
        $result = $px->post("photos/{$photoId}/favorite");

        return $result;
    }

    public function vote($photoId){
        $px = App::make('pxoauth');
        $url = "photos/{$photoId}/vote";
        $result = $px->post($url, ['vote' => '1']);
        dd($result);

        return $result;
    }
    
    public function upload(){

        $px = App::make('pxoauth');

        $result = $px->upload('photos/upload', [
            'name'          => Input::get('name'),
            'description'   => Input::get('description'),
            'file'          => '@' . $_FILES['photo']['tmp_name'],
        ]);

        $px->upload("", $result);


        dd();

        $url = "https://api.500px.com/v1/photos/upload";
        $filename = $_FILES['photo']['name'];
        $filedata = $_FILES['photo']['tmp_name'];
        $filesize = $_FILES['photo']['size'];

        $headers = array(
            'Content-Type:multipart/form-data; name="test_file"',
            'Content-Disposition: form-data; name="file"; filename="photo.jpeg"',
            "consumer_key" => "TxNYEWxvU26cylAkxTc1KgNmXCPvFc1EazhIk5Po",
            "consumer_secret" => "n88vhgVgpkaCr3I0h1yB1bmkhy72jPzhhzFSbpYI"
        );

        $postfields = array(
            "file" => "@$filedata",
            "filename" => $filename,
            "name" => "test",
            "consumer_key" => "TxNYEWxvU26cylAkxTc1KgNmXCPvFc1EazhIk5Po",
            "consumer_secret" => "n88vhgVgpkaCr3I0h1yB1bmkhy72jPzhhzFSbpYI"
        );

        $ch = curl_init();
        $options = array(
            CURLOPT_URL => $url,
            CURLOPT_HEADER => true,
            CURLOPT_POST => 1,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_POSTFIELDS => $postfields,
            CURLOPT_INFILESIZE => $filesize,
            CURLOPT_RETURNTRANSFER => true
        );

        curl_setopt_array($ch, $options);
        dd(curl_exec($ch));

        $errmsg = "";

        if(!curl_errno($ch))
        {
            $info = curl_getinfo($ch);
            if ($info['http_code'] == 200)
                $errmsg = "File uploaded successfully";
        }
        else
        {
            $errmsg = curl_error($ch);
        }
        curl_close($ch);

        return $errmsg;
    }//upload

}

 