<?php

use GuzzleHttp\Subscriber\Oauth\Oauth1;
use GuzzleHttp\Client;
use \Illuminate\Support\Collection;

class PxOAuth{

    private $host;

    private $client;

    private $consumer_key;

    private $consumer_secret;

    public function __construct($host, $consumer_key, $consumer_secret){
        $this->consumer_key = $consumer_key;
        $this->consumer_secret = $consumer_secret;
        $this->host = $host;

        $oauth = new Oauth1([
            'consumer_key'      => $this->consumer_key,
            'consumer_secret'   => $this->consumer_secret
        ]);

        $this->client = new Client([ 'base_url' => $this->host, 'defaults' => ['auth' => 'oauth']]);
        $this->client->getEmitter()->attach($oauth);
    }

    public function get($url, $data){
        $request = $this->client->createRequest('GET', $url);
        $query = $request->getQuery();

        (new Collection($data))->map(function($v, $k) use($query){
            $query->set($k, $v);
        });

        return $this->client->send($request);
    }
}//class
