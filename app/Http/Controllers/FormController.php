<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FormController extends Controller
{
  public function store(Request $request) {

    $input = $request -> all();

    $rules = [
      'text' => [
        'required',
        'alpha_dash',
        'max:255',
        //controllo dei token
        function ($attribute, $value, $fail) {
            //suddivido la stringa contenente il testo dell'input in array
            $arr = str_split($value);
            $count = 0;
            $correct = true;

            //per ciascun array cerco il separatore
            foreach ($arr as $key => $variable) {
              //per ogni separatore "_" incremento il counter di uno mentre lo reimposto in caso contrario
              if ($variable=='_') {
                $count++;
              } else {
                $count=0;
              }
              //se il contatore raggiunge il valore "2" i separatori sono affiancati
              if ($count==2) {
                $correct=false;
              }
            }

            if ($correct == false) {
                $fail('Separatori non validi');
            }
        },
      ]

    ];

    $messages = [
      'required' => 'Il campo è vuoto!',
      'alpha_dash'    => 'Niente caratteri speciali!',
    ];

    $validator = Validator::make($input, $rules, $messages);

    if ($validator->fails()) {

      $msg = $validator->errors()->first();

      //stringa per il log
      $log  = '['.date("F j, Y, g:i a").']'.$msg.PHP_EOL;

      //append della stringa
      $file = date("j.n.Y").'-'.'test_Across'.'.log';

      file_put_contents($file, $log, FILE_APPEND);


      return redirect('/')
                          ->withErrors($validator)
                          ->withInput();
    }

    function palindromeCheck($input){

      $toString = implode("_", $input);
      $words = explode("_", $toString);
      $palindromeWords = [];

      foreach ($words as $key => $word) {
        if ($word == strrev($word))
        $palindromeWords[] = $word;
      }

      return $palindromeWords;
    }

    $paCheck = palindromeCheck($input);

    if ( count($paCheck) > 0 ){
      $paWords = implode(",", $paCheck);
      $pamsg = 'le seguenti parole: '.$paWords.'; sono palindrome.';

      //stringa per il log
      $palog  = '['.date("F j, Y, g:i a").']'.$pamsg.PHP_EOL;

      //append della stringa
      $pafile = date("j.n.Y").'-'.'test_Across'.'.log';

      file_put_contents($pafile, $palog, FILE_APPEND);
    }

    return redirect() -> route('form');
  }
}
