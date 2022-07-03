<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:add-user')->only(['create', 'store']);
        $this->middleware('can:edit-user')->only(['edit', 'update']);
        $this->middleware('can:delete-user')->only('destroy');
        $this->middleware('can:	set-permission-role-to-user')->only(['setAcl', 'setAclToDB']);
        $this->middleware('can:show-users')->only('index');
        
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::query();

        if($keyword = request('search')){
            $users->where('name', 'LIKE', "%{$keyword}%")->orWhere('email', 'LIKE', "%{$keyword}%");
        }

        $users = $users->paginate(20);
        return view('admin.users.all', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:8'],
            'phone' => ['nullable'],
            'type' => ['nullable'],
            'image' => ['nullable', 'mimes:png,jpg'],
            'permissions' => 'nullable'
        ]);

        // check if the inserted user is super user or staff
        if($request->type == 'manager'){
            $data['is_superuser'] = true;
        }else if($request->type == 'staff'){
            $data['is_staff'] = true;
        }


        // hash password
        $data['password'] = Hash::make($data['password']);
        // check the user has image or not
        if($request->file('image')){
            $data['image'] = $request->file('image')->store('public/users');
        }

        $user = User::create($data);

        if($request->permissions != null){
            $user->permissions()->sync($data['permissions']);
        }

        return redirect()->back()->with('message', 'کاربر با موفقیت ایجاد شد');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {   
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {

        $data = $request->validate([
            'name' => 'required',
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => ['nullable', 'min:8'],
            'phone' => ['nullable'],
            'type' => ['nullable'],
            'image' => ['nullable', 'mimes:png,jpg'],
        ]);

        // check if the inserted user is super user or staff
        $data['is_superuser'] = false;
        $data['is_staff'] = false;

        if($request->phone != $request->user()->phone){
            $data['two_factor_auth_type'] = 'off';
        }

        if($request->type == 'manager'){
            $data['is_superuser'] = true;
        }else if($request->type == 'staff'){
            $data['is_staff'] = true;
        }

        // hash password
        $data['password'] = $user->password;
        if($request->password){
            $data['password'] = Hash::make($data['password']);
        }
        
        // check the user has sended image or not, if has delete the previos image and replace it with the new image
        $data['image'] = $user->image;
        if($request->file('image')){
            if(!is_null($user->image)){
                if(File::exists(public_path(Storage::url($user->image)))){
                    File::delete(public_path(Storage::url($user->image)));
                }
            }
            $data['image'] = $request->file('image')->store('public/users');
        }

        // set user updated at
        $data['updated_at'] = now();

        // update user
        $user->update($data);

        return redirect()->route('admin.users.index')->with('message', 'کاربر با موفیت تغییر یافت');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if(!is_null($user->image)){
            if(File::exists(public_path(Storage::url($user->image)))){
                File::delete(public_path(Storage::url($user->image)));
            }
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('message', 'کاربر با موفیت حذف شد');
    }

    public function setAcl(User $user){
        // return $user;
        return view('admin.users.setAcl', compact('user'));
    }

    public function setAclToDB(Request $request, User $user){
        $user->permissions()->sync($request->permissions);
        $user->roles()->sync($request->roles);
        return redirect()->route('admin.users.index')->with('message', 'مقامات و دسترسی ها برای این کاربر تایین شد');
    }
}
