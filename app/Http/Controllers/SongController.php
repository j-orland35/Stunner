<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Song;
class SongController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(){
        $this->middleware(['auth','history']);
    }
    public function index()
    { 
        $user = Auth::user();
        if(Auth::check()){
        $title = $this->toArrayByIndex($this->personalEntries(),"title");
        $id = $this->toArrayByIndex($this->personalEntries(),"id");
        return view("layouts.lyrics",["entryId" => $id,"entryTitle" => $title,"userName" => $user->name]);
        }
       
    }
    public function personalEntries($arr=null){
        if(is_array($arr)){
            $data = Song::where('belongTo',Auth::id())->get($arr);
        }else{
            $data = Song::where('belongTo',Auth::id())->get();
        }

        return $data;
    }
    public function toArrayByIndex($data,$index){
        $lists = [];
        foreach($data as $value){
            array_push($lists,$value->$index);
        }
        return $lists;
    }
    public function logout(){
        Auth::logout();
        return redirect('/login');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        $insert = new Song;
        $insert->title =  $request->title;
        $insert->artist = $request->title;
        $insert->lyrics = $request->lyrics;
        $insert->belongTo = Auth::id();
        $insert->save();
        return $insert->id;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
         return  Song::where('belongTo',Auth::id())->get();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return  Song::where('id',$id)->first();
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
        $entry = Song::find($id);
        $entry->title =  $request->title;
        $entry->artist = $request->artist;
        $entry->lyrics = $request->lyrics;
        $entry->save();
        return $id;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $entry = Song::find($id);
        $entry->delete();
        return $id;
    }
}
