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

</head>
<body>
  	<!-- SIDEBAR -->
	<section id="sidebar">
		<a href="#" class="brand">
			<i class='bx bxs-smile'></i>
			<span class="text">Admin</span>
		</a>
		<ul class="side-menu top">
			<li class="@yield('item1')">
				<a href="dashboard" >
					<i class='bx bxs-dashboard' ></i>
					<span class="text">Dashboard</span>
				</a>
			</li>
			<li class="@yield('item3')">
				<a href="orderHistory">
					<i class='bx bxs-doughnut-chart' ></i>
					<span class="text">Orders History</span>
				</a>
			</li>
			<li class="@yield('item4')">
				<a href="addDrug"><i class=""></i>
                    <i class="bx fa fa-plus" aria-hidden="true"></i>
					<span class="text">Medicines</span>
				</a>
			</li>
            {{-- <li class="@yield('item5')">
				<a href="healthInsurance">
                    <i class="fa-solid fa-hospital-user hi"></i>
					<span class="text">Health Insurance</span>
				</a>
			</li> --}}
			<li class="@yield('item7')">
				<a href="addCashier">
					<i class='fas fa-user-plus hi'></i>
					<span class="text">Add Cashier</span>
				</a>
			</li>
			<li class="@yield('item5')">
				<a href="alternativeMedicines">
                    <i class="bx fa fa-plus" aria-hidden="true"></i>
					<span class="text">alternative Medicines</span>
				</a>
			</li>
            <hr>
        </ul>

		<!--side menue-->
		<ul class="side-menu">
			<li class="@yield('item8')"> 
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
		@yield('content')
	</section>
</body>
</html>