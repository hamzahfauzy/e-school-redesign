<?php

use App\User;
use App\Model\Role;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
    	$user = User::create([
    		"name"=>"Admin",
    		"email"=>"admin@admin.com",
    		"password"=> bcrypt("admin"),
    		"picture"=>"",
    		"status"=> 1
    	]);
    	$role = Role::where('slug', 'admin')->first();
    	$user->roles()->attach($role);

        // $this->call(UsersTableSeeder::class);
    }
}
