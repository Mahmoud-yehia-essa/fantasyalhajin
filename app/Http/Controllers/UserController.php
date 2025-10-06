<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;

// use PragmaRX\Countries\Package\Countries;




class UserController extends Controller
{
    public function getAllUsers()
    {
        // $users = User::latest()->get();
        // $users = User::where('role', '!=', 'admin')->latest()->get();
        $users = User::where('role', 'user')->latest()->get();


        return view('admin.users.all_users',compact('users'));


    }


      public function getAllOwners()
    {
        // $users = User::latest()->get();
        $users = User::where('role', 'owner')->latest()->get();


        return view('admin.users.all_owners',compact('users'));


    }



      public function getAllAdmin()
    {
        // $users = User::latest()->get();
        $users = User::where('role', 'admin')->latest()->get();


        return view('admin.users.all_admin',compact('users'));


    }





    // public function addUser()
    // {


    //     $countryList = $countries->all()->map(function ($country) {
    //     return [
    //         'name'  => $country->name['common'] ?? '',
    //         'code'  => $country->cca2,  // ISO Alpha-2 (e.g. KW, SA)
    //         'dial'  => $country->callingCodes[0] ?? '',
    //         'flag'  => $country->flag['emoji'] ?? '',
    //     ];
    // })->filter(fn($c) => !empty($c['dial'])) // keep only countries with dial codes
    //   ->values();

    //     return view('admin.users.add_user',compact('countryList'));


    // }



