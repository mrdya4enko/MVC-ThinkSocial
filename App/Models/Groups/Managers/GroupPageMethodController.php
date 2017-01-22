<?php

namespace App\Models\Groups\Managers;

use App\Models\Groups\Butler;

interface GroupPageMethodController
{
    const REQUEST_METHOD_GET = "GET";
    const REQUEST_METHOD_POST = "POST";

    public function __construct(Butler $butler);
    public function handleRequest();
    public function methodCheck();
}
