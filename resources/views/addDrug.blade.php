<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Admin</title>
</head>
<body>
	<!-- SIDEBAR -->
	{{-- <section id="sidebar">
		<a href="#" class="brand">
			<i class='bx bxs-smile'></i>
			<span class="text">Admin</span>
		</a>
		<ul class="side-menu top">
			<li>
				<a href="dashboard">
					<i class='bx bxs-dashboard' ></i>
					<span class="text">Dashboard</span>
				</a>
			</li>
			<li >
				<a href="myStore">
					<i class='bx bxs-shopping-bag-alt' ></i>
					<span class="text">My Store</span>
				</a>
			</li>
			<li>
				<a href="orderHistory">
					<i class='bx bxs-doughnut-chart' ></i>
					<span class="text">Order History</span>
				</a>
			</li>
			<li class="active">
				<a href="addDrug">
                    <i class="bx fa fa-plus" aria-hidden="true"></i>
					<span class="text">Add Medicines</span>
				</a>
			</li>
            <li>
				<a href="healthInsurance">
                    <i class="fa-solid fa-hospital-user hi"></i>
					<span class="text">Health Insurance</span>
				</a>
			</li>
            <li>
				<a href="#">
                    <i class="fa fa-exchange hi" aria-hidden="true"></i>
					<span class="text">Edit Alternative Medicines</span>
				</a>
			</li>
            <hr>
            <li>
				<a href="#">
					<i class='bx bxs-group'></i>
					<span class="text">user1</span>
				</a>
			</li>
            <li>
				<a href="#">
					<i class='bx bxs-group'></i>
					<span class="text">user2</span>
				</a>
			</li>
        </ul>

		<ul class="side-menu">
			<li>
				<a href="/profile">
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
	</section> --}}
    @extends('layouts.master')
	@section('item4')active @endsection
	<!-- SIDEBAR -->



	<!-- CONTENT -->
	@section('content')
				<!-- NAVBAR -->
				<nav>
					<i class='bx bx-menu' ></i>
					<a href="#" class="nav-link">Categories</a>
					<form action="#">
						<div class="form-input">
							<input type="search" placeholder="Search...">
							<button type="submit" class="search-btn"><i class='bx bx-search' ></i></button>
						</div>
					</form>
					<!-- mode -->
					<input type="checkbox" id="switch-mode" hidden>
					<label for="switch-mode" class="switch-mode"></label>
					<!-- mode -->
		
					<a href="#" class="profile">
						<img src="img/admin.png">
					</a>
				</nav>
				<!-- NAVBAR -->
		
				<!-- MAIN -->
				<main>
					<div class="head-title">
						<div class="left">
							<h1>Order History</h1>
							<ul class="breadcrumb">
								<li>
									<a href="#">System</a>
								</li>
								<li><i class='bx bx-chevron-right' ></i></li>
								<li>
									<a class="active" href="#">Name</a>
								</li>
							</ul>
						</div>
					</div>
		
		
					<div class="table-data">
						<div class="order">
							<div class="head">
								<h3>Orders history</h3>
								<i class='bx bx-search' ></i>
								<i class='bx bx-filter' ></i>
							</div>
							<table>
								<thead>
									<tr>
										<th>User</th>
										<th>Date Order</th>
										<th>Status</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>
											<p>John Doe</p>
										</td>
										<td>01-10-2021</td>
										<td><span class="status completed">Completed</span></td>
									</tr>
									<tr>
										<td>
											<p>John Doe</p>
										</td>
										<td>01-10-2021</td>
										<td><span class="status completed">Completed</span></td>
									</tr>
									<tr>
										<td>
											<p>John Doe</p>
										</td>
										<td>01-10-2021</td>
										<td><span class="status completed">Completed</span></td>
									</tr>
									<tr>
										<td>
											<p>John Doe</p>
										</td>
										<td>01-10-2021</td>
										<td><span class="status completed">Completed</span></td>
									</tr>
									<tr>
										<td>
											<p>John Doe</p>
										</td>
										<td>01-10-2021</td>
										<td><span class="status completed">Completed</span></td>
									</tr>
									<tr>
										<td>
											<p>John Doe</p>
										</td>
										<td>01-10-2021</td>
										<td><span class="status completed">Completed</span></td>
									</tr>
									<tr>
										<td>
											<p>John Doe</p>
										</td>
										<td>01-10-2021</td>
										<td><span class="status completed">Completed</span></td>
									</tr>
									<tr>
										<td>
											<p>John Doe</p>
										</td>
										<td>01-10-2021</td>
										<td><span class="status completed">Completed</span></td>
									</tr>
									<tr>
										<td>
											<p>John Doe</p>
										</td>
										<td>01-10-2021</td>
										<td><span class="status completed">Completed</span></td>
									</tr>
									<tr>
										<td>
											<p>John Doe</p>
										</td>
										<td>01-10-2021</td>
										<td><span class="status completed">Completed</span></td>
									</tr>
									<tr>
										<td>
											<p>John Doe</p>
										</td>
										<td>01-10-2021</td>
										<td><span class="status completed">Completed</span></td>
									</tr>
									<tr>
										<td>
											<p>John Doe</p>
										</td>
										<td>01-10-2021</td>
										<td><span class="status completed">Completed</span></td>
									</tr>
									<tr>
										<td>
											<p>John Doe</p>
										</td>
										<td>01-10-2021</td>
										<td><span class="status completed">Completed</span></td>
									</tr>
									<tr>
										<td>
											<p>John Doe</p>
										</td>
										<td>01-10-2021</td>
										<td><span class="status completed">Completed</span></td>
									</tr>
									<tr>
										<td>
											<p>John Doe</p>
										</td>
										<td>01-10-2021</td>
										<td><span class="status completed">Completed</span></td>
									</tr>
									<tr>
										<td>
											<p>John Doe</p>
										</td>
										<td>01-10-2021</td>
										<td><span class="status pending">Pending</span></td>
									</tr>
									<tr>
										<td>
											<p>hello Doe</p>
										</td>
										<td>01-10-2021</td>
										<td><span class="status process">Process</span></td>
									</tr>
									<tr>
										<td>
											<p>John Doe</p>
										</td>
										<td>01-10-2021</td>
										<td><span class="status pending">Pending</span></td>
									</tr>
									<tr>
										<td>
											<p>John Doe</p>
										</td>
										<td>01-10-2021</td>
										<td><span class="status completed">Completed</span></td>
									</tr>
								</tbody>
							</table>
							<table>
								<thead>
									<tr>
										<th>User</th>
										<th>Date Order</th>
										<th>Status</th>
									</tr>
								</thead>
						</div>
					</div>
				</main>
				<!-- MAIN -->		
	@endsection

</body>
</html>



