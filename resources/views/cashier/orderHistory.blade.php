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

	@extends('layouts.masterForCashier')
	@section('item3')active @endsection

	<!-- SIDEBAR -->



	<!-- CONTENT -->
	@section('content')
    <!-- NAVBAR -->
	<nav>
		<i class='bx bx-menu' ></i>
		<form>
			<div class="form-input">
                <input type="search" placeholder="Search By Order Id OR Date" id="search" name="search" onfocus="this.value='' ">
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
            
			{{-- @if(session('msgEmpty'))
			<script>
				Swal.fire({
				title: "No Orders With This Id",
				icon: "warning",
				timer: 2500,
			  });
			  </script>
			@endif --}}
		
			<!-- NAVBAR -->
	
			<!-- MAIN -->
			<main>
				<div class="head-title">
					<div class="left">
						<h1>Orders History</h1>
					</div>
				</div>
                
                <div id="search_list">

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
                                <th>Date && Time</th>
                                <th>Medicine Details</th>
                                <th>Quantity</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders->orders as $order)
                                <tr>
                                    <td>
                                        {{-- id --}}
                                        @foreach($order->orderDetails as $orderDetails)
                                            <b>{{$orderDetails->id}}</b>
                                            @break
                                        @endforeach
                                    </td>
                                    <td>
                                        {{-- Date --}}
                                        @if ($orderDetails->created_at)
                                        Date: {{ $orderDetails->created_at->format('Y-m-d') }}
                                        <br>
                                        Time: {{ $orderDetails->created_at->format('H:i:s') }}
                                    @else
                                        Date and Time not available
                                    @endif
                                    </td>   
                                    <td>
                                        @foreach($order->orderDetails as $orderDetails)
                                            <b>{{$orderDetails->medicine->name}}</b>
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
                                                    <b>Id: {{$orderDetails->medicine->id}}</b> <br>
                                                </p>
                                                <p>
                                                    <b>Price: ${{$orderDetails->medicine->price}}</b> <br>
                                                </p>
                                                <p>
                                                    Exp-date: {{$orderDetails->medicine->exp_date}}
                                                </p>
                                                <p>
                                                    MFG-date: {{$orderDetails->medicine->mfg_date}}
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
                        </tbody>
                    </table> 
                </div> 
                </div>
			</main>
            </table>
			<!-- MAIN -->
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js" integrity="sha512-2rNj2KJ+D8s1ceNasTIex6z4HWyOnEYLVC3FigGOmyQCZc2eBXKgOxQmo3oKLHyfcj53uz4QMsRCWNbLd32Q1g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.min.js" integrity="sha512-WW8/jxkELe2CAiE4LvQfwm1rajOS8PHasCCx+knHG0gBHt8EXxS6T6tJRTGuDQVnluuAvMxWF4j8SNFDKceLFg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
            <script>
                $(document).ready(function(){
                    $('#search').on('keyup',function(){
                        var query=$(this).val();
                        $.ajax({
                            url:"search",
                            type:"GET",
                            data:{'search':query},
                            success:function(data){
                                $('#search_list').html(data);
                            }
                        });
                    });
                });
            </script>
    
        @endsection
	<!-- CONTENT -->


</body>
</html>



