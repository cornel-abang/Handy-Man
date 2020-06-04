<?php

namespace App\Http\Controllers;

use App\Job;
use App\JobApplication;
use App\Payment;
use App\User;
use App\Service;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){

        $data = [
            'usersCount' => User::count(),
            'totalPayments' => Payment::success()->sum('amount'),
            'activeJobs' => Job::active()->count(),
            'totalJobs' => Service::count(),
            'employerCount' => User::employer()->count(),
            'agentCount' => User::agent()->count(),
            'totalApplicants' => JobApplication::count(),

        ];
        $user = auth()->user();
        $title = 'Handy Man Admin';
        return view('admin.dashboard', compact('data','title','user'));
    }
}
