<?php

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roleAdmin = Role::where('name', 'admin')->first();
        $roleUser = Role::where('name', 'user')->first();

        factory(User::class, 10)->create()->each(function ($model) use ($roleUser) {
            $model->roles()->attach($roleUser);
        });

        $user = User::create([
            'name' => 'thienhungho',
            'email' => 'thienhungho@gmail.com',
            'username' => 'thienhungho@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123456789'),
            'remember_token' => Str::random(10),
            'status' => 1,
        ]);

        $user->roles()->attach($roleAdmin);

        $user = User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'username' => 'admin@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123456789'),
            'remember_token' => Str::random(10),
            'status' => 1,
        ]);

        $user->roles()->attach($roleAdmin);

        $user = User::create([
            'name' => 'user',
            'email' => 'user@gmail.com',
            'username' => 'user@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123456789'),
            'remember_token' => Str::random(10),
            'status' => 1,
        ]);

        $user->roles()->attach($roleUser);
    }
}
