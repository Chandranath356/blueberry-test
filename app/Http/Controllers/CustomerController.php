<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Http\Controllers\Controller;
use App\Imports\CustomersImport;
use App\Exports\CustomerExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use DB;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private function getalldate($startofmonth,$lastofmonth){

        $period =  CarbonPeriod::create($startofmonth,$lastofmonth);
        $dates = [];
        foreach ($period as $date) {
            array_push($dates,$date->format('Y-m-d'));
        }
        return $dates; 
    }
    private function getdatewisedata($data){
       
        $daterange = $this->getalldate(Carbon::now()->startOfMonth()->format("Y-m-d"),Carbon::now()->format("Y-m-d"));
        $data1 = [];
        foreach($daterange as $range ){
            if($data->where('date',$range)){
                array_push($data1,$data->where('date',$range));
            }
        }

        return $data1;
    }
    public function transposeData($data){
    
      $retData = array();
      $data1 = collect([$data]);
      $collection = collect(array_column($data->toArray(), 'name'));
      $customer = $collection->unique();
      foreach($customer as $row){
        $Data['customer'] = $row;
        $Data['data'] = $this->getdatewisedata($data->where('name',$row));
        array_push($retData,$Data);
        
       }
      return $retData;
    }

    public function index()
    {
        // $data = Customer::select('date','name',DB::raw('SUM(amount) as amount'))->groupBy('date')->groupBy('name')->get();
        // return $data;
   
        //  $data = $this->transposeData($data);
        
        return Excel::download(new CustomerExport, 'customer.csv');
        // return $data;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('upload');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
             'file' => 'required|file|mimes:csv,txt'
        ]);
        Excel::import(new CustomersImport, $request->file('file'));
        return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        //
    }
}
