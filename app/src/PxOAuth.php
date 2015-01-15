<?php

use Abraham\TwitterOAuth\TwitterOAuth;

class PxOAuth extends TwitterOAuth{

    public function __construct($consumer_key, $consumer_secret, $oauth_token = NULL, $oauth_token_secret = NULL){
        parent::__construct($consumer_key, $consumer_secret, $oauth_token, $oauth_token_secret);
        $this->setApiHost('https://api.500px.com');
        $this->setApiVersion('v1');
        $this->setTimeout(null);
        $this->setConnectionTimeout(null);
    }

}//class
