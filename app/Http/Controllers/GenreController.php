<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Genre;
use App\Http\Resources\GenreResource;
use App\Http\Resources\GenreCollection;
use Illuminate\Support\Facades\Response;

class GenreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        
        return new GenreCollection(Genre::orderBy('name')->paginate(10));;
    }

   

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $newGenre= Genre::addGenre($request->all());
        
        return response()->json($newGenre, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $genre= Genre::find($id);
        if($genre){
             return new GenreResource($genre);        
        }else{
            return response()->json(['message'=>'Not found'], 404);
        }
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
        
        $genre = Genre::find($id);
        if($genre){
            $updateGenre = Genre::updateGenre($genre, $request->all());       
            return response()->json($updateGenre, 200);
        }else{
            return response()->json(['message'=>'Not found'], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $genre = Genre::find($id);
            if($genre){
            $genre->books()->detach();
            $genre->delete();
            return response()->json('', 204);
        }else{
            return response()->json(['message'=>'Not found'], 404);
        }
    }
}
