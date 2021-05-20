<?php

namespace App\Http\Controllers\BotHandler;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index(Request $request) {
        //dd($request);
        return 'ok';
        //return response()->json(['Привет']);
    }
}
