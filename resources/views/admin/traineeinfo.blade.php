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
				<div class="ui icon huge green button" id="addlog"><i class="calendar plus outline icon"></i></div>
				<a href="/Admin/TraineePdf?download=pdf&id={{$info->ojt_profile_id}}" target="_blank" class="ui icon huge blue button"><i class="print icon"></i></a>
			</div>
		</div>
	</div>

	<div class="row" style="margin-top: 50px">
		<div class="column">
			<table class="ui striped inverted celled table">
				<thead>
					<tr>
						<th class="four wide">Date</th>
						<th class="three wide">Time in</th>
						<th class="three wide">Time out</th>
						<th class="two wide">Hours Rendered</th>
						<th class="one wide"></th>
					</tr> 
				</thead>
				<tbody>
					@php 
						$total = '00:00:00';
					@endphp
					@foreach($logs as $log)
					<tr>
						<td class="date">{{date_create($log->dtime_in)->format('M d, Y')}}</td>
						<td class="in">{{date_create($log->dtime_in)->format('h:i a')}}</td>
						<td class="out">
							@if($log->dtime_out != null)
							{{date_create($log->dtime_out)->format('h:i a')}}
							@else
							--:--
							@endif
						</td>
						@php
							if($log->dtime_out != null){
								$to_time = strtotime($log->dtime_out);
								$from_time = strtotime($log->dtime_in);
								$time = round(abs($to_time - $from_time) / 60,2);
								if($time > 240) {
									$time = round(abs($to_time - $from_time - 3600) / 60,2);
								}
								$total = Helper::sum_the_time($total, date("H:i:s",  mktime(0,$time,0)));
								echo '<td>'.date('H \h i \m', mktime(0,$time)).'</td>';
							} else {
								echo '<td> -- h -- m</td>';
							}
						@endphp 
						<td class="center aligned"><button class="ui icon red small button dellog"><i class="trash icon"></i></button></td>
					</tr>
					@endforeach
				</tbody>
				<tfoot>
					<tr>
						<th colspan="3" class="right aligned">Total No. of Hours Rendered:</th>
						<th colspan="2">{{Helper::format_total($total)}}</th>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>

</div>

<div class="ui modal" id="form"> 
  <div class="header">
    Add Log
  </div>
  <div class="content"> 
  <form class="ui form" method="post" action="/addLog">
    {{csrf_field()}}
    <input type="hidden" name="id" value="{{$info->ojt_profile_id}}"> 
    <div class="two fields">
      <div class="field">
        <label>Start Time:</label>  
        <div class="ui calendar starttime">
          <div class="ui input left icon">
            <i class="clock icon"></i>
            <input type="text" placeholder="Start Time" name="in">
          </div>
        </div>
      </div>
      <div class="field">
        <label>End Time:</label>  
        <div class="ui calendar endtime">
          <div class="ui input left icon">
            <i class="clock icon"></i>
            <input type="text" placeholder="End Time" name="out">
          </div>
        </div>
      </div>
    </div> 
  </div>
  <div class="actions">
    <button type="submit" class="ui positive button">Save</button>
    <button type="reset" class="ui black deny button">Cancel</button>
  </form>
  </div>
</div>

<div class="ui small modal" id="del">
  <div class="header">Delete</div>
  <div class="content">
    <p>Delete Log?</p>
  </div>
  <div class="actions">
    <form method="post" action="/delLog">
    <input type="hidden" name="id" value="{{$info->ojt_profile_id}}">
    <input type="hidden" name="date">
    {{csrf_field()}}
    <button type="submit" class="ui positive button">Yes</button>
    <button type="reset" class="ui black deny button">No</button>
    </form>
  </div>
</div>
@if(Session::has('message'))
<div style="position: fixed; width: 50%; height: 300px; left: 50%; top:50px; margin: 0 0 0 -25%; z-index: -1">
  <div class="ui error message">
    <!-- <i class="close icon"></i> --> 
    <div class="header">
    {{ Session::get('message') }}
    </div> 
  </div>
</div>
@endif
@endsection

@section('script')
<link rel="stylesheet" type="text/css" href="{{asset('Semantic-UI-CSS-master/calendar/dist/calendar.min.css')}}">
<script src="{{asset('Semantic-UI-CSS-master/calendar/dist/calendar.min.js')}}"></script>
<script type="text/javascript">
$(document).ready(function(){

  setTimeout(function(){ $('.ui.error.message').transition('fade'); }, 5000);

	$('#addlog').click(function(){
		$('#form').modal('show');
	    $('#form .starttime, #form .endtime').calendar({
	      type: 'datetime'
	    });
	    $('#form form').form('reset');
	});
	$('.dellog').click(function(){
		$('#del input[name=date]').val($(this).parent().parent().find('td.date').text()+' '+$(this).parent().parent().find('td.in').text());
		$('#del').modal('show');
	});
	  $('#form .positive.button').click(function(){
	    if ($('#form form').form('is valid') == false) {
	      $('#form form').form('validate form');
	      return false;
	    }
	    return true;
	  });
	  
	$('#form form')
	    .form({
	      inline: true,
	      fields: {  
	        in: {
	          identifier: 'in',
	          rules: [
	          {
	            type   : 'empty', 
	          }, 
	          ]
	        },
	        out: {
	          identifier: 'out',
	          rules: [
	          {
	            type   : 'empty', 
	          }, 
	          ]
	        },
	    }
	});
});
</script>
@endsection