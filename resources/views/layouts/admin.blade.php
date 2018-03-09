<!DOCTYPE html>
<html>
<head>
  <!-- Standard Meta -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

  <!-- Site Properties -->
  <title>Admin</title>

  <script src="{{asset('Semantic-UI-CSS-master/jquery-3.3.1.min.js')}}"></script>

  <script src="{{asset('Semantic-UI-CSS-master/jquery.dataTables.min.js')}}"></script>
  <script src="{{asset('Semantic-UI-CSS-master/semantic.min.js')}}"></script>
  <script src="{{asset('Semantic-UI-CSS-master/dataTables.semanticui.min.js')}}"></script>
  
  <link rel="stylesheet" type="text/css" href="{{asset('Semantic-UI-CSS-master/semantic.min.css')}}">
  <link rel="stylesheet" type="text/css" href="{{asset('Semantic-UI-CSS-master/dataTables.semanticui.min.css')}}">

  <style type="text/css">
  body {
    background-color: #FFFFFF;
  }
  .ui.menu .item img.logo {
    margin-right: 1.5em;
  }
  .main.container {
    margin-top: 7em;
    margin-bottom: 7em;
  }
  .wireframe {
    margin-top: 2em;
  }
  .ui.footer.segment {
    margin: 5em 0em 0em;
    padding: 5em 0em;
  }
  </style>
  @yield('style')
  @yield('script')
</head>
<body>

  <div class="ui fixed inverted menu">
    <div class="ui container">
      <a href="/Admin" class="header item"> 
        Login Tracker
      </a>
      <!-- <a href="/Admin" class="item">Home</a> -->
      <a href="/Admin/Trainee" class="item">Trainee</a>
      <a href="/Admin/Schedule" class="item">Schedule</a>
      <!-- <a href="/Admin/Reports" class="item">Reports</a> -->
      <div class="right menu">
        <!-- <a href="/Users" class="item">Admin Users</a> -->
        <a href="/logout" class="item">Logout</a>
      </div>
    </div>
  </div>

  @yield('content')


</body>
</html>
