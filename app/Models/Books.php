<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Books extends Model
{
    use HasFactory;

    protected $table = 'books';
    public $timestamps = false;

    protected $fillable = [
        'name',
        'isbn',
        'authors',
        'country',
        'publisher',
        'release_date',
        'number_of_pages'
    ];
}