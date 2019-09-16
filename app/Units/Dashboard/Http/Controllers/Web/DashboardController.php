<?php

namespace App\Units\Dashboard\Http\Controllers\Web;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class DashboardController extends BaseController
{
    public function index(Request $request)
    {
        $totals = DB::table('users AS US')
                    ->join('roles AS RO', 'US.role_id', '=', 'RO.id')
                    ->selectRaw('count(US.id) AS total_users')
                    ->selectRaw("count((is_enabled or null) AND (email_verified_at or null)) AS total_enabled")
                    ->selectRaw("count(case when RO.code = 'super-admin' then 1 end) AS total_supers_admins")
                    ->selectRaw("count(case when RO.code = 'admin' then 1 end) AS total_admins")
                    ->selectRaw("count(case when RO.code = 'company' then 1 end) AS total_companies")
                    ->selectRaw("count(case when DAY(US.last_login_at) = DAY(NOW()) AND YEAR(US.last_login_at) = YEAR(NOW()) then 1 end) AS total_daily_logins")
                    ->first();

        $totals->total_active_suppliers = DB::table('suppliers AS SP')
                                             ->selectRaw("count((is_activated or null) AND (activated_at or null)) AS total_enabled")
                                             ->value('total_enabled');

        return view('dashboard::index', compact('totals'));
    }
}
