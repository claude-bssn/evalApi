<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Author;
use App\Http\Resources\AuthorResource;
use App\Http\Resources\AuthorCollection;


class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new AuthorCollection(Author::orderBy('name')->paginate(10)); // meme chose que le code commenté en dessous mais en passant par un "collection" qui formate le retour des données 
        // $authors =Author::all();
        // return response()->json($authors, 200); // Paramètre = données et le code http de retour
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $newAuthor= Author::addAuthor($request->name);
        
        return response()->json($newAuthor, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $author = Author::find($id);
        if($author){
               return new AuthorResource($author);

        }else{
            return response()->json(['message'=>'Not found'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $author = Author::find($id);
        if($author){
            $updateAuthor = Author::updateAuthor($author, $request->all());
            
            return response()->json($updateAuthor, 200);
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
        $author = Author::find($id);
        
        if($author){
            $author->delete();
            return response()->json('', 204);
        }else{
            return response()->json(['message'=>'Not found'], 404);
        }
    }
}
