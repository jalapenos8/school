<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use App\Models\Subject;
use App\Models\Unit;
use App\Models\Lesson;
use App\Models\Step;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        Permission::create(['name' => 'subjects']);
        Permission::create(['name' => 'units']);
        Permission::create(['name' => 'users']);
        Permission::create(['name' => 'study']);
        Permission::create(['name' => 'results']);

        // create roles and assign created permissions

        // or may be done by chaining
        Role::create(['name' => 'admin'])->givePermissionTo(Permission::all()); // ['subjects', 'units', 'study']

        Role::create(['name' => 'teacher'])->givePermissionTo(['units']); // ['units', 'study']

        Role::create(['name' => 'parent'])->givePermissionTo(['results']); // ['results']

        Role::create(['name' => 'student'])->givePermissionTo(['results','study']); // ['results',  'study']

        $user = User::factory()->create([
            'id' => '533364697566',
            'name' => 'Test',
            'surname' => 'Admin',
            'email' => 'admin@test.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'remember_token' => 'ssssssss8s',
        ]);
        $user->assignRole('admin');
    
        $user = User::factory()->create([
            'id' => '533364697567',
            'name' => 'Test',
            'surname' => 'Teacher',
            'email' => 'teacher@test.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'remember_token' => 'ssssssssss',
        ]);        
        $user->assignRole('teacher');
        $user = User::factory()->create([
            'id' => '533364697568',
            'name' => 'Test',
            'surname' => 'Parent',
            'email' => 'parent@test.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'remember_token' => 'ssssssss3s',
        ]);        
        $user->assignRole('parent');
        $user = User::factory()->create([
            'id' => '533364697569',
            'name' => 'Test',
            'surname' => 'Student',
            'email' => 'student@test.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'remember_token' => 'ssssssss22',
        ]);

        $user->assignRole('student');

        Subject::create([
            'name' => 'Subject Example',
            'grade' => 7,
            'img' => 'https://www.thoughtco.com/thmb/6MsMmUK27akFhb8i89kj95J5iko=/1500x0/filters:no_upscale():max_bytes(150000):strip_icc()/GettyImages-545286316-433dd345105e4c6ebe4cdd8d2317fdaa.jpg',
        ]);
        Unit::create([
            'name' => 'Unit Example',
            'term' => 1,
            'subject_id' => 1,
        ]);

    }
}
