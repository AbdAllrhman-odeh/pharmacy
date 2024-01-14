<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Settings</title>
    <style>
        .container{
           display: flex;
           justify-content: center;
            align-items: center;
            height: 80vh;
            margin: 0;
        }

        .form{
            width: 420px;
            padding: 30px;
            background-color: #fbfbfb;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            border-radius: 5px;
            margin:20px;
        }
        .form label{
            width: 100%;
            display: block;
            margin-bottom: 5px;
        }
        .form .input{
            margin-bottom:10px;
        }
        h2 {
        font-size: 1.5em;
        line-height: 1.5em;
        margin: 0;
        text-align: center;
        padding-bottom: 15px;
        }

        input:hover {
        background: #dddddd;
        }

        input[type=text],
        input[type=email],
        input[type=password] {
        width: 70%;
        padding: 8px 10px;
        height: 35px;
        border: 1px solid #cccccc;
        box-sizing: border-box;
        outline: none;
        }

        input[type=text]:focus,
        input[type=email]:focus,
        input[type=password]:focus {
        box-shadow: 0 0 2px 1px #3C91E6;
        border: 1px solid #3C91E6;;
        background: #fafafa;
        }

        input[type=submit] {
        background: #3C91E6;;
        height: 35px;
        line-height: 35px;
        width: 100%;
        border: none;
        outline: none;
        cursor: pointer;
        color: #fff;
        font-size: 1.1em;
        margin-bottom: 10px;
        }

        input[type=submit]:hover {
        background: #3C91E6;;
        }

    </style>
</head>
<body>
    @extends('layouts.masterForCashier')

    @section('content')
    <nav>
        <i class='bx bx-menu' ></i>
        <form>
        </form>
        <!-- mode -->
        <input type="checkbox" id="switch-mode" hidden>
        <label for="switch-mode" class="switch-mode"></label>
        <!-- mode -->

        <a href="#" class="profile">
            <img src="{{asset('img/admin.png')}}">
        </a>
    </nav>
    @if(session('error'))
	<script>
		Swal.fire({
		title: "Your old password is incorrect",
		icon: "warning",
		timer: 2500,
	  });
	  </script>
	@endif

    @if(session('success'))
	<script>
		Swal.fire({
		title: "Your Information updated successfully.",
		icon: "success",
		timer: 2500,
	  });
	  </script>
	@endif

    <div class="container">
        <div class="form">
            <h2 style="text-align: center; color:">Update Your Information</h2>
            <form action="{{route('updateInfo')}}" method="POST">
                @csrf
                <div class="input">
                    <label for="name">Your Name:</label>
                    <input type="text" value="{{$cashier->name}}" name="name">
                </div>
                <div class="input">
                    <label for="email">Your Email:</label>
                    <input type="email" value="{{$cashier->email}}" name="email">
                </div>
                <div class="input">
                    <label for="old_password">
                        <small style="color:red">* </small>Your Old Password:
                        <small style="color:red">*This field is required</small>
                    </label>
                    <input type="password" value="" name="old_password" required />
                </div>
                <hr>
                <br>
                <div class="input">
                    <label for="newPassword1">
                        Your New Password:
                        <small style="color:red">*If you wanna change your password, Those fields are required</small>
                    </label>
                    <input type="password"  name="newPassword">
                </div>
                <div class="input">
                    <label for="newPassword2">Re-Type Your New Password:</label>
                    <input type="password"  name="newPassword_confirmation">
                </div>
                @if($errors->any())
                <ul>
                    @foreach($errors->all() as $error)
                        <li style="color:red;">
                            {{$error}}
                        </li>
                    @endforeach
                </ul>
                @endif
                <div class="input">
                    <input type="submit" value="Update">
                </div>
            </form>
        </div>
    </div>
    
    @endsection
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.2/dist/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.2/dist/sweetalert2.min.css">
  
</body>
</html>