<?php

return [
    'consumer_key'      => isset($_ENV['consumer_key']) ?: '',
    'consumer_secret'   => isset($_ENV['consumer_secret']) ?: '',
    'token'             => isset($_ENV['token']) ?: '',
    'token_secret'      => isset($_ENV['token_secret']) ?: '',
];
