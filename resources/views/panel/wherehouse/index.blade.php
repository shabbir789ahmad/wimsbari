@extends('panel.master')

@section('content')

<div class="row">
	<div class="col-12">
		<div class="form-group">
			<x-btn.link-create route="wherehouse.create"></x-btn.link-create>
		</div>
	</div>
</div>
	
<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-body pb-1">
				@if(count($wherehouses) > 0)
					<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover">
							<thead class="thead-light">
								<tr>
									
									<th scope="col">WhereHouse Name</th>
									<th scope="col">WhereHouse Location</th>
									
									<th scope="col"></th>
								</tr>
							</thead>
							<tbody>
								@foreach($wherehouses as $wherehouse)
								<tr>
									
									<td>{{ $wherehouse->where_house_name }}</td>
									<td>{{ $wherehouse->where_house_location}}</td>
									
									<td>
										<a href="{{ route('wherehouse.edit', ['wherehouse' => $wherehouse->id]) }}" type="submit" class="btn btn-md btn-info">
										Edit
									</a>
										<form action="{{ route('wherehouse.destroy', ['wherehouse' => $wherehouse->id]) }}" method="POST" class="d-inline" >
											
											@csrf
											@method('Delete')
											<button type="submit" class="btn  btn-danger">
												Delete
											</button>
										</form>
										
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				@else
					<x-alert.resource-empty resource=" WhereHouse" new="wherehouse.create"></x-alert.resource-empty>
				@endif			
			</div>
		</div>
	</div>
</div>

@endsection