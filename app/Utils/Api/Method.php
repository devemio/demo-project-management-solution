<?php

namespace App\Utils\Api;

use JsonSerializable;

class Method implements JsonSerializable
{
    private $method;
    private $url;
    private $params = [];

    public function __construct($method, $url, array $params = [])
    {
        $this->method = $method;
        $this->url = $url;
        $this->params = $params;
    }

    public function jsonSerialize()
    {
        return [
            'method' => $this->method,
            'url' => $this->url,
            'params' => $this->params,
        ];
    }
}