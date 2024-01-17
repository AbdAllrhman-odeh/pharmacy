<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>Admin</title>
</head>
<body>
    <!--
        get the admin info
    -->
    <?php
        $adminName="";
        $adminRole="";
        foreach($pharmacy->admins as $admin)
        {
            $adminName=$admin->user->name;
            $adminRole=$admin->user->role;
        }
    ?>
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
				<h1>{{$pharmacy->name}}</h1>
				<ul class="breadcrumb">
					<li>
						<a href="#">{{$adminName}}</a>
					</li>
					<li><i class='bx bx-chevron-right' ></i></li>
					<li>
						<a class="active" href="#">{{$adminRole}}</a>
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
					@foreach ($pharmacy->orders as $order)
						@php
						$todayDate=date('Y-M-d');
						if($todayDate == $order->created_at->format('Y-M-d') )
                        {
                            $count++;
                        }
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
				@foreach($pharmacy->orders as $order)
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

		</ul>

		<div class="table-data">
			<div class="order">
				<div class="head">
					<h3>Recent Orders</h3>
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
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pharmacy->orders->take(5) as $order)
                        <tr>
                            <td>
                                @foreach($order->orderDetails as $orderDetails)
                                    {{$orderDetails->cashier->user->name}}
                                    @break
                                @endforeach
                            </td>
                            <td>
                                @foreach($order->orderDetails as $orderDetails)
                                    {{$orderDetails->medicine->name}}
                                    <br>
                                @endforeach
                            </td>
                            <td>
                                @foreach($order->orderDetails as $orderDetails)
                                    {{$orderDetails->medicine->price}}
                                    <br>
                                @endforeach
                            </td>
                            <td>
                                @foreach($order->orderDetails as $orderDetails)
                                    *({{$orderDetails->quantity}})
                                    <br>
                                @endforeach
                            </td>
                            <td>
                                @foreach($order->orderDetails as $orderDetails)
                                    {{$orderDetails->created_at}}
                                    @break
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



