<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdsController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CamalController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\PriceController;
use App\Http\Controllers\PrizeController;
use App\Http\Controllers\RoundController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\PayMentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SponsorController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FestivalController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AppVersionController;
use App\Http\Controllers\NominationController;
use App\Http\Controllers\QuestionAIController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\FestivalPointController;
use App\Http\Controllers\LiveBroadcastController;

Route::get('/admin', function () {
    // return view('welcome');
    return redirect()->route('dashboard');
});



Route::controller(IndexController::class)->group(function () {


    Route::get('/', 'showSoon')->name('show.soon');


});


// Route::get('/dashboard', function () {
//     return view('admin.index');
// })->middleware(['auth', 'verified','checkUserRole'])->name('dashboard');


Route::controller(DashboardController::class)->middleware(['auth', 'verified','checkUserRole'])->group(function () {


    Route::get('/dashboard', 'showDashboard')->name('dashboard');


});

Route::controller(NotificationController::class)->middleware(['checkUserRole','auth'])->group(function () {


    Route::get('/add/notification', 'sendNotification')->name('send.notification');
    Route::get('/all/notification', 'alldNotification')->name('all.notification');


});

Route::controller(AppVersionController::class)->middleware(['checkUserRole','auth'])->group(function () {


    Route::get('/add/versions', 'addVersions')->name('add.versions');
    Route::post('/update/versions', 'updateVersions')->name('update.versions.store');


});







Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::get('/admin/logout', [AdminController::class, 'destroy'])->name('admin.logout');




});


Route::controller(AdminController::class)
->middleware(['checkUserRole','auth'])
->group(function () {
    // Route::get('/admin/logout', 'destroy')->name('admin.logout');

    Route::get('/admin/profile', 'adminProfile')->name('admin.profile');

    Route::post('/admin/profile', 'adminProfileStore')->name('admin.profile.store');

    Route::get('/admin/change/password', 'AdminChangePassword')->name('admin.change.password');


    Route::post('/admin/update/password', 'AdminUpdatePassword')->name('update.password');







});


Route::controller(CategoryController::class)->middleware(['checkUserRole','auth'])->group(function () {
    Route::get('/admin/category', 'category')->name('all.category');

    Route::get('/admin/add/category', 'addCategory')->name('add.category');


    Route::post('/add/category' , 'storeCategory')->name('add.category.store');

    Route::get('/admin/edit/category/{id}', 'editCategort')->name('edit.category');

    Route::post('/edit/category' , 'editCategortStore')->name('edit.category.store');


    Route::get('/delete/category/{id}' , 'deleteCategory')->name('delete.category');

    Route::get('/category/inactive/{id}', 'categoryInactive')->name('inactive.category');


    Route::get('/category/active/{id}', 'categoryActive')->name('active.category');



});






Route::controller(FestivalController::class)->middleware(['checkUserRole','auth'])->group(function () {
    Route::get('/all/festival', 'allFestival')->name('all.festival');

    Route::get('/add/festival', 'addFestival')->name('add.festival');


    Route::post('/add/festival' , 'storeFestival')->name('add.festival.store');

    Route::get('/edit/festival/{id}', 'editFestival')->name('edit.festival');

    Route::post('/edit/festival' , 'updateFestival')->name('update.festival');


    Route::get('/delete/festival/{id}' , 'deleteFestival')->name('delete.festival');

    Route::get('/festival/inactive/{id}', 'festivalInactive')->name('inactive.festival');


    Route::get('/festival/active/{id}', 'festivalActive')->name('active.festival');



});


Route::controller(RoundController::class)
    ->middleware(['checkUserRole','auth'])
    ->group(function () {

        Route::get('/all/round', 'allRound')->name('all.round');

        Route::get('/add/round', 'addRound')->name('add.round');

        Route::post('/add/round', 'storeRound')->name('add.round.store');

        Route::get('/edit/round/{id}', 'editRound')->name('edit.round');

        Route::post('/edit/round', 'updateRound')->name('update.round');

        Route::get('/delete/round/{id}', 'deleteRound')->name('delete.round');

        Route::get('/round/inactive/{id}', 'roundInactive')->name('inactive.round');

        Route::get('/round/active/{id}', 'roundActive')->name('active.round');
        // Route::get('/get-camals/{gender}', 'getCamals')->name('get.camals');





        Route::get('/get-camals/{gender}', 'getCamals')->name('get.camals');
// Route::get('/get-camals/{gender}', [CamalController::class, 'getCamals']);


    });


Route::controller(FestivalPointController::class)
    ->middleware(['checkUserRole','auth'])
    ->group(function () {
        Route::get('/festival-points', 'index')->name('all.festival.points');
        Route::get('/festival-points/add', 'create')->name('add.festival.points');
        Route::post('/festival-points/store', 'store')->name('store.festival.points');
        Route::get('/festival-points/edit/{id}', 'edit')->name('edit.festival.points');
        Route::post('/festival-points/update/{id}', 'update')->name('update.festival.points');
        Route::get('/festival-points/delete/{id}', 'destroy')->name('delete.festival.points');
    });





Route::controller(UserController::class)->middleware(['checkUserRole','auth'])->group(function () {
    Route::get('/users/all', 'getAllUsers')->name('all.users');

        Route::get('/owners/all', 'getAllOwners')->name('all.owners');
        Route::get('/admin/all', 'getAllAdmin')->name('all.admin');

    Route::get('/user/add', 'addUser')->name('add.user');

    Route::post('/user/add', 'addUserStore')->name('add.user.store');




    Route::get('/user/edit/{id}', 'editUser')->name('edit.user');

    Route::post('/user/edit', 'editUserStore')->name('edit.user.store');



    Route::get('/user/inactive/{id}', 'userInactive')->name('inactive.user');


    Route::get('/user/active/{id}', 'userActive')->name('active.user');


    Route::get('/user/delete/{id}', 'deleteUser')->name('delete.user');









});



Route::controller(NewsController::class)
    ->middleware(['checkUserRole','auth'])
    ->group(function () {

        // عرض كل الأخبار
        Route::get('/all/news', 'allNews')->name('all.news');

        // صفحة إضافة خبر جديد
        Route::get('/add/news', 'addNews')->name('add.news');

        // تخزين خبر جديد
        Route::post('/add/news', 'storeNews')->name('add.news.store');

        // صفحة تعديل الخبر
        Route::get('/edit/news/{id}', 'editNews')->name('edit.news');

        // تحديث الخبر
        Route::post('/edit/news', 'editNewsStore')->name('edit.news.store');

        // حذف الخبر
        Route::get('/delete/news/{id}', 'deleteNews')->name('delete.news');

        // جعل الخبر غير نشط
        Route::get('/news/inactive/{id}', 'newsInactive')->name('inactive.news');

        // جعل الخبر نشط
        Route::get('/news/active/{id}', 'newsActive')->name('active.news');

});


Route::controller(SliderController::class)
    ->middleware(['checkUserRole','auth'])
    ->group(function () {

        // عرض كل السلايدر
        Route::get('/all/slider', 'allSlider')->name('all.slider');

        // صفحة إضافة سلايدر جديد
        Route::get('/add/slider', 'addSlider')->name('add.slider');

        // تخزين سلايدر جديد
        Route::post('/add/slider', 'storeSlider')->name('add.slider.store');

        // صفحة تعديل السلايدر
        Route::get('/edit/slider/{id}', 'editSlider')->name('edit.slider');

        // تحديث السلايدر
        Route::post('/edit/slider', 'editSliderStore')->name('edit.slider.store');

        // حذف السلايدر
        Route::get('/delete/slider/{id}', 'deleteSlider')->name('delete.slider');

        // جعل السلايدر غير نشط
        Route::get('/slider/inactive/{id}', 'sliderInactive')->name('inactive.slider');

        // جعل السلايدر نشط
        Route::get('/slider/active/{id}', 'sliderActive')->name('active.slider');

    });




    Route::controller(LiveBroadcastController::class)
    ->middleware(['checkUserRole','auth'])
    ->group(function () {

        Route::get('/all/live-broadcast', 'allLiveBroadcast')->name('all.live.broadcast');
        Route::get('/add/live-broadcast', 'addLiveBroadcast')->name('add.live.broadcast');
        Route::post('/add/live-broadcast', 'storeLiveBroadcast')->name('add.live.broadcast.store');
        Route::get('/edit/live-broadcast/{id}', 'editLiveBroadcast')->name('edit.live.broadcast');
        Route::post('/edit/live-broadcast', 'editLiveBroadcastStore')->name('edit.live.broadcast.store');
        Route::get('/delete/live-broadcast/{id}', 'deleteLiveBroadcast')->name('delete.live.broadcast');
        Route::get('/live-broadcast/inactive/{id}', 'liveBroadcastInactive')->name('inactive.live.broadcast');
        Route::get('/live-broadcast/active/{id}', 'liveBroadcastActive')->name('active.live.broadcast');
});



