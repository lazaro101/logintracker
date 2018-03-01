<!DOCTYPE html>
<html>
<head> 
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
 
  <title>Admin Login</title>

  <script src="{{asset('Semantic-UI-CSS-master/jquery-3.3.1.min.js')}}"></script>
  <link rel="stylesheet" type="text/css" href="{{asset('Semantic-UI-CSS-master/semantic.min.css')}}">
  <script src="{{asset('Semantic-UI-CSS-master/semantic.min.js')}}"></script>

  <style type="text/css">
    body {
      background-color: #DADADA;
    }
    body > .grid {
      height: 100%;
    }
    .image {
      margin-top: -100px;
    }
    .column {
      max-width: 450px;
    }
  </style>
  <script>
  // $(document)
  //   .ready(function() {
  //     $('.ui.form')
  //       .form({
  //         fields: {
  //           email: {
  //             identifier  : 'email',
  //             rules: [
  //               {
  //                 type   : 'empty',
  //                 prompt : 'Please enter your e-mail'
  //               },
  //               {
  //                 type   : 'email',
  //                 prompt : 'Please enter a valid e-mail'
  //               }
  //             ]
  //           },
  //           password: {
  //             identifier  : 'password',
  //             rules: [
  //               {
  //                 type   : 'empty',
  //                 prompt : 'Please enter your password'
  //               },
  //               {
  //                 type   : 'length[6]',
  //                 prompt : 'Your password must be at least 6 characters'
  //               }
  //             ]
  //           }
  //         }
  //       })
  //     ;
  //   })
  // ;
  </script>
</head>
<body>

<div class="ui middle aligned center aligned grid">
  <div class="column">
    <h2 class="ui icon header">
      <i class="user secret icon"></i>
      <div class="content">
        Log-in as Admin
      </div>
    </h2>
    <form method="post" action="/doLoginAdmin" class="ui form">
    {{csrf_field()}}
      <div class="ui stacked segment">
        <div class="field">
          <div class="ui left icon input">
            <i class="user icon"></i>
            <input type="text" name="username" placeholder="username" tabindex="1">
          </div>
        </div>
        <div class="field">
          <div class="ui left icon input">
            <i class="lock icon"></i>
            <input type="password" name="password" placeholder="Password" tabindex="2">
          </div>
        </div>
        <button type="submit" class="ui fluid large teal submit button" value="logout" name="submit">Login</button>
      </div>

    </form>
  </div>
</div>


</body>

</html>
