<?php

namespace Database\Seeders;

use App\Models\Agenda\AssessmentAspect;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AssessmentAspectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AssessmentAspect::create([
            'id' => Str::uuid(),
            'aspect' => 'Take ablution orderly',
            'aspect_for' => 'teacher',
            'aspect_status' => true,
        ]);
        AssessmentAspect::create([
            'id' => Str::uuid(),
            'aspect' => 'Pray orderly',
            'aspect_for' => 'teacher',
            'aspect_status' => true,
        ]);
        AssessmentAspect::create([
            'id' => Str::uuid(),
            'aspect' => 'Dzikir, istighosah orderly',
            'aspect_for' => 'teacher',
            'aspect_status' => true,
        ]);
        AssessmentAspect::create([
            'id' => Str::uuid(),
            'aspect' => 'Discipline in habitual morning, Dhuhur, and Ashar Prayer',
            'aspect_for' => 'teacher',
            'aspect_status' => true,
        ]);
        AssessmentAspect::create([
            'id' => Str::uuid(),
            'aspect' => 'Polite in speaking with teacher/friends',
            'aspect_for' => 'teacher',
            'aspect_status' => true,
        ]);
        AssessmentAspect::create([
            'id' => Str::uuid(),
            'aspect' => 'Like to help others',
            'aspect_for' => 'teacher',
            'aspect_status' => true,
        ]);
    }
}
