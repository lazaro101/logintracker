@extends('layouts.admin')

@section('style')
<style type="text/css">
#project {
  float: left;
  margin-bottom: 50px;
}
#buttons {
  float: right;
  margin-bottom: 50px;
}

#project span {
  color: #5D6975;
  text-align: right;
  width: 150px;
  margin-right: 10px;
  display: inline-block;
  font-size: 1em;
  font-weight: bold;
}

#company {
  float: right;
  text-align: right;
}

#project div,
#company div {
  white-space: nowrap;        
}
</style>
@endsection

@section('content')
<div class="ui main container">
	<h4 class="ui horizontal divider header">
	  <i class="info circle icon"></i>
	  Trainee Information
	</h4>

	<div class="row">
		<div class="column">
	      	<div id="project">
		        <div><span>Name:</span> {{$info->fname.' '.$info->mname.' '.$info->lname}}</div>
		        <div><span>School:</span> {{$info->school}}</div>
		        <div><span>Schedule:</span> {{date_create($info->schedule->starttime)->format('h:i a').' - '.date_create($info->schedule->endtime)->format('h:i a')}}</div>
		        <div><span>Hours to Render:</span> {{$info->render_hrs}} hrs</div>
		        <div><span>Start Date:</span> {{date_create($info->start_date)->format('M d, Y')}}</div> 
	      	</div>
		</div>
		<div class="column">
			<div id="buttons">
				<a href="" class="ui icon huge blue button"><i class="print icon"></i></a>
			</div>
		</div>
	</div>

	<div class="row" style="margin-top: 50px">
		<div class="column">
			<table class="ui striped inverted celled table">
				<thead>
					<tr>
						<th class="four wide">Date</th>
						<th class="four wide">Time in</th>
						<th class="four wide">Time out</th>
						<th class="two wide">Hours Rendered</th>
					</tr> 
				</thead>
				<tbody>
					@php $total = 0 @endphp
					@foreach($logs as $log)
					<tr>
						<td>{{date_create($log->dtime_in)->format('M d, Y')}}</td>
						<td>{{date_create($log->dtime_in)->format('h:i a')}}</td>
						<td>{{date_create($log->dtime_out)->format('h:i a')}}</td>
						@php
							$dteStart = new DateTime($log->dtime_in); 
							$dteEnd   = new DateTime($log->dtime_out);
							$dteDiff  = $dteStart->diff($dteEnd);  
						@endphp
						<td>{{$dteStart->format("H:i")}}</td>
					</tr>
					@endforeach
				</tbody>
				<tfoot>
					<tr>
						<th colspan="3" class="right aligned">Total No. of Hours Rendered:</th>
						<th>{{$total}}</th>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>

</div>
@endsection