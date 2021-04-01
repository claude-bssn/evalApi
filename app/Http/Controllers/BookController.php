<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Http\Resources\BookResource;
use App\Http\Resources\BookCollection;

class BookController extends Controller
{
    /**
     * @OA\Get(
     *      path="/books",
     *      operationId="getBooksList",
     *      tags={"CRUD: Read Book"},
     *      summary="Get list of all books in alphabetical order",
     *      description="Returns list of all books",
     *      @OA\Parameter(
     *          name="title",
     *          in="query",
     *          description="Search by title",
     *          required=false
     *      ),
     *          @OA\Parameter(
     *          name="filter",
     *          in="query",
     *          description="Filter by genre Id",
     *          required=false
     *      ),
     *          @OA\Parameter(
     *          name="sort",
     *          in="query",
     *          description="Sort books by: title | author_id | publication_year | pages_nb  ",
     *          required=false
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *     )
     */
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {      $path='/api/books';
        if((empty($request->parameters))){
            $books = Book::orderBy('title');
            
        }
        if(($term= $request->title)){
            $books=Book::where('title','LIKE', '%'.$term . '%');
            $path = '/api/books?title='.$term;
            
        }
        if(($term= $request->filter)){
            $books=Book::whereHas('genres',function ($query) use ($term){
                $query->where('genres.id', '=', $term );
                $path = '/api/books?filter='.$term;
                // dd($query);
            });
        }
        if (($term = $request->sort)){
            $books = Book::orderBy($term);
                $path = '/api/books?sort='.$term;

        }
        $books= $books->paginate(10)->withPath($path);
            return new BookCollection($books);
            
        }
        
    /**
     * @OA\Post(
     *      path="/books",
     *      operationId="store books",
     *      tags={"CRUD: Create book"},
     *      summary="Store new book",
     *      description="Store new book all field are required ",
     *     @OA\Parameter(
     *          name="title",
     *          in="query",
     *          description="title max 100",
     *          required=true,
     *      ),
     *     @OA\Parameter(
     *          name="description",
     *          in="query",
     *          description="description max 1000 ",
     *          required=true,
     *      ),
     *      @OA\Parameter(
     *          name="author_id",
     *          in="query",
     *          description="id of the author",
     *          required=true,
     *      @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="publication_year",
     *          in="query",
     *          description="publication year",
     *          required=true,
     *      @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="pages_nb",
     *          in="query",
     *          description="number of pages",
     *          required=true,
     *      @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="genres",
     *          in="query",
     *          description="genre id ",
     *          required=true,
     *      @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     * 
     * 
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            
            "title"=> ['required','max:100'],
            "description"=> ['required','max:1000'],
            "author_id"=> ['required','integer'],
            "publication_year"=> ['required','integer'],
            "pages_nb"=> ['required','integer'],
            "genres"=> ['required','integer'],

        ]);
        $newBook= Book::addBook($validated);
        
        return response()->json($newBook, 201);
    }
/**
     * @OA\patch(
     *      path="/books/{id}",
     *      operationId="getProjectById",
     *      tags={"Projects"},
     *      summary="Get project information",
     *      description="Returns project data",
     *     
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {   
        $book = book::find($id);
        if($book){
            return new BookResource($book);
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
        $book = Book::find($id);
        if($book){
            $validated = $request->validate([
            
                "title"=> ['required','max:100'],
                "description"=> ['required','max:1000'],
                "author_id"=> ['required','integer'],
                "publication_year"=> ['required','integer'],
                "pages_nb"=> ['required','integer'],
                "genres"=> ['required','integer'],
    
            ]);
        $updateBook = Book::updateBook($book,$validated);
        
        return response()->json($updateBook, 200);
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
        $book = Book::find($id);
            if($book){
            $book->genres()->detach();
            $book->delete();
            return response()->json('', 204);
        }else{
            return response()->json(['message'=>'Not found'], 404);
        }
    }
}
