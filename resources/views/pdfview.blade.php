<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Trainee Info</title>

<style type="text/css">
    * {
        font-family: Verdana, Arial, sans-serif;
    }
    table{
        font-size: x-small;
    }
    tfoot tr td{
        font-weight: bold;
        font-size: x-small;
    }
    .gray {
        background-color: lightgray
    }
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
</head>
<body>
 
  <table width="100%">
    <thead style="background-color: lightgray;">
      <tr> 
        <th>Date</th>
        <th>Time in</th>
        <th>Time out</th>
        <th>Hours rendered</th>
      </tr>
    </thead>
    <tbody>
	@php 
		$total = '00:00:00';
	@endphp
	@foreach($logs as $log)
	<tr>
		<td>{{date_create($log->dtime_in)->format('M d, Y')}}</td>
		<td>{{date_create($log->dtime_in)->format('h:i a')}}</td>
		<td>{{date_create($log->dtime_out)->format('h:i a')}}</td>
		@php
			$dteStart = new DateTime($log->dtime_in); 
			$dteEnd   = new DateTime($log->dtime_out);
			$dteDiff  = $dteStart->diff($dteEnd);
			$time = strtotime($dteDiff->format("%H:%I")) - 3600;  
			$total = Helper::sum_the_time($total, date("H:i:s", $time));
		@endphp
		<td>{{date("H \h i \m", $time)}}</td>
	</tr>
	@endforeach
    </tbody>
    <tfoot>
		<tr>
			<th colspan="3" align="right">Total No. of Hours Rendered:</th>
			<th>{{Helper::format_total($total)}}</th>
		</tr>
    </tfoot>
  </table>

</body>
</html>