   public static $countryList = [
    // دول الخليج أولاً
    ['name' => 'Kuwait', 'code' => 'KW', 'dial' => '+965', 'flag' => '🇰🇼'],
    ['name' => 'Saudi Arabia', 'code' => 'SA', 'dial' => '+966', 'flag' => '🇸🇦'],
    ['name' => 'United Arab Emirates', 'code' => 'AE', 'dial' => '+971', 'flag' => '🇦🇪'],
    ['name' => 'Qatar', 'code' => 'QA', 'dial' => '+974', 'flag' => '🇶🇦'],
    ['name' => 'Oman', 'code' => 'OM', 'dial' => '+968', 'flag' => '🇴🇲'],
    ['name' => 'Bahrain', 'code' => 'BH', 'dial' => '+973', 'flag' => '🇧🇭'],

    // الدول العربية الأخرى
    ['name' => 'Egypt', 'code' => 'EG', 'dial' => '+20', 'flag' => '🇪🇬'],
    ['name' => 'Iraq', 'code' => 'IQ', 'dial' => '+964', 'flag' => '🇮🇶'],
    ['name' => 'Jordan', 'code' => 'JO', 'dial' => '+962', 'flag' => '🇯🇴'],
    ['name' => 'Lebanon', 'code' => 'LB', 'dial' => '+961', 'flag' => '🇱🇧'],
    ['name' => 'Syria', 'code' => 'SY', 'dial' => '+963', 'flag' => '🇸🇾'],
    ['name' => 'Yemen', 'code' => 'YE', 'dial' => '+967', 'flag' => '🇾🇪'],
    ['name' => 'Algeria', 'code' => 'DZ', 'dial' => '+213', 'flag' => '🇩🇿'],
    ['name' => 'Morocco', 'code' => 'MA', 'dial' => '+212', 'flag' => '🇲🇦'],
    ['name' => 'Tunisia', 'code' => 'TN', 'dial' => '+216', 'flag' => '🇹🇳'],
    ['name' => 'Libya', 'code' => 'LY', 'dial' => '+218', 'flag' => '🇱🇾'],
    ['name' => 'Sudan', 'code' => 'SD', 'dial' => '+249', 'flag' => '🇸🇩'],

    // باقي العالم (أبجديًا)
    ['name' => 'Afghanistan', 'code' => 'AF', 'dial' => '+93', 'flag' => '🇦🇫'],
    ['name' => 'Albania', 'code' => 'AL', 'dial' => '+355', 'flag' => '🇦🇱'],
    ['name' => 'Andorra', 'code' => 'AD', 'dial' => '+376', 'flag' => '🇦🇩'],
    ['name' => 'Angola', 'code' => 'AO', 'dial' => '+244', 'flag' => '🇦🇴'],
    ['name' => 'Argentina', 'code' => 'AR', 'dial' => '+54', 'flag' => '🇦🇷'],
    ['name' => 'Armenia', 'code' => 'AM', 'dial' => '+374', 'flag' => '🇦🇲'],
    ['name' => 'Australia', 'code' => 'AU', 'dial' => '+61', 'flag' => '🇦🇺'],
    ['name' => 'Austria', 'code' => 'AT', 'dial' => '+43', 'flag' => '🇦🇹'],
    ['name' => 'Azerbaijan', 'code' => 'AZ', 'dial' => '+994', 'flag' => '🇦🇿'],
    ['name' => 'Bangladesh', 'code' => 'BD', 'dial' => '+880', 'flag' => '🇧🇩'],
    ['name' => 'Belarus', 'code' => 'BY', 'dial' => '+375', 'flag' => '🇧🇾'],
    ['name' => 'Belgium', 'code' => 'BE', 'dial' => '+32', 'flag' => '🇧🇪'],
    ['name' => 'Bhutan', 'code' => 'BT', 'dial' => '+975', 'flag' => '🇧🇹'],
    ['name' => 'Bolivia', 'code' => 'BO', 'dial' => '+591', 'flag' => '🇧🇴'],
    ['name' => 'Brazil', 'code' => 'BR', 'dial' => '+55', 'flag' => '🇧🇷'],
    ['name' => 'Bulgaria', 'code' => 'BG', 'dial' => '+359', 'flag' => '🇧🇬'],
    ['name' => 'Canada', 'code' => 'CA', 'dial' => '+1', 'flag' => '🇨🇦'],
    ['name' => 'China', 'code' => 'CN', 'dial' => '+86', 'flag' => '🇨🇳'],
    ['name' => 'France', 'code' => 'FR', 'dial' => '+33', 'flag' => '🇫🇷'],
    ['name' => 'Germany', 'code' => 'DE', 'dial' => '+49', 'flag' => '🇩🇪'],
    ['name' => 'India', 'code' => 'IN', 'dial' => '+91', 'flag' => '🇮🇳'],
    ['name' => 'Italy', 'code' => 'IT', 'dial' => '+39', 'flag' => '🇮🇹'],
    ['name' => 'Japan', 'code' => 'JP', 'dial' => '+81', 'flag' => '🇯🇵'],
    ['name' => 'United States', 'code' => 'US', 'dial' => '+1', 'flag' => '🇺🇸'],
    ['name' => 'United Kingdom', 'code' => 'GB', 'dial' => '+44', 'flag' => '🇬🇧'],
    // يمكنك متابعة إضافة باقي الدول حسب الحاجة…
];

   public function addUser()
{

        $countryList = self::$countryList;



    return view('admin.users.add_user', compact('countryList'));
}






