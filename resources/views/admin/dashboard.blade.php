<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>Admin</title>
</head>
<body>
	{{-- {{
		[1]info=>["id","user_id","pharmacy_id","created_at","updated_at"]
				=>[user]=>[id,name,email,password,role,created_at,updated_at]
				=>[pharmacy]=>[id,name,location,number,created_at,updated_at]
				=>[order]=>[array]=>[id,cashier_id,pharamcy_id,created_at,updated_at]
		
			[2]orders=>[array,order]=>[id,cashier_id,pharmacy_id,created_at,updated_at]
									=>[array,orderDetails]=>[id,order_id,medicine_id,quantity,created_at,updated_at]	
												      	  =>[medicine]=>[id,name,chemical_Name,does,type,qunatity,price,exp_date,mfg_date,pharamcy_id,compnay_name,created_at,updated_at]
	)}} --}}
	
	<!-- SIDEBAR -->
	@extends('layouts\master')
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
			<img src="{{asset('img/admin.png')}}">
		</a>
	</nav>
	<!-- NAVBAR -->

	<!-- MAIN -->
	<main>
		<div class="head-title">
			<div class="left">
				<h1>{{$info->pharmacy->name}}</h1>
				<ul class="breadcrumb">
					<li>
						<a href="#">{{$info->user->name}}</a>
					</li>
					<li><i class='bx bx-chevron-right' ></i></li>
					<li>
						<a class="active" href="#">{{$info->user->role}}</a>
					</li>
				</ul>
			</div>
		</div>

		<ul class="box-info">
			<li>
				<i class='bx bxs-calendar-check' ></i>
				<span class="text">
					<!--get the numbers of orders on this day-->
					@php
						$count=0;	
					@endphp
					@foreach ($info->order as $order)
						@php
						$todayDate=date('Y-M-d');
						if($todayDate == $order->created_at->format('Y-M-d') )
							$count++;
						@endphp
					@endforeach
					<h3>{{$count}}</h3>
					<p>Orders Today</p>
				</span>
			</li>
			<li>
				<i class='bx bxs-dollar-circle' ></i>
				<span class="text">
				<!-- Handle the total of this day-->
				@php
				$total = 0;
				@endphp
				@foreach($orders as $order)
					@php
					if($todayDate==$order->created_at->format('Y-M-d'))
					{
					@endphp
						@foreach($order->orderDetails as $orderDetail)
							@php
								$total += $orderDetail->medicine->price*$orderDetail->quantity;
							@endphp
						@endforeach
					@php
					}
					@endphp
				@endforeach
			
					<h3>${{$total}}</h3>
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


				<!--print all orders for this pharmacy-->
				<table>
					<thead>
						<tr>
							<th>Cashier</th>
							<th>Medicine Name</th>
							<th>Price</th>
							<th>Quantity</th>
							<th>Date & Time</th>
						</tr>
					</thead>
					<tbody>
						@foreach($orders as $order)
							<tr>
								<td>
									<p>
										{{ $order->cashier_id }}
									</p>
								</td>
								<td>
									@foreach($order->orderDetails as $orderDetail)
										<p>
											 {{ $orderDetail->medicine->name }}
										</p>
									@endforeach
								</td>
								<td>
									@foreach($order->orderDetails as $orderDetail)
										<p>
											 {{ $orderDetail->medicine->price }}$
										</p>
									@endforeach
								</td>
								<td>
									@foreach($order->orderDetails as $orderDetail)
										<p>
											*{{ $orderDetail->quantity }}
										</p>
									@endforeach
								</td>
								<td>
									{{ $order->created_at->format('Y-m-d'); }}<br>
									{{ $order->created_at->format('h-i-s'); }}<br>
								</td>
							</tr>
							@if($loop->last)
								<tr>
									<td colspan="5"><hr></td>
								</tr>
							@endif
						@endforeach
					</tbody>
				</table>


			</div>
		</div>
	</main>
	<!-- MAIN -->
	@endsection
	<!-- CONTENT -->
	

</body>
</html>



