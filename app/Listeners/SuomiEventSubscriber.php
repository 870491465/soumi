<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/10
 * Time: 22:30
 */

namespace App\Listeners;


use Illuminate\Support\Facades\Log;

class SuomiEventSubscriber
{
    public function subscribe($events)
    {
        $events->listen(
            'App\Events\TransferStatusUpdate',
            'App\Listeners\SuomiEventSubscriber@TransferUpdate'
        );
    }

    public function TransferUpdate($event)
    {
        Log::info('transfer');
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