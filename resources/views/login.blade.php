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
  $(document)
    .ready(function() { 
      setTimeout(function(){ $('.ui.login.message').transition('fade'); }, 5000);
      $('.ui.form')
        .form({
          inline: false,
          fields: {
            username: {
              identifier  : 'username',
              rules: [
                {
                  type   : 'empty',
                  prompt : 'Please enter your Username'
                },
                {
                  type   : 'maxLength[6]',
                  prompt : 'Please enter a valid length'
                }
              ]
            },
            password: {
              identifier  : 'password',
              rules: [
                {
                  type   : 'empty',
                  prompt : 'Please enter your password'
                },
                {
                  type   : 'length[6]',
                  prompt : 'Your password must be at least 6 characters'
                }
              ]
            }
          }
        })
      ;
    })
  ;
  </script>
</head>
<body>

<div class="ui middle aligned center aligned grid">
  <div class="row ui form">
    <div class="eight wide column">
    <form method="post" action="/doLogin">
      <div class="ui stacked segment">
        <div class="field">
          <div class="ui left icon input">
            <i class="user icon"></i>
            <input type="text" name="username" placeholder="Username" tabindex="1">
          </div>
        </div>
        <button type="submit" class="ui fluid large teal submit button" value="login" name="submit">Login</button>
      </div>
    </div>
      {{csrf_field()}}
    <div class="eight wide column">
      <div class="ui stacked segment">
        <div class="field">
          <div class="ui left icon input">
            <i class="lock icon"></i>
            <input type="password" name="password" placeholder="Password" tabindex="2">
          </div>
        </div>
        <button type="submit" class="ui fluid large teal submit button" value="logout" name="submit">Logout</button>
      </div>
      <div class="ui error message" style="position: fixed; width: 50%; height: 150px; left: 50%; top:400px; margin: 0 0 0 -25%; z-index: -1"></div>
    </form>
    </div>
  </div>

@if(Session::has('message'))
<div style="position: fixed; width: 50%; height: 300px; left: 50%; top:100px; margin: 0 0 0 -25%; z-index: -1">
  <div class="ui success message login">
    <i class="close icon"></i>
    <div class="header">
    {{ Session::get('message') }}
    </div> 
  </div>
</div>
@endif


</div>

</body>

</html>
