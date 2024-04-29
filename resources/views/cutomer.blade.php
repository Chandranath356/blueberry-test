<table>
    <thead>
    <tr>
    	<th>Customer Name</th>
    	@foreach($getalldates as $row)
        <th>{{$row}}</th>
        @endforeach
    </tr>
    </thead>
    <tbody>
    @foreach($data1 as $row)
        <tr>
            <td>{{$row['customer']}}</td>
              @foreach($row['data'] as $date)
              	@if(!$date->isEmpty())
              	  <td>
              	  	{{$date->value('amount')}}
              	  </td>
              	@else
              	  <td>0</td>
              	@endif
              	
       		@endforeach
            
        </tr>
    @endforeach
    </tbody>
     <tfoot>
    <tr>
        <th>Grand Total</th>
        @foreach($getalldates as $row)
        <th>{{collect($data)->where('date',$row)->sum('amount')}}</th>
        @endforeach
    </tr>
    </tfoot>
</table>