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
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;

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

    public function uploadFileWeb(Request $request)
    {
        // $file = $request->file('file');
        // $fileName = time() . '_' . strtotime(date('y-m-d')) . '_' . mt_rand() . '.' . $file->getClientOriginalExtension();
        // Storage::disk('profile')->put($fileName, file_get_contents($file));
        // return Storage::disk('profile')->url($fileName);



        // dd(Storage::disk('s3')->exists("uploads/default.jpeg"));
        $file = $request->file('file');
        $fileName = time() . '_' . mt_rand() . '.' . $file->getClientOriginalExtension();
        $path = Storage::disk('s3')->put($fileName, file_get_contents($file->getRealPath()));
        dd($path);
        $url = Storage::disk('s3')->url($fileName);
        return $url;



        // dd(Storage::disk('s3')->put('uploads/' . $fileName, file_get_contents($file), 'public'));
        // $uploadFile = $this->uploadFile([
        //     'file' => ['current' => $file, 'previous' => ''],
        //     // 'file' => ['current' => $file, 'previous' => $user->image],
        //     'platform' => $this->platform,
        //     'storage' => Config::get('constants.storage')['testFile']
        // ]);
    }
}
