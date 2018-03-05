@extends('layouts.admin')

@section('content')
<div class="ui main container">

  <div class="row">
    <div class="column">
      <h2 class="ui header">Trainee</h2>
      <button class="ui labeled icon green button" type="button" id='add'>
        <i class="add icon"></i>
        ADD
      </button>
      <table class="ui celled table">
        <thead>
          <tr><th class="six wide">Name</th>
          <th class="six wide">School</th>
          <th class="four wide">Actions</th>
        </tr></thead>
        <tbody>
          @foreach($ojts as $ojt)
          <tr>
            <td>{{$ojt->fname.' '.$ojt->mname.' '.$ojt->lname}}</td>
            <td>{{$ojt->school}}</td>
            <td class="center aligned">
              <a class="ui blue green icon button" href="/Admin/Trainee/{{$ojt->ojt_profile_id}}"><i class="file icon"></i></a>
              <button class="ui blue icon button edit" value="{{$ojt->ojt_profile_id}}"><i class="pencil icon"></i></button>
              <button class="ui red icon button del" value="{{$ojt->ojt_profile_id}}"><i class="trash icon"></i></button>
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
    Add Trainee
  </div>
  <div class="content">
  <h4 class="ui dividing header">Trainee Information</h4>
  <form class="ui form" method="post">
    {{csrf_field()}}
    <input type="hidden" name="id">
    <div class="field">
      <label>Name</label>
      <div class="three fields">
        <div class="field">
          <input type="text" name="fname" placeholder="First Name">
        </div>
        <div class="field">
          <input type="text" name="mname" placeholder="Middle Name">
        </div>
        <div class="field">
          <input type="text" name="lname" placeholder="Last Name">
        </div>
      </div>
    </div>
    <div class="field">
      <label>School</label>
      <input type="text" name="school">
    </div>
    <div class="three fields">
      <div class="field">
        <label>Start Date</label>  
        <div class="ui calendar" id="example2">
          <div class="ui input left icon">
            <i class="calendar icon"></i>
            <input type="text" placeholder="Date" name="startdate">
          </div>
        </div>
      </div>
      <div class="field">
        <label>Schedule</label>
        <select class="ui dropdown" name="schedule" id="schedule">
          <option value="">Schedule</option>
          @foreach($scheds as $sched)
          <option value="{{$sched->schedule_id}}">{{date_create($sched->starttime)->format('h:i a').' - '.date_create($sched->endtime)->format('h:i a')}}</option>
          @endforeach
        </select>
      </div>
      <div class="field">
        <label>Hours to Render</label>
        <input type="text" name="hrs">
      </div>
    </div>
    <div class="login">
    <h4 class="ui dividing header">Login</h4>
    <div class="two fields">
      <div class="field">
        <label>Username</label>
        <input placeholder="Username" type="text" name="username">
      </div>
      <div class="field">
        <label>Password</label>
        <input placeholder="Password" type="password" name="password">
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
    <p>Delete Trainee Info?</p>
  </div>
  <div class="actions">
    <form method="post" action="/delTrainee">
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

  $('#schedule').dropdown();

  $('#add').click(function(){
    $('#form div.header').text('Add Trainee');
    $('#form form').trigger('reset').attr('action','/addTrainee');
    $('#form').modal('show');
    $('#form .login').transition('show');
    $('#example2').calendar({
      type: 'date'
    });
    $('#schedule').dropdown('clear');
    $('#form form').form('reset');
  });

  $('.edit').click(function(){ 
    $('#form div.header').text('Edit Trainee');
    $('#form form').trigger('reset').attr('action','/editTrainee');
    $('#form form').form('remove fields', ['username', 'password']);
    $('#example2').calendar({
      type: 'date'
    });
    $('#form form').form('reset');
    $.ajax({
      url : '/getTrainee',
      type : 'get',
      data : { id : $(this).val() },
      success:function(response){ 
        $('#form form input[name=id]').val(response.ojt_profile_id);
        $('#form form input[name=fname]').val(response.fname);
        $('#form form input[name=mname]').val(response.mname);
        $('#form form input[name=lname]').val(response.lname);
        $('#form form input[name=school]').val(response.school);
        $('#form form input[name=hrs]').val(response.render_hrs);
        $('#schedule').dropdown('set selected',response.schedule_id);
        $('#form #example2').calendar('set date',response.start_date);
      },
      complete:function(){
        $('#form').modal('show');
        $('#form .login').transition('hide');
      }
    });
  });

  $('.del').click(function(){
    $('#del').modal('show');
    $('#del input[name=id]').val($(this).val());
  });

  $('#form .positive.button').click(function(){
    $('body').addClass('scrolling');
    if ($('#form form').form('is valid') == false) {
      $('#form form').form('validate form');
      return false;
    }
    return true;
  });

  $.fn.form.settings.rules.checkUsername = function(value) { //-----------duplicate -------------//
    var res = true;
    $.ajax
    ({
      async : false,
      url: '/checkUsername',
      type : "get",
      data : {"value" : value},
      dataType: "json",
      success: function(data) {
          if (data.length > 0) {
            res = false;
          } else {
            res = true;
          }
      }
    });
    return res;
  };

  $('.ui.form')
    .form({
      inline: true,
      fields: {  
        fname: {
          identifier: 'fname',
          rules: [
          {
            type   : 'empty',
            prompt : 'Cannot be Empty.'
          },
          {
            type   : 'maxLength[25]',
            // prompt : 'Cannot be Empty.'
          },
          ]
        },
        mname: {
          identifier: 'mname',
          rules: [
          {
            type   : 'empty',
            prompt : 'Cannot be Empty.'
          },
          {
            type   : 'maxLength[25]',
            // prompt : 'Cannot be Empty.'
          },
          ]
        },
        lname: {
          identifier: 'lname',
          rules: [
          {
            type   : 'empty',
            prompt : 'Cannot be Empty.'
          },
          {
            type   : 'maxLength[25]',
            // prompt : 'Cannot be Empty.'
          },
          ]
        },
        school: {
          identifier: 'school',
          rules: [
          {
            type   : 'empty',
            prompt : 'Cannot be Empty.'
          },
          {
            type   : 'maxLength[155]',
            // prompt : 'Cannot be Empty.'
          },
          ]
        },
        hrs: {
          identifier: 'hrs',
          rules: [
          {
            type   : 'empty',
            prompt : 'Cannot be Empty.'
          },
          {
            type   : 'integer[1..1000]',
            prompt : 'Invalid value.'
          }, 
          ]
        },
        startdate: {
          identifier: 'startdate',
          rules: [
          {
            type   : 'empty',
            prompt : 'Cannot be Empty.'
          }, 
          ]
        },
        schedule: {
          identifier: 'schedule',
          rules: [
          {
            type   : 'empty',
            prompt : 'Cannot be Empty.'
          }, 
          ]
        },
        username: {
          identifier: 'username',
          rules: [
          {
            type   : 'empty',
            prompt : 'Cannot be Empty.'
          }, 
          {
            type   : 'length[8]',
            // prompt : 'Cannot be Empty.'
          },
          {
            type   : 'maxLength[15]',
            // prompt : 'Cannot be Empty.'
          },  
          {
            type   : 'checkUsername',
            prompt : 'Username already taken.'
          }
          ]
        },
        password: {
          identifier: 'password',
          rules: [
          {
            type   : 'empty',
            prompt : 'Cannot be Empty.'
          }, 
          {
            type   : 'length[8]',
            // prompt : 'Cannot be Empty.'
          }, 
          ]
        },
      }
    });

});
</script>
@endsection