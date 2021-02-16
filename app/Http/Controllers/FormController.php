<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//per la validazione ho deciso di creare un validatore manualmente tramite facade Validator
use Illuminate\Support\Facades\Validator;

class FormController extends Controller
{
  public function store(Request $request) {

    //pre-imposto i dati di input, rules e messages
    $input = $request -> all();

    $rules = [
      'text' => [
        'required',
        //ho optato per alpha_dash per l'utilizzo dei dash come separatori
        'alpha_dash',
        'max:255',
        //controllo dei separatori (su custom rule)
        function ($attribute, $value, $fail) {
            //suddivido la stringa contenente il testo dell'input in array
            $arr = str_split($value);
            $count = 0;
            $correct = true;

            //per ciascun array cerco il separatore
            foreach ($arr as $key => $variable) {
              //per ogni separatore "_" incremento il counter di uno mentre lo azzero in caso contrario
              if ($variable=='_') {
                $count++;
              } else {
                $count=0;
              }
              //se il contatore raggiunge il valore "2" i separatori sono affiancati, di conseguenza l'input è errato
              if ($count==2) {
                $correct=false;
              }
            }

            if ($correct == false) {
                $fail('Separatori non validi');
            }
        },
      ],
    ];
    //imposto dei messaggi custom
    $messages = [
      'required' => 'Il campo è vuoto!',
      'alpha_dash'    => 'Niente caratteri speciali!',
    ];

    $validator = Validator::make($input, $rules, $messages);

    //in caso di fail
    if ($validator->fails()) {

      //vado a prendere il messaggio
      $msg = $validator->errors()->first();

      //lo inserisco in una stringa per il log
      $log  = '['.date("F j, Y, g:i a").'] '.$msg.PHP_EOL;

      //imposto il nome del file
      $file = date("j.n.Y").'-'.'test_Across'.'.log';

      //e utilizzo la funzione "file_put_contents" per eseguire l'append o creare il file log nel caso non dovesse ancora esistere
      file_put_contents($file, $log, FILE_APPEND);
      //dato che non viene specificata, la destinazione del file log è all'interno del public folder

      //dato che la validazione mi ha dato errori torno al form riportandoli all'utente
      return redirect('/')
                          ->withErrors($validator)
                          ->withInput();
    }

    //funzione per il controllo delle parole palindrome
    function palindromeCheck($input){

      //dispongo i dati in array utilizzando i separatori
      $toString = implode("_", $input);
      $words = explode("_", $toString);
      //creo un array di parole palindrome
      $palindromeWords = [];
      //per ciascuna parola eseguo il controllo e se palindroma la aggiungo al corrispondente array
      foreach ($words as $key => $word) {
        if ($word == strrev($word))
        $palindromeWords[] = $word;
      }
      //la funzione mi ritorna quindi l'array delle parole palindrome
      return $palindromeWords;
    }

    // eseguo la funzione sull'input del post
    $paCheck = palindromeCheck($input);
    //controllo se la funzione ha rilevato delle parole valide
    if ( count($paCheck) > 0 ){
      // raggruppo le parole in stringa
      $paWords = implode(",", $paCheck);
      // imposto la stringa per il log
      $pamsg = 'Le seguenti parole: '.$paWords.'; sono palindrome.';
      $palog  = '['.date("F j, Y, g:i a").'] '.$pamsg.PHP_EOL;

      // seleziono il file
      $pafile = date("j.n.Y").'-'.'test_Across'.'.log';
      // eseguo l'append
      file_put_contents($pafile, $palog, FILE_APPEND);
    }

    //nel caso in cui la validazione non mi ha dato errori ritorno al form
    return redirect() -> route('form');
  }
}
