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
        return new AuthorCollection(Author::all()); // meme chose que le code commenté en dessous mais en passant par un "collection" qui formate le retour des données 
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
     * @param  Author  $author
     * @return \Illuminate\Http\Response
     */
    public function show(Author $author)
    {
        return new AuthorResource($author);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Author $author
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Author $author)
    {
        $updateAuthor = Author::updateAuthor($author,$request->all());
        
        return response()->json($updateAuthor, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Author $author)
    {
        $author->delete();
        return response()->json('', 204);
    }
}
