<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('chat');
});

Route::post('/process', function () {
    // $userInput = request('user_input');
    $userAnswer = request('user_input');
    $constant1 = "Suppose you were a code reviewer, and you need to provide feedback in a written form after checking an applicant's code with the following algorithm question asking to";
    $constant2 = "Point out in bulleted points, 1) the good points, 2) the needed improvements, and 3) the developer level by making sure it's one word to indicate if the candidate is a junior, mid-level or senior developer. Don't bother to mention any further explanation, or disclaimers. The applicant's answer is:";
    // $constant1 = "Suppose you were a code reviewer, and you check an applicant's code with the following algorithm question asking to";
    $dynamicVariable1 = "write a Python program to find those numbers which are divisible by 7 and multiples of 5, between 1500 and 2700 (both included).";
    // $constant2 = "point out in bulleted points the good points and also the needed improvements, afterwards provide in one word if this person is a junior, mid-level or senior developer. The applicant's answer is:";
    $additional= "remember to show good points: in a list , followed by needed improvenents and then after show overall which will determine the level of a developer.";
    $dynamicVariable2 = $userAnswer;

    $userInput = $constant1 . " " . $dynamicVariable1 . " " . $constant2 . " " . $dynamicVariable2. " " . $additional;;

    $apiKey = env('OPEN_AI_KEY');

    $headers = [
        'Content-Type: application/json',
        'Authorization: Bearer ' . $apiKey,
    ];

    $data = [
        'model' => 'gpt-3.5-turbo',
        'messages' => [
            ['role' => 'system', 'content' => 'You are a helpful assistant.'],
            ['role' => 'user', 'content' => $userInput],
        ],
    ];

    $dataString = json_encode($data);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://api.openai.com/v1/chat/completions');
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
    $output = json_decode($response, true);
    $generatedText = $output['choices'][0]['message']['content'];

    return view('chat')->with('generatedText', $generatedText);
});
