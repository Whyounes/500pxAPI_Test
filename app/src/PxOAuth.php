<?php


class PxOAuth extends TwitterOAuth{

    public function __construct($consumer_key, $consumer_secret, $oauth_token = NULL, $oauth_token_secret = NULL){
        parent::__construct($consumer_key, $consumer_secret, $oauth_token = NULL, $oauth_token_secret = NULL);
        $this->host = 'https://api.500px.com/v1/';
    }

    function accessTokenURL(){
        return 'https://api.500px.com/v1/oauth/access_token';
    }

    function authenticateURL(){
        return 'https://api.500px.com/v1/oauth/authorize';
    }

    function authorizeURL(){
        return 'https://api.500px.com/v1/oauth/authorize';
    }

    function requestTokenURL(){
        return 'https://api.500px.com/v1/oauth/request_token';
    }

}//class
