<?php

namespace Database\Seeders;

use App\Models\Categories;
use App\Models\Course;
use App\Models\Instructor;
use App\Models\Material;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

       $userSiswa = User::create([
        'name' => 'Budiono Siregar',
        'email' => 'budi@gmail.com',
        'password' => bcrypt('rahasia123'),
        'role' => 'student'
       ]);
        Student::create(['user_id' => $userSiswa->id]);

        $userInstructor = User::create([
        'name' => 'Andi Pratama',
        'email' => 'andipratama@gmail.com',
        'password' => bcrypt('rahasia123'),
        'role' => 'instructor'
        ]);
        $instructor = Instructor::create(['user_id' => $userInstructor->id, 'experience_year' => 5]);

        $course = Course::create([
        'instructor_id' => $instructor->id,
        'title' => 'Laravel Basic',
        'description' => 'Belajar Laravel dari dasar hingga membuat REST API',
        'price' => '500000',
        'image' => '[image]'
        ]);

        $kategori = Categories::create(['name' => 'Web Development']);
        $course->categories()->attach($kategori->id);

        Material::create(['course_id' => $course->id, 'title' => 'Pengenalan Laravel', 'video_url' => '[video]']);
        Material::create(['course_id' => $course->id, 'title' => 'Routing Laravel', 'video_url' => '[video]']);
    }
}
