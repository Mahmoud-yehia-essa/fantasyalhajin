<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Camal;
use App\Models\Round;
use App\Models\Festival;
use App\Models\Nomination;
use Illuminate\Http\Request;
use App\Models\FestivalPoint;
use App\Models\CamelRoundParticipation;

class NominationController extends Controller
{
    // عرض جميع الترشيحات
    public function allNomination()
    {

        // $nominations = Nomination::with(['user', 'camel', 'festival', 'round'])->get();
$nominations = Nomination::with(['user', 'camal', 'festival', 'round'])->get();

                // $nominations = Nomination::latest()->get();

                // return $nominations;
        return view('admin.nomination.all_nomination', compact('nominations'));
    }


      // عرض جميع الترشيحات
    public function addNominationUser()
    {

     $users = User::all();
        $camals = Camal::all();
        $festivals = Festival::all();
        $rounds = Round::all();

        return view('admin.nomination.add_nomination_user_for_camal', compact('users', 'camals', 'festivals', 'rounds'));


    }


    public function addNominationUserStore(Request $request)
    {



        Nomination::create([
            'user_id' => $request->user_id,
            'festival_id' => $request->festival_id,
            'round_id' => $request->round_id,
            'camel_round_participations_id' => $request->camal_id,

            'is_winner' =>  0,
        ]);


        return redirect()->route('all.nomination')->with('success', 'تم إضافة الترشيح بنجاح');





    }



    // صفحة إضافة ترشيح جديد
    public function addNomination()
    {
        $users = User::all();
        $camals = Camal::all();
        $festivals = Festival::all();
        $rounds = Round::all();
        return view('admin.nomination.add_nomination', compact('users', 'camals', 'festivals', 'rounds'));
    }



      public function addRoundWinner()
    {



        $users = User::all();
        $camals = Camal::all();
        $festivals = Festival::all();
        $rounds = Round::all();
        return view('admin.nomination.add_camal_winner', compact('users', 'camals', 'festivals', 'rounds'));
    }






 public function addRoundWinnerStore(Request $request)
    {






        /// Get point //



        $round = Round::find($request->round_id);

          $round->status = "finished";

          $round->save();



           $camelRoundParticipation = CamelRoundParticipation::find($request->camal_id);

           // get points

$festivalPoint = FestivalPoint::where('festival_id', $request->festival_id)
    ->where('age_name', $camelRoundParticipation->camal->age_name)
    ->first();

    //Get point OK
            // return $festivalPoint->points;


/// Get user who anotation
$nomination = Nomination::where('festival_id', $request->festival_id)
    ->where('round_id', $request->round_id)
    ->get();

  foreach ($nomination as $newnomination) {
    if($newnomination->camel_round_participations_id == $request->camal_id)
    {

        $newnomination->points = $festivalPoint->points;
        $newnomination->is_winner = 1;

         $newnomination->save();
    }
    else
    {

        $newnomination->is_winner = 2;
                 $newnomination->save();


    }
}

// return $nomination;
//     return $request->camal_id;

//     return $nomination;





        $camelRoundParticipation->is_winner = 1;
        $camelRoundParticipation->save();

        // return $camelRoundParticipation;

    return redirect()->route('all.nomination')->with('success', 'تم اضافة المطية الفائزة بنجاح');

    }

