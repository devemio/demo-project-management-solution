<?php

namespace App\Repositories;

use Illuminate\Http\Request;

abstract class BaseRepository
{
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    protected function getUserID(): int
    {
        return $this->request->user()->getID();
    }
}