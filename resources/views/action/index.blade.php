@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="row"><h2>
					  <div class="col-md-10">รายการบริการทั้งหมด</div>
					  <div class="col-md-2"><a href="{{ route('action-add') }}"><button type="button" class="btn btn-success">
 				 		เพิ่มบริการ
						</button></a></div>
					</h2>
					</div>
				</div>

				<div class="panel-body">
					<ul class="nav nav-pills nav-stacked">
						@foreach( $actions as $action )
							<li role="presentation"><a href="{{ route('action', $action->action_id ) }}">{{ $action->name }}</a></li>
						@endforeach
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection