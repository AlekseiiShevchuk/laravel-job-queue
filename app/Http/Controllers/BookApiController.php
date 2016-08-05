<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Book;
use App\Http\Requests;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Queue;
use Carbon\Carbon;
use App\Jobs\SendBookRefundNotification;

class BookApiController extends Controller
{

    /**
     * @param $book
     */
    public function InformUsersAboutNewBook($book)
    {
        $users = User::all();
        foreach ($users as $user) {
            $this->dispatch(new InformUserAboutNewBook($user,$book));
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function giveback($id){
        
            $book = Book::find($id);
        if($book){
            $book->user_id = null;
            $book->save();
            return response('Book with ID:' .$id. ' has given back successfully');
        }else{
            return response('There is no book with id'.$id,406);
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = Book::all();
        return $books;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'title' => 'required',
            'year' => 'required|digits:4',
            'author' => 'required|alpha',
            'genre' => 'required|alpha' //alpha - поле может содержать только буквы
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {

            return response($validator->errors(),422);

        } else {
            $book = new Book($request->all());
            $book->save();
            $this->InformUsersAboutNewBook($book);

            return response()->json($book, 201);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $book = Book::findOrFail($id);
        return $book;
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $book = Book::findOrFail($id);

            $rules = [
                'title' => 'required',
                'year' => 'required|digits:4',
                'author' => 'required|alpha',
                'user_id' => 'exists:users,id',
                'genre' => 'required|alpha' //alpha - поле может содержать только буквы
            ];

            $validator = Validator::make($request->all(),$rules);
            if($validator->fails()){
                return response('',406);
            }else {

                $book->title = $request->title;
                $book->year = $request->year;
                $book->author = $request->author;
                $book->genre = $request->genre;
                $book->user_id = $request->user_id;
                $book->save();
                if($request->user_id){
                    $user = User::findOrfail($request->user_id);
                    $date = Carbon::now()->addDays(30);
                    Queue::later($date, new SendBookRefundNotification($user,$book));
                }
                $message = 'Book with ID:' . $book->id . ' successfully updated';
                return $message;
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
            $book->delete();
            $message='Book with ID:' .$id. ' Successfully deleted';
            return $message;
        }else{
            $message='ERROR: There is no Book with ID:' .$id;
            return response($message,406);
        }

    }
}
