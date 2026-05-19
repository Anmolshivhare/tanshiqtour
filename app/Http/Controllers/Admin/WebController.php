<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Traits\WebResponseTrait;

class WebController extends Controller
{
    use WebResponseTrait;

    protected $indexRouteName;
}
