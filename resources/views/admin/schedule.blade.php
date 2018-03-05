@extends('layouts.admin')

@section('content')
<div class="ui main container">

  <div class="row">
    <div class="column">
      <h2 class="ui header">Schedule</h2>
      <button class="ui labeled icon green button" type="button" id='add'>
        <i class="add icon"></i>
        ADD
      </button>
      <table class="ui celled table">
        <thead>
          <tr>
          <th>Schedule</th>
          <th class="four wide">Actions</th>
        </tr></thead>
        <tbody>
          @foreach($scheds as $sched)
          <tr>
            <td>{{date_create($sched->starttime)->format('h:i a').' - '.date_create($sched->endtime)->format('h:i a')}}</td>            
            <td class="center aligned">
              <button class="ui blue icon button edit" value="{{$sched->schedule_id}}"><i class="pencil icon"></i></button>
              <button class="ui red icon button del" value="{{$sched->schedule_id}}"><i class="trash icon"></i></button>
            </td>            
          </tr>
          @endforeach
        </tbody> 
      </table>
    </div>
  </div>

</div>

<div class="ui modal" id="form"> 
  <div class="header">
    Add Schedule
  </div>
  <div class="content"> 
  <form class="ui form" method="post">
    {{csrf_field()}}
    <input type="hidden" name="id"> 
    <div class="two fields">
      <div class="field">
        <label>Start Time:</label>  
        <div class="ui calendar starttime">
          <div class="ui input left icon">
            <i class="clock icon"></i>
            <input type="text" placeholder="Start Time" name="starttime">
          </div>
        </div>
      </div>
      <div class="field">
        <label>End Time:</label>  
        <div class="ui calendar endtime">
          <div class="ui input left icon">
            <i class="clock icon"></i>
            <input type="text" placeholder="End Time" name="endtime">
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
    <p>Delete Schedule?</p>
  </div>
  <div class="actions">
    <form method="post" action="/delSchedule">
    <input type="hidden" name="id">
    {{csrf_field()}}
    <button type="submit" class="ui positive button">Yes</button>
    <button type="reset" class="ui black deny button">No</button>
    </form>
  </div>
</div>
@endsection


@section('script')
<link rel="stylesheet" type="text/css" href="{{asset('Semantic-UI-CSS-master/calendar/dist/calendar.min.css')}}">
<script src="{{asset('Semantic-UI-CSS-master/calendar/dist/calendar.min.js')}}"></script>
<script type="text/javascript">
$(document).ready(function(){

  $('#add').click(function(){
    $('#form div.header').text('Add Schedule');
    $('#form form').trigger('reset').attr('action','/addSchedule');
    $('#form').modal('show'); 
    $('#form .starttime, #form .endtime').calendar({
      type: 'time'
    });
  });

  $('.edit').click(function(){ 
    $('#form div.header').text('Edit Schedule');
    $('#form form').trigger('reset').attr('action','/editSchedule');
    $('#example2').calendar({
      type: 'date'
    });
    $.ajax({
      url : '/getSchedule',
      type : 'get',
      data : { id : $(this).val() },
      success:function(response){  
        $('#form input[name=id]').val(response.schedule_id);
        $('#form .starttime').calendar('set date',response.starttime);
        $('#form .endtime').calendar('set date',response.endtime);
      },
      complete:function(){
        $('#form').modal('show'); 
        $('#form .starttime, #form .endtime').calendar({
          type: 'time'
        });
      }
    });
  });

  $('.del').click(function(){
    $('#del').modal('show');
    $('#del input[name=id]').val($(this).val());
  });

});
</script>
@endsection