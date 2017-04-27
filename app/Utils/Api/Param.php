<?php

namespace App\Utils\Api;

use JsonSerializable;

class Param implements JsonSerializable
{
    private $name;
    private $type;
    private $required = false;

    public function __construct($name, $type = Types::TEXT, $required = false)
    {
        $this->name = $name;
        $this->type = $type;
        $this->required = $required;
    }

    public function jsonSerialize()
    {
        return [
            'name' => $this->name,
            'type' => $this->type,
            'required' => $this->required,
        ];
    }
}