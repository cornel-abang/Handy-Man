<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Artisan;
use App\Category;
use App\Service;

class ArtisanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Artisans';
        $artisans = Artisan::orderBy('full_name', 'asc')->paginate(20);
        return view('admin.artisans', compact('title', 'artisans'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Add New Artisan';
        $category = Category::all();
        return view('admin.create_artisan', compact('title','category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         $rules = [
            'full_name' => ['required', 'string', 'max:190'],
            'phone'=> ['required', 'digits:11'],
            'email' => ['required', 'string', 'email', 'max:190', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'address' => ['required', 'string'],
            'state' => ['required', 'string'],
            'lga' => ['required', 'string'],
            'skill' => ['required', 'string'],
            'gender' => 'required'
        ];

        $this->validate($request, $rules);
        $data = $request->except('_token');
        Artisan::create($data);

        return redirect(route('artisans'))->with('success', 'Artisan added!');
    }

    public static function createSlug($data)
    {
        return $newSlug = str_replace(' ', '-', strtolower($data));
    }

    public static function getArtisans($slug)
    {
        return $artisans = Artisan::where('skill', $slug)->get();
    }

    public function assignArtisan($artisan_id, $job_id)
    {
        $job = Service::find($job_id);
        $artisan = Artisan::find($artisan_id);

        $artisan->status = 'Occupied';
        $job->artisan_id = $artisan_id;
        $job->save();
        
        return response()->json([
            "success" => true,
            "artisan" =>$job->artisan
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $title = 'Artisan profile';
        $artisan = Artisan::find($id);

        return view('admin.artisan_profile', compact('title','artisan'));
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
        //
    }
}
