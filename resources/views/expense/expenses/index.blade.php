@extends('panel.master')
@section('content')
<div class="row">
	<div class="col-12">
		<div class="form-group">
		<button class="btn btn-md btn-primary" data-id="1" id="new_expence">Create Expense</button>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-body pb-0">
				@if(count($expenses) > 0)
         <table id="example" class="table table-striped table-bordered" style="width:100%">
          <thead>
            <tr>
                <th scope="col">Expense Type </th>
								<th scope="col">Expense Amount </th>
								<th scope="col">Customer Name </th>
								<th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
        	 @foreach($expenses as $payment)
        	  <tr>
        	  	@foreach($expense_type as $type)
        	  	@if($type['id']==$payment['expense_id'])
					     <td>{{ $type->expence_type }}</td>
					     @endif
					     @endforeach
								<td>{{ $payment->expense }}</td>
								<td>{{ $payment->name }}</td>
							  <td class=" d-flex">
									<a href="{{ route('expence.edit', ['expence' => $payment->id]) }}" type="button"  class="btn btn-xs btn-info ml-2 ">
											Update 
									</a>
                  <form action="{{ route('expence.destroy', ['expence' => $payment->id]) }}" method="POST" class="d-inline" onsubmit="return confirmDelete()">
										@method('DELETE')
										@csrf
										<button type="submit" class="btn btn-sm ml-2 btn-danger">
											Delete
										</button>
									</form>
								</td>
						</tr>
            @endforeach
          </tbody>
        </table>
				@else
				<x-alert.resource-empty resource="Expenses" new="expense.create"></x-alert.resource-empty>
				@endif			
			</div>
		</div>
	</div>
</div>

<!-- create expense modal  -->
<x-expense.new-expencecomponent :expense="$expense_type"></x-expense.new-expencecomponent>



@endsection
@section('script')
<script type="text/javascript">
$('#example').DataTable( {
        "paging":   false,
        "ordering": false,
        "info":     false
    });
</script>
@parent
@endsection