<?php

namespace App\Http\Controllers\Manage;

use App\UserRequests;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    use UserRequests;


    public function __construct()
    {
        $this->type = 'material';
    }
}