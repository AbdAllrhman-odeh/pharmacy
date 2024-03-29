<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Medicines</title>
  <link rel="stylesheet" href="{{asset('addCashier/addCashier.css')}}">
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.2/dist/sweetalert2.all.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.2/dist/sweetalert2.min.css">

</head>

<body>
    @extends('layouts\master')
	@section('item4')active @endsection
    
    @section('content')

		<!-- NAVBAR -->
	<nav>
		<i class='bx bx-menu' ></i>
		<form action="{{route('searchMethod')}}" method="get">
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



    <!-- Modal Container for the add cashier -->
    <div id="myModal" class="modal" style="{{ $errors->any() ? 'display: block;' : 'display: none;' }}">
        <div class="modal-content top">
            <!-- Close button for the modal -->
            <span class="close" onclick="closeModal()">&times;</span>
            
            <!-- Form content -->
			<div class="container">
				<h2>Add Medicine</h2>
				<form method="POST" action="{{route('addMedicine')}}">
				@csrf 
				<div class="input-field">
					<label>Name: </label>
					<input type="text" name="name" required />
				</div>
				<div class="input-field">
					<label>Chemcial :</label>
					<input type="text" name="chemical_Name" required />
				</div>
				<div class="input-field">
					<label>Does: </label>
					<input type="number"  name="does" step="0.1" required />
				</div>
				<div class="input-field">
					<input type="radio" id="Liquid" value="liquid" name="type" />
					<label for="Liquid"> Liquid</label>
			
					<input type="radio" id="Tablet" value="tablet" name="type" />
					<label for="Tablet"> Tablet</label>	

					<input type="radio" id="Cream" value="cream" name="type" />
					<label for="Cream"> Cream</label>	
				</div>
				<div class="input-field">
					<label>Quantity: </label>
					<input type="number"  name="quantity" step="1" required />
				</div>
				<div class="input-field">
					<label>Price: </label>
					<input type="number" name="price" step="0.01" required />
				</div>
				<div class="input-field">
					<label>EXP-date: </label>
					<input type="date" name="exp_date" required />
				</div>
				<div class="input-field">
					<label>MFG-date: </label>
					<input type="date"  name="mfg_date" required />
				</div>
				<input class="button" type="submit" value="Add!">
				</form>
				@if($errors->any())
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>
                                <span style="color:red;">* {{$error}}</span>
                            </li>
                            
                        @endforeach
                    </ul>
                 @endif
			</div>
        </div>
    </div>
	@if(session('msgAdd'))
	<script>
		Swal.fire({
		title: "Successfully Added",
		icon: "success"
	  });
	  </script>
	@endif

	@if(session('msgEmpty'))
	<script>
		Swal.fire({
		title: "No Medicine With This Name",
		icon: "warning",
		timer: 2500,
	  });
	  </script>
	@endif
    <!-- MAIN -->
    <main>
        <div class="head-title">
            <div class="left">
                <h1>Medicines in {{$pharmacy->name}} - {{$pharmacy->location}}</h1>
            </div>
            <div class="right">
                <span class="status completed"><button style="background:transparent; border:none; color:white; font-size:17px; padding:10px;" id="openModalButton">Add Medicine</button></span>
            </div>
			@if(session('msg'))
				<script>
					Swal.fire({
					title: "Successfully Deleted",
					icon: "success"
				  });
				  </script>
			@endif
        </div>

        <div class="table-data">
            <div class="order">
                <div class="head">
                    <h3>View Medicines</h3>
                </div>

				<table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Quantity</th>
							<th>Pirce/Unit</th>
							<th>Expiry Date</th>
							<th>Detalis</th>
                        </tr>
                    </thead>
                    <tbody>
						<!--display either search method or defult-->
						@foreach ((isset($filteredData) && count($filteredData) > 0) ? $filteredData : $pharmacy->medicines as $medicine)
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
								<!-- Modal Container for the editing cashiers -->
								<div class="modal" id="myModal2_{{$medicine->id}}" style="display: none">
									<div class="modal-content">
										<!-- Close button for the modal -->
										<span class="close" onclick="closeModal2({{$medicine->id}})">&times;</span>
										
										<!-- Form content -->
										<div class="container">
											<h2>Show Medicine Information</h2>
											<form method="POST" action="{{route('updateMedicine',$medicine->id)}}">
											@csrf
											<div class="input-field">
												<label>Id: </label>
												<input type="text" value="{{$medicine->id}}" name="id" disabled />
											</div>
											<div class="input-field">
												<label>Name: </label>
												<input type="text" value="{{$medicine->name}}" name="new_name" />
											</div>
											<div class="input-field">
												<label>Chemcial :</label>
												<input type="text" value="{{$medicine->chemical_Name}}" name="new_chemical_name" />
											</div>
											<div class="input-field">
												<label>Does: </label>
												<input type="number" value="{{$medicine->does}}" name="new_does" step="0.1" />
											</div>
											<div class="input-field">
												<input type="radio" id="Liquid{{$medicine->id}}" name="new_type" value="liquid" {{ $medicine->type == 'liquid' ? 'checked' : '' }}>
												<label for="Liquid{{$medicine->id}}"> Liquid</label>
										
												<input type="radio" id="Tablet{{$medicine->id}}" name="new_type" value="tablet" {{ $medicine->type == 'tablet' ? 'checked' : '' }}>
												<label for="Tablet{{$medicine->id}}"> Tablet</label>	

												<input type="radio" id="Cream{{$medicine->id}}" name="new_type" value="cream" {{ $medicine->type == 'cream' ? 'checked' : '' }}>
												<label for="Cream{{$medicine->id}}"> Cream</label>	
											</div>
											<div class="input-field">
												<label>Quantity: </label>
												<input type="number" value="{{intval($medicine->quantity)}}" name="new_quantity" step="1" />
											</div>
											<div class="input-field">
												<label>price: </label>
												<input type="number" value="{{$medicine->price}}" name="new_price" step="0.01" />
											</div>
											<div class="input-field">
												<label>EXP-date: </label>
												<input type="date" value="{{$medicine->exp_date}}" name="new_exp_date"/>
											</div>
											<div class="input-field">
												<label>MFG-date: </label>
												<input type="date" value="{{$medicine->mfg_date}}" name="new_mfg_date"/>
											</div>
											<input class="button" type="submit" value="Edit">
											</form>
										</div>
									</div>
								</div>
								<td>
									<button class="openModalButton2 status g" data-cashier-id="{{$medicine->id}}" onclick="openModal2('{{$medicine->id}}')" style="border:none; font-size:17px;">More Info</button>
									<form action="{{route('dd')}}" method="POST">
										@csrf
										<input type="hidden" value="{{$medicine->id}}" name="medicine_id" /><br>
										<button type="submit" class="status pending" onclick="showConfirmation(event)" style="border:none; font-size:17px;">Delete</button>
									</form>					
								</td>
								<td>

								</td>
							</tr>
						@endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </main>
    <!-- MAIN -->

  @include('sweetalert::alert')
  @endsection
  @include('sweetalert::alert')
    <script src="{{ asset('addCashier/addCashier.js') }}" data-errors="{{ $errors->any() }}"></script>

	
	<script>
		function showConfirmation(event) {
			event.preventDefault(); // Prevent the default form submission
	
			Swal.fire({
				title: "Are you sure you want to delete?",
				showCancelButton: true,
				confirmButtonText: "Yes, delete it!",
				cancelButtonText: "No, cancel!",
				icon: "warning"
			}).then((result) => {
				if (result.isConfirmed) {
					event.target.closest('form').submit();
				} else {
					// User clicked "No" or closed the dialog
					Swal.fire("Cancelled", "Your medicine is safe :)", "info");
				}
			});
		}
	</script>

	


</body>
</html>