<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use App\Models\ActiveCode;

class ProfileController extends Controller
{
    public function index()
    {
        return view('admin.profile.index');
    }

    public function update(Request $request, User $user){
        $data = $request->validate([
            'name' => 'required',
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => 'nullable',
            'phone' => 'nullable',
            'address' => 'nullable',
            'bio' => 'nullable',
            'image' => 'nullable',
        ]);

        $data['is_superuser'] = $user->is_superuser;
        $data['is_staff'] = $user->is_staff;

        if($request->phone != $request->user()->phone){
            $data['two_factor_auth_type'] = 'off';
        }

        $data['password'] = $user->password;
        if($request->password){
            $data['password'] = Hash::make($data['password']);
        }

        $data['image'] = $user->image;
        if($request->file('image')){
            if(File::exists(public_path(Storage::url($user->image)))){
                File::delete(public_path(Storage::url($user->image)));
            }
            $data['image'] = $request->file('image')->store('public/users');
        }

        $user->update($data);

        return back()->with('message', 'پروفایل با موفقیت تغییر یافت');
    }

    public function sendCode(Request $request){
        $data = $request->validate([
            'two_factor_auth_type' => ['required', 'in:off,sms'],
            'phone' => 'required_unless:two_factor_auth_type,off',
        ]);

        if($data['two_factor_auth_type'] == 'sms'){
            // create new Code
            $code = ActiveCode::generateCode($request->user());

            // send code to the users phone


            // store phone in the session for 1 route
            $request->session()->flash('phone', $data['phone']);

            // show form to user
            return redirect()->route('admin.profile.verifyPage');
        }

        // if the tofactor type was equal to 'off'
        $request->user()->update([
            'two_factor_auth_type' => $data['two_factor_auth_type'],
            'phone' => $data['phone'],
        ]);
        

        return redirect()->back()->with('message', 'شماره تلفن شما تغییر یافت اما شماره تلفن شما به دلیل فعال نکردن قسمت اس ام اس اعتبار سنجی نشد');
    }

    public function verifyPage(Request $request){

        if(!$request->session()->has('phone')){
            return redirect(route('admin.profile'));
        }

        $request->session()->reflash('phone');

        return view('admin.profile.verifyPhone');
    }

    public function verifyPhoneNumber(Request $request){
        $request->validate([
            'code' => 'required',
        ]);

        if(!$request->session()->has('phone')){
            return redirect(route('admin.profile'));
        }

        // check if the code is in the data base or not
        $status = ActiveCode::verifyCode($request->code, $request->user());


        // if the code was true change the user two_factor_auth_type to sms and change the phone number
        if($status){
            $request->user()->activeCodes()->delete();
            
            $request->user()->update([
                'two_factor_auth_type' => 'sms',
                'phone' => $request->session()->get('phone'),
            ]);

            return redirect(route('admin.profile'))->with('message', 'شماره تلفن شما با موفقیت تایید شد');
        }

        // if the code was wrong reflash the phone for verify page and redirect user to the verify page
        $request->session()->reflash('phone');

        return redirect(route('admin.profile.verifyPage'))->with('message', 'کد وارد شده اشتباه میباشد لطفا دوباره تلاش کنید');

        
    }
}
