<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\User;
use App\Book;

class UserActionLogTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testSuccessfulBookCheckout()
    {
        $user = factory(User::class)->create();
        $book = factory(Book::class)->create([
            "title" => "Programming PHP",
            "isbn" => "0565926102",
            "publication_date" => "2002-03-26",
            "status" => "AVAILABLE"
        ]);

        $data = [
            'user_id' => $user->id,
            'book_id' => $book->id,
            'book_status' => 'CHECKOUT',
            'created_at' => date("Y-m-d H:i:s")
        ];
        
        $this->json('POST', 'api/book/change', $data, ['Accept' => 'application/json'])
                    ->assertStatus(200)
                    ->assertJson([
                        "message" => "Book checked out successfully",
                        "code" => 200
                    ]);
        
        $user->books()->detach($book->id);
        User::destroy($user->id);
        Book::destroy($book->id);
        // fwrite(STDERR, print_r($result, TRUE));
    }

    public function testSuccessfulBookCheckin()
    {
        $user = factory(User::class)->create();
        $book = factory(Book::class)->create([
            "title" => "Programming PHP",
            "isbn" => "1565926102",
            "publication_date" => "2002-03-26",
            "status" => "AVAILABLE"
        ]);

        $user->books()->attach(
            $book->id, 
            [
                "status" => "CHECKOUT",
                "created_at" => date("Y-m-d H:i:s")
            ]
        );
        $book->status = "CHECKED_OUT";
        $book->save();

        $data = [
            'user_id' => $user->id,
            'book_id' => $book->id,
            'book_status' => 'CHECKIN',
            'created_at' => date("Y-m-d H:i:s")
        ];
        
        $this->json('POST', 'api/book/change', $data, ['Accept' => 'application/json'])
                    ->assertStatus(200)
                    ->assertJson([
                        "message" => "Book checked in successfully",
                        "code" => 200
                    ]);
        
        $user->books()->detach($book->id);
        User::destroy($user->id);
        Book::destroy($book->id);
        // fwrite(STDERR, print_r($result, TRUE));
    }
}
