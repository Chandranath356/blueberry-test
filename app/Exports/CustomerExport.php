<?php

namespace App\Exports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use DB;
use Maatwebsite\Excel\Concerns\FromView;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class CustomerExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
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

    public function view(): View
    {
         $data = Customer::select('date','name',DB::raw('SUM(amount) as amount'))->whereBetween('date',[Carbon::now()->startOfMonth()->format("Y-m-d"),Carbon::now()->format("Y-m-d")])->groupBy('date')->groupBy('name')->get();
         
         $data1 = $this->transposeData($data);
        
         $getalldates = $this->getalldate(Carbon::now()->startOfMonth()->format("Y-m-d"),Carbon::now()->format("Y-m-d"));
     
        return view('cutomer', [
            'data1' => $data1,
            'getalldates'=>$getalldates,
            'data'=>$data
        ]);
    }
}
