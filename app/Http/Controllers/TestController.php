<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Schema;

class TestController extends Controller
{
    public function checkTable()
    {
        if (Schema::hasTable('mdlz_retailer_master')) { 
            return 'mdlz_retailer_master table exists';
        }

        return 'mdlz_retailer_master table does not exist';
    }
}
