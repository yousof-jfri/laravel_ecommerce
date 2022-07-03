<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Mockery\Undefined;

class ActiveCode extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function user(){
        return $this->belongsTo(User::class);
    }

    protected $fillable = ['user_id', 'code', 'expired_at'];


    // generate new code
    public function scopeGenerateCode($query, $user){
        if($code = $this->getUserAliveActiveCode($user)){
            $code = $code->code;
        }else{
            do { 
                $code = mt_rand(100000, 999999);
            } while ($this->checkCodeIsUnique($user, $code));

            $user->activeCodes()->create([
                'code' => $code,
                'expired_at' => now()->addMinutes(10),
            ]);
        }

        return $code;
    }

    // check if the user has already a code which is not expired , if has return it
    protected function getUserAliveActiveCode($user){
        return $user->activeCodes()->where('expired_at', '>', now())->first();
    }

    // check if the code is unique in the active codes table
    protected function checkCodeIsUnique($user, $code){
        return !! $user->activeCodes()->whereCode($code)->first();
    }

    // check if the code exsists in the database or not
    protected function scopeVerifyCode($query, $code, $user){
        return !! $user->activeCodes()->whereCode($code)->where('expired_at', '>', now())->first();
    }

}
