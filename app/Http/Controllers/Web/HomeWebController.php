<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

use App\Traits\CommonTrait;

use Exception;

class HomeWebController extends Controller
{
    use CommonTrait;
    public $platform = 'web';

    public function showHome()
    {
        try {
            return view('web.home.home');
        } catch (Exception $e) {
            abort(500);
        }
    }
}
