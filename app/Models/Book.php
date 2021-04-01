<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    public static function getOne($id)
    {
        return Book::find($id);
    }

    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function genres()
    {
        return $this->belongsToMany(Genre::class);
    }
    public static function addBook($data)
    {
        $book = new Book;
        $book->title = $data['title'];
        $book->description = $data['description'];
        $book->author_id = $data['author_id'];
        $book->publication_year = $data['publication_year'];
        $book->pages_nb = $data['pages_nb'];
        $book->save();
        $book->genres()->attach($data['genres']);
        return $book;

    }
    public static function updateBook($book, $data) // $data vient de request all() dans le controller 
    {
        
        $book->title = $data['title'];
        $book->description = $data['description'];
        $book->author_id = $data['author_id'];
        $book->publication_year = $data['publication_year'];
        $book->pages_nb = $data['pages_nb'];
        $book->genres()->sync($data['genres']);
        $book->save();
        return $book;
    }
}