    // تخزين ترشيح جديد
    public function storeNomination(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'camal_id' => 'required|exists:camals,id',
            'festival_id' => 'required|exists:festivals,id',
            'round_id' => 'required|exists:rounds,id',
            'is_winner' => 'nullable|boolean',
        ]);

        Nomination::create([
            'user_id' => $request->user_id,
            'camal_id' => $request->camal_id,
            'festival_id' => $request->festival_id,
            'round_id' => $request->round_id,
            'is_winner' => $request->is_winner ?? 0,
        ]);

        return redirect()->route('all.nomination')->with('success', 'تم إضافة الترشيح بنجاح');
    }

    // صفحة تعديل ترشيح
    public function editNomination($id)
    {
        $nomination = Nomination::findOrFail($id);
        $users = User::all();
        $camals = Camal::all();
        $festivals = Festival::all();
        $rounds = Round::all();
        return view('admin.nomination.edit_nomination', compact('nomination', 'users', 'camals', 'festivals', 'rounds'));
    }

    // تحديث ترشيح
    public function updateNomination(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'camal_id' => 'required|exists:camals,id',
            'festival_id' => 'required|exists:festivals,id',
            'round_id' => 'required|exists:rounds,id',
            'is_winner' => 'nullable|boolean',
        ]);

        $nomination = Nomination::findOrFail($id);
        $nomination->update([
            'user_id' => $request->user_id,
            'camal_id' => $request->camal_id,
            'festival_id' => $request->festival_id,
            'round_id' => $request->round_id,
            'is_winner' => $request->is_winner ?? 0,
        ]);

        return redirect()->route('all.nomination')->with('success', 'تم تحديث الترشيح بنجاح');
    }

    // حذف ترشيح
    public function deleteNomination($id)
    {
        $nomination = Nomination::findOrFail($id);
        $nomination->delete();

        return redirect()->route('all.nomination')->with('success', 'تم حذف الترشيح بنجاح');
    }

    public function getRounds($festivalId)
{
    $rounds = Round::where('festival_id', $festivalId)->get();
    return response()->json($rounds);
}


//   public function getCamalsByRound($roundId)
// {


//     $camelRoundParticipation = CamelRoundParticipation::where('round_id', $roundId)->get();






//     return response()->json($camelRoundParticipation);
// }


public function getCamalsByRound($roundId)
{
    // نجيب المشاركات مع بيانات المطية
    $camelRoundParticipation = CamelRoundParticipation::with('camal')
        ->where('round_id', $roundId)
        ->get();

    // نرجع فقط البيانات المهمة (id + name)
    $camals = $camelRoundParticipation->map(function ($item) {
        return [
            'id' => $item->id,
            // 'camal_id' => $item->camal->id,
            'name' => $item->camal->name,
        ];
    });

    return response()->json($camals);
}




/// API

// public function addNominationUserAPI(Request $request)
// {
//     // إنشاء الترشيح مباشرة بدون validate
//     $nomination = Nomination::create([
//         'user_id' => $request->user_id,
//         'festival_id' => $request->festival_id,
//         'round_id' => $request->round_id,
//         'camel_round_participations_id' => $request->camal_id,
//         'is_winner' => 0,
//     ]);

//     // تحميل بيانات الجمل + صاحبه
//     $camalParticipation = \App\Models\CamelRoundParticipation::with([
//         'camal.user',
//         'round',
//     ])->find($request->camal_id);

//     // بيانات الجمل + صاحبه
//     $camalData = null;
//     if ($camalParticipation && $camalParticipation->camal) {
//         $camalData = [
//             'id' => $camalParticipation->camal->id,
//             'name' => $camalParticipation->camal->name,
//             'photo' => $camalParticipation->camal->photo,
//         ];

//         if ($camalParticipation->camal->user) {
//             $camalData = array_merge($camalData, [
//                 'user_id'   => $camalParticipation->camal->user->id,
//                 'fname'     => $camalParticipation->camal->user->fname,
//                 'lname'     => $camalParticipation->camal->user->lname,
//                 'email'     => $camalParticipation->camal->user->email,
//                 'phone'     => $camalParticipation->camal->user->phone,
//                 'user_photo'=> $camalParticipation->camal->user->photo,
//             ]);
//         }
//     }

//     // بيانات الشوط
//     $roundData = null;
//     if ($camalParticipation && $camalParticipation->round) {
//         $roundData = [
//             'id' => $camalParticipation->round->id,
//             'name' => $camalParticipation->round->name,
//             'name_en' => $camalParticipation->round->name_en,
//             'start' => \Carbon\Carbon::parse($camalParticipation->round->start)
//                         ->setTimezone('Asia/Kuwait')
//                         ->toDateTimeString(),
//             'end'   => \Carbon\Carbon::parse($camalParticipation->round->end)
//                         ->setTimezone('Asia/Kuwait')
//                         ->toDateTimeString(),
//             'status' => $camalParticipation->round->status,
//         ];
//     }

