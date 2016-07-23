<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Book;
use App\Http\Requests;

class UserApiController extends Controller
{


    public function addBookToUser($userId,$bookId)
    {
        $user = User::find($userId);
        if(!$user){
            return response('There is no user with id ' . $userId, 404);
        }

        $book = Book::find($bookId);
        if(!$book){
            return response('There is no book with id'.$bookId,404);
        }elseif ($book->user_id == $userId){
            return response('This user already has this book',406);
        }elseif ($book->user_id != 0){
            return response('This book uses by other member',406);
        }

        $user->books()->save($book);

        return 'Book added successfully, user updated';
    }


    public function showBooks($id)
    {
        $user = User::find($id);
        if($user){
            return $user->books;
        }else{
            return response('There is no user with id ' . $id, 404);
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
        $user = User::find($id);
        if($user){
            return $user;
        }else{
            return response('There is no user with id ' . $id, 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
