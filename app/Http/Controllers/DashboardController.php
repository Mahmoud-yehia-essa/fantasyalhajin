<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\User;
use App\Models\Camal;
use App\Models\Round;
use App\Models\Category;
use App\Models\Festival;
use App\Models\Question;
use App\Models\Nomination;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function showDashboard()
    {


    $festival = Festival::latest()->get();
     $rounds = Round::latest()->get();
     $camal = Camal::latest()->get();

          $nomination = Nomination::latest()->get();




    $users = User::where('role', '!=', 'admin')->latest()->get();

    $category = Category::latest()->get();

    $games = Game::latest()->get();

    $questions = Question::latest()->get();

    return view('admin.index',compact('users','category','games','questions','festival','rounds','camal','nomination'));

        // return view('admin.index');
    }
}