    public function addUserStore(Request $request)
    {


        $request->validate([

                    'role' => 'required|not_in:non',

            'fname' => 'required|string|max:255',
            // 'lname' => 'required|string|max:255',
            // 'email' => 'required|email|unique:users,email',
            // 'password' => 'required|min:6|confirmed',

                    //   'phone'  => 'required|regex:/^\+?[0-9]{7,15}$/',

                    //   'phone'  => 'required',

'phone' => [
    'required',
    'regex:/^[0-9]+$/',
    'max:15'
],





            // 'password_confirmation' => 'required',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'fname.required' => 'حقل الاسم  مطلوب.',
            'fname.string' => 'يجب أن يكون الاسم الأول نصًا.',
            'fname.max' => 'يجب ألا يزيد الاسم الأول عن 255 حرفًا.',

            // 'lname.required' => 'حقل اسم العائلة مطلوب.',
            // 'lname.string' => 'يجب أن يكون اسم العائلة نصًا.',
            // 'lname.max' => 'يجب ألا يزيد اسم العائلة عن 255 حرفًا.',

            'email.required' => 'حقل البريد الإلكتروني مطلوب.',
            'email.email' => 'يجب إدخال بريد إلكتروني صالح.',
            'email.unique' => 'هذا البريد الإلكتروني مستخدم بالفعل.',

            'password.required' => 'حقل كلمة المرور مطلوب.',
            'password.min' => 'يجب أن تكون كلمة المرور على الأقل 6 أحرف.',
            'password.confirmed' => 'تأكيد كلمة المرور غير متطابق.',

            'password_confirmation.required' => 'حقل تأكيد كلمة المرور مطلوب.',



            'photo.image' => 'يجب أن يكون الملف صورة.',
            'photo.mimes' => 'يجب أن تكون الصورة من نوع jpeg أو png أو jpg أو gif.',
            'photo.max' => 'يجب ألا يتجاوز حجم الصورة 2 ميغابايت.',



              'role.required' => 'الرجاء اختيار نوع الحساب.',
        'role.not_in' => 'الرجاء اختيار نوع الحساب.',

             'phone.required' => 'يرجى إدخال رقم الهاتف.',


        'phone.integer' => 'الرجاء ادخال رقم الهاتف',

         'phone.required' => 'يرجى إدخال رقم الهاتف.',
    'phone.regex'    => 'يجب إدخال الأرقام باللغة الإنجليزية فقط.',
    // 'phone.min'      => 'رقم الهاتف يجب أن لا يقل عن 8 أرقام.',
    'phone.max'      => 'رقم الهاتف يجب أن لا يتجاوز 15 رقم.',
        ]);


        $filename = "";
    $countryData = json_decode($request->input('country_data'), true);

    $dialCode = $countryData['dial'] ?? null;
    $countryCode = $countryData['code'] ?? null;
    $flag = $countryData['flag'] ?? null;

    $cName = $countryData['name'] ?? null;



        if ($request->file('photo')) {
            // $file = $request->file('photo');
            // $filename = date('YmdHi').$file->getClientOriginalName();
            // $file->move(public_path('upload/user_images'),$filename);


            $file = $request->file('photo');
            $filename = date('YmdHi') . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('upload/user_images'), $filename);
        }


        User::create([
            'fname' => $request->fname,
            'lname' => $request->lname,

            'role' => $request->role,


            'email' => $request->email,

                        'country_code' => $dialCode,
                        'country_flag' => $flag,
                        'country_name' => $cName,





            'phone' => $request->phone,
            'address' => $request->address,
            'password' => Hash::make($request->password),
            'photo' => $filename,


        ]);

        $notification = array(
            'message' => 'تمت الاضافة بنجاح',
            'alert-type' => 'success'
        );

        if($request->role === 'user')
        {

                    return redirect()->route('all.users')->with($notification);

        }


        else if($request->role === 'owner')
        {

                    return redirect()->route('all.owners')->with($notification);

        }

