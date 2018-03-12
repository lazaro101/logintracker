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
<<<<<<< HEAD
      $('.ui.form')
        .form({
          inline: false,
=======
      
      $('.ui.form')
        .form({
          inline: true,
>>>>>>> 22051e6b020d152546c743cb1fe437358bd03346
          fields: {
            username: {
              identifier  : 'username',
              rules: [
                {
                  type   : 'empty',
                  prompt : 'Please enter your Username'
                },
<<<<<<< HEAD
                {
                  type   : 'maxLength[6]',
                  prompt : 'Please enter a valid length'
                }
=======
                // {
                //   type   : 'maxLength[6]',
                //   prompt : 'Please enter a valid length'
                // }
>>>>>>> 22051e6b020d152546c743cb1fe437358bd03346
              ]
            },
            password: {
              identifier  : 'password',
              rules: [
                {
                  type   : 'empty',
                  prompt : 'Please enter your password'
                },
<<<<<<< HEAD
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
=======
                // {
                //   type   : 'length[6]',
                //   prompt : 'Your password must be at least 6 characters'
                // }
              ]
            }
          }
        });
       
        $('h2').dblclick(function(event){
          if(event.ctrlKey) {
            if (event.altKey) { 
                location.href = '/AdminLogin'; 
            }
          }
      });
    });
>>>>>>> 22051e6b020d152546c743cb1fe437358bd03346
  </script>
</head>
<body>

<div class="ui middle aligned center aligned grid">
  <div class="column">
    <h2 class="ui icon header">
      <i class="user icon"></i>
      <div class="content">
        Log-in as Trainee
      </div>
    </h2>
    <form method="post" action="/doLogin" class="ui form">
    {{csrf_field()}}
      <div class="ui stacked segment">
        <div class="field">
          <div class="ui left icon input">
            <i class="user icon"></i>
            <input type="text" name="username" placeholder="Username" tabindex="1">
          </div>
        </div>
        <div class="field">
          <div class="ui left icon input">
            <i class="lock icon"></i>
            <input type="password" name="password" placeholder="Password" tabindex="2">
          </div>
        </div>
        <div class="ui fluid buttons">
          <button type="submit" class="ui large inverted green submit button" value="login" name="submit">Login</button> 
          <button type="submit" class="ui large inverted red submit button" value="logout" name="submit">Logout</button>
        </div>
      </div>
      <div class="ui error message" style="position: fixed; width: 50%; height: 150px; left: 50%; top:400px; margin: 0 0 0 -25%; z-index: -1"></div>
    </form>
  </div>
</div>

@if(Session::has('message'))
<<<<<<< HEAD
<div style="position: fixed; width: 50%; height: 300px; left: 50%; top:100px; margin: 0 0 0 -25%; z-index: -1">
  <div class="ui success message login">
    <i class="close icon"></i>
=======
<div style="position: fixed; width: 50%; height: 300px; left: 50%; top:50px; margin: 0 0 0 -25%; z-index: -1">
  <div class="ui {{ Session::get('type') }} message login">
    <!-- <i class="close icon"></i> --> 
>>>>>>> 22051e6b020d152546c743cb1fe437358bd03346
    <div class="header">
    {{ Session::get('message') }}
    </div> 
  </div>
<<<<<<< HEAD
</div>
@endif


=======
>>>>>>> 22051e6b020d152546c743cb1fe437358bd03346
</div>
@endif
 

</body>

</html>
