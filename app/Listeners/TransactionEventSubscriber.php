<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/11
 * Time: 14:48
 */

namespace App\Listeners;


use App\Jobs\BalanceJob;
use App\Jobs\BalanceTransactionJob;
use App\Jobs\BalanceTransactionUpdateJob;
use App\Jobs\DepositSuccessJob;
use App\Jobs\UpgradeSmsJob;
use App\Models\DepositStatus;
use Illuminate\Support\Facades\Log;

class TransactionEventSubscriber
{
    public function subscribe($events)
    {
        $events->listen(
            [  'App\Events\TransferCreated',
                ],
            'App\Listeners\TransactionEventSubscriber@Transaction'
        );
        /*$events->listen(
            ['App\Events\DepositCreated'],
            'App\Listeners\TransactionEventSubscriber@handelSms'
        );*/
        $events->listen(
            'App\Events\DepositStatusUpdate',
            'App\Listeners\TransactionEventSubscriber@handleDeposit'
        );

        $events->listen(
            'App\Events\BonusCreated',
            'App\Listeners\TransactionEventSubscriber@handleBalance'
        );


        /*$events->listen(
          'App\Events\DepositStatusUpdate',
            'App\Listeners\TransactionEventSubscriber@handleDeposit'
        );
        $events->listen(
            'App\Events\DeclarationStatusUpdate',
            'App\Listeners\TransactionEventSubscriber@handleBalance'
        );*/
    }

    /**
     * @param $event
     */
    public function handleUpgradeHistoryCreated($event)
    {
        $model = $event->model;

    }

    public function handelSms($event)
    {
        $model = $event->model;
        $job = (new UpgradeSmsJob($model));
        dispatch($job);
    }

    public function handleBalanceTransactionCreated($event)
    {

    }

    public function handleBalanceTransactionUpdate($event)
    {
        var_dump('balancetransactionupdate...');
        $model = $event->model;
        $job = (new BalanceTransactionUpdateJob($model));
        dispatch($job);
    }

    public function handleBalance($event)
    {
        $model = $event->model;
        $job = (new BalanceJob($model));
        dispatch($job);
    }

    public function Transaction($event)
    {
        $model = $event->model;
        $job = (new BalanceTransactionJob($model));
        dispatch($job);
    }

    public function handleDeposit($event)
    {
        $model = $event->model;

        if ($model->status_id == DepositStatus::SUCCESS) {
            $job = (new DepositSuccessJob($model));
            dispatch($job);
        }
    }
}