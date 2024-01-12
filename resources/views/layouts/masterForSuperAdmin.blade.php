<!DOCTYPE html>
<html lang="en">
<head>
	<!--FONT AWESOME AND Boxicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <!-- My CSS -->
    <link rel="stylesheet" href="{{asset('style.css')}}">
    <!-- JS CODE :/-->
    <script src="{{asset('script.js')}}"></script>
    <title>@yield('title')</title>


</head>
<body>
  	<!-- SIDEBAR -->
	<section id="sidebar">
		<a href="#" class="brand">
			<i class='bx bxs-smile'></i>
			<span class="text">Super Admin</span>
		</a>
		<ul class="side-menu top">
			<li class="@yield('item1')">
				<a href="dashboard" >
					<i class='bx bxs-dashboard' ></i>
					<span class="text">Dashboard</span>
				</a>
			</li>
			<li class="@yield('item2')">
				<a href="addCashier">
					<i class='fas fa-user-plus hi'></i>
					<span class="text">Admins</span>
				</a>
			</li>
            <hr>
        </ul>

		<!--side menue-->
		<ul class="side-menu">
			<li class="@yield('item3')"> 
				<a href="settings">
					<i class='bx bxs-cog' ></i>
					<span class="text">Settings</span>
				</a>
			</li>
			<li>
				<a href="/" class="logout">
					<i class='bx bxs-log-out-circle' ></i>
					<span class="text">Logout</span>
				</a>
			</li>
		</ul>
    </section>
	
	<section id="content">
        <!-- NAVBAR -->
        <nav>
            <i class='bx bx-menu' ></i>
            <form action="@yield('action')" method="@yield('method')">
                @yield('form')
            </form>
            <!-- mode -->
            <input type="checkbox" id="switch-mode" hidden>
            <label for="switch-mode" class="switch-mode"></label>
            <!-- mode -->

            <a href="#" class="profile">
                <img src="{{asset('img/admin.png')}}">
            </a>
        </nav>
        <!-- NAVBAR -->
		@yield('content')
	</section>
</body>
</html>