<?php

namespace App\Http\Core\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Core\Models\Ticket;
use App\Http\Core\Models\User;
use App\Http\Shop\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        $usersCount = User::count();
        $notActiveUsersCount = User::where('active', 0)->count();
        $notVerifiedUsersCount = User::whereNull('mobile_verified_at')->count();
        $verifiedUsersCount = User::whereNotNull('mobile_verified_at')->count();
        $activeVerifiedUsersCount = User::active()->whereNotNull('mobile_verified_at')->count();
        $activeNotAnswerdTicketCount = Ticket:: where('status', 0)->count();

        $today = Carbon::today();

        $todayUsersCount = User::where('created_at', '>=', $today)->count();
        $todaySells = Transaction::where('created_at', '>=', $today)->where('status', 1)->sum('amount');
        $todayTransactions = Transaction::where('created_at', '>=', $today)->count();


        $success = DB::table('transactions')
            ->select(DB::raw('DATE(created_at) as date'))
            ->where('status', 1)
            ->where('created_at', '>=', Carbon::now()->subMonth())
            ->get();
        $failed = DB::table('transactions')
            ->select(DB::raw('DATE(created_at) as date'))
            ->where('status', 0)
            ->where('created_at', '>=', Carbon::now()->subMonth())
            ->get();
        foreach (range(30, 0) as $item) {
            $transactions['days'][] = verta()->subDays($item)->format('Y-m-d');
            $transactions['success'][] = count($success->whereIn('date', Carbon::now()->subDays($item)->toDateString()));
            $transactions['failed'][] = count($failed->whereIn('date', Carbon::now()->subDays($item)->toDateString()));
        }


        $users = DB::table('users')
            ->select(DB::raw('DATE(created_at) as date'))
            ->where('created_at', '>=', Carbon::now()->subMonth())
            ->get();
        $shops = DB::table('shops')
            ->select(DB::raw('DATE(created_at) as date'))
            ->where('created_at', '>=', Carbon::now()->subMonth())
            ->get();

        foreach (range(30, 0) as $item) {
            $income['days'][] = verta()->subDays($item)->format('Y-m-d');
            $income['users'][] = count($users->whereIn('date', Carbon::now()->subDays($item)->toDateString()));
            $income['shops'][] = count($shops->whereIn('date', Carbon::now()->subDays($item)->toDateString()));
        }


        return view('panel.dashboard.index', compact(
            'usersCount', 'notActiveUsersCount', 'verifiedUsersCount', 'notVerifiedUsersCount', 'activeVerifiedUsersCount',
            'todayUsersCount', 'todaySells', 'todayTransactions',
            'income', 'transactions',
            'activeNotAnswerdTicketCount'));

    }


}