        else
        {
                                return redirect()->route('all.admin')->with($notification);

        }



    }





    public function editUser($id)
    {

        $user = User::findOrFail($id);
        $countryList = self::$countryList;






        return view('admin.users.edit_user',compact('user','countryList'));





    }

    public function editUserStore(Request $request)
    {

        $user_id = $request->id;
        $old_img = $request->old_image;
        $old_email = $request->old_email;

        $user = User::findOrFail($user_id);


// Check if the email hasn't changed
if ($old_email == $request->email) {
    // Validate without the unique rule
    $rules = [
         'role' => 'required|not_in:non',

            'fname' => 'required|string|max:255',
            // 'lname' => 'required|string|max:255',
            // 'email' => 'required|email|unique:users,email',
            // 'password' => 'required|min:6|confirmed',

                    //   'phone'  => 'required|regex:/^\+?[0-9]{7,15}$/',

                    //   'phone'  => 'required',



'phone' => [
    'required',
    'regex:/^[0-9]+$/',
    'max:15'
],





            // 'password_confirmation' => 'required',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ];
} else {
    // Validate with the unique rule for a new email
    $rules = [
         'role' => 'required|not_in:non',

            'fname' => 'required|string|max:255',
            // 'lname' => 'required|string|max:255',
            // 'email' => 'required|email|unique:users,email',
            // 'password' => 'required|min:6|confirmed',

                    //   'phone'  => 'required|regex:/^\+?[0-9]{7,15}$/',

                      'phone'  => 'required',







            // 'password_confirmation' => 'required',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ];


     $user->email = $request->email;

}



$request->validate($rules, [
     'fname.required' => 'حقل الاسم  مطلوب.',
            'fname.string' => 'يجب أن يكون الاسم الأول نصًا.',
            'fname.max' => 'يجب ألا يزيد الاسم الأول عن 255 حرفًا.',

            // 'lname.required' => 'حقل اسم العائلة مطلوب.',
            // 'lname.string' => 'يجب أن يكون اسم العائلة نصًا.',
            // 'lname.max' => 'يجب ألا يزيد اسم العائلة عن 255 حرفًا.',

            'email.required' => 'حقل البريد الإلكتروني مطلوب.',
            'email.email' => 'يجب إدخال بريد إلكتروني صالح.',
            'email.unique' => 'هذا البريد الإلكتروني مستخدم بالفعل.',

            'password.required' => 'حقل كلمة المرور مطلوب.',
            'password.min' => 'يجب أن تكون كلمة المرور على الأقل 6 أحرف.',
            'password.confirmed' => 'تأكيد كلمة المرور غير متطابق.',

            'password_confirmation.required' => 'حقل تأكيد كلمة المرور مطلوب.',



            'photo.image' => 'يجب أن يكون الملف صورة.',
            'photo.mimes' => 'يجب أن تكون الصورة من نوع jpeg أو png أو jpg أو gif.',
            'photo.max' => 'يجب ألا يتجاوز حجم الصورة 2 ميغابايت.',



              'role.required' => 'الرجاء اختيار نوع الحساب.',
        'role.not_in' => 'الرجاء اختيار نوع الحساب.',

             'phone.required' => 'يرجى إدخال رقم الهاتف.',

    'phone.regex'    => 'يجب إدخال الأرقام باللغة الإنجليزية فقط.',
    // 'phone.min'      => 'رقم الهاتف يجب أن لا يقل عن 8 أرقام.',
    'phone.max'      => 'رقم الهاتف يجب أن لا يتجاوز 15 رقم.',
            //  'phone.regex' => 'صيغة رقم الهاتف غير صحيحة. يرجى إدخال رقم مع رمز الدولة مثل دولة الكويت تبدأ ب ‎+965',


        'phone.integer' => 'الرجاء ادخال رقم الهاتف',
]);


$countryData = json_decode($request->input('country_data'), true);

    $dialCode = $countryData['dial'] ?? null;
    $countryCode = $countryData['code'] ?? null;
    $flag = $countryData['flag'] ?? null;

    $cName = $countryData['name'] ?? null;


        // $filename = "";

        $path = 'upload/user_images/'.$old_img;




        if ($request->file('photo')) {


            $file = $request->file('photo');
            $filename = date('YmdHi') . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('upload/user_images'), $filename);


            if (file_exists($path) && $old_img != "" ) {
                unlink($path);
             }


             $user->photo = $filename;








        }



        if($request->password != "")
        {

            $user->password = Hash::make($request->password);

        }



        $user->fname = $request->fname;
        $user->lname = $request->lname;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->country_code = $dialCode;
                $user->country_flag = $flag;
                $user->country_name = $cName;


                $user->role = $request->role;




        // $user->is_game_free = $request->is_game_free;


        $user->save();

        $notification = array(
            'message' => 'تم التعديل',
            'alert-type' => 'success'
        );


         if($request->role === 'user')
        {

                    return redirect()->route('all.users')->with($notification);

        }


        else if($request->role === 'owner')
        {

                    return redirect()->route('all.owners')->with($notification);

        }

        else
        {
                                return redirect()->route('all.admin')->with($notification);

        }

        // return redirect()->route('all.users')->with($notification);















    }
    public function userInactive($id){
        User::findOrFail($id)->update(['status' => 'inactive']);
        $notification = array(
            'message' => 'المستخدم غير مفعل',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }// End Method
      public function userActive($id){
        User::findOrFail($id)->update(['status' => 'active']);
        $notification = array(
            'message' => 'المستخدم مفعل',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }// End Method



    public function deleteUser($id){
        $user = User::findOrFail($id);
        $img = $user->photo;

        // unlink($img );

      //  return $user->photo;

        $path = 'upload/user_images/'.$user->photo;

        if ($user->photo && file_exists(public_path($path))) {
            unlink(public_path($path));
        }
        User::findOrFail($id)->delete();
        $notification = array(
            'message' => 'تم حذف المستخدم',
            'alert-type' => 'success'
        );
        return redirect()->route('all.users')->with($notification);

        // return redirect()->back()->with($notification);
    }// End Method


    /// API ///



    public function loginApi(Request $request) {
        $incomingFields = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        if (auth()->attempt($incomingFields)) {
            $user = auth()->user(); // Get authenticated user
            $token = $user->createToken('ourapptoken')->plainTextToken;

            return response()->json([
                'success' => true,
                'message' => 'Login successful',
                'user' => $user, // Return all user data
                'token' => $token
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'Invalid credentials'
        ], 401);
    }


    public function registerApi(Request $request) {
        // Check if email already exists
        if (User::where('email', $request->email)->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Email already exists'
            ], 409); // 409 Conflict status code
        }

        // Create user
        $userCreated = User::create([
            'fname' => $request->fname,
            'lname' => $request->lname,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'photo' => $request->photo,
            'is_game_free' => 'paid',


        ]);

        if ($userCreated) {
            $token = $userCreated->createToken('ourapptoken')->plainTextToken;

            return response()->json([
                'success' => true,
                'message' => 'Registration successful',
                'user' => $userCreated,
                'token' => $token
            ], 201);
        }

        return response()->json([
            'success' => false,
            'message' => 'Registration failed'
        ], 500);
    }


 public function checkPhoneNumberExist(Request $request) {


        // Check if email already exists

        if (User::where('phone', $request->phone)->where('country_code', $request->country_code)->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'phone already exists'
            ], 200); // 409 Conflict status code
        }
        else
        {
  return response()->json([
                'success' => true,
                'message' => 'phone Not exists Go register'
            ], 200);

        }

    }


     public function registerApiV2(Request $request) {



        // Check if email already exists

        if (User::where('phone', $request->phone)->where('country_code', $request->country_code)->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'phone already exists'
            ], 409); // 409 Conflict status code
        }

        // Create user
        $userCreated = User::create([
            'fname' => $request->fname,
            'lname' => $request->lname,
            'email' => $request->email,
            'phone' => $request->phone,
            'country_code' => $request->country_code,
            'password' => Hash::make($request->password),
            'photo' => $request->photo,
            'is_game_free' => 'paid',


        ]);

        if ($userCreated) {
            $token = $userCreated->createToken('ourapptoken')->plainTextToken;

            return response()->json([
                'success' => true,
                'message' => 'Registration successful',
                'user' => $userCreated,
                'token' => $token
            ], 201);
        }

        return response()->json([
            'success' => false,
            'message' => 'Registration failed'
        ], 500);
    }


    public function loginApiV2(Request $request)
{
    $incomingFields = $request->validate([
        'phone' => 'required|string',
        'country_code' => 'required|string',
    ]);

    // Find user instead of using auth()->attempt()
    $user = \App\Models\User::where('phone', $incomingFields['phone'])
                ->where('country_code', $incomingFields['country_code'])
                ->first();

    if ($user) {
        // Create Sanctum token
        $token = $user->createToken('ourapptoken')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'user' => $user,
            'token' => $token
        ], 200);
    }

    return response()->json([
        'success' => false,
        'message' => 'Invalid credentials'
    ], 401);
}



    public function uploadUpadteImageApi(Request $request,$user_id)
    {


        $user = User::find($user_id);

        if ($request->file('photo')) {
            $file = $request->file('photo');
            @unlink(public_path('upload/user_images/'.$user->photo));
            $filename = 'app-'.date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('upload/user_images'),$filename);


            return response()->json(['link' => $filename], 200);

        }

      else {
            return response()->json(['error' => 'Image not provided'], 400);
        }




    }

    public function uploadImageApi(Request $request)
    {



        if ($request->file('photo')) {
            $file = $request->file('photo');
            @unlink(public_path('upload/user_images/'.$user->photo));
            $filename = 'app-'.date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('upload/user_images'),$filename);


            return response()->json(['link' => $filename], 200);

        }

      else {
            return response()->json(['error' => 'Image not provided'], 400);
        }




    }



