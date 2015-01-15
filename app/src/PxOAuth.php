<?php

use Abraham\TwitterOAuth\TwitterOAuth;
use Abraham\TwitterOAuth\Util;

class PxOAuth extends TwitterOAuth{

    public function __construct($consumer_key, $consumer_secret, $oauth_token = NULL, $oauth_token_secret = NULL){
        parent::__construct($consumer_key, $consumer_secret, $oauth_token, $oauth_token_secret);
        $this->setApiHost('https://api.500px.com');
        // $this->setUploadHost('http://upload.500px.com');
        $this->setApiVersion('v1');
        $this->setTimeout(null);
        $this->setConnectionTimeout(null);
    }

    public function upload($path, array $parameters = array()){
        $postfields = $parameters;
        $headers = 'Content-Type:multipart/form-data; name:"test_file"';

        $options = [
            CURLOPT_CAPATH          => __DIR__,
            CURLOPT_CONNECTTIMEOUT  => 100,
            CURLOPT_HEADER          => true,
            CURLOPT_HTTPHEADER      => [$headers, 'Expect:'],
            CURLOPT_RETURNTRANSFER  => true,
            CURLOPT_SSL_VERIFYHOST  => 2,
            CURLOPT_TIMEOUT         => 100,
            CURLOPT_URL             => "https://api.500px.com/v1/photos/upload",
            CURLOPT_USERAGENT       => "500pxOAuth",
            CURLOPT_POST            => true,
            CURLOPT_POSTFIELDS      => Util::buildHttpQuery($postfields)
        ];

        $curlHandle = curl_init();

        curl_setopt_array($curlHandle, $options);

        $response = curl_exec($curlHandle);

        $curlErrno = curl_errno($curlHandle);
        switch ($curlErrno) {
            case 28:
                throw new TwitterOAuthException('Request timed out.');
            case 51:
                throw new TwitterOAuthException('The remote servers SSL certificate or SSH md5 fingerprint failed validation.');
            case 56:
                throw new TwitterOAuthException('Response from server failed or was interrupted.');
        }

        curl_close($curlHandle);
        dd($response);
    }
}//class
