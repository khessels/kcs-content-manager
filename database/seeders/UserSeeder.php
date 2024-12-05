<?php

namespace Database\Seeders;

use App\Models\DealerToken;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function users(): array
    {
        $users                  = [];

        $user['name']           = 'Kees Hessels';
        $user['active']         = 'YES';
        $user['email_verified_at'] = Carbon::now()->toIso8601String();
        $user['email']          = 'kees.hessels@gmail.com';
        $user['password']       = 'Hades666';
        $user['roles']          = config('constants.roles.admin');
        $user['permissions']    = config('constants.permissions.admin');

        $users[]                = $user;

        $user['name']           = 'Daymiendo';
        $user['active']         = 'YES';
        $user['email_verified_at'] = Carbon::now()->toIso8601String();
        $user['email']          = 'info@selectfinance.nl';
        $user['password']       = '123PeterPan';
        $user['roles']          = config('constants.roles.admin');
        $user['permissions']     = config('constants.permissions.admin');
        $users[]                = $user;

        return $users;
    }
    public function run(): void
    {
        foreach($this->users() as $aUser){
            $aUser['password'] = Hash::make( $aUser['password']);

            $roles = $aUser['roles'];
            unset( $aUser['roles']);

            $permissions = $aUser['permissions'];
            unset($aUser['permissions']);

            $user = User::create( $aUser);

            foreach( $roles as $role ){
                $user->assignRole( $role );
            }
            foreach( $permissions as $permission ){
                $user->givePermissionTo( $permission );
            }
        }
    }
}
