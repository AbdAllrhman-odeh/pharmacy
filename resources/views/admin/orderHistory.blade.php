<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Orders History</title>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<style>
		summary::marker{
			color:var(--blue);
		}
	</style>
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
				<a href="#">
					<i class='bx bxs-dashboard' ></i>
					<span class="text">Dashboard</span>
				</a>
			</li>
			<li >
				<a href="#">
					<i class='bx bxs-shopping-bag-alt' ></i>
					<span class="text">My Store</span>
				</a>
			</li>
			<li class="active">
				<a href="#">
					<i class='bx bxs-doughnut-chart' ></i>
					<span class="text">Order History</span>
				</a>
			</li>
			<li>
				<a href="#">
					<i class='bx bxs-message-dots' ></i>
					<span class="text">Message</span>
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
	@section('item3')active @endsection

	<!-- SIDEBAR -->



	<!-- CONTENT -->
	@section('content')
			<!-- NAVBAR -->
			<nav>
				<i class='bx bx-menu' ></i>
				<form action="{{route('searchMethodForOrder')}}" method="GET">
					<div class="form-input">
						<input type="search" placeholder="Search By Order Id OR Medicine Name	" name="search">
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
			@if(session('msgEmpty'))
			<script>
				Swal.fire({
				title: "No Orders With This Id",
				icon: "warning",
				timer: 2500,
			  });
			  </script>
			@endif
		
			<!-- NAVBAR -->
	
			<!-- MAIN -->
			<main>
				<div class="head-title">
					<div class="left">
						<h1>Orders History</h1>
						<ul class="breadcrumb">
							<li>
								<a href="#">{{$pharmacy->name}}</a>
							</li>
							<li><i class='bx bx-chevron-right' ></i></li>
							<li>
								<a href="">{{$pharmacy->location}}</a>
							</li>
						</ul>
					</div>
				</div>
	
	
				<div class="table-data">
					<div class="order">
						<div class="head">
							<h3>Orders history</h3>
						</div>
						<table>
							<thead>
								<tr>
									<th>Order Id</th>
									<th>Cashier Name</th>
									<th>Medicine Id</th>
									<th>Medicine Details</th>
									<th>Quantity</th>
									<th>Total</th>
								</tr>
							</thead>
							<tbody style="">
								@if(! (isset($filteredData) && count($filteredData) > 0))
								@foreach($pharmacy->orders as $order)
								{{-- @foreach ((isset($filteredData) && count($filteredData) > 0) ? $filteredData->orders : $pharmacy->orders as $order) --}}
								<tr>
									<td>
										@foreach($order->orderDetails as $orderDetails)
                                    		<b>{{$orderDetails->id}}</b>
                                    		@break
                                		@endforeach
									</td>
									<td>
										@foreach($order->orderDetails as $orderDetails)
                                    		{{$orderDetails->cashier->user->name}}
                                    		@break
                                		@endforeach
									</td>
									<td>
										@foreach($order->orderDetails as $orderDetails)
											<b>{{$orderDetails->medicine->id}}</b> <br>
										@endforeach
									</td>
									<td>
										@foreach($order->orderDetails as $orderDetails)
											{{$orderDetails->medicine->name}}
											@php
												if($orderDetails->medicine->type == 'tablet') {
													echo(' / '.$orderDetails->medicine->does.' MG');
												}
											@endphp
											
											<details>
												<summary>
													More
												</summary>
												<p>
													Exp-date:{{$orderDetails->medicine->exp_date}}
												</p>
												<p>
													MFG-date:{{$orderDetails->medicine->mfg_date}}
												</p>
											</details>
									  @endforeach
									</td>
									<td>
										@foreach($order->orderDetails as $orderDetails)
											*({{$orderDetails->quantity}})
											<br>
										@endforeach
									</td>
									<td>
										@php
											$total = 0;
										@endphp
						
										@foreach($order->orderDetails as $orderDetails)
											@php
												$total += $orderDetails->quantity * $orderDetails->medicine->price;
											@endphp
										@endforeach
						
										${{$total}}
									</td>
									{{-- <td>
										<details>
											<summary>Click to view more details</summary>
											<p>This is the additional content that will be revealed when the user clicks on the "Click to view more details" link.</p>
										</details>
									</td> --}}
								</tr>
								@endforeach
								@else
									@foreach($filteredData as $order)
									<tr>
										<td>
											<b>{{$order->id}}</b>
										</td>
										<td>
											@foreach($order->orderDetails as $orderDetails)
												{{$orderDetails->cashier->user->name}}
												@break
											@endforeach
										</td>
										<td>
											@foreach($order->orderDetails as $orderDetails)
												<b>{{$orderDetails->medicine->id}}</b>
												<br>
											@endforeach
										</td>
										<td>
											
										@foreach($order->orderDetails as $orderDetails)
											{{$orderDetails->medicine->name}}
											@php
												if($orderDetails->medicine->type == 'tablet') {
													echo(' / '.$orderDetails->medicine->does.' MG');
												}
											@endphp
											
											<details>
												<summary>
													More
												</summary>
												<p>
													Exp-date:{{$orderDetails->medicine->exp_date}}
												</p>
												<p>
													MFG-date:{{$orderDetails->medicine->mfg_date}}
												</p>
											</details>
								  		@endforeach
										</td>
										<td>
											@foreach($order->orderDetails as $orderDetails)
											*({{$orderDetails->quantity}})
											<br>
											@endforeach
										</td>
										<td>
											@php
												$total = 0;
											@endphp
							
											@foreach($order->orderDetails as $orderDetails)
												@php
													$total += $orderDetails->quantity * $orderDetails->medicine->price;
												@endphp
											@endforeach
							
											${{$total}}
											</td>
									</tr>
									@endforeach
								@endif
								
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