//     // بيانات المهرجان
//     $festival = \App\Models\Festival::find($request->festival_id);
//     $festivalData = null;
//     if ($festival) {
//         $festivalData = [
//             'id' => $festival->id,
//             'title' => $festival->title,
//             'title_en' => $festival->title_en,
//             'start' => \Carbon\Carbon::parse($festival->start)
//                         ->setTimezone('Asia/Kuwait')
//                         ->toDateTimeString(),
//             'end'   => \Carbon\Carbon::parse($festival->end)
//                         ->setTimezone('Asia/Kuwait')
//                         ->toDateTimeString(),
//             'status' => $festival->status,
//         ];
//     }

//     // استجابة JSON
//     return response()->json([
//         'success' => true,
//         'message' => 'تم إضافة الترشيح بنجاح',
//         'nomination' => $nomination,
//         'camal' => $camalData,
//         'round' => $roundData,
//         'festival' => $festivalData
//     ], 201);
// }


public function addNominationUserAPI(Request $request)
{
    $camalId    = $request->camal_id;
    $festivalId = $request->festival_id;
    $roundId    = $request->round_id;
    $userId     = $request->user_id;

    // التأكد من وجود سجل في camel_round_participations أو إنشاؤه
    $camalParticipation = \App\Models\CamelRoundParticipation::firstOrCreate(
        [
            'festival_id' => $festivalId,
            'round_id' => $roundId,
            'camal_id' => $camalId
        ],
        [
            'registration_number' => 'C-'.$roundId.'-'.$camalId,
            'is_winner' => 0
        ]
    );

    // إنشاء الترشيح
    $nomination = Nomination::create([
        'user_id' => $userId,
        'festival_id' => $festivalId,
        'round_id' => $roundId,
        'camel_round_participations_id' => $camalParticipation->id,
        'is_winner' => 0,
    ]);

    // تحميل بيانات الجمل + صاحبه + الشوط
    $camalParticipation = $camalParticipation->load(['camal.user', 'round']);

    // بيانات الجمل + صاحبه
    $camalData = null;
    if ($camalParticipation->camal) {
        $camalData = [
            'id' => $camalParticipation->camal->id,
            'name' => $camalParticipation->camal->name,
            'photo' => $camalParticipation->camal->photo,
        ];

        if ($camalParticipation->camal->user) {
            $camalData = array_merge($camalData, [
                'user_id'   => $camalParticipation->camal->user->id,
                'fname'     => $camalParticipation->camal->user->fname,
                'lname'     => $camalParticipation->camal->user->lname,
                'email'     => $camalParticipation->camal->user->email,
                'phone'     => $camalParticipation->camal->user->phone,
                'user_photo'=> $camalParticipation->camal->user->photo,
            ]);
        }
    }

    // بيانات الشوط
    $roundData = null;
    if ($camalParticipation->round) {
        $roundData = [
            'id' => $camalParticipation->round->id,
            'name' => $camalParticipation->round->name,
            'name_en' => $camalParticipation->round->name_en,
            'start' => \Carbon\Carbon::parse($camalParticipation->round->start)
                        ->setTimezone('Asia/Kuwait')
                        ->toDateTimeString(),
            'end'   => \Carbon\Carbon::parse($camalParticipation->round->end)
                        ->setTimezone('Asia/Kuwait')
                        ->toDateTimeString(),
            'status' => $camalParticipation->round->status,
        ];
    }

    // بيانات المهرجان
    $festival = \App\Models\Festival::find($festivalId);
    $festivalData = null;
    if ($festival) {
        $festivalData = [
            'id' => $festival->id,
            'name' => $festival->name,
            'name_en' => $festival->name_en,
            'des' => $festival->des,
            'des_en' => $festival->des_en,
            'location' => $festival->location,
            'start' => \Carbon\Carbon::parse($festival->start)
                        ->setTimezone('Asia/Kuwait')
                        ->toDateTimeString(),
            'end'   => \Carbon\Carbon::parse($festival->end)
                        ->setTimezone('Asia/Kuwait')
                        ->toDateTimeString(),
            'latitude' => $festival->latitude,
            'longitude' => $festival->longitude,
            'photo' => $festival->photo,
            'status' => $festival->status,
        ];
    }

    // استجابة JSON
    return response()->json([
        'success' => true,
        'message' => 'تم إضافة الترشيح بنجاح',
        'nomination' => $nomination,
        'camal' => $camalData,
        'round' => $roundData,
        'festival' => $festivalData
    ], 201);
}


