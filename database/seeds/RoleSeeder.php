<?php

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Role::class)->create([
            'name' => 'user',
            'display_name' => 'User',
            'description' => 'User Role'
        ]);

        factory(Role::class)->create([
            'name' => 'admin',
            'display_name' => 'Admin',
            'description' => 'Admin Role'
        ]);

        factory(Role::class)->create([
            'name' => 'editor',
            'display_name' => 'Editor',
            'description' => 'Editor Role'
        ]);

        factory(Role::class)->create([
            'name' => 'writer',
            'display_name' => 'writer',
            'description' => 'Writer Role'
        ]);

        factory(Role::class)->create([
            'name' => 'shop_manager',
            'display_name' => 'Shop Manager',
            'description' => 'Shop Manager Role'
        ]);

        factory(Role::class)->create([
            'name' => 'order_manager',
            'display_name' => 'Order Manager',
            'description' => 'Order Manager Role'
        ]);

        factory(Role::class)->create([
            'name' => 'translator',
            'display_name' => 'Translator',
            'description' => 'Translator Role'
        ]);
    }
}
