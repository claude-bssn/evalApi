<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    public function books()
    {
        return $this->hasMany(Book::class);
    }
    
    public static function addAuthor($name)
    {
        $author = new Author;
        $author->name = $name;
        
        $author->save();
        return $author;
    }
    public static function updateAuthor($author, $data) 
    { 
        $author->name = $data['name']; 
        
        $author->save();
        return $author;
    }
}
