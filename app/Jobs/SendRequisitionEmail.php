<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendRequisitionEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $requisition;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($requisition)
    {
        $this->requisition = $requisition;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $instance = \App\Requisition::find($this->requisition);

        $department = \App\Department::find($instance->Department);
        $charged = \App\Department::find($instance->ChargeTo);
        $requester = $instance->Requester();
        $approver1 = $instance->Approver1();

        $recepients = [];
    
        foreach($department->Users() as $user) {
            $person = $user->Person();
            array_push($recepients,$person->Email);
        }
        
    
        // $recepients = ["ajamiscosa@gmail.com"];
    
        $mailHelper = new \App\Classes\MailHelper();
        $mailHelper->sendMail('mail.requisition', [
            'number' => $instance->OrderNumber,
            'type' => ($instance->Type=='IR'?"Issuance":"Purchase")." Request",
            'requester' => $requester->Name(),
            'approver' => $approver1->Name(),
            'department' => $department->Name,
            'charged' => $charged->Name,
        ], $recepients, '[WIS] New Requisition');
    }
}
