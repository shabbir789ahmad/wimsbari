@extends('panel.master')
@section('content')

<div class="row">
	<div class="col-12">
		<div class="form-group">
			<div class="btn-group" role="group" aria-label="Basic example">
				<a href="#"  data-id="1" id="customer" class="btn btn-primary">
					Add Customer
				</a>
				
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-12">
		<div class="card">
			
			<div class="card-body pb-0">
				@if(count($customers) > 0)

				<table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th scope="col">Customer Image</th>
								<th scope="col">Customer Name </th>
								<th scope="col">Payable Address</th>
								<th scope="col">Customer Phone</th>
								
								<th scope="col">Customer Email</th>
								
								<th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
        	
        	@foreach($customers as $customer)
        	
            <tr class="col-1">
					     <td><img class="img-fluid img-thumbnail" src="{{asset('uploads/brand/'.$customer->customer_image)}}" style="width: 64px;" loading="lazy">
								<td>
									{{ $customer->customer_name }}
								</td>
								<td>
									{{ $customer->customer_address }}
								</td>
								<td>
									{{ $customer->customer_phone }}
								</td>
								<td>
									{{ $customer->customer_email }}
								</td>
								
								
								<td class=" d-flex">

									<a href="{{ route('customer.edit', ['customer' => $customer->id]) }}" type="button" class="btn btn-xs btn-info ml-2" >
											Update 
										</a>
									<form action="{{ route('customer.destroy', ['customer' => $customer->id]) }}" method="POST">
										@csrf
										@method('DELETE')
									<button type="submit" class="btn btn-xs btn-danger ml-2">
										Delete
									</button>
								</form>
									
							</td>
							</tr>
            @endforeach
        </tbody>
    </table>
				
				 
				@else
				<x-alert.resource-empty resource="products" new="customer.create"></x-alert.resource-empty>
				@endif			
			</div>
		
		</div>
	</div>
</div>


<x-customer.customercomponent  />

@endsection
