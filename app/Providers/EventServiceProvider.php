<?php

namespace App\Providers;

use App\Reassignment;
use App\Task;
use App\Utils\Events;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\Event' => [
            'App\Listeners\EventListener',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        Event::listen(Events::TASK_CREATED, function (Task $task) {
            $reassignment = new Reassignment();
            $reassignment->task_id = $task->id;
            $reassignment->assigned_to = $task->assigned_to;
            $reassignment->save();
        });
    }
}
