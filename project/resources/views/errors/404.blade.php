<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Error</title>

    <!-- Bootstrap -->
    <link href="{{asset('vendor/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{asset('vendor/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
    <!-- iCheck -->
    <link href="{{asset('css/custom.css')}}" rel="stylesheet">
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <!-- page content -->
        <div class="col-md-12">
          <div class="col-middle">
            <div class="text-center text-center">
              <h1 class="error-number">404</h1>
              <h2>指定されたURLのページは存在しません。</h2>
              <div class="mid_center">
                <a href="{{url('/')}}" class="btn btn-success btn-lg">ホームページへ</a>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->
      </div>
    </div>
    </body>
</html>
