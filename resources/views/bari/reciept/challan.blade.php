@extends('panel.master')
@section('content')


<div class="row">
	<div class="col-12">
		<div class="card">
			
			<div class="card-body pb-0">
				
				@if(count($challans) > 0)

				<table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
           <tr>
            
            <th scope="col">Biller Name</th>
	        <th scope="col">Customer Name</th>
	        <th scope="col">Amount</th>
	        <th scope="col">Installation Charges</th>
	        <th scope="col">Delivery Charges</th>
	        <th scope="col"></th>
           </tr>
        </thead>
        <tbody>
        	
        	@foreach($challans as $invoice)
        	

        <tr>
        	<td>{{$invoice['biller_name']}}</td>
        	<td>{{$invoice['customer_name']}}</td>
        	<td>{{$invoice['paying_amount']}}</td>
        	<td>{{$invoice['discount']}}</td>
        	<td>{{$invoice['tax']}}</td>
		    <td class=" d-flex ">
		 
			<a href="{{ route('bari.quotation.edit', ['id' => $invoice->id]) }}" type="submit" class="btn btn-md btn-info ">
			Detail
			</a>
			
		
		<form action="{{route('bari.delete.order',['id'=>$invoice['id']])}}" method="POST" class="ml-1" onsubmit="return confirmDelete()">
		@method('DELETE')
		@csrf
		<button type="submit" class="btn btn-md btn-danger ">
			Delete
		</button>
								
		</form>
		</td>
							</tr>
      
            
            @endforeach
        </tbody>
    </table>
  
				
				 
				@else
				<x-alert.resource-empty resource="challans" new="bari.challan"></x-alert.resource-empty>
				@endif			
			</div>
		</form>
		</div>
	</div>
</div>






@endsection
@section('script')

@parent

<script type="text/javascript">



</script>
@endsection