// public function checkNominationApi(Request $request)
// {
//     $userId     = $request->input('user_id');
//     $festivalId = $request->input('festival_id');
//     $roundId    = $request->input('round_id');

//     $exists = \App\Models\Nomination::where('user_id', $userId)
//         ->where('festival_id', $festivalId)
//         ->where('round_id', $roundId)
//         ->exists();

//     return response()->json([
//         'success' => true,
//         'already_nominated' => $exists,
//         'message' => $exists
//             ? 'المستخدم قام بالترشيح مسبقاً'
//             : 'المستخدم لم يقم بالترشيح بعد'
//     ]);
// }


public function checkNominationApi(Request $request)
{
    $userId     = $request->input('user_id');
    $festivalId = $request->input('festival_id');
    $roundId    = $request->input('round_id');

    // جلب الترشيح مع بيانات الجمل وصاحب الجمل والشوط والمهرجان
    $nomination = \App\Models\Nomination::with([
        'camelRoundParticipation.camal.user',
        'camelRoundParticipation.round',
        'festival'
    ])
    ->where('user_id', $userId)
    ->where('festival_id', $festivalId)
    ->where('round_id', $roundId)
    ->first();

    $alreadyNominated = $nomination ? true : false;

    $data = null;
    if ($alreadyNominated) {
        $camalData = null;
        $roundData = null;
        $festivalData = null;

        if ($nomination->camelRoundParticipation && $nomination->camelRoundParticipation->camal) {
            $camal = $nomination->camelRoundParticipation->camal;
            $camalData = [
                'id' => $camal->id,
                'name' => $camal->name,
                'photo' => $camal->photo,
                'owner' => $camal->user ? [
                    'id' => $camal->user->id,
                    'fname' => $camal->user->fname,
                    'lname' => $camal->user->lname,
                    'email' => $camal->user->email,
                    'phone' => $camal->user->phone,
                    'photo' => $camal->user->photo,
                ] : null,
            ];
        }

        if ($nomination->camelRoundParticipation && $nomination->camelRoundParticipation->round) {
            $round = $nomination->camelRoundParticipation->round;
            $roundData = [
                'id' => $round->id,
                'name' => $round->name,
                'name_en' => $round->name_en,
                'des' => $round->des,
                'des_en' => $round->des_en,
                'start' => $round->start,
                'end' => $round->end,
                'status' => $round->status,
                'round_type' => $round->round_type,
            ];
        }

        if ($nomination->festival) {
            $festival = $nomination->festival;
            $festivalData = [
                'id' => $festival->id,
                'name' => $festival->name,
                'name_en' => $festival->name_en,
                'des' => $festival->des,
                'des_en' => $festival->des_en,
                'start' => $festival->start,
                'end' => $festival->end,
                'location' => $festival->location,
                'status' => $festival->status,
            ];
        }

        $data = [
            'nomination_id' => $nomination->id,
            'is_winner' => $nomination->is_winner,
            'created_at' => $nomination->created_at,
            'created_at_human' => $nomination->created_at
                ? \Carbon\Carbon::parse($nomination->created_at)
                    ->locale('ar') // تعريب
                    ->diffForHumans()
                : null,
            'updated_at' => $nomination->updated_at,
            'camal' => $camalData,
            'round' => $roundData,
            'festival' => $festivalData,
        ];
    }

    return response()->json([
        'success' => true,
        'already_nominated' => $alreadyNominated,
        'message' => $alreadyNominated
            ? 'المستخدم قام بالترشيح مسبقاً'
            : 'المستخدم لم يقم بالترشيح بعد',
        'data' => $data
    ]);
}






// public function getUserNominationsApi(Request $request)
// {
//     $userId = $request->input('user_id');

//     // جلب كل الترشيحات للمستخدم مع العلاقات اللازمة
//     $nominations = \App\Models\Nomination::with([
//         'camelRoundParticipation.camal.user',
//         'camelRoundParticipation.round',
//         'festival'
//     ])
//     ->where('user_id', $userId)
//     ->orderBy('created_at', 'desc')
//     ->get();

//     $result = [];

//     foreach ($nominations as $nomination) {
//         $camalData = null;
//         $roundData = null;
//         $festivalData = null;

//         // camal + owner
//         if ($nomination->camelRoundParticipation && $nomination->camelRoundParticipation->camal) {
//             $camal = $nomination->camelRoundParticipation->camal;
//             $owner = $camal->user ?? null; // العلاقة عندك اسمها user
//             $camalData = [
//                 'id' => $camal->id,
//                 'name' => $camal->name,
//                 'age_name' => $camal->age_name,
//                 'photo' => $camal->photo,
//                 'owner' => $owner ? [
//                     'id' => $owner->id,
//                     'fname' => $owner->fname,
//                     'lname' => $owner->lname,
//                     'email' => $owner->email,
//                     'phone' => $owner->phone,
//                     'photo' => $owner->photo,
//                 ] : null,
//             ];
//         }

//         // round (مع age_name لو موجود)
//         if ($nomination->camelRoundParticipation && $nomination->camelRoundParticipation->round) {
//             $round = $nomination->camelRoundParticipation->round;
//             $roundData = [
//                 'id' => $round->id,
//                 'name' => $round->name,
//                 'name_en' => $round->name_en,
//                 'des' => $round->des,
//                 'des_en' => $round->des_en,
//                 'start' => $round->start,
//                 'end' => $round->end,
//                 'status' => $round->status,
//                 'round_type' => $round->round_type,
//             ];
//         }

//         // festival
//         if ($nomination->festival) {
//             $festival = $nomination->festival;
//             $festivalData = [
//                 'id' => $festival->id,
//                 'name' => $festival->name,
//                 'name_en' => $festival->name_en,
//                 'des' => $festival->des,
//                 'des_en' => $festival->des_en,
//                 'start' => $festival->start, // كما هو من الجدول
//                 'end' => $festival->end,     // كما هو من الجدول
//                 'start_date_human' => $festival->start
//                     ? \Carbon\Carbon::parse($festival->start)
//                         ->timezone(config('app.timezone'))
//                         ->format('d/m/Y')
//                     : null,
//                 'end_date_human' => $festival->end
//                     ? \Carbon\Carbon::parse($festival->end)
//                         ->timezone(config('app.timezone'))
//                         ->format('d/m/Y')
//                     : null,
//                 'location' => $festival->location,
//                 'status' => $festival->status,
//             ];
//         }

//         $result[] = [
//             'nomination_id' => $nomination->id,
//             'is_winner' => $nomination->is_winner,
//             'created_at' => $nomination->created_at,
//             'created_at_human' => $nomination->created_at
//                 ? \Carbon\Carbon::parse($nomination->created_at)
//                     ->locale('ar')
//                     ->diffForHumans()
//                 : null,
//             'updated_at' => $nomination->updated_at,
//             'camal' => $camalData,
//             'round' => $roundData,
//             'festival' => $festivalData,
//         ];
//     }

//     return response()->json([
//         'success' => true,
//         'user_id' => $userId,
//         'count' => count($result),
//         'nominations' => $result,
//     ]);
// }



