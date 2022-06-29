@extends('panel.master')
@section('content')

<div class="row">
	<div class="col-12">
		<div class="form-group">
			<div class="btn-group" role="group" aria-label="Basic example">
				<button  class="btn btn-primary" id="expense_type"  data-id="1">
					Create
				</button>
				
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-12">
		<div class="card">
			
			<div class="card-body pb-0">
				@if(count($expense) > 0)

				<table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                
								<th scope="col">Expense Type  </th>
								
								
								<th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
        	
        	@foreach($expense as $payment)
        	
            <tr>
					
								<td>
									{{ $payment->expence_type }}
								</td>
							
								
								<td class="col-2 d-flex">
									
									<a type="button" href="{{ route('expense.edit', ['expense' => $payment->id]) }}"  class="btn btn-md btn-info ml-2 ">
											Update 
										</a>

									<form action="{{ route('expense.destroy', ['expense' => $payment->id]) }}" method="POST" class="d-inline" onsubmit="return confirmDelete()">
										@method('DELETE')
										@csrf
										<button type="submit" class="btn btn-md ml-3 btn-danger">
											Delete
										</button>
									</form>
								
									
								</td>
							</tr>
            @endforeach
        </tbody>
    </table>
				
				 
				@else
				<x-alert.resource-empty resource="products" new="expense.create"></x-alert.resource-empty>
				@endif			
			</div>
		
		</div>
	</div>
</div>




<!-- Modal -->
<x-expense.createexpensecomponent />



@endsection
@section('script')
<script type="text/javascript">

 $('.expense').click(function(e){

 	e.preventDefault()
 	let id=$(this).data('id')
 	let expense=$(this).data('expense')
 	$('#expenseupdate').modal('show')
 	$('#expense_id').val(id);
 	$('#expense_type').val(expense);
 })
</script>
@parent
@endsection