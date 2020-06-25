<?php

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
            ]);

            factory(ClassCategory::class, $numClassCategories)->create([
                'class_id' => $class->id,
            ])->each(function ($classContent) use ($students) {
                $forum = factory(Forum::class)->create([
                    'class_content_id' => $classContent->id,
                    'class_id' => $classContent->class_id,
                    'author_id' => $students[rand(0, 9)]->id
                ]);

                $forum->comments()->create(factory(Comment::class)->make([
                    'author_id' => $students[rand(0, 9)]->id
                ])->toArray());
            });

            $class->students()->sync($students);

            factory(Schedule::class, 3)->create([
                'class_id' => $class->id
            ])->each(function ($schedule) {
                factory(ScheduleSession::class, 3)->create([
                    'schedule_id' => $schedule->id
                ]);
            });
        });

        DB::commit();
    }
}
