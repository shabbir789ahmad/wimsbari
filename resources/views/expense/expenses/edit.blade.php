@extends('panel.master')

@section('content')

<form action="{{ route('expence.update',['expence' => $expense->id]) }}" method="POST" enctype="multipart/form-data">
	@method('PUT')
	@csrf
	<div class="row">
		<div class="col">
			<div class="card">
				<div class="card-body">
					<div class="row">
						<div class="col-6">
                          <select class="form-control mt-4" name="e_type">
                       
                           @foreach($expense_type as $type)
                            <option value="{{$type['id']}}" @if($type['id'] == $expense->expense_id) selected @endif >{{$type['expence_type']}}</option>
                           @endforeach
                          </select> 
						</div>
                       <div class="col-6">
        
                         <lable class="font-weight-bold">Expense Amount</lable>
                         <input type="text" name="expense_amount" value="{{$expense['expense']}}" class="form-control">
                      </div>
                      <div class="col-6 mt-3 mb-4">
                      <lable class="font-weight-bold mt-5">Expense User</lable>
                      <input type="text" name="expense_user" value="{{$expense['name']}}" class="form-control">
                  </div>
              </div>
					<x-btn.update></x-btn.update>
				</div>
			</div>
		</div>
	</div>
</form>

@endsection