Route::controller(NominationController::class)
    ->middleware(['checkUserRole', 'auth'])
    ->group(function () {

        // عرض كل الترشيحات
        Route::get('/nominations', 'allNomination')->name('all.nomination');

        // إضافة ترشيح جديد
        Route::get('/nominations/add', 'addNomination')->name('add.nomination');
        Route::post('/nominations/store', 'storeNomination')->name('store.nomination');

        // تعديل ترشيح موجود
        Route::get('/nominations/edit/{id}', 'editNomination')->name('edit.nomination');
        Route::post('/nominations/update/{id}', 'updateNomination')->name('update.nomination');

        // حذف ترشيح
        Route::get('/nominations/delete/{id}', 'deleteNomination')->name('delete.nomination');


                        Route::get('/add/round/winner', 'addRoundWinner')->name('add.round.winner');




        // Route::post('/add/round/winner', 'addRoundWinnerStore')->name('add.round.winner.store');
        Route::post('/add/round/winner/store', 'addRoundWinnerStore')->name('add.round.winner.store');




                Route::get('/get-rounds/{festival}', 'getRounds')->name('get.round');



                Route::get('/get-camals-by-round/{roundId}', 'getCamalsByRound');





        Route::get('add/nominations/user', 'addNominationUser')->name('add.nomination.user');




        Route::post('/nominations/user/store', 'addNominationUserStore')->name('store.nomination.user');





    });






Route::controller(CamalController::class)->middleware(['checkUserRole','auth'])->group(function () {
    Route::get('/camal/all', 'getAllCamal')->name('all.camal');


    Route::get('/camal/add', 'addCamal')->name('add.camal');

    Route::post('/camal/add', 'addCamalStore')->name('add.camal.store');




    Route::get('/camal/edit/{id}', 'editCamal')->name('edit.camal');

        Route::get('/camal/all/edit/{owner_id}', 'editAllCamal')->name('edit.all.camal');
        Route::post('/camal/all/edit/store', 'editAllCamalStore')->name('edit.all.camal.store');


    Route::post('/camal/edit', 'editCamalStore')->name('edit.camal.store');



    Route::get('/camal/inactive/{id}', 'camalInactive')->name('inactive.camal');


    Route::get('/camal/active/{id}', 'camalActive')->name('active.camal');


    Route::get('/camal/delete/{id}', 'deleteCamal')->name('delete.camal');









});






Route::controller(GameController::class)->middleware(['checkUserRole','auth'])->group(function () {

    Route::get('/games/all', 'allGames')->name('all.games');

    Route::get('/games/details/{id}', 'detailsGames')->name('details.games');
    Route::get('/games/delete/{id}', 'deleteGame')->name('delete.games');


});




Route::controller(AdsController::class)->middleware(['checkUserRole','auth'])->group(function(){

    Route::get('/add/ads' , 'addAds')->name('add.ads');

    // addAds
});

 // Report All Route
 Route::controller(ReportController::class)->middleware(['checkUserRole','auth'])->group(function(){

    Route::get('/report/view' , 'ReportView')->name('report.view');


    Route::post('/search/by/date' , 'SearchByDate')->name('search-by-date');

    Route::post('/search/by/month' , 'SearchByMonth')->name('search-by-month');
    Route::post('/search/by/year' , 'SearchByYear')->name('search-by-year');

    Route::get('/order/by/user' , 'OrderByUser')->name('order.by.user');
    Route::post('/search/by/user' , 'SearchByUser')->name('search-by-user');


});

Route::controller(QuestionController::class)->middleware(['checkUserRole','auth'])->group(function () {

    Route::get('/admin/add/question', 'addQuestion')->name('add.question');
    Route::post('/admin/add/question', 'addQuestionStore')->name('add.question.store');


    Route::get('/admin/all/question', 'allQuestion')->name('all.question');


    Route::get('/admin/edit/question/{id}', 'editQuestion')->name('edit.question');


    Route::post('/admin/edit/question', 'editQuestionStore')->name('edit.question.store');


    Route::get('/question/delete/{id}', 'deleteQuestion')->name('delete.question');









});


