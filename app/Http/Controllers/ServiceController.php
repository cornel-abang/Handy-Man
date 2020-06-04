<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Country;
use App\FlagJob;
use App\Job;
use App\Service;
use App\JobApplication;
use App\Mail\ShareByEMail;
use App\State;
use App\User;
use PDF;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Mockery\Exception;

class ServiceController extends Controller
{
    /*##############################################################
    ## Customer Activities Area
     ###################################*###########################/


    /*#######################
    Return the views for jobs
     #######################*/

    public function newJobs(){
        $user = Auth::user();
        $title = "New Jobs";
        $jobs = $this->new();
        return view('admin.jobs', compact('title', 'jobs', 'user'));
    }
    public function jobsInProgress(){
        $title = "Jobs in Progress";
        $jobs = Job::pending()->orderBy('id', 'desc')->paginate(20);
        return view('admin.jobs', compact('title', 'jobs'));
    }
     public function pendingJobs(){
        $title = __('app.pending_jobs');
        $jobs = Job::pending()->orderBy('id', 'desc')->paginate(20);
        return view('admin.jobs', compact('title', 'jobs'));
    }
    public function completedJobs(){
        $title = "Completed Jobs";
        $jobs = Job::approved()->orderBy('id', 'desc')->paginate(20);
        return view('admin.jobs', compact('title', 'jobs'));
    }
    public function cancelledJobs(){
        $title = "Cancelled Jobs";
        $jobs = Job::blocked()->orderBy('id', 'desc')->paginate(20);
        return view('admin.jobs', compact('title', 'jobs'));
    }

    /*###############################
        return the resources for jobs
     ##############################*/
    static function new(){
            $user = Auth::user();
            return $newJobs = Service::where('status','new')
                                     ->where('user_id', $user->id)
                                     ->orderBy('created_at','desc')
                                     ->paginate(10);
    }

    static function progress(){
            $user = Auth::user();
            return $progressJobs = Service::where('status','In progress')
                                     ->where('user_id', $user->id)
                                     ->orderBy('created_at','desc')
                                     ->get();
    }

    static function jobsCompleted(){
            $user = Auth::user();
            return $completedJobs = Service::where('status','coomplete')
                                     ->where('user_id', $user->id)
                                     ->orderBy('created_at','desc')
                                     ->get();
    }

    static function jobsPending(){
            $user = Auth::user();
            return $pendingJobs = Service::where('status','pending')
                                     ->where('user_id', $user->id)
                                     ->orderBy('created_at','desc')
                                     ->get();
    }

    static function jobsCancelled(){
            $user = Auth::user();
            return $cancelled = Service::where('status','cancelled')
                                     ->where('user_id', $user->id)
                                     ->orderBy('created_at','desc')
                                     ->get();
    }

     /*########################
        //Jobs Ends
     ########################*/




    /*########################
        Handle Service Request
     ########################*/

    public function requestService(){
        $title = "Request Service";

        $categories = Category::orderBy('category_name', 'asc')->get();

        $LGAs = $this->getLGAs();
        return view('admin.request-new-service', compact('title', 'categories', 'LGAs'));
    }

    public function getLGAs(){
        /*
            get LGAs in Cross River using a REST API call
         */
        $cURLConn = curl_init();
        curl_setopt($cURLConn, CURLOPT_URL, 'http://locationsng-api.herokuapp.com/api/v1/states/cross_river/lgas');
        curl_setopt($cURLConn, CURLOPT_RETURNTRANSFER, true);
        $lgas = curl_exec($cURLConn);
        curl_close($cURLConn);
        return $LGAs = json_decode($lgas);
    }

    public function requestServicePost(Request $request){
        $rules = [
            'category' => ['required', 'string', 'max:190'],
            //'sub_category' => ['string', 'max:190'],
            'local_govt' => 'required',
            'street_address' => ['required', 'string'],
            'description' =>  'string'
        ];
        $this->validate($request, $rules);

        $service = $this->saveRequest($request);
        if ( ! $service){
            return back()->with('error', 'app.something_went_wrong')->withInput($request->input());
        }

        return redirect(route('account'))->with('success', 'Service request successful! Expect a call from us in no time. Cheers!');
    }

    public function saveRequest($request){
        $state = 'Cross River';
        $user = Auth::user();
        $data = [
            'user_id'                   => $user->id,
            'state'                     => str_replace('-', ' ', $request->state),
            'category'                  => ucfirst(str_replace('-', ' ', $request->category)),
            //'sub_category'              => $request->sub_category,
            'local_govt'                => str_replace('-', ' ', $request->local_govt),
            'street_addr'               => $request->street_address,
            'message'                   => $request->description
        ];

        return $service = Service::create($data);
    }
    /*#################################
        //Service arequest handler ends
     #################################*/








     /*########################
        Invoicing Area
     ########################*/

    public function invoice(){
        $data = ['title'=>'Invoice Test'];
        $pdfInvoice = PDF::loadView('invoice.test', $data);

        return $pdfInvoice->stream('InvoiceTest.pdf');
    }

     /*########################
        //Invoicing Ends
     ########################*/








    /*################################################################################
    ## Customer Activities Area Ends
     #################################################################################*/








     /*##################################################################################
        ADMIN ACTIVITIES AREA
     ####################################################################################*/

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
    }

    public static function alljobs(){
        return $allJobs = Service::orderBy('created_at','desc')
                                   ->get();
    }

     static function newAll(){
            return $newJobs = Service::where('status','new')
                                     ->orderBy('created_at','desc')
                                     ->get();
    }

    static function progressAll(){
            return $progressJobs = Service::where('status','In progress')
                                     ->orderBy('created_at','desc')
                                     ->get();
    }

    static function jobsCompletedAll(){
            return $completedJobs = Service::where('status','coomplete')
                                     ->orderBy('created_at','desc')
                                     ->get();
    }

    static function jobsPendingAll(){
            return $pendingJobs = Service::where('status','pending')
                                     ->orderBy('created_at','desc')
                                     ->get();
    }

    static function jobsCancelledAll(){
            return $cancelled = Service::where('status','cancelled')
                                     ->orderBy('created_at','desc')
                                     ->get();
    }
}
