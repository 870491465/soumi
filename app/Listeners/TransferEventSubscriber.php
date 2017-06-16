<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/10
 * Time: 23:00
 */

namespace App\Listeners;


use App\Jobs\SmsSendJob;
use Illuminate\Support\Facades\Log;

class TransferEventSubscriber
{
    public function subscribe($events)
    {
        $events->listen(
            'App\Events\TransferStatusUpdate',
            'App\Listeners\TransferEventSubscriber@TransferUpdate'
        );
        $events->listen(
            'App\Events\UserCreated',
            'App\Listeners\TransferEventSubscriber@UserCreated'
        );


    }

    public function TransferUpdate($event)
    {
        Log::info($event->model);
    }

    public function UserCreated($event)
    {
        Log::info('smsSend');
        $job = (new SmsSendJob($event->model));
        dispatch($job);
    }

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function handle()
    {

    }
}