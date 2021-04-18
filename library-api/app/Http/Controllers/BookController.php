<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\BookPostRequest;
use App\Book;
use App\User;

class BookController extends Controller
{
    public function index() {
        return Book::all();
    }

    public function create(BookPostRequest $request) {
        Book::create([
            'title' => $request->title,
            'isbn' => $request->isbn,
            'publication_date' => $request->publication_date,
            'status'=> $request->status
        ]);
        return response()->json(["message" => "Book created successfully", "code" => 200]);
    }

    public function changeStatus(Request $request) {
        $user_id = $request->user_id;
        $book_id = $request->book_id;
        $book_status = $request->book_status;

        $user = User::find($user_id);
        $book = Book::find($book_id);
        
        if ( $book_status == "CHECKOUT") {
            if ($book->status == "AVAILABLE") {
                $user->books()->attach(
                    $book_id, 
                    [
                        "status" => $book_status,
                        "created_at" => date("Y-m-d H:i:s")
                    ]);

                $book->status = "CHECKED_OUT";
                $book->save();
                return response()->json(["message" => "Book checked out successfully", "code" => 200]);
            }
            else if ($book->status == "CHECKED_OUT") {
                return response()->json(["message" => "Book is not available", "code" => 200]);
            }
        }
        else if ($book_status == "CHECKIN") {
            if ($book->status == "AVAILABLE") {
                return response()->json(["message" => "Book was already available", "code" => 400]);
            }

            if ($book->user->last()->pivot->user_id == $user_id) {
                $user->books()->attach(
                    $book_id, 
                    [
                        "status" => $book_status,
                        "created_at" => date("Y-m-d H:i:s")
                    ]);
                $book->status = "AVAILABLE";
                $book->save();
                return response()->json(["message" => "Book checked in successfully", "code" => 200]);
            }
            else {
                return response()->json(["message" => "Book already checked out by other user", "code" => 400]);
            }
        }
    }
}
