<?php

use App\Models\ClassAttendance;
use App\Models\ClassCategory;
use App\Models\ClassContent;
use App\Models\Classes;
use App\Models\Comment;
use App\Models\Exam;
use App\Models\Forum;
use App\Models\Identity;
use App\Models\Schedule;
use App\Models\ScheduleSession;
use App\Models\User;
use Illuminate\Database\Seeder;

class ClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $numClasses = (int) $this->command->ask('Enter number of classes: ', 5);
        $numClassContents = (int) $this->command->ask('Enter number of contents in each class: ', 5);
        $numClassCategories = (int) $this->command->ask('Enter number of categories in each class: ', 5);

        DB::beginTransaction();
        $students = factory(User::class, 10)->create()->each(function ($user) {
            factory(Identity::class)->create([
                'user_id' => $user->id,
            ]);
            $user->assignRole('student');
        });

        Forum::$isAutoInjectAuthIdFieldsOn = false;
        Comment::$isAutoInjectAuthIdFieldsOn = false;
        factory(Classes::class, $numClasses)->create()->each(function ($class) use ($numClassContents, $numClassCategories, $students) {
            $class->teacher->assignRole('teacher');
            $class->teacher->identity()->create(factory(Identity::class)->make()->toArray());

            factory(ClassContent::class, $numClassContents)->create([
                'class_id' => $class->id,
            ])->each(function ($classContent) use ($students) {
                $forums = factory(Forum::class, 2)->create([
                    'class_content_id' => $classContent->id,
                    'class_id' => $classContent->class_id,
                    'author_id' => $students[rand(0, 9)]->id
                ]);

                $forums->each(function ($forum) use ($students) {
                    $forum->comments()->createMany(factory(Comment::class, 2)->make([
                        'author_id' => $students[rand(0, 9)]->id,
                    ])->toArray());
                });
            });

            factory(ClassCategory::class, $numClassCategories, 2)->create([
                'class_id' => $class->id,
                'weight' => 50
            ])->each(function ($classCategory) use ($students) {
                $classCategory->exams()->createMany(factory(Exam::class, 2)->make([
                    'class_category_id' => $classCategory->id,
                    'class_id' => $classCategory->class_id,
                ])->toArray());
            });

            $class->students()->sync($students);

            factory(Schedule::class, 3)->create([
                'class_id' => $class->id
            ])->each(function ($schedule) use ($class, $students) {
                factory(ScheduleSession::class)->create([
                    'schedule_id' => $schedule->id
                ])->each(function ($scheduleSession) use ($class, $students) {
                    // $scheduleSession->attendances()->createMany(factory(ClassAttendance::class, 3)->make([
                    //     'schedule_session_id' => $scheduleSession->id,
                    //     'class_id' => $class->id
                    // ])->toArray())->each(function ($classAttendance) use ($students) {
                    //     $classAttendance->studentAttendances()->createMany([
                    //         [
                    //             'student_id' => $students[rand(0, 9)]->id,
                    //             'attendance_type' => ['absence', 'present', 'permission'][rand(0, 2)]
                    //         ],
                    //         [
                    //             'student_id' => $students[rand(0, 9)]->id,
                    //             'attendance_type' => ['absence', 'present', 'permission'][rand(0, 2)]
                    //         ]
                    //     ]);
                    // });
                });
            });
        });

        DB::commit();
    }
}
