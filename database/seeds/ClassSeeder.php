<?php

use App\Models\ClassCategory;
use App\Models\ClassContent;
use App\Models\Classes;
use App\Models\Exam;
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
        $numExams = (int) $this->command->ask('Enter number of exams in each class: ', 5);

        DB::beginTransaction();
        factory(Classes::class, $numClasses)->create()->each(function ($class) use ($numClassContents, $numClassCategories, $numExams) {
            factory(ClassContent::class, $numClassContents)->create([
                'class_id' => $class->id,
            ]);

            factory(ClassCategory::class, $numClassCategories)->create([
                'class_id' => $class->id,
            ])->each(function ($classCategory) use ($numExams) {
                for ($i = 0; $i < $numExams; $i++) {
                    $classCategory->exams()->create(factory(Exam::class)->make([
                        'class_category_id' => $classCategory->id
                    ])->toArray());
                }
            });
        });

        DB::commit();
    }
}
