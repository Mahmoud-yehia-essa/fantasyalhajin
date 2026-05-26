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
use App\Models\CamelRoundParticipation;

class DashboardController extends Controller
{

    public function showDashboard()
    {
        $festival_count = Festival::count();
        $rounds_count = Round::count();
        $camal_count = CamelRoundParticipation::count();
        $nomination_count = Nomination::count();
        $category_count = Category::count();
        $games_count = Game::count();
        $questions_count = Question::count();
        $users_count = User::where('role', '!=', 'admin')->count();

        // Get only the latest 10 users for the table on dashboard
        $users = User::where('role', '!=', 'admin')->latest()->take(10)->get();

        return view('admin.index', compact(
            'users',
            'users_count',
            'category_count',
            'games_count',
            'questions_count',
            'festival_count',
            'rounds_count',
            'camal_count',
            'nomination_count'
        ));
    }
}