// Coupon controller

 Route::controller(CouponController::class)->middleware(['checkUserRole','auth'])->group(function(){




    ///

         Route::get('/all/coupon', 'AllCoupon')->name('all.coupon');
        Route::get('/add/coupon', 'AddCoupon')->name('add.coupon');
        Route::post('/store/coupon', 'StoreCoupon')->name('store.coupon');

        Route::get('/edit/coupon/{id}', 'EditCoupon')->name('edit.coupon');
        Route::post('/update/coupon', 'UpdateCoupon')->name('update.coupon');
        Route::get('/delete/coupon/{id}', 'DeleteCoupon')->name('delete.coupon');


});


/// price

 Route::controller(PriceController::class)->middleware(['checkUserRole','auth'])->group(function(){




    ///

         Route::get('/all/price', 'allPrice')->name('all.price');
        Route::get('/add/price', 'addPrice')->name('add.price');
        Route::post('/add/price', 'addPriceStore')->name('add.price.store');

                Route::get('/delete/price/{id}', 'deletePrice')->name('delete.price');
        Route::get('/edit/price/{id}', 'editPrice')->name('edit.price');



        Route::post('/edit/price', 'editPriceStore')->name('edit.price.store');


});



Route::middleware(['checkUserRole','auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



 Route::controller(SponsorController::class)->middleware(['checkUserRole','auth'])->group(function(){


        Route::get('/add/sponsor/new' , 'addSponsorNew')->name('sponsor.add.new');

    Route::get('/edit/sponsor/{id}' , 'editSponsor')->name('edit.sponsor');
        Route::get('/add/sponsor/question' , 'addSponsorQuestion')->name('sponsor.add.question');


        Route::post('/edit/sponsor/home/cate', 'editHomeCateStore')->name('edit.home.cate.store');

        Route::post('/add/sponsor/new', 'addSponsorStore')->name('add.sponsor.new');

        Route::get('/all/sponsor' , 'allSponsor')->name('sponsor.all');

                Route::get('/delete/sponsor/{id}', 'deleteSponsor')->name('delete.sponsor');


    // Route::post('/search/by/date' , 'SearchByDate')->name('search-by-date');

    // Route::post('/search/by/month' , 'SearchByMonth')->name('search-by-month');
    // Route::post('/search/by/year' , 'SearchByYear')->name('search-by-year');

    // Route::get('/order/by/user' , 'OrderByUser')->name('order.by.user');
    // Route::post('/search/by/user' , 'SearchByUser')->name('search-by-user');


});




Route::controller(PrizeController::class)
    ->middleware(['checkUserRole','auth'])
    ->group(function () {
        Route::get('/all/prizes', 'allPrizes')->name('all.prizes');
        Route::get('/add/prize', 'addPrize')->name('add.prize');
        Route::post('/add/prize', 'storePrize')->name('add.prize.store');
        Route::get('/edit/prize/{id}', 'editPrize')->name('edit.prize');
        Route::post('/edit/prize', 'editPrizeStore')->name('edit.prize.store');
        Route::get('/delete/prize/{id}', 'deletePrize')->name('delete.prize');
        Route::get('/prize/inactive/{id}', 'prizeInactive')->name('inactive.prize');
        Route::get('/prize/active/{id}', 'prizeActive')->name('active.prize');
});



Route::controller(QuestionAIController::class)->middleware(['checkUserRole','auth'])->group(function () {

    Route::get('/admin/add/question/ai', 'addQuestionAi')->name('add.question.ai');
    Route::post('/admin/add/question/to/game/ai', 'addQuestionToGameAi')->name('add.question.to.game.ai');


    Route::post('/admin/get/question/ai', 'getdQuestionStoreAi')->name('get.question.store.ai');


    Route::get('/admin/all/question/ai', 'allQuestionAi')->name('all.question.ai');


    Route::get('/admin/edit/question/ai/{id}', 'editQuestionAi')->name('edit.question.ai');


    Route::post('/admin/edit/question/ai', 'editQuestionStoreAi')->name('edit.question.store.ai');


    Route::get('/question/delete/ai/{id}', 'deleteQuestionAi')->name('delete.question.ai');









});


Route::get('/payment', [PayMentController::class, 'showPaymentPage']);

require __DIR__.'/auth.php';
