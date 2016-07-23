<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Book;
use App\Http\Requests;
use Illuminate\Support\Facades\Validator;

class BookApiController extends Controller
{
    
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
        $book = Book::find($id);
        if($book){
            return $book;
        }else{
            return response('There is no book with id'.$id,404);
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
