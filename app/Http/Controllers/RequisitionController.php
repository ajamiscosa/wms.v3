<?php

namespace App\Http\Controllers;

use App\Classes\DTO\DTO;
use App\Classes\Html2Pdf;
use App\Department;
use App\Form;
use App\GeneralLedger;
use App\Location;
use App\Product;
use App\ProductLine;
use App\Requisition;
use App\LineItem;
use App\Role;
use App\StatusLog;
use App\UnitOfMeasure;
use App\User;
use Carbon\Carbon;
use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\InventoryLog;
use App\IssuanceReceipt;
use App\Jobs\SendRequisitionEmail;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Maatwebsite\Excel\Facades\Excel;
use Psy\Exception\ErrorException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class RequisitionController extends Controller
{
    private $requisition;
    private $lineItem;
    private $user;
    private $department;

    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    function __construct()
    {
        $this->middleware('auth');
        $this->requisition = new Requisition();
        $this->lineItem = new LineItem();
        $this->user = new User();
        $this->department = new Department();
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        return view('rs.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showIssuanceRequestIndexPage()
    {
        return view('rs.issuance.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showPurchaseRequestIndexPage()
    {
        return view('rs.purchase.index');
    }



    /**
     * Display the specified issuance.
     *
     * @param  $issuance
     * @return \Illuminate\Http\Response
     *
     */
    public function showIssuanceRequestByOrderNumber($issuance) {
        try {
            $issuance = $this->requisition->where('OrderNumber','=', $issuance)->first();
            if($issuance && $issuance->Type=='IR') {
                return view('rs.issuance.view', ['data'=>$issuance]);
            } else {
                $data = new DTO();
                $data->Title = "Issuance $issuance";
                $data->Class = "Issuance";
                $data->Description = "We cannot not find the $data->Class in the database.";
                return response()
                    ->view('errors.404',['data'=>$data]
                        ,404);
            }
        } catch(\ErrorException $exception) {
            dd($exception);
        }
    }


    /**
     * Display the Special Request create form.
     *
     * @return \Illuminate\Http\Response
     *
     */
    public function showCreateSpecialRequestForm() {
        return view('rs.special.create');
    }


    /**
     * Display the specified resource.
     *
     * @param $orderNumber
     * @return \Illuminate\Http\Response
     */
    public function showPurchaseRequestByOrderNumber($orderNumber) {
        try {
            $pr = $this->requisition->where('OrderNumber','=', $orderNumber)->first();

            if($pr && $pr->Type=='PR') {
                return view('rs.purchase.view', ['data'=>$pr]);
            } else {
                $data = new DTO();
                $data->Title = "Requisition $orderNumber";
                $data->Class = "Requisition";
                $data->Description = "We cannot not find the $data->Class in the database.";
                return response()
                    ->view('errors.404',['data'=>$data]
                    ,404);
            }
        } catch(\ErrorException $exception) {
            dd($exception);
        }

        return response();
    }


    /**
     * Show the form for creating a new Issuance Request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function showCreateIssuanceRequestForm(Request $request) {
        $data = session()->get('issuanceList');
        $request->session()->put('issuanceList', $data);

        if($request->_zx == csrf_token()){
            return view('rs.issuance.create',['data'=>$data]);
        }
        else {
            session()->flash('error','Invalid Request');
            return redirect()->to('/rs');
        }
    }

    /**
     * Checks if you can create an Issuance Request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function canCreateRequest(Request $request, $table, $id) {
        $data = session()->pull($table);
        session()->put($table, $data);


        if(count($data)>0) {
            $product = new Product();

            if($table=='issuanceList') {
                foreach($data as $entry) {
                    $product = $product->where('ID','=',$entry)->first();
                    if($id=="ir") {
                        if($product->getAvailableQuantity()==0) {
                            return response()->json([
                                'code'=>0,
                                'title'=>'Oops...',
                                'message'=>'One or more of your selected items is currently out of stock and cannot be issued.!'
                            ]);
                        }
                    }
                }
            }

            return response()->json(['code'=>1,'csrf'=>csrf_token()]);
        }

        return response()->json([
            'code'=>0,
            'title'=>'Oops...',
            'message'=>'You need to select at least one item from the lookup list!'
        ]);
    }

    /**
     * Checks if you can create an Purchase Request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function canCreatePurchaseRequest(Request $request) {
        $data = session()->pull('purchaseList');
        session()->put('purchaseList', $data);

        if(count($data)>0) {
            return response()->json(['code'=>1,'csrf'=>csrf_token()]);
        }

        return response()->json([
            'code'=>0,
            'title'=>'Oops...',
            'message'=>'You need to select at least one item from the lookup list!'
        ]);
    }

    /**
     * Show the form for creating a Purchase Request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function showCreatePurchaseRequestForm(Request $request) {
        if($request->ref == "rspage") {
            $data = session()->get('issuanceList');
            $request->session()->put('issuanceList', $data);
//            $request->session()->put('requisitionList', $data);
        }
        else {
            $data = session()->get('requisitionList');
            $request->session()->put('requisitionList', $data);
        }

        if($request->_zx == csrf_token()){
            return view('rs.purchase.create',['data'=>$data]);
        }
        else {
            session()->flash('error','Invalid Request');
            return redirect()->to('/rs');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        $orderNumber = $this->getCurrentIncrement($request->Type);

        DB::transaction(function() use ($request, $orderNumber){
            $chargeToDept = $this->department->where('ID','=',$request->ChargeTo)->first();
            // dd($request->UserDept);
            $authUser = $this->user->where('ID','=',auth()->user()->ID)->first();
            $selectedApproverID=0;
            if($request->Type=='PR'){
                $selectedApproverID = $request->Approver1?$request->Approver1:$authUser->Department()->Manager()->ID;
            }
            else {
                $selectedApproverID = $authUser->Department()->Manager()->ID;
            }

            // dd($chargeToDept);
            $issuance = new Requisition();
            $issuance->Type = $request->Type;
            $issuance->GLAccount = is_array($request->GLCode)?$request->GLCode[0]:$request->GLCode;
            $issuance->OrderNumber = $orderNumber;
            $issuance->Date = Carbon::parse($request->DateRequired); //Carbon::now();//->parse('F d, y');
            $issuance->Requester = $authUser->ID;
            $issuance->Department = $authUser->Department()->ID;
    
            //default dept mgr if approvers are empty
            $defaultApprover = $selectedApproverID;
            $issuance->Approver1 = $request->Approver1?$request->Approver1:$defaultApprover;
            $issuance->Approver2 = $request->Approver2?$request->Approver2:$defaultApprover;

            $issuance->ChargeTo = $chargeToDept->ID;

            if($request->Type=='IR'){
                // $issuance->Approver1 = $authUser->Department()->Manager()->ID;
//                $issuance->Approver1 = $request->Approver;
//                $issuance->Approver2 = $chargeToDept->Manager()->ID;
                $issuance->ChargeType = $request->ChargeType;
                $issuance->Status = '1'; // one approval only for IR
            } else { // PR
                $issuance->Status = '1';
                if(isset($request->ChargeType)) {
                    $issuance->ChargeType = $request->ChargeType;
                    // $issuance->ChargeTo = $issuance->Department;
                    // $issuance->Approver2 = $chargeToDept->Manager()->ID;
                } else {
                    $chargeToDept = Department::findByName('Materials Group');
                    // $issuance->ChargeTo = $issuance->Department;
                    // $issuance->Approver2 = $chargeToDept->Manager()->ID;
                }
                // $issuance->Approver1 = $authUser->Department()->Manager()->ID;
            }

            $issuance->Purpose = $request->Purpose;

            $remarks = array();
            $remark = array('userid'=>auth()->user()->ID, 'message'=>$request->Remarks, 'time'=>Carbon::now()->toDateTimeString());
            array_push($remarks, $remark);

            $issuance->Remarks = json_encode(['data'=>$remarks]);

            $issuance->save();

            for($i=0;$i<count($request->Product);$i++) {
                $product = Product::find($request->Product[$i]);
                if($product->InventoryGL == 0) {
                    $product->InventoryGL = $request->InventoryGL;
                }

                $lineItem = new LineItem();
                $lineItem->OrderNumber = $issuance->OrderNumber;
                $lineItem->Product = $product->ID;
                $lineItem->Quantity = $request->Quantity[$i];
                $lineItem->GLCode = is_array($request->GLCode)?$request->GLCode[$i]:$request->GLCode;

                if($product->IssuanceGL == 0) {
                    $product->IssuanceGL = $lineItem->GLCode;
                    $product->save();
                }

                $lineItem->save();
            }

            $log = new StatusLog();
            $log->OrderNumber = $orderNumber;
            $log->TransactionType = $request->Type;
            $log->LogType = 'N';
            $log->save();

            /* TODO: Send Mail to all persons involved
             * 1. Send Notification that Request is created.
             *  - Creator
             *  - Approver 1
             *  - Approver 2
             *  - Plant Manager
             * 2. Send Notification to Purchasing to do quotes for the items.
             *
            */

            dispatch(new SendRequisitionEmail($issuance->ID));
            // $exitCode = Artisan::call('queue:work');
            
            // Finally, clear the rsList after creating the request.

            session()->pull('requisitionList', []);
            session()->pull('issuanceList', []);
        });

        $path = sprintf('/%s/view/',$request->Type=='IR'?'issuance-request':'purchase-request');
        return redirect()->to($path.$orderNumber);
    }


    public function getCurrentIncrement($type)
    {
        $i = 0;
        $current = $this->requisition->where('Type','=',$type)->orderByDesc('created_at')->first();
        if($current) {
            if(is_numeric($current->OrderNumber)) {
                $i = $current->OrderNumber;
            } else {
                $i = substr($current->OrderNumber,2);
            }
            $i++;
        } else {
            $i++;
        }
        return sprintf('%s%s',$type,str_pad($i,7,'0',STR_PAD_LEFT));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Requisition  $issuance
     * @return \Illuminate\Http\Response
     */
    public function showEditIssuanceRequestForm($issuance) {
        $issuance = $this->requisition->where('OrderNumber','=', $issuance)->first();
        return view('rs.issuance.edit', ['data'=>$issuance]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Requisition  $issuance
     * @return \Illuminate\Http\Response
     */
    public function showPurchaseRequestEditForm($pr) {
        $pr = $this->requisition->where('OrderNumber','=', $pr)->first();
        return view('rs.purchase.edit', ['data'=>$pr]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Requisition  $issuance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $rs)
    {
        $rs = $this->requisition->where('OrderNumber','=',$rs)->first();

        for($i=0;$i<count($request->LineItem);$i++) {
            $entry = $this->lineItem->where('ID','=', $request->LineItem[$i])->first();
            $entry->GLCode = $request->GLCode[$i];
            $entry->Quantity = $request->Quantity[$i];
            $entry->save();
        }

        $log = new StatusLog();
        $log->OrderNumber = $rs->OrderNumber;
        $log->TransactionType = $rs->Type;
        $log->LogType = 'U'; // update.
        $log->save();

        $path = $rs->Type=='IR'?"issuance-request":"purchase-request";

        return redirect()->to("/$path/view/{$rs->OrderNumber}");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Requisition  $issuance
     * @return \Illuminate\Http\Response
     */
    public function destroy(Requisition $issuance)
    {
        //
    }

    public function getPurchaseRequestList($status) {
        $data = array();
        $authUser = $this->user->where('ID','=',auth()->user()->ID)->firstOrFail();

        if($authUser->isAuthorized('PurchaseRequests','M')
         or $authUser->isPlantManager() or $authUser->isPurchasingManager() or $authUser->isAdministrator()
        ) {
            $issuances = $this->requisition->where('Type', '=', 'PR');
        }
        else {
            $issuances = $this->requisition
                ->where('Type','=','PR')
                ->where(function($query) use ($authUser) {
                    $query
                        ->where('Requester','=',$authUser->ID)
                        ->orWhere('Approver1','=',$authUser->ID)
                        ->orWhere('Approver2','=',$authUser->ID);
                });
        }

        if($status=="Z") {
            $issuances = $issuances;
        } else {
            if($status=='P') {
                $issuances = $issuances
                    ->where('Type','=','PR')
                    ->where(function($query) use ($authUser) {
                        $query
                            ->where('Status','=','P')
                            ->orWhere('Status','=',2)
                            ->orWhere('Status','=',1)
                            ->orWhere('Status','=','Q');
                    });
                    
            } else if($status=='X' || $status=='V') {
                $issuances = $issuances
                    ->where('Type','=','PR')
                    ->where(function($query) use ($authUser) {
                        $query
                            ->where('Status','=','X')
                            ->orWhere('Status','=','C')
                            ->orWhere('Status','=','V');
                    });
            } else {
                $issuances = $issuances
                    ->where('Type','=','PR')
                    ->where(function($query) use ($status) {
                        $query
                            ->where('Status','=',$status);
                    });
            }
        }

        foreach($issuances->get() as $issuance) {
            $requester = $this->user->where('ID','=',$issuance->Requester)->firstOrFail();

            $entry = array();
            $entry['ID'] = $issuance->ID;
            $entry['OrderNumber'] = $issuance->OrderNumber;
            $entry['Date'] = $issuance->Date->format('F d, Y');
            $entry['Requester'] = $requester->Person()->Name();
            $entry['ChargeTo'] = $this->department->where('ID','=',$issuance->ChargeTo)->first()->Name;
            $entry['Status'] = $issuance->Status();
            array_push($data, $entry);
        }

        $entry['Role'] = auth()->user()->isPurchasingManager();    
        return response()->json(['aaData'=>$data]);
    }

    public function getIssuanceRequestList($status) {
        $data = array();
        $authUser = $this->user->where('ID','=',auth()->user()->ID)->firstOrFail();

        if($authUser->isAdministrator()
        or $authUser->isAuthorized('Issuances','M')
        or $authUser->isPlantManager() 
        or $authUser->isPurchasingManager()
        ) {
            $issuances = $this->requisition->where('Type','=','IR');
        } else {
            $issuances = $this->requisition
                ->where('Type','=','IR')
                ->where(function($query) use ($authUser) {
                    $query
                        ->where('Requester','=',$authUser->ID)
                        ->orWhere('Approver1','=',$authUser->ID)
                        ->orWhere('Approver2','=',$authUser->ID);
                });
        }

        if($status=="Z") {
            $issuances = $issuances;
        } else {
            if($status=='P') {
                $issuances = $issuances
                    ->where('Type','=','IR')
                    ->where(function($query) use ($authUser) {
                        $query
                            ->where('Status','=','P')
                            ->orWhere('Status','=',1)
                            ->orWhere('Status','=',2);
                    });
            } else if($status=='X' || $status=='V') {
                $issuances = $issuances
                    ->where('Type','=','IR')
                    ->where(function($query) use ($authUser) {
                        $query
                            ->where('Status','=','X')
                            ->orWhere('Status','=','C')
                            ->orWhere('Status','=','V');
                    });
            } else {
                $issuances = $issuances
                    ->where('Type','=','IR')
                    ->where(function($query) use ($status) {
                        $query
                            ->where('Status','=',$status);
                    });
            }
        }


        foreach($issuances->get() as $issuance) {
            $requester = $this->user->where('ID','=',$issuance->Requester)->firstOrFail();
            $entry = array();
            $entry['ID'] = $issuance->ID;
            $entry['OrderNumber'] = $issuance->OrderNumber;
            $entry['Date'] = $issuance->Date->format('F d, Y');
            $entry['Requester'] = $requester->Person()->Name();
            $entry['ChargeTo'] = $this->department->where('ID','=',$issuance->ChargeTo)->first()->Name;
            $entry['Status'] = $issuance->Status();
            array_push($data, $entry);
        }
        return response()->json(['aaData'=>$data]);
    }

    public function toggleIssuanceRequest(Request $request, $issuance) {
        $authUser = $this->user->where('ID','=',auth()->user()->ID)->firstOrFail();
        $requisition = new Requisition();

        $issuance = $this->requisition->where('OrderNumber','=',$issuance)->first();
        $issuance->Status = $issuance->Status=='P'?'1':($issuance->Status=='1'?'A':'P');


        $remarks = json_decode($issuance->Remarks, true);
        $remark = array('userid'=>$authUser->ID, 'message'=>$request->Remarks, 'time'=>\Carbon\Carbon::now()->toDateTimeString());

        array_push($remarks['data'], $remark);

        $issuance->Remarks = json_encode($remarks);

        $issuance->save();

        if($issuance->Status != 'P') {
            $log = new StatusLog();
            $log->OrderNumber = $issuance->OrderNumber;
            $log->TransactionType = 'IR'; // issuance
            $log->LogType = $issuance->Status;
            $log->save();
        }

        return redirect()->back();
    }

    public function togglePurchaseRequestStatus(Request $request, $pr) {
        $authUser = $this->user->where('ID','=',auth()->user()->ID)->firstOrFail();
        $pr = $this->requisition->where('OrderNumber','=',$pr)->first();


        switch($pr->Status) {
            //case 'P': $status = '1'; break;
            case '1': $status = $pr->isFullyQuoted()==1?'2':'Q'; break;
            case '2': $status = 'A'; break;
            default: $status = $pr->Status;
        }

        $pr->Status = $status;

        $remarks = json_decode($pr->Remarks, true);
        $remark = array('userid'=>$authUser->ID, 'message'=>$request->Remarks, 'time'=>\Carbon\Carbon::now()->toDateTimeString());
        array_push($remarks['data'], $remark);
        $pr->Remarks = json_encode($remarks);
        $pr->save();

        if($pr->Status == '1') {
            // TODO:
            // check if there are products that needs to be quoted.
            // if(any()) {
            //    send mail to purchasing to add quote.
            // }
        }

        if($pr->Status == '2') {
            // TODO:
            // check if there are products that needs to be quoted.
            // if(any()) {
            //    send mail to purchasing to add quote.
            // }
        }

        if($pr->Status == 'A') {
            // TODO:
            // check if there are products that needs to be quoted.
            // if(any()) {
            //    send mail to purchasing to add quote.
            // }
        }


        if($pr->Status != 'P') {
            $log = new StatusLog();
            $log->OrderNumber = $pr->OrderNumber;
            $log->TransactionType = 'PR'; // purchase
            $log->LogType = $pr->Status;
            $log->save();
        }



        return redirect()->back();
    }

    public function voidIssuanceRequest(Request $request, $issuance) {
        $authUser = $this->user->where('ID','=',auth()->user()->ID)->firstOrFail();
        $issuance = $this->requisition->where('OrderNumber','=',$issuance)->first();
        $issuance->Status = 'V';

        $remarks = json_decode($issuance->Remarks, true);
        $remark = array('userid'=>$authUser->ID, 'message'=>$request->Remarks, 'time'=>\Carbon\Carbon::now()->toDateTimeString());
        array_push($remarks['data'], $remark);
        $issuance->Remarks = json_encode($remarks);

        $issuance->save();

        $log = new StatusLog();
        $log->OrderNumber = $issuance->OrderNumber;
        $log->TransactionType = 'IR'; // issuance
        $log->LogType = 'V';
        $log->save();

        return redirect()->back();
    }

    public function voidPurchaseRequest(Request $request, $pr) {
        $authUser = $this->user->where('ID','=',auth()->user()->ID)->firstOrFail();
        $pr = $this->requisition->where('OrderNumber','=',$pr)->first();
        $pr->Status = 'V';

        $remarks = json_decode($pr->Remarks, true);
        $remark = array('userid'=>$authUser->ID, 'message'=>$request->Remarks, 'time'=>\Carbon\Carbon::now()->toDateTimeString());
        array_push($remarks['data'], $remark);
        $pr->Remarks = json_encode($remarks);

        $pr->save();

        $log = new StatusLog();
        $log->OrderNumber = $pr->OrderNumber;
        $log->TransactionType = 'PR'; // issuance
        $log->LogType = 'V';
        $log->save();

        return redirect()->back();
    }


    public function rsdata(Request $request) {
        $data = array();
        $products = Product::all();
//        $products = Product::paginate(50);
        foreach($products as $product){
            $uom = $product->UOM()->Abbreviation;
            $entry = array();
            $entry['ID'] = $product->UniqueID;
            $entry['Name'] = $product->Name;
            $entry['Description'] = $product->Description;
//            $entry['Category'] = $product->Category;
            $entry['Category'] = $product->CategoryCode();
            $entry['ProductLine'] = $product->ProductLineCode();
            $entry['Available'] = sprintf('%d %s',($product->getAvailableQuantity()), $uom);
            $entry['Reserved'] = sprintf('%d %s',($product->Reserved()), $uom);
            $entry['Incoming'] = sprintf('%d %s',($product->Incoming()), $uom);
            array_push($data, $entry);
        }
        return response()->json(['data'=>$data]);
    }

    public function getDepartmentData(Request $request) {
        $data = array();
        $query = $request->q ?: $request->term;
        if($query == "undefined") {
            $departments = Department::all();
            for($i=0;$i<count($departments);$i++){
                $entry['id'] = $departments[$i]->ID;
                $entry['text'] = $departments[$i]->Name;

                array_push($data, $entry);
            }
        }
        else {
            $departments = Department::where('Name','like','%'.$query.'%')->get();
            for($i=0;$i<count($departments);$i++){
                $entry['id'] = $departments[$i]->ID;
                $entry['text'] = $departments[$i]->Name;

                array_push($data, $entry);
            }
        }

        return response()->json(['results'=>$data]);
    }

    public function getGeneralLedgerDataOfDepartmentForSelect(Request $request, $type, $departmentID) {
        $department = new Department();
        $department = $department->where('ID','=',$departmentID)->first();

        if($type=="issuance") {
            $glList = $department->getGeneralLedgerCodes('I');
        }
        else if ($type=="expense") {
            $glList = $department->getGeneralLedgerCodes('X');
        }
        else if ($type=="inventory") {
            $glList = GeneralLedger::getInventoryGeneralLedgerCodes();
        } else {
            $glList = GeneralLedger::getCapexGeneralLedgerCodes();
        }

        $data = array();
        if($request->q) {
            $glList = collect($glList)->filter(function ($item) use ($request) {
                return false !== stristr($item->Code, $request->q) || false !== stristr($item->Description, $request->q);
            });

            $glList = collect($glList);
            
            foreach($glList as $k=>$v) {
                $v['id'] = $glList[$k]->ID;
                $v['text'] = '['.$glList[$k]->Code.'] '.$glList[$k]->Description;

                array_push($data, $v);
            }
        } else {
            for($i=0;$i<count($glList);$i++) {
                $entry['id'] = $glList[$i]->ID;
                $entry['text'] = '['.$glList[$i]->Code.'] '.$glList[$i]->Description;

                array_push($data, $entry);
            }
        }

        return response()->json(['results'=>$data]);
    }

    public function getApproverDataOfDepartmentForSelect($department) {
        $data = array();
        $approvers = Department::where('ID','=',$department)->first()->Approvers();

        foreach($approvers as $approver) {
            if($approver->User()->Status==1) {
                $entry['id'] = $approver->ID;
                $entry['text'] = $approver->Name().' ('.$approver->User()->Username.')';

                array_push($data, $entry);
            }
        }
        
        return response()->json(['results'=>$data]);
    }

    public function updateIssuanceReceivingDetails(Request $request){

    }

    public function addToRequisitionList(Request $request, $table){
        $list = session()->pull($table, []); // Second argument is a default value

        if(!in_array($request->value, $list, true)) {
            array_push($list, $request->value);
            session()->put($table, $list);
        }
        else {
            session()->put($table, $list);
            return response()->json(['message'=>"Item $request->value already in the requisition list."]);
        }

        return response()->json(['message'=>"<strong>$request->value</strong> added to requisition list."]);
    }

    public function addArrayToRequisitionList(Request $request, $table){
        $list = session()->pull($table, []); // Second argument is a default value

        $array = json_decode($request->value);

        $counter = 0;
        foreach($array as $entry) {
            if(!in_array($entry, $list, true)) {
                array_push($list,$entry);
                session()->put($table, $list);
                $counter++;
            }
            else {
                session()->put($table, $list);
                return response()->json(['message'=>"Item $request->value already in the requisition list."]);
            }

        }

        return response()->json(['message'=>"<strong>$counter items</strong> added to requisition list."]);
    }

    public function removeFromRequisitionList(Request $request, $table){
        $list = session()->pull($table, []); // Second argument is a default value
        if(($key = array_search($request->value, $list)) !== false) {
            unset($list[$key]);
        }
        session()->put($table, $list);

        return response()->json(['message'=>"<strong>$request->value</strong> removed from requisition list."]);
    }

    public function getRequisitionList($table) {
        $list = session()->pull($table, []); // Second argument is a default value
        session()->put($table, $list);

        $data = array();
        $product = new Product();
        if($list) {
            foreach($list as $item){
                $product = $product->where('ID','=',$item)->firstOrFail();

                $uom = $product->UOM()->Abbreviation;
                $entry = array();
                $entry['ID'] = $product->ID;
                $entry['UniqueID'] = $product->UniqueID;
                $entry['Name'] = $product->Name;
                $entry['Description'] = $product->Description;
                $entry['Category'] = $product->CategoryCode();
                $entry['ProductLine'] = $product->ProductLineCode();
                $entry['Available'] = sprintf('%d %s',($product->getAvailableQuantity()), $uom);
                $entry['Reserved'] = sprintf('%d %s',($product->getReservedQuantity()), $uom);
                $entry['Incoming'] = sprintf('%d %s',($product->getIncomingQuantity()), $uom);
                array_push($data, $entry);
            }
        }
        return response()->json(['data'=>$data]);
    }

    public function getRequisitionListAsArray($table) {
        $list = session()->pull($table, []); // Second argument is a default value
        session()->put($table, $list);

        dd($list);
    }

    public function getRequisitionListCount($table) {
        $list = session()->pull($table, []); // Second argument is a default value
        session()->put($table, $list);

        return count($list);
    }

    public function showForRestockingList() {
        return view('rs.restock.index');
    }

    public function showDeferredForRestockingList() {
        return view('rs.restock.deferred');
    }

    public function addNewLineItem(Request $request) {
        $product = new Product();
        $product->Location = Location::findByName('Default Location')->ID;
        $product->Name = $request->Name;
        $product->Description = $request->Description;
        $product->Category = $request->Category;
        $product->ProductLine = ProductLine::FindProductLineByCode($request->ProductLine);
        $product->Series = $product->getNextItemSeriesNumber();
        $product->Quantity = 0;
        $product->UOM = $request->UOM;
        $product->ReOrderQuantity = 0;
        $product->MaximumQuantity = 0;
        $product->MinimumQuantity = 0;
        $product->ReOrderPoint = 0;
        $product->UniqueID = $product->generateUniqueID("temp");
        $product->save();

        return view('templates.LineItemRow',['data'=>$product]);
    }

    public function addNewLineService(Request $request) {
        $product = new Product();
        $product->Location = Location::findByName('Default Location')->ID;
        $product->Name = "Service";
        $product->Description = $request->Description;
        $product->Category = 1;
        $product->ProductLine = 1;
        $product->Series = $product->getNextServiceSeriesNumber();
        $product->Quantity = 0;
        $product->UOM = UnitOfMeasure::findByName('Lot')->ID;
        $product->ReOrderQuantity = 0;
        $product->MaximumQuantity = 0;
        $product->MinimumQuantity = 0;
        $product->ReOrderPoint = 0;
        $product->UniqueID = $product->generateUniqueID("svc");
        $product->save();

        return view('templates.ServiceItemRow',['data'=>$product]);
    }

    public function generateCanvassReport($purchaseRequest) {
        $pr = new Requisition();

        try{
            $pr = $pr->where('OrderNumber', '=',$purchaseRequest)->first();
            if($pr) {

                $user = User::where('ID','=',$pr->Requester)->first();

                $department = $pr->Department()->Name;
                $purpose = $pr->Purpose;
                $date = $pr->Date;
                $orderNumber = $pr->OrderNumber;

                $requester = $user->Person()->AbbreviatedName();
                $orderedBy = $user->Username; // nag order

                $checkedBy = Role::FindUserWithRole("PurchasingManager")->Username; // Purchasing Manager
                $approvedBy = Role::FindUserWithRole("PlantManager")->Username;; // Plant Manager

                $timeRequested = $pr->Date->format('h:i:s A -');
                $dateRequested = $pr->Date->format('n/j/Y');


                $c = collect($pr->OrderItems());
                $timeChecked_raw = $c->sortBy('created_at', SORT_REGULAR, true)->first();

                $timeChecked = $timeChecked_raw->created_at->format('h:i:s A -');
                $dateChecked = $timeChecked_raw->created_at->format('n/j/Y');

                $dto = new DTO();
                $dto->Department = $department;
                $dto->Requester = $requester;
                $dto->Purpose = $purpose;
                $dto->Date = $date->format('n/j/Y');
                $dto->OrderNumber = $orderNumber;
                $dto->OrderedBy = sprintf("%s / %s", $orderedBy, $timeRequested);
                $dto->DateRequested = $dateRequested;
                $dto->CheckedBy = sprintf("%s / %s", $checkedBy, $timeChecked);
                $dto->DateChecked = $dateChecked;

                $dto->LineItems = $pr->LineItems();

                if($pr->Status == 'A') {
                    $timeApproved = $pr->updated_at->format('h:i:s A -');
                    $dateApproved = $pr->updated_at->format('n/j/Y');
                    $dto->ApprovedBy = sprintf("%s / %s", $approvedBy, $timeApproved);
                    $dto->DateApproved = $dateApproved;
                }
                else {
                    $dto->ApprovedBy = "";
                    $dto->DateApproved = "";
                }


                return view('report.templates.canvassreport',['data'=>$dto]);

//                $pdf = \PDF::loadView('report.templates.canvassreport',['data'=>$dto]);
//                $pdf->setPaper('letter','landscape');
//                return $pdf->download('testinvoice.pdf');

            } else {
                $data = new DTO();
                $data->Title = "Purchase Request $purchaseRequest";
                $data->Class = "Purchase Request";
                $data->Description = "We cannot not find the $data->Class in the database.";
                return response()
                    ->view('errors.404',['data'=>$data]
                        ,404);
            }
        } catch(\Exception $exc) {
            dd($exc);
        }


    }

    public function generateIssueSlip($issuance) {
        $ir = new IssuanceReceipt();


        try{
            $issuanceReceipt = $ir->where('OrderNumber','=',$issuance)->first();
            if($issuanceReceipt) {
                $lineItem = $issuanceReceipt->getLineItem();
                $rs = $lineItem->Requisition();
                $dto = new DTO();
                $dto->Department = $rs->ChargedTo()->Name;
                $dto->OrderNumber = $issuanceReceipt->OrderNumber;
                $dto->IssuanceNo = $rs->OrderNumber;
                $dto->Date = Carbon::parse($issuanceReceipt->Received)->format('j/d/Y');
                $dto->Time = Carbon::parse($issuanceReceipt->Received)->format('g:i:s a');
                $dto->LineItems = $issuanceReceipt->getLineItems();


                return view('report.templates.issuance',['data'=>$dto]);

            }
        } catch(\Exception $exc) {
            dd($exc);
        }
    }

    public function getIssuanceDataByOrderNumber($issuance) {
        return view('rs.issuance.issuance.details',['data'=>Requisition::where('OrderNumber','=',$issuance)->firstOrFail()]);
    }


    public function addToDeferList(Request $request) {
        $product = Product::where('ID','=',$request->id)->firstOrFail();
        if($product->setDeferred()) {
            return response()->json(['message'=>"Item {$product->Description} has been deferred."]);
        }
        return false;
    }

    public function addArrayToDeferList(Request $request) {

        $array = json_decode($request->value);

        $counter = 0;
        foreach($array as $entry) {
            $product = Product::where('ID','=',$entry)->firstOrFail();
            $product->setDeferred();
            $counter++;
        }
        return response()->json(['message'=>"<strong>$counter items</strong> added to deferred list."]);

    }

    public function restoreDeferredItem(Request $request) {
        $product = Product::where('ID','=',$request->id)->firstOrFail();
        if($product->restoreDeferred()) {
            return response()->json(['message'=>"Item {$product->Description} has been deferred."]);
        }
    }
}
