<?php

namespace App\Console;

use App\IssuanceReceipt;
use App\Product;
use App\Quote;
use App\Requisition;
use App\StatusLog;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();

        $schedule->call(function () {
            $requisition = new Requisition();
            $requisitions = $requisition->where('Type','=','IR')->get();

            foreach($requisitions as $issuance) {
                if(
                    Carbon::now()->diff($issuance->Date)->days >= 1 &&
                    $issuance->Status == 'A'
                ){
                    // Step 1: Set status to Expired.
                    $issuance->Status = 'X';
                    $issuance->updated_by = 1;
                    $issuance->save();

                    // Step 2: Create status log for expiration.
                    $log = new StatusLog();
                    $log->OrderNumber = $issuance->OrderNumber;
                    $log->TransactionType = 'IR'; // Expired
                    $log->LogType = 'X'; // Expired
                    $log->created_by = 1;
                    $log->updated_by = 1;
                    $log->save();

                    // Step 3: Send mail.
                    /* TODO: Send mail to:
                     * 1. Creator
                     * 2. Approver 1
                     * 3. Approver 2
                     */
                }
            }

        })->everyFiveMinutes();

        $schedule->call(function(){
            $today = Carbon::today();
            $today->startOfWeek(Carbon::MONDAY);
            $today->endOfWeek(Carbon::SUNDAY);
            $issuanceReceipt = new IssuanceReceipt();
            $issuanceReceipts = $issuanceReceipt->all();
            $issuanceReceipts = $issuanceReceipts
                ->where('Received','>=',$today->startOfMonth())
                ->where('Received','<=',$today->endOfMonth());

            foreach($issuanceReceipts as $issuanceReceipt) {
                $product = $issuanceReceipt->getLineItem()->Product();
                $product->MinimumQuantity = $product->getMinimumStockLevel();
                $product->MaximumQuantity = $product->getMaximumStockLevel();
                // $product->ReOrderQuantity = $product->getSafetyStockCount();
                $product->save();
            }
        })->weekly();

//        $schedule->call(function(){
//            $log = new StatusLog();
//            $log->OrderNumber = "TEST";
//            $log->TransactionType = 'T'; // Expired
//            $log->LogType = 'T'; // Expired
//            $log->save();
//        });


        $schedule->call(function(){
            // 1. activate all quotes need activated
            $quote = new \App\Quote();
            $quotes = $quote->all();
            foreach($quotes as $quote) {
                if($quote->Valid==0 && \Carbon\Carbon::today()>$quote->ValidFrom) {
                    $quote->Valid = 1;
                    $quote->save();
                }

                if($quote->Valid==1 && \Carbon\Carbon::today()>($quote->ValidFrom->addDays($quote->Validity))){
                    $quote->Valid = 0;
                    $quote->save();
                }
            }
        })->daily();



        // $schedule->call(function() {

        //     // 2. send daily restock report.
        //     // get Recepient(s). 
        //     $department = App\Department::find(14);
        //     // $recepients = [];
        
        //     // foreach($department->Users() as $user) {
        //     //     $person = $user->Person();
        //     //     array_push($recepients,$person->Email);
        //     // }
            
        //     $recepients = ["ajamiscosa@gmail.com","era.azana@gmail.com"];

        //     $reportController = new App\Http\Controllers\ReportController();

        //     $fileName = sprintf('ItemsForRestock%s.xlsx', Carbon::today()->format('Ymd'));

        //     $mailHelper = new \App\Classes\MailHelper();
        //     $mailHelper->sendMailWithAttachment('mail.restock', [], $recepients, '[WIS] Restock List', $reportController->exportItemRestockReportAsFile(), $fileName);



        // })->dailyAt('10:38');

        // * Automated Task *
        // Update Fully Quoted RS to be ready for Plant Manager's Approval.
        // Run Time: Every Minute
        $schedule->call(function(){
            $rs = new Requisition();
            $rsList = $rs
                ->where('Type','=', 'PR' )
                ->where('Status','=','Q')
                ->get();

            foreach($rsList as $rs) {
                if($rs->isFullyQuoted()) {
                    // TODO: Send email to Plant Manager to notify PR needs approval.
                    // $rs->Status = 2;
                    $rs->Status = 'A';
                    $rs->save();
                }
            }
        })->everyMinute();
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
