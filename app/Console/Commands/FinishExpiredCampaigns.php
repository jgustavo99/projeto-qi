<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class FinishExpiredCampaigns extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'finish-expired-campaigns';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Finaliza as campanhas que estão vencidas.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $campaigns = \App\Models\Campaign::whereDate('close_at', '<=', \Carbon\Carbon::now())->get();

        foreach ($campaigns as $campaign) {
            $campaign->status = 2;
            $campaign->save();
        }
    }
}
