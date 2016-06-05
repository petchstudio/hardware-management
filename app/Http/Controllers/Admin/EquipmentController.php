<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Hardware;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class EquipmentController extends Controller
{
    use Hardware;


    public function __construct()
    {
        $this->type = 'equipment';
    }
}
