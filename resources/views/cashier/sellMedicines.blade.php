<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Sell Medicines</title>
  <link rel="stylesheet" href="{{asset('addCashier/addCashier.css')}}">
  
  

    <style>
        .number 
        {
            text-align: center;
            font-size:14px; 
            width:50px !important;
            height: 20px;
        }
                /* WebKit browsers */
        input[type='number']::-webkit-inner-spin-button,
        input[type='number']::-webkit-outer-spin-button {
            
            padding-top: 5px;
            padding-bottom: 5px;
            
        }
		.editForCart{
			width:30%;
		}
        .custom-info-alert {
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: .25rem;
            color: #0c5460;
            background-color: #d1ecf1;
            border-color: #bee5eb;
            position: relative;
        }

        .custom-info-alert .close-btn {
            position: absolute;
            top: 5px;
            right: 10px;
            cursor: pointer;
        }

		.custom-danger-alert {
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: .25rem;
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
            position: relative;
        }

        .custom-danger-alert .close-btn {
            position: absolute;
            top: 5px;
            right: 10px;
            cursor: pointer;
        }

    </style>
</head>

<body>
    @extends('layouts\masterForCashier')
    @section('item2')active @endsection
    @section('content')

		<!-- NAVBAR -->
	<nav>
		<i class='bx bx-menu' ></i>
		<!--search method-->
		<form action="{{route('searchMethodCashier_sell')}}" method="get">
			<div class="form-input">
				<input type="search" placeholder="Search..." name="search">
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
		@if(session('updateCart'))
		<div class="custom-info-alert" role="alert">
			<h1>{{ session('updateCart') }} Quantity Updated Successfully</h1>
			<span class="close-btn" onclick="hideAlert()">×</span>
		</div>
	@endif
	
	@if(session('deleteMedicine'))
		<div class="custom-danger-alert" role="alert">
			<h1>{{ session('deleteMedicine') }} Deleted Successfully</h1>
			<span class="close-btn" onclick="hideAlert()">×</span>
		</div>
	@endif

		@if(session('yes'))
		<script>
			Swal.fire({
			title: "order Completed.",
			icon: "success",
			timer: 2500,
		  });
		  </script>
		@endif
		
		@if(session('qunatityErorr'))
		<script>
			Swal.fire({
				title: "Invalied!",
				text: "You cannot add medicine with zero quantity",
				icon: "error",
				timer: 2500,
			});
		</script>
		@endif

		<!--cart-->
		<div class="table-data">
		<div class="order">
			<div class="head">
				<h3>Cart</h3>
			</div>
			@if(isset($cart) && count($cart) > 0)
			@php
			$total = 0;
			@endphp
			<form action="{{route('checkOut')}}" method="POST">
				@csrf
				<table>
					<thead>
						<tr>
							<th>Name</th>
							<th>Pirce/Unit</th>
							<th>Expiry Date</th>
							<th>Does</th>
							<th>Detalis</th>
							<th>Edit</th>
							<th>Delete</th>
						</tr>
					</thead>
					<tbody>
						@foreach($cart as $cartItem)
							<tr>
								<td>
									{{$cartItem->medicines->name}}
								</td>
								<td>
									{{$cartItem->medicines->price}}
								</td>
								<td>
									{{$cartItem->medicines->exp_date}}
								</td>
								<td>
									@if($cartItem->medicines->type != 'cream')
										{{$cartItem->medicines->does}} GM
									@else <?php echo('Cream'); ?>
									@endif
								</td>
								<!-- Modal-->
								<div class="modal" id="myModal2_{{$cartItem->medicines->id}}" style="display: none">
									<div class="modal-content">
										<!-- Close button for the modal -->
										<span class="close" onclick="closeModal2({{$cartItem->medicines->id}})">&times;</span>
										
										<!-- Form content -->
										<div class="container">
											<h2>Show Medicine Information</h2>
											<form method="POST">
											@csrf
											<div class="input-field">
												<label for="id">Id: </label>
												<input type="text" value="{{$cartItem->medicines->id}}" name="id" disabled />
											</div>
											<div class="input-field">
												<label for="name">Name: </label>
												<input type="text" value="{{$cartItem->medicines->name}}" name="new_name"  disabled />
											</div>
											<div class="input-field">
												<label for="chemical_name">Chemcial :</label>
												<input type="text" value="{{$cartItem->medicines->chemical_Name}}" name="new_chemical_name"  disabled />
											</div>
											<div class="input-field">
												<label for="does">Does: </label>
												<input type="number" value="{{$cartItem->medicines->does}}" name="new_does" step="0.1"  disabled />
											</div>
											<div class="input-field">
												<input type="radio" id="Liquid" name="new_type" value="liquid" {{ $cartItem->medicines->type == 'liquid' ? 'checked' : '' }} disabled >
												<label for="Liquid"> Liquid</label>
										
												<input type="radio" id="Tablet" name="new_type" value="tablet" {{ $cartItem->medicines->type == 'tablet' ? 'checked' : '' }} disabled >
												<label for="Tablet"> Tablet</label>	

												<input type="radio" id="Cream" name="new_type" value="cream" {{ $cartItem->medicines->type == 'cream' ? 'checked' : '' }} disabled >
												<label for="Cream"> Cream</label>	
											</div>
											<div class="input-field">
												<label for="quantity">Quantity: </label>
												<input type="number" value="{{intval($cartItem->medicines->quantity)}}" name="new_quantity" step="1"  disabled />
											</div>
											<div class="input-field">
												<label for="price">price: </label>
												<input type="number" value="{{$cartItem->medicines->price}}" name="new_price" step="0.01"  disabled />
											</div>
											<div class="input-field">
												<label for="price">EXP-date: </label>
												<input type="date" value="{{$cartItem->medicines->exp_date}}" name="new_exp_date" disabled />
											</div>
											<div class="input-field">
												<label for="price">MFG-date: </label>
												<input type="date" value="{{$cartItem->medicines->mfg_date}}" name="new_mfg_date" disabled />
											</div>
											{{-- <button class="button" type="submit" value="Close" onclick="closeModal2({{$medicine->id}})">close</button> --}}
											</form>
										</div>
									</div>
								</div>
								<!--end of model-->
								<td>
									<button type="button" class="openModalButton2 status g" data-cashier-id="{{$cartItem->medicines->id}}" onclick="openModal2('{{$cartItem->medicines->id}}')" style="border:none; font-size:15px;">More Info</button>
								</td>
								<td>
									<form action="{{route('editCart')}}" method="POST">
										@csrf
										<input type="hidden" value="{{$cartItem->id}}" name="cart_id">
										<input type="number" min="1" max="{{$cartItem->medicines->quantity}}" value="{{$cartItem->quantity}}" name="newQuantity">
										<br>
										<button type="submit" class="openModalButton2 status g" style="border:none; font-size:15px; background:var(--blue); margin-top:5px;">Edit</button>
										</form>
								</td>
								<td>
									<form action="{{route('deleteMedicine')}}" method="POST">
										@csrf
										<input type="hidden" value="{{$cartItem->id}}" name="cart_id">
										<button type="submit" class="openModalButton2 status g" style="border:none; font-size:15px; background:#dc3545;">Delete</button>
									</form>
								</td>
								<!--handle the total-->

								@php
								$total += $cartItem->quantity * $cartItem->medicines->price;
								@endphp
								<!--end of total-->
							</tr>
						@endforeach
					</tbody>
					<tfoot>
						<tr>
							<td colspan="7" style="text-align:center;">
								<h2>Total: {{ $total }} $</h2>
							</td>
						</tr>
					</tfoot>
				</table>
				<div style="text-align:center; margin:10px;">
					<input type="submit" value="Check Out" style="width:50%">
				</div>
			</form>
			@else
				<p>You have not added anything yet</p>
			@endif
		</div>
	</div>

        <!--search result-->
        <div class="table-data">
            <div class="order">
                <div class="head">
                    <h3>Searched Medicines</h3>
                </div>
            @if(isset($filteredData) && count($filteredData) > 0)
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Quantity In Phy</th>
							<th>Pirce/Unit</th>
							<th>Expiry Date</th>
                            <th>Does</th>
							<th>Detalis</th>
                            <th>Add To Cart</th>
                        </tr>
                    </thead>
                    <tbody>
						<!--display either search method or defult-->
						@foreach ($filteredData as $medicine)
							<tr>
								<td>
									{{$medicine->name}}
								</td>
								<td>
									{{intval($medicine->quantity)}}
								</td>
								<td>
									{{$medicine->price}}
								</td>
								<td>
									{{$medicine->exp_date}}
								</td>
								<!-- Modal-->
								<div class="modal" id="myModal2_{{$medicine->id}}" style="display: none">
									<div class="modal-content">
										<!-- Close button for the modal -->
										<span class="close" onclick="closeModal2({{$medicine->id}})">&times;</span>
										
										<!-- Form content -->
										<div class="container">
											<h2>Show Medicine Information</h2>
											<form method="POST">
											@csrf
											<div class="input-field">
												<label for="id">Id: </label>
												<input type="text" value="{{$medicine->id}}" name="id" disabled />
											</div>
											<div class="input-field">
												<label for="name">Name: </label>
												<input type="text" value="{{$medicine->name}}" name="new_name"  disabled />
											</div>
											<div class="input-field">
												<label for="chemical_name">Chemcial :</label>
												<input type="text" value="{{$medicine->chemical_Name}}" name="new_chemical_name"  disabled />
											</div>
											<div class="input-field">
												<label for="does">Does: </label>
												<input type="number" value="{{$medicine->does}}" name="new_does" step="0.1"  disabled />
											</div>
											<div class="input-field">
												<input type="radio" id="Liquid" name="new_type" value="liquid" {{ $medicine->type == 'liquid' ? 'checked' : '' }} disabled >
												<label for="Liquid"> Liquid</label>
										
												<input type="radio" id="Tablet" name="new_type" value="tablet" {{ $medicine->type == 'tablet' ? 'checked' : '' }} disabled >
												<label for="Tablet"> Tablet</label>	

												<input type="radio" id="Cream" name="new_type" value="cream" {{ $medicine->type == 'cream' ? 'checked' : '' }} disabled >
												<label for="Cream"> Cream</label>	
											</div>
											<div class="input-field">
												<label for="quantity">Quantity: </label>
												<input type="number" value="{{intval($medicine->quantity)}}" name="new_quantity" step="1"  disabled />
											</div>
											<div class="input-field">
												<label for="price">price: </label>
												<input type="number" value="{{$medicine->price}}" name="new_price" step="0.01"  disabled />
											</div>
											<div class="input-field">
												<label for="price">EXP-date: </label>
												<input type="date" value="{{$medicine->exp_date}}" name="new_exp_date" disabled />
											</div>
											<div class="input-field">
												<label for="price">MFG-date: </label>
												<input type="date" value="{{$medicine->mfg_date}}" name="new_mfg_date" disabled />
											</div>
											{{-- <button class="button" type="submit" value="Close" onclick="closeModal2({{$medicine->id}})">close</button> --}}
											</form>
										</div>
									</div>
								</div>
								<!--end of model-->
                                <td>
                                    @if($medicine->type != 'cream')
                                        {{$medicine->does}} GM
                                    @else <?php echo('Cream'); ?>
                                    @endif
                                </td>
								<td>
									<button type="button" class="openModalButton2 status g" data-cashier-id="{{$medicine->id}}" onclick="openModal2('{{$medicine->id}}')" style="border:none; font-size:15px;">More Info</button>
								</td>
                                <td>
									<form method="POST"	 action="{{route('addToCart')}}">
										@csrf
										<input type="hidden" name="med_id" value="{{$medicine->id}}">
                                    	<input type="number" class="number" min="0" max="{{intval($medicine->quantity)}}" value="0" name="med_quantity">   
										<button type="submit" class="openModalButton2 status g" style="border:none; font-size:15px; background:var(--blue); margin-left:5px;">Add</button>
									</form>         
                                </td>
							</tr>
						@endforeach
                    </tbody>
                </table>
            @else You have not searched anything yet
            @endif
            </div>
        </div> 	
    </main>
    <!-- MAIN -->

  @include('sweetalert::alert')
  @endsection
  @include('sweetalert::alert')
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.2/dist/sweetalert2.all.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.2/dist/sweetalert2.min.css">
<script src="{{ asset('addCashier/addCashier.js') }}" data-errors="{{ $errors->any() }}"></script>

<script>
    setTimeout(function () {
        hideAlert('.custom-info-alert');

    }, 4000);
	setTimeout(function () {
        hideAlert('.custom-danger-alert');

    }, 4000);

    function hideAlert(selector) {
        document.querySelector(selector).style.display = 'none';
    }       
</script>

</body>
</html>