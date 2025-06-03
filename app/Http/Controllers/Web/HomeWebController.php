<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Traits\CommonTrait;
use App\Traits\FileTrait;
use App\Traits\ValidationTrait;

use App\Models\Banner;
use App\Models\ContactEnquiry;
use App\Models\Units;
use Exception;

class HomeWebController extends Controller
{
    use FileTrait, CommonTrait, ValidationTrait;
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
