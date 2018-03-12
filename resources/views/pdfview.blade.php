<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Trainee Info</title>
    <style type="text/css">
.clearfix:after {
  content: "";
  display: table;
  clear: both;
}

a {
  color: #5D6975;
  text-decoration: underline;
}

body {
  position: relative;
  width: 100%;  
  height: 29.7cm; 
  margin: 0 auto; 
  color: #001028;
  background: #FFFFFF; 
  font-family: Arial, sans-serif; 
  font-size: 12px; 
  font-family: Arial;
}

header {
  padding: 10px 0;
  margin-bottom: 30px;
}

#logo {
  text-align: center;
  margin-bottom: 10px;
}

#logo img {
  width: 90px;
}

h1 {
  border-top: 1px solid  #5D6975;
  border-bottom: 1px solid  #5D6975;
  color: #5D6975;
  font-size: 2.4em;
  line-height: 1.4em;
  font-weight: normal;
  text-align: center;
  margin: 0 0 20px 0;
  background: url(dimension.png);
}

#project {
  float: left;
  margin-left: 30px;
}

#project span {
  color: #5D6975;
  text-align: right;
  width: 60px;
  margin-right: 10px;
  display: inline-block;
  font-size: 1em;
}

#company {
  float: right;
  text-align: right;
}

#project div,
#company div {
  white-space: nowrap;     
  margin-bottom: 2px;   
}

table {
  width: 100%;
  border-collapse: collapse;
  border-spacing: 0;
  margin-bottom: 20px;
}

table tr:nth-child(2n-1) td {
  background: #F5F5F5;
}

table th,
table td {
  text-align: center;
}

table th {
  padding: 5px 20px;
  color: #5D6975;
  border-bottom: 1px solid #C1CED9;
  white-space: nowrap;        
  font-weight: normal;
}

table .service,
table .desc {
  text-align: left;
}

table td {
  padding: 5px;
  /*text-align: right;*/
}

table td.service,
table td.desc {
  vertical-align: top;
}

table td.unit,
table td.qty,
table td.total {
  font-size: 1.2em;
}

table td.grand {
  border-top: 1px solid #5D6975; 
}

#notices {
	margin-top: 50px;
	width: 30%; 
}

#notices .notice {
  /*color: #5D6975;*/
  font-size: 1.2em;
  border-top: 1px solid;
  text-align: center;
  margin-top: 50px;
}

footer {
  color: #5D6975;
  width: 100%;
  height: 30px;
  position: fixed;
  bottom: 0;
  border-top: 1px solid #C1CED9;
  padding: 8px 0;
  text-align: center;
} 
    </style>
  </head>
  <body>
    <header class="clearfix">
    <!--   <div id="logo">
        <img src="logo.png">
      </div> -->
      <h1>Trainee Info</h1> 
      <div id="project">
        <div><span>Name: </span> {{$info->fname.' '.$info->mname.' '.$info->lname}}</div>
        <div><span>Position: </span> IT-OJT (Regional)</div>
        <div><span>Shift Schedule: </span> {{date_create($info->schedule->starttime)->format('h:i a').' - '.date_create($info->schedule->endtime)->format('h:i a')}}</div>
        <div><span>School: </span> {{$info->school}}</div>
        <div><span>Hours to Render: </span> {{$info->render_hrs}} hrs</div>
        <div><span>Start Date: </span> {{date_create($info->start_date)->format('M d, Y')}}</div>
      </div>
    </header>
    <main>
      <table>
        <thead>
          <tr>
            <th>DATE</th>
            <th>TIME IN</th>
            <th>TIME OUT</th>
            <th>HOURS RENDERED</th>
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
			<td>
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
		</tr>
		@endforeach
          <tr>
            <td colspan="3" class="grand total" style="text-align: right;">TOTAL HOURS RENDERED:</td>
            <td class="grand total">{{Helper::format_total($total)}}</td>
          </tr>
        </tbody>
      </table>
      <div id="notices">
        <div style="font-weight: bold; font-size: 15px;">Checked By:</div>
        <div class="notice">Signature over printed name</div>
      </div>
    </main>
    <footer>
      Transcom Worldwide - 67 EDSA Mandaluyong 1555, Manila, Philippines
    </footer>
  </body>
</html>