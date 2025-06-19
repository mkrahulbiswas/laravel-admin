<?php

namespace App\Http\Controllers\Admin\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\User;

use App\Traits\ValidationTrait;
use Exception;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardAdminController extends Controller
{
    use ValidationTrait;
    public $platform = 'backend';


    public function showQuickOverview()
    {
        try {
            return view('admin.dashboard.quick_overview.quick_overview_info');
        } catch (Exception $e) {
            abort(500);
        }
    }

    public function showChartsView()
    {
        try {
            return view('admin.dashboard.charts_view.charts_view_info');
        } catch (Exception $e) {
            abort(500);
        }
    }
}
