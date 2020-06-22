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
use Session;
use PDF;
use App\Rating;
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
    public function allUserJobs()
    {
        $user = Auth::user();
        $title = "All Jobs";
        $jobs = Service::orderBy('created_at', 'desc')
                        ->where('user_id', $user->id)
                        ->paginate(20);
        
        return view('admin.jobs', compact('title', 'jobs'));
    }


    /*###############################
        return the resources for jobs
     ##############################*/
    public static function allUserJobsCount()
    {
            $user = Auth::user();
            return $allJobs = Service::where('user_id', $user->id)
                                     ->orderBy('created_at','desc')
                                     ->paginate(10);
    }
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
        if (auth()->user()->user_type !== 'admin') {
            $title = "Request Service";

            $categories = Category::orderBy('category_name', 'asc')->get();

            $LGAs = $this->getLGAs();
            return view('admin.request-new-service', compact('title', 'categories', 'LGAs'));
        }

        return redirect(route('account'))->with('error','You can not request a service as an admin');
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
            'category'              => ['required', 'string', 'max:190'],
            //'sub_category' => ['string', 'max:190'],
            'local_govt'            => 'required',
            'street_address'        => ['required', 'string'],
            'description'           =>  'string',
            'visiting_date'         => ['date', 'required'],
            'visiting_time'         => 'required'
        ];
        $this->validate($request, $rules);

        $service = $this->saveRequest($request);
        if ( ! $service){
            return back()->with('error', 'app.something_went_wrong')->withInput($request->input());
        }

        return redirect(route('all'))->with('success', '<b>'.ucwords(str_replace('-', ' ', $request->category)).'</b>'.
            ' - Service request successful! Expect a call from us in no time. Cheers!');
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
            'message'                   => $request->description,
            'visiting_date'             => $request->visiting_date,
            'visiting_time'             => $request->visiting_time
        ];

        return $service = Service::create($data);
    }

    public function requestBySlug(Request $request)
    {
        /*
            get the service category and store in a session variable
            for future use after authentication
         */  
        session()->put('intended-category', $request->search_term);
        if (auth()->check()) {
            return redirect(route('account'));
         }

         return redirect(route('login')); 
    }
    /*#################################
        //Service request handler ends
     #################################*/

    public function markJobPost(Request $request)
    {
        $rating = $this->rateService($request->all());
        if ($rating) {
            $job = Service::find($request->service_id);
            $job->status = 'Completed';
            $job->save();
            session()->flash('success', 'Thanks for working with Handy Man!');
        }else{
            session()->flash('error', 'Server Error! Unable to Mark Off this Job');
        }
        
        return redirect(route('all'));
    }

    public function rateService($job)
    {
        return Rating::create($job);
    }




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

     /*########################
        //Visiting Feature Area
     ########################*/
     public function rescheduleVisit(Request $request)
     {
        $title = "Reschedule Visit";
        $services = Service::where("user_id", auth()->user()->id)->get();
       
        return view("admin.rescheduleVisit", compact('title', 'services'));
     }

     public function getJobForReschedule(Request $request)
     {
        $service = Service::find($request->job_id);
        return $service;
     }







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

    public static function allJobs(){
        return $allJobs = Service::orderBy('created_at','desc')
                                   ->paginate(10);
    }

     static function newAll(){
            return $newJobs = Service::where('status','new')
                                     ->orderBy('created_at','desc')
                                     ->paginate(10);
    }

    static function progressAll(){
            return $progressJobs = Service::where('status','In-progress')
                                     ->orderBy('created_at','desc')
                                     ->paginate(10);
    }

    static function jobsCompletedAll(){
            return $completedJobs = Service::where('status','completed')
                                     ->orderBy('created_at','desc')
                                     ->paginate(10);
    }

    static function jobsPendingAll(){
            return $pendingJobs = Service::where('status','pending')
                                     ->orderBy('created_at','desc')
                                     ->paginate(10);
    }

    static function jobsCancelledAll(){
            return $cancelled = Service::where('status','cancelled')
                                     ->orderBy('created_at','desc')
                                     ->paginate(10);
    }

    //Get the tag associated with the request
    public function showJobsAdmin($tag)
    {
        //assign a state to know from the template which templet your on
        //all template (1 yes, 0 no)
        $state = 0;

        switch ($tag) {
            case 'all':
                $title = "All Jobs";
                $state = 1;
                $jobs = $this->allJobs();
                break;

            case 'new':
                $title = "New Jobs";
                $jobs = $this->newAll();
                break;

            case 'in-progress':
                $title = "Jobs in Progress";
                $jobs = $this->progressAll();
                break;

            case 'completed':
                $title = "Completed Jobs";
                $jobs = $this->jobsCompletedAll();
                break;

            case 'pending':
                $title = "Pending Jobs";
                $jobs = $this->jobsPendingAll();
                break;

            case 'cancelled':
                $title = "Cancelled Jobs";
                $jobs = $this->jobsCancelledAll();
                break;
            
            default:
                $title = "All Jobs";
                $jobs = $this->allJobs();
                break;
        }
        
        $user = Auth::user();
        return view('admin.jobs_admin', compact('title', 'jobs', 'user', 'state'));
    }

    public function markJob(Request $request)
    {
        $job = Service::find($request->job_id);
        $job->status = $request->status;
        $job->save();
        return "success";
    }
}
