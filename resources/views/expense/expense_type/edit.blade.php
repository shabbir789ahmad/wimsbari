@extends('panel.master')

@section('content')

<form action="{{ route('expense.update',['expense' => $expense->id]) }}" method="POST" enctype="multipart/form-data">
	@method('PUT')
	@csrf
	<div class="row">
		<div class="col">
			<div class="card">
				<div class="card-body">
					<div class="form-group">
						<label for="">
							Expense Type <span class="text-danger">*</span>
						</label>
						<x-forms.input type="text" name="expence_type" class="form-control" value="{{ $expense->expence_type }}"></x-forms.input>
						
					</div>
					<x-btn.update></x-btn.update>
				</div>
			</div>
		</div>
	</div>
</form>

@endsection