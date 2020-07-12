<?php

namespace App\Http\Controllers;

use App\Invoice;
use App\Artisan;
use App\Payment;
use App\User;
use App\Service;

class DashboardController extends Controller
{
    public function index(){

        $data = [
            'usersCount' 			=> User::count(),
            'artisansCount'	 		=> Artisan::count(),
            'artisansFree' 			=> Artisan::where('status', 'free')->count(),
            'artisansOccupied' 		=> Artisan::where('status', 'occupied')->count(),
            'jobsCount'				=> Service::count(),
            'jobsCompleted'			=> Service::where('status', 'Completed')->count(),
            'jobsProgress'			=> Service::where('status', 'In-Progress')->count(),
            'jobsCancelled'			=> Service::where('status', 'Cancelled')->count(),	
            'jobsPending'			=> Service::where('status', 'Pending')->count(),		
            'invoicesCount'			=> Invoice::count(),
            'invoicesPaid'			=> Invoice::where('status', 'Paid')->count(),
            'invoicesUnpaid'		=> Invoice::where('status', 'Unpaid')->count(),
            'paymentsCount'			=> Payment::count()
            ];
           
        $user = auth()->user();
        $title = 'Handiman Admin';
        return view('admin.dashboard', compact('data','title','user'));
    }
}
