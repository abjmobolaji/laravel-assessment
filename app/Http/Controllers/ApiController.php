<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use App\Models\Books;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;


// SET TEMPLATE FOR RESPONSE
function responseFormat($statusCode, $status, $data, $message) {
        if($message == null) {
            return response([
                "status_code" => $statusCode,
                "status" => $status,
                "data" => $data
            ], $statusCode)
            ->header('Content-Type', 'application/json');
        } else {
            return response([
                "status_code" => $statusCode,
                "status" => $status,
                "message" => $message,
                "data" => $data
            ], $statusCode)
            ->header('Content-Type', 'application/json');
        }
        
    }

class ApiController extends Controller
{
    

    // REQUIREMENT 1
    /*
     * GET BOOK DETAILS FROM ICE AND FIRE BOOKS API
     */
    public function getExternalBook(Request $request)
    {
        // GET THE NAME OF THE BOOK AND FETCH
        $bookName = $request->name;
        $url = 'https://www.anapioficeandfire.com/api/books?name='. $bookName;
        
        // GET RESPONSE AND DECODE DATA
        $response = Http::get($url);        
        $books = json_decode($response->body());
        
        // STORE THE FOUND BOOK(S)
        $foundBooks = array();
        foreach ($books as $book) {
            $releaseDate = date_format(date_create($book->released),"Y-m-d");
            $result = array(
                    "name" => $book->name,
                    "isbn" => $book->isbn,
                    "authors" => $book->authors,
                    "number_of_pages" => $book->numberOfPages,
                    "publisher" => $book->publisher,
                    "country" => $book->country,
                    "release_date" => $releaseDate
            );
            array_push($foundBooks, $result);
        }
        
        // SEND RESPONSE & RESULTS
        return responseFormat(200, "success", $foundBooks, null);
    }


    // REQUIREMENTS 2
     /*
     * READ - Returns the list of books from database
     * 
     */
    public function index(Request $request)
    {
        // SEARCHABLE PARAMETERS 
        /*
           * E.g http://localhost:8000/api/v1/books?name=:nameOfBook
           * N.B Full Match Implemented
        */
        if($request->name) {
            $books = Books::where('name', $request->name)->get();
        } elseif($request->country) {
            $books = Books::where('country', $request->country)->get();
        } elseif($request->publisher) {
            $books = Books::where('publisher', $request->publisher)->get();
        } elseif($request->release_date && is_numeric($request->release_date)) {
            $books = Books::where('release_date',  'LIKE', $request->release_date.'%')->get();
        } else {
           $books = Books::all(); 
        }
        
        // PAGE ITEMS ACCORDING TO REQUEST - FOR REQUIREMENT 3A
        $itemsPerPage = $request->items; // Minimum - 5 items on a page
        
        if($itemsPerPage && is_numeric($itemsPerPage)) {
            $books = (count($books) > 5) ? Books::simplePaginate($itemsPerPage) : $books;
        } 

        // Reassign authors into an array for response
        foreach ($books as $book) {
            $book->authors = explode(",", $book->authors);
        }

        // SEND RESPONSE & RESULTS
        return responseFormat(200, "success", $books, null); 
    }

    /*
     * CREATE - Add a new Book
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'authors' => 'required',
            'country' => 'required',
            'publisher' => 'required',
            'release_date' => 'required',
            'number_of_pages' => 'required'
        ]); 
        
        // Split authors from array
        $authors = implode(",", $request->authors);

        $newBook = array(
                "name" => $request->name,
                "isbn" => $request->isbn,
                "authors" => $authors,
                "number_of_pages" => $request->number_of_pages,
                "publisher" => $request->publisher,
                "country" => $request->country,
                "release_date" => $request->release_date
        );
        
        // Create Book
        Books::create($newBook);

        // Reassign authors into an array for response
        $newBook["authors"] = $request->authors;

        $book = ["book" => $newBook];
        
        // SEND RESPONSE & RESULTS
        return responseFormat(201, "success", $book, null);
    }

    /**
     * SHOW - Fetch a book
     */
    public function show($id)
    {
        $book = Books::where('id', $id)
                ->take(1)
                ->get();
        if (count($book) < 1) {
            return responseFormat(404, "error", [], "No book found with the ID supplied: " . $id);
        }
        $book[0]->authors = explode(",", $book[0]->authors);
        
        // SEND RESPONSE & RESULTS
        return responseFormat(200, "success", $book, null);

    }


    /**
     * UPDATE - Update the specified book
     */
    public function update($id, Request $request)
    {
        $request->validate([
            'name' => 'required',
            'isbn' => 'required',
            'authors' => 'required',
            'country' => 'required',
            'publisher' => 'required',
            'release_date' => 'required',
            'number_of_pages' => 'required'
        ]);
        
        if(is_array($request->authors)) {
            // Split authors from array
            $request->authors = implode(",", $request->authors);
        }

        $book = Books::find($id);
        // Check if book is present
        if (!$book) {
            return responseFormat(404, "error", [], "No book found with the ID supplied: " . $id);
        }

        $bookName = $book->name;
        $book->update($request->all());

        // Reassign authors into an array for response
        $book->authors = explode(",", $request->authors);
        
        // SEND RESPONSE & RESULTS
        return responseFormat(200, "success", $book, "The book, " . $bookName . " was updated successfully");
        
    }

    /**
     * DELETE - Delete a book from db.
     */
    public function destroy($id)
    {
        $book = Books::find($id);
        if (!$book) {
            return responseFormat(404, "error", [], "No book found with the ID supplied: " . $id);
        }
        $bookName = $book->name;

        $book->delete();

        // SEND RESPONSE & RESULTS
        return responseFormat(200, "success", [], "The book, " . $bookName . " was deleted successfully");
    }
    
}