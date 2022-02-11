<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>User Dashboard | Home</title>
   <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('dashboard/dist/css/adminlte.min.css')}}">

</head>
<body>

    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3" style="margin-top: 45px">
                <h4 class="offset-md-3">User Dash board</h4><hr>
                <table class="table table-striped table-inverse table-responsive offset-md-3">
                    <thead class="thead-inverse">
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td >{{Auth::user()->name}}</td>
                                <td>{{Auth::user()->email}}</td>
                                <td><a href="{{route('logout')}}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">LogOut</a>
                                    <form id="logout-form" method="POST" action="{{route('user.logout')}}" class="d-none">@csrf</form>
                                </td>
                            </tr>

                        </tbody>
                </table>

            </div>
        </div>
    </div>

</body>
</html>
