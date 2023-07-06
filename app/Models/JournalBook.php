<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JournalBook extends Model
{
    use HasFactory;

    protected $connection = 'mysql2';
    protected $primaryKey = 'book_id';
    protected $table = "journal_book";



    public function getJounalBookById($bookId) {
       return self::where('book_id',$bookId)->first();
    }
}
