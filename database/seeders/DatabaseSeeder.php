<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // For SQLite, disable foreign key checks differently
        DB::statement('PRAGMA foreign_keys = OFF;');

        // Clear existing data
        User::query()->delete();
        Student::query()->delete();
        Subject::query()->delete();

        // Re-enable foreign key checks
        DB::statement('PRAGMA foreign_keys = ON;');

        // Create Headmaster
        User::create([
            'name' => 'Dr. John Headmaster',
            'email' => 'headmaster@school.com',
            'password' => Hash::make('password123'),
            'role' => 'headmaster',
        ]);

        // Create Teachers
        User::create([
            'name' => 'Mrs. Sarah Teacher',
            'email' => 'teacher@school.com',
            'password' => Hash::make('password123'),
            'role' => 'teacher',
        ]);

        User::create([
            'name' => 'Mr. James Smith',
            'email' => 'teacher2@school.com',
            'password' => Hash::make('password123'),
            'role' => 'teacher',
        ]);

        // Create Sample Students
        $students = [
            [
                'admission_number' => 'STU001',
                'first_name' => 'John',
                'last_name' => 'Doe',
                'middle_name' => 'Michael',
                'gender' => 'male',
                'date_of_birth' => '2010-05-15',
                'class' => 'JSS 1',
                'section' => 'A',
            ],
            [
                'admission_number' => 'STU002',
                'first_name' => 'Jane',
                'last_name' => 'Smith',
                'middle_name' => 'Elizabeth',
                'gender' => 'female',
                'date_of_birth' => '2010-08-22',
                'class' => 'JSS 1',
                'section' => 'A',
            ],
            [
                'admission_number' => 'STU003',
                'first_name' => 'David',
                'last_name' => 'Johnson',
                'middle_name' => 'William',
                'gender' => 'male',
                'date_of_birth' => '2010-03-10',
                'class' => 'JSS 1',
                'section' => 'B',
            ],
            [
                'admission_number' => 'STU004',
                'first_name' => 'Mary',
                'last_name' => 'Brown',
                'middle_name' => 'Grace',
                'gender' => 'female',
                'date_of_birth' => '2010-11-05',
                'class' => 'JSS 1',
                'section' => 'B',
            ],
            [
                'admission_number' => 'STU005',
                'first_name' => 'Peter',
                'last_name' => 'Wilson',
                'middle_name' => 'James',
                'gender' => 'male',
                'date_of_birth' => '2009-06-18',
                'class' => 'JSS 2',
                'section' => 'A',
            ],
        ];

        foreach ($students as $student) {
            Student::create($student);
        }

        // Create Subjects
        $subjects = [
            ['name' => 'Mathematics', 'code' => 'MATH101', 'class' => 'JSS 1'],
            ['name' => 'English Language', 'code' => 'ENG101', 'class' => 'JSS 1'],
            ['name' => 'Basic Science', 'code' => 'SCI101', 'class' => 'JSS 1'],
            ['name' => 'Social Studies', 'code' => 'SOC101', 'class' => 'JSS 1'],
            ['name' => 'Basic Technology', 'code' => 'TECH101', 'class' => 'JSS 1'],
            ['name' => 'Computer Studies', 'code' => 'COMP101', 'class' => 'JSS 1'],
            ['name' => 'Home Economics', 'code' => 'HOME101', 'class' => 'JSS 1'],
            ['name' => 'Agricultural Science', 'code' => 'AGR101', 'class' => 'JSS 1'],
            ['name' => 'Civic Education', 'code' => 'CIV101', 'class' => 'JSS 1'],
            ['name' => 'Christian Religious Studies', 'code' => 'CRS101', 'class' => 'JSS 1'],
            
            ['name' => 'Mathematics', 'code' => 'MATH201', 'class' => 'JSS 2'],
            ['name' => 'English Language', 'code' => 'ENG201', 'class' => 'JSS 2'],
            ['name' => 'Basic Science', 'code' => 'SCI201', 'class' => 'JSS 2'],
            ['name' => 'Social Studies', 'code' => 'SOC201', 'class' => 'JSS 2'],
        ];

        foreach ($subjects as $subject) {
            Subject::create($subject);
        }

        $this->command->info('Database seeded successfully!');
        $this->command->info('========================================');
        $this->command->info('Headmaster Login: headmaster@school.com / password123');
        $this->command->info('Teacher Login: teacher@school.com / password123');
        $this->command->info('========================================');
    }
}