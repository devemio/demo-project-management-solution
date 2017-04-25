<?php

use Illuminate\Database\Seeder;

class GeneralSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class, 5)->create()->each(function (App\User $user) {
            factory(App\Project::class, 2)->create()->each(function (App\Project $project) use ($user) {
                $project->tasks()->save(factory(App\Task::class)->make());
            });
        });
    }
}
