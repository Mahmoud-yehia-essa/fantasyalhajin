<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PriceController;
use App\Http\Controllers\PrizeController;
use App\Http\Controllers\RoundController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\SponsorController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FestivalController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\AppVersionController;
use App\Http\Controllers\NominationController;
use App\Http\Controllers\FestivalPointController;
use App\Http\Controllers\LiveBroadcastController;


// PostMan URL for V1 remote : https://chraimba.net/admin-dashboard/public

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');




 Route::post('/login',[UserController::class,'loginApiV2']);
    Route::post('/register',[UserController::class,'registerApiV2']);


    Route::post('/login/email',[UserController::class,'loginApi']);


Route::post('/register/email',[UserController::class,'registerApi']);

        Route::post('/check/phone',[UserController::class,'checkPhoneNumberExist']);




// Route::post('/login',[UserController::class,'loginApi']);


// Route::post('/register',[UserController::class,'registerApi']);

Route::get('/categories',[CategoryController::class,'getCategoryApi']);
Route::get('/question/{id}',[QuestionController::class,'getQuestionApi']);

// Route::get('/categories',[CategoryController::class,'getCategoryApi'])->middleware('auth:sanctum');


Route::get('/question/{id}',[QuestionController::class,'getQuestionApi']);


Route::get('/answer/{id}',[QuestionController::class,'getQuestionAnswerApi']);




Route::post('/news',[NewsController::class,'getNewsApi']);

Route::post('/sliders',[SliderController::class,'getSlidersApi']);




//
Route::post('/festivals',[FestivalController::class,'getFestivalsApi']);




// {
//   "type": "current",
//   "limit": "1"
// }

// {
//   "type": "upcoming",
//   "limit": 5
// }

// {
//   "type": "ended"
// }

// {
//   "type": "all"
// }
///




Route::post('/live/broadcast',[LiveBroadcastController::class,'getLiveBroadcastApi']);


Route::post('/all/sponsor',[SponsorController::class,'getAllsponsorApi']);


Route::post('/prizes',[PrizeController::class,'getPrizeApi']);



Route::post('/get/rounds',[RoundController::class,'getRoundsDatesApi']);

Route::post('/get/rounds/by/date',[RoundController::class,'getRoundsByDateApi']);



Route::post('/get/camel/participations',[RoundController::class,'getCamelParticipationsApi']);


Route::post('/add/nomination/user',[NominationController::class,'addNominationUserAPI']);

Route::post('/check/nomination',[NominationController::class,'checkNominationApi']);

Route::post('/get/user/nomination',[NominationController::class,'getUserNominationsApi']);



Route::post('/get/festivals/points/nomination',[NominationController::class,'getUserFestivalsWithPoints']);


Route::post('get/festival/leaderboard',[NominationController::class,'getFestivalLeaderboard']);



Route::post('/get/festival/point',[FestivalPointController::class,'getFestivalPoints']);






// After getting api key

// Route::post('/create-post', [PostController::class, 'storeNewPostApi'])->middleware('auth:sanctum');


// Route::post('/upload-image/{user_id}', [UserController::class, 'uploadImageApi']);

Route::post('/upload-image', [UserController::class, 'uploadImageApi']);

Route::post('/upload-image/{id}',[UserController::class,'uploadUpadteImageApi']);



Route::post('/edit/user',[UserController::class,'editUserApi']);

// Sava Game
Route::post('/save/game',[GameController::class,'saveGameApi']);
Route::post('/save/team',[GameController::class,'saveTeamGameApi']);

Route::post('/save/category',[GameController::class,'saveGameCatesApi']);

Route::post('/save/questions/register',[GameController::class,'saveGameQuetionApi']);
// Route::post('/save/game/question',[GameController::class,'saveGameApi']);



/// get Gammes
Route::get('/games/by/{id}',[GameController::class,'getGamesByUserId']);


/// get user by email

Route::get('/user/by/{email}',[UserController::class,'getUserByEmail']);

Route::post('/edit/user/password',[UserController::class,'editUserPasswordApi']);



Route::post('/update/user/games/number',[UserController::class,'updateUserGamesNumber']);


Route::post('/delete/user',[UserController::class,'deleteUserApi']);


Route::get('/setting/app/{id}',[AppVersionController::class,'getSettingApp']);


Route::get('/get/price',[PriceController::class,'getAllPrice']);


Route::post('/get/coupon',[CouponController::class,'getCouponByNameApi']);


Route::get('/get/sponsor',[SponsorController::class,'getSponsor']);




// PostMan URL for V1 remote : https://chraimba.net/admin-dashboard/public

// ------------------ New API v2 ------------------
Route::prefix('v2')->group(function () {

    Route::get('/user', function (Request $request) {
        return $request->user();
    })->middleware('auth:sanctum');

    Route::post('/login',[UserController::class,'loginApiV2']);
    Route::post('/register',[UserController::class,'registerApiV2']);

        Route::post('/check/phone',[UserController::class,'checkPhoneNumberExist']);



    Route::get('/categories',[CategoryController::class,'getCategoryApi']);
    Route::get('/question/{id}',[QuestionController::class,'getQuestionApi']);
    Route::get('/answer/{id}',[QuestionController::class,'getQuestionAnswerApi']);

    Route::post('/upload-image', [UserController::class, 'uploadImageApi']);
    Route::post('/upload-image/{id}',[UserController::class,'uploadUpadteImageApi']);

    Route::post('/edit/user',[UserController::class,'editUserApi']);

    // Save Game
    Route::post('/save/game',[GameController::class,'saveGameApi']);
    Route::post('/save/team',[GameController::class,'saveTeamGameApi']);
    Route::post('/save/category',[GameController::class,'saveGameCatesApi']);
    Route::post('/save/questions/register',[GameController::class,'saveGameQuetionApi']);

    // Get Games
    Route::get('/games/by/{id}',[GameController::class,'getGamesByUserId']);

    // Get user by email
    Route::get('/user/by/{email}',[UserController::class,'getUserByEmail']);

    Route::post('/edit/user/password',[UserController::class,'editUserPasswordApi']);
    Route::post('/update/user/games/number',[UserController::class,'updateUserGamesNumber']);
    Route::post('/delete/user',[UserController::class,'deleteUserApi']);

    Route::get('/setting/app/{id}',[AppVersionController::class,'getSettingApp']);
    Route::get('/get/price',[PriceController::class,'getAllPrice']);
    Route::post('/get/coupon',[CouponController::class,'getCouponByNameApi']);
    Route::get('/get/sponsor',[SponsorController::class,'getSponsor']);
});