public function getUserNominationsApi(Request $request)
{
    $userId = $request->input('user_id');
    $festivalId = $request->input('festival_id');


    // جلب كل الترشيحات للمستخدم مع العلاقات اللازمة
    $nominations = \App\Models\Nomination::with([
        'camelRoundParticipation.camal.user',
        'camelRoundParticipation.round',
        'festival'
    ])
    ->where('user_id', $userId)
    ->where('festival_id', $festivalId)
    ->orderBy('created_at', 'desc')
    ->get();

    $result = [];

    foreach ($nominations as $nomination) {
        $camalData = null;
        $roundData = null;
        $festivalData = null;

        // camal + owner
        if ($nomination->camelRoundParticipation && $nomination->camelRoundParticipation->camal) {
            $camal = $nomination->camelRoundParticipation->camal;
            $owner = $camal->user ?? null;
            $camalData = [
                'id' => $camal->id,
                'name' => $camal->name,
                'age_name' => $camal->age_name,
                'photo' => $camal->photo,
                'owner' => $owner ? [
                    'id' => $owner->id,
                    'fname' => $owner->fname,
                    'lname' => $owner->lname,
                    'email' => $owner->email,
                    'phone' => $owner->phone,
                    'photo' => $owner->photo,
                ] : null,
            ];
        }

        // round
        if ($nomination->camelRoundParticipation && $nomination->camelRoundParticipation->round) {
            $round = $nomination->camelRoundParticipation->round;
            $roundData = [
                'id' => $round->id,
                'name' => $round->name,
                'name_en' => $round->name_en,
                'des' => $round->des,
                'des_en' => $round->des_en,
                'start' => $round->start,
                'end' => $round->end,
                'status' => $round->status,
                'round_type' => $round->round_type,
            ];
        }

        // festival
        if ($nomination->festival) {
            $festival = $nomination->festival;
            $festivalData = [
                'id' => $festival->id,
                'name' => $festival->name,
                'name_en' => $festival->name_en,
                'des' => $festival->des,
                'des_en' => $festival->des_en,
                'start' => $festival->start,
                'end' => $festival->end,
                'start_date_human' => $festival->start
                    ? \Carbon\Carbon::parse($festival->start)
                        ->timezone(config('app.timezone'))
                        ->format('d/m/Y')
                    : null,
                'end_date_human' => $festival->end
                    ? \Carbon\Carbon::parse($festival->end)
                        ->timezone(config('app.timezone'))
                        ->format('d/m/Y')
                    : null,
                'location' => $festival->location,
                'status' => $festival->status,
            ];
        }

        $result[] = [
            'nomination_id' => $nomination->id,
                        'points' => $nomination->points,

            'is_winner' => $nomination->is_winner,
            'created_at' => $nomination->created_at,
            'created_at_human' => $nomination->created_at
                ? \Carbon\Carbon::parse($nomination->created_at)
                    ->locale('ar')
                    ->diffForHumans()
                : null,
            'updated_at' => $nomination->updated_at,
            'camal' => $camalData,
            'round' => $roundData,
            'festival' => $festivalData,
        ];
    }

    return response()->json($result);
}





public function getUserFestivalsWithPoints(Request $request)
{
    $userId = $request->input('user_id');

    // نجيب مجموع النقاط لكل مهرجان شارك فيه المستخدم
    $festivals = \App\Models\Nomination::select(
            'festival_id',
            \DB::raw('SUM(points) as total_points')
        )
        ->where('user_id', $userId)
        ->groupBy('festival_id')
        ->with('festival') // علاقة المهرجان
        ->get();

    $result = [];

    foreach ($festivals as $row) {
        $festival = $row->festival;

        if ($festival) {
            $result[] = [
                'festival_id' => $festival->id,
                'name' => $festival->name,
                'name_en' => $festival->name_en,
                'des' => $festival->des,
                'des_en' => $festival->des_en,
                'start' => $festival->start,
                'end' => $festival->end,
                'start_date_human' => $festival->start
                    ? \Carbon\Carbon::parse($festival->start)->format('d/m/Y')
                    : null,
                'end_date_human' => $festival->end
                    ? \Carbon\Carbon::parse($festival->end)->format('d/m/Y')
                    : null,
                'location' => $festival->location,
                'status' => $festival->status,
                'total_points' => (int) $row->total_points, // مجموع النقاط
            ];
        }
    }

    return response()->json($result);
}


public function getFestivalLeaderboard(Request $request)
{
    $festivalId = $request->input('festival_id');

    // جلب المستخدمين مع مجموع النقاط
    $usersPoints = \DB::table('nominations')
        ->join('users', 'nominations.user_id', '=', 'users.id')
        ->select(
            'users.id',
            'users.fname',
            'users.lname',
            'users.email',
            'users.phone',
            'users.country_flag',
            'users.photo',
            \DB::raw('SUM(nominations.points) as total_points')
        )
        ->where('nominations.festival_id', $festivalId)
        ->groupBy(
            'users.id',
            'users.fname',
            'users.lname',
            'users.email',
            'users.phone',
            'users.country_flag',
            'users.photo'
        )
        ->orderByDesc('total_points')
        ->get();

    return response()->json($usersPoints);
}






}