/// editUserApi

    public function editUserApi(Request $request)
    {


        $user_id = $request->id;

        $user = User::findOrFail($user_id);





        if($request->password != "")
        {

            $user->password = Hash::make($request->password);

        }


        $user->fname = $request->fname;
        $user->lname = $request->lname;
        $user->phone = $request->phone;
        $user->photo = $request->photo;
        // $user->address = $request->address;
        $user->save();





        $token = "Non";

        return response()->json([
            'success' => true,
            'message' => 'updated user successful',
            'user' => $user, // Return all user data
            'token' => $token
        ], 200);







    }

    public function getUserByEmail($email)
    {
        $user = User::where('email', $email)->first(); // Returns true or false

        if ($user) {

            $token = $user->createToken('ourapptoken')->plainTextToken;

            return response()->json([
                'success' => true,
                'message' => 'Email exists',
                'token' => $token,
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Email not found',
                'token' => 'non',

            ], 404);
        }
    }





    public function editUserPasswordApi(Request $request)
    {

  // Retrieve the token from the request header
  $token = $request->bearerToken();

  if (!$token) {

    return response()->json([
        'success' => false,
        'message' => 'Token not provided',
        'token' => 'non',


    ], 401);
  }

  // Find the token in the database
  $accessToken = PersonalAccessToken::findToken($token);

  if (!$accessToken) {

      return response()->json([
        'success' => false,
        'message' => 'Invalid token',
        'token' => 'non',


    ], 401);
  }

        $email = $request->email;

        $user = User::where('email', $email)->first(); // Returns true or false


        // $user_id = $request->id;


        // $user = User::findOrFail($user_id);







        if($request->password != "")
        {

            $user->password = Hash::make($request->password);

        }



        $user->save();





        $token = "Non";

        return response()->json([
            'success' => true,
            'message' => 'updated password successful',
            'token' => 'non',


        ], 200);







    }



    public function updateUserGamesNumber(Request $request)
    {
        $checkForIncrementGameOrDecrement = $request->checkForIncrementGameOrDecrement;
        $user_id = $request->user_id;
        $numberRequestGame = $request->numberRequestGame;

        $user = User::findOrFail($user_id);
        $numberOfGames = $user->number_of_games;

        if ($checkForIncrementGameOrDecrement == 'increment') {
            $numberOfGames += $numberRequestGame;
            $user->number_of_games = $numberOfGames;
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'increment games successful',
                'numberOfGames'=>$user->number_of_games,

            ], 200);
        } elseif ($checkForIncrementGameOrDecrement == 'decrement') {
            $numberOfGames -= $numberRequestGame;
            $user->number_of_games = $numberOfGames;
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'decrement games successful',
                'numberOfGames'=>$user->number_of_games,

            ], 200);
        }

        // Fallback response if the value doesn't match 'increment' or 'decrement'
        return response()->json([
            'success' => false,
            'message' => 'Invalid action specified',
        ], 400);
    }


 public function deleteUserApi(Request $request){

    $id = $request->delet_user_id;


        $user = User::findOrFail($id);
        $img = $user->photo;

        // unlink($img );

      //  return $user->photo;

        $path = 'upload/user_images/'.$user->photo;

        if ($user->photo && file_exists(public_path($path))) {
            unlink(public_path($path));
        }
        User::findOrFail($id)->delete();

    return response()->json([
                'success' => true,
                'message' => 'user deleted successful',


            ], 200);

        // return redirect()->back()->with($notification);
    }// End Method


}
