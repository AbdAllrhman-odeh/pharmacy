<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>Admin</title>
</head>
<body>

	<!-- SIDEBAR -->
	@extends('layouts.master')
	@section('item1')active @endsection
	<!-- SIDEBAR -->



	<!-- CONTENT -->
	{{-- <section id="content">
	</section> --}}
	@section('content')
	<!-- NAVBAR -->
	<nav>
		<i class='bx bx-menu' ></i>
		<a href="#" class="nav-link">Categories </a>
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
				<h1>Dashboard</h1>
				<ul class="breadcrumb">
					<li>
						<a href="#">Dashboard</a>
					</li>
					<li><i class='bx bx-chevron-right' ></i></li>
					<li>
						<a class="active" href="#">Home</a>
					</li>
				</ul>
			</div>
		</div>

		<ul class="box-info">
			<li>
				<i class='bx bxs-calendar-check' ></i>
				<span class="text">
					<h3>1020</h3>
					<p>Orders Today</p>
				</span>
			</li>
			<li>
				<i class='bx bxs-dollar-circle' ></i>
				<span class="text">
					<h3>$2543</h3>
					<p>Total Sales</p>
				</span>
			</li>
			<li>
				<i class='bx bxs-group' ></i>
				<span class="text">
					<h3>name</h3>
					<p>Will be out of stock</p>
				</span>
				<span class="text">
					<h3>name</h3>
					<p>Will be out of stock</p>
				</span>
				
			</li>
		</ul>


		<div class="table-data">
			<div class="order">
				<div class="head">
					<h3>Recent Orders</h3>
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
			</div>
		</div>
	</main>
	<!-- MAIN -->
	@endsection
	<!-- CONTENT -->
	

	<script src="script.js"></script>
</body>
</html>



