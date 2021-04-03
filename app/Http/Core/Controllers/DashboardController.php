<?php

namespace App\Http\Core\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Core\Models\Ticket;
use App\Http\Core\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function redirect;

class DashboardController extends Controller
{
    public function __construct()
    {
//        dd(2);
    }

    public function dashboard()
    {
//        dd(4);

//        if (!Auth::user()->can('read-dashboard')) {
//            return back()->with('error-message', 'دسترسی شما به این بخش محدود می باشد!');
//        }
        $usersCount=User::count();
        $notActiveUsersCount=User::where('active',0)->count();
        $notVerifiedUsersCount=User::whereNull('mobile_verified_at')->count();
        $verifiedUsersCount=User::whereNotNull('mobile_verified_at')->count();
        $activeVerifiedUsersCount=User::active()->whereNotNull('mobile_verified_at')->count();
        $activeNotAnswerdTicketCount=Ticket:: where('status',0)->count();


        return view('panel.dashboard.index',compact(
        'usersCount','notActiveUsersCount','verifiedUsersCount', 'notVerifiedUsersCount','activeVerifiedUsersCount',
        'activeNotAnswerdTicketCount'));

    }


}
