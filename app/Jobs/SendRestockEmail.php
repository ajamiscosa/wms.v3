<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendRestockEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $department = \App\Department::find(14);
        $recepients = [];
    
        foreach($department->Users() as $user) {
            $person = $user->Person();
            array_push($recepients,$person->Email);
        }
        
    
        // $recepients = ["ajamiscosa@gmail.com"];
    
        $reportController = new \App\Http\Controllers\ReportController();
    
        $fileName = sprintf('ItemsForRestock%s.xlsx', \Carbon\Carbon::today()->format('Ymd'));
    
        $mailHelper = new \App\Classes\MailHelper();
        //$mailHelper->sendMailWithAttachment('mail.restock', [], $recepients, '[WIS] Restock List', $reportController->exportItemRestockReportAsFile(), $fileName);
        
    }
}
