<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\Operations;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use PhpParser\Node\Stmt\TryCatch;

class MainController extends Controller
{
   public function index()
   {
      //load user's notes
      $id = session('user.id');
      $notes = User::find($id)->notes()->get()->toArray();

      //show home view
      return view ('home', ['notes'=> $notes]);
   }

   public function newNote()
   {
      // show new note view
      return view ('new_note');

   }

   public function newNoteSubmit(Request $request)
   {
      //validate request 
       $request -> validate (
    [
                'text_title' => 'required|min:3|max:200',
                'text_note'  => 'required|min:3|max:3000'
            ], 
            //error messages
    [
                'text_title.required' =>'O título é obrigatório',

                'text_note.required' =>'A nota é obrigatória.',
                'text_note.min' =>'A nota deve ter pelo menos :min caracteres.',
                'text_note.max' =>'A nota deve ter no máximo :max caracteres.'

            ]
        );

      //get user id

      //create new note

      //redirect to home
   }

   public function editNote($id) {
      $id = Operations::decryptId($id);   
      echo "I'm editing note with id = $id";

   }

      public function deleteNote($id) {
      $id = Operations::decryptId($id);   
      echo "I'm deleting note with id = $id";
   }

}
