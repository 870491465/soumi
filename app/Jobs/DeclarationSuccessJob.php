<?php

namespace App\Jobs;

use App\Models\BalanceTransaction;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class DeclarationSuccessJob
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $declaratioin;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($declaration)
    {
        //
        $this->declaratioin = $declaration;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //

    }
}
