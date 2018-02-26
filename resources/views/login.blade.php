<!DOCTYPE html>
<html>
<head> 
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
 
  <title>Login</title>

  <script src="Semantic-UI-CSS-master/jquery-3.3.1.min.js"></script>
  <link rel="stylesheet" type="text/css" href="Semantic-UI-CSS-master/semantic.min.css">
  <script src="Semantic-UI-CSS-master/semantic.min.js"></script>

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
  <div class="eight wide column">
    <form method="post" action="/doLogin">
      {{csrf_field()}}
      <div class="ui stacked segment form">
        <div class="field">
          <div class="ui left icon input">
            <i class="user icon"></i>
            <input type="text" name="username" placeholder="username">
          </div>
        </div>
        <button type="submit" class="ui fluid large teal submit button" value="login" name="submit">Login</button>
      </div> 
    </div>
    <div class="eight wide column">
      <div class="ui stacked segment form">
        <div class="field">
          <div class="ui left icon input">
            <i class="lock icon"></i>
            <input type="password" name="password" placeholder="Password">
          </div>
        </div>
        <button type="submit" class="ui fluid large teal submit button" value="logout" name="submit">Logout</button>
      </div>

    </form>
  </div>
</div>

</body>

</html>
