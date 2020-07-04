<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function insert($request)
    {

        $insert = new $this;
        $insert->id = Str::uuid();
        $insert->name = $request->name;
        $insert->email = $request->email;
        $insert->email_verified_at = date('Y-m-d H:s:i');
        $insert->password = Hash::make($request->password);
        $insert->save();

        return true;
    }

    public function list($request)
    {
        $list = self::select()->where('id', $request->uuid)->first();

        return $list;
    }

    public function edit($request)
    {
        $edit = self::where('id', '=', $request->uuid)
        ->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return $edit;
    }

    public function deleteUser($request)
    {
        $delete = self::where('id', $request->uuid)
            ->delete();

        return $delete;
    }
}
