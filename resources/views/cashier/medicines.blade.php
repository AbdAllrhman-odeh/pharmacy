<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Medicines</title>
  <link rel="stylesheet" href="{{asset('addCashier/addCashier.css')}}">
  <style>
			summary::marker{
			color:var(--blue);
		}
  </style>
</head>

<body>
    @extends('layouts\masterForCashier')
    @section('item1')active @endsection
    @section('content')

		<!-- NAVBAR -->
		<nav>
			<i class='bx bx-menu' ></i>
			<form method="GET" action="{{route('searchMethodCashier')}}">
				<div class="form-input">
					<input type="search" placeholder="Search By Medicine Name or Chemical Name" id="search" name="search" onfocus="this.value='' ">
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

    {{-- <div id="myModal" class="modal" style="{{ $errors->any() ? 'display: block;' : 'display: none;' }}">
        <div class="modal-content top">
            <!-- Close button for the modal -->
            <span class="close" onclick="closeModal()">&times;</span>
            
            <!-- Form content -->
			<div class="container">
				<h2>Add Medicine</h2>
				<form method="POST" action="{{route('addMedicine')}}">
				@csrf 
				<div class="input-field">
					<label for="name">Name: </label>
					<input type="text" name="name" required />
				</div>
				<div class="input-field">
					<label for="chemical_Name">Chemcial :</label>
					<input type="text" name="chemical_Name" required />
				</div>
				<div class="input-field">
					<label for="does">Does: </label>
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
					<label for="quantity">Quantity: </label>
					<input type="number"  name="quantity" step="1" required />
				</div>
				<div class="input-field">
					<label for="price">Price: </label>
					<input type="number" name="price" step="0.01" required />
				</div>
				<div class="input-field">
					<label for="exp_date">EXP-date: </label>
					<input type="date" name="exp_date" required />
				</div>
				<div class="input-field">
					<label for="mfg_date">MFG-date: </label>
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
	@endif--}}

    {{-- search is empty --}}
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
                            <th>Does</th>
							<th>Detalis</th>
							<th>Alternative</th>
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
											</form>
											<input class="button" type="submit" value="Close" onclick="closeModal2({{$medicine->id}})">
										</div>
									</div>
								</div>
                                <td>
                                    @if($medicine->type != 'cream')
                                        {{$medicine->does}} GM
                                    @else <?php echo('No Does'); ?>
                                    @endif
                                </td>
								<td>
									<button class="openModalButton2 status g" data-cashier-id="{{$medicine->id}}" onclick="openModal2('{{$medicine->id}}')" style="border:none; font-size:17px;">More Info</button>
								</td>
								<td>
									@if(isset($alternatives) && count($alternatives) > 0)
										@foreach($alternatives as $alt)
											@if($alt->originalMedicine->id == $medicine->id)
												<details>
													<summary>
														See Alternative	
													</summary>
													<ul>
														<li>
															{{ $alt->alternativeMedicine->name }} / {{$alt->alternativeMedicine->does}}
														</li>
													</ul>
												</details>
											@endif
										@endforeach
										@if(count($alternatives) == 0)
											No Alternative
										@endif
									@else
										Alternative has not been added yet
									@endif
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
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.2/dist/sweetalert2.all.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.2/dist/sweetalert2.min.css">
	<script src="{{ asset('addCashier/addCashier.js') }}" data-errors="{{ $errors->any() }}"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js" integrity="sha512-2rNj2KJ+D8s1ceNasTIex6z4HWyOnEYLVC3FigGOmyQCZc2eBXKgOxQmo3oKLHyfcj53uz4QMsRCWNbLd32Q1g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.min.js" integrity="sha512-WW8/jxkELe2CAiE4LvQfwm1rajOS8PHasCCx+knHG0gBHt8EXxS6T6tJRTGuDQVnluuAvMxWF4j8SNFDKceLFg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<script>
		$(document).ready(function(){
			$('#search').on('keyup',function(){
				var query=$(this).val();
				$.ajax({
					url:"searchMedicines",
					type:"GET",
					data:{'search':query},
					success:function(data){
						var tableRow='';
						$('#search_list').html(data);
						$.each(res,function(index,value){
							//content of the table row
							tableRow='<tr><td></td></tr>';
							$('#dynamic-table').append(tableRow);
						});
					}
				});
			});
		});
	</script>

</body>
</html>