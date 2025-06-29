<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\User;
use App\Services\Operations;
use Illuminate\Http\Request;


class MainController extends Controller
{
   public function index()
   {
      //load user's notes
      $id = session('user.id');                     //pegar id do user logado
      $notes = User::find($id)                       //achar user
                  ->notes()                              //achar suas notas
                  ->whereNull('deleted_at')     //ignorar notas apagadas (deleted_at) e só buscar as notas que estão com deleted_at = null
                  ->get()                                //retornar notas  
                  ->toArray();                           //transformar em array      

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
                'text_title.min' =>'O título deve ter pelo menos :min caracteres.',
                'text_title.max' =>'O título deve ter no máximo :max caracteres.',
                
                'text_note.required' =>'A nota é obrigatória.',
                'text_note.min' =>'A nota deve ter pelo menos :min caracteres.',
                'text_note.max' =>'A nota deve ter no máximo :max caracteres.'

            ]
        );
      //get user id
      $id = session('user.id');

      //create new note
      $note = new Note();
      $note->user_id =$id;
      $note->title = $request->text_title;
      $note->text = $request->text_note;
      $note->save();

      //redirect to home

      return redirect()->route('home');
   }

   public function editNote($id) {
      $id = Operations::decryptId($id);   
      // load note
      $note = Note::find($id);
      //show edit note view
      return view('edit_note', ['note' =>$note]);
   }

   public function editNoteSubmit(Request $request){
      //validate request
         $request -> validate (
    [
                'text_title' => 'required|min:3|max:200',
                'text_note'  => 'required|min:3|max:3000'
            ], 
            //error messages
    [
                'text_title.required' =>'O título é obrigatório',
                'text_title.min' =>'O título deve ter pelo menos :min caracteres.',
                'text_title.max' =>'O título deve ter no máximo :max caracteres.',
                
                'text_note.required' =>'A nota é obrigatória.',
                'text_note.min' =>'A nota deve ter pelo menos :min caracteres.',
                'text_note.max' =>'A nota deve ter no máximo :max caracteres.'

            ]
        );

        // check if note_id exists
        if($request->note_id == null){
         return redirect()->route('home');
        }

      // decrypt note_id 
        $id = Operations::decryptId($request->note_id);

      // load note
        $note = Note::find($id);
      //update note
        $note->title =$request->text_title;
        $note->text = $request->text_note;
        $note->save();
      //redirect to home
      return redirect()->route('home');
   }
      public function deleteNote($id) 
      {
      $id = Operations::decryptId($id);   
      // LOAD NOTE
      $note = Note::find($id);
      
      //show delete note confirm
      return view('delete_note', ['note' =>$note]);
   }

   public function deleteNoteConfirm($id)
   {
      //check i id is encrypt
      $id = Operations::decryptId($id);

      //load note
      $note = Note::find($id);

      //1. hard delete
      //$note->delete();
      //2. soft delete
      $note->deleted_at = date ('Y-m-d H:i:s');
      $note->save();
      //rediret to home
      return redirect()->route('home');
   }

}
