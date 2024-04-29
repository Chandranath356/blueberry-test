<?php

namespace App\Imports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\Importable;

class CustomersImport implements ToModel,SkipsEmptyRows, WithHeadingRow,WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    use Importable;
    public function model(array $row)
    {
      
        return new Customer([
            'date'  => date('Y-m-d',strtotime($row['date'])),
            'name' => $row['name'],
            'amount' => $row['amount'],
        ]);
    }

     public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
            ],
            'date'=>['required','date'],
            'amount'=>['required','integer']
        ];
    }
}
