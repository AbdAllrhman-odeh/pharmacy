<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <title>Add Cashier</title>
  <link rel="stylesheet" href="{{asset('addCashier/addCashier.css')}}">
</head>

<body>
    @extends('layouts\master')
	@section('item7')active @endsection
    
    @section('content')

    <!-- NAVBAR -->
	<nav>
		<i class='bx bx-menu' ></i>
		<form action="#">
			<div class="form-input">
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


    <!-- Modal Container -->
    <div id="myModal" class="modal" style="{{ $errors->any() ? 'display: block;' : 'display: none;' }}">
        <div class="modal-content">
            <!-- Close button for the modal -->
            <span class="close" onclick="closeModal()">&times;</span>
            
            <!-- Form content -->
            <div class="container">
                <h2>Add Cashier To Our Family</h2>
                <form action="{{route('addCashierFunction')}}" method="POST">
                    @csrf
                <div class="input-field">
                    <input type="text" name="firstName" placeholder="First Name" required/>
                </div>
                <div class="input-field">
                    <input type="text" name="secondName" placeholder="Last Name" required />
                </div>
                <div class="input-field">
                    <input type="email" name="email" placeholder="Email" required />
                
                </div>
                <div class="input-field">
                    <input type="password" name="password" placeholder="Password" required />
                </div>

                <div class="input-field">
                    <input type="password" name="password_confirmation" placeholder="Re-type Password" required />
                </div>

                <input class="button" type="submit" value="Add!!!">
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

    <!-- MAIN -->
    <main>
        <div class="head-title">
            <div class="left">
                <h1>Our Membres</h1>
            </div>
            <div class="right">
                <span class="status completed"><button style="background:transparent; border:none; color:white; font-size:17px; padding:10px;" id="openModalButton">Add Cashier</button></span>
            </div>
        </div>


        <div class="table-data">
            <div class="order">
                <div class="head">
                    <h3>See or Delete An Cashier</h3>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Joined At</th>
                            <th>Edit</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pharmacy->cashiers as $cashier)
                            <tr>
                                <td>
                                    {{$cashier->user->name}}
                                </td>
                                <td>
                                    {{$cashier->user->email}}
                                </td>
                                <td>
                                    @php
                                        $createdAt=$cashier->user->created_at;
                                        $createdAt=$createdAt->format('Y-M-d');   
                                    @endphp
                                    {{$createdAt}}
                                </td>
                                <td>
                                    <span class="status pending"><a href="" style="color:white">edit</a></span></td>
                                </td>
                            </tr>
                        @endforeach
                        {{-- <tr>
                            <td>
                                <p></p>
                            </td>
                            <td>
                                <p>
                                    Email@email.com
                                </p>
                            </td>
                            <td>
                                2016/06/06
                            </td>
                            <td><span class="status pending">Completed</span></td>
                        </tr> --}}
                    </tbody>
                </table>
            </div>
        </div>
    </main>
    <!-- MAIN -->



  @include('sweetalert::alert')
  @endsection

  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="{{ asset('addCashier/addCashier.js') }}" data-errors="{{ $errors->any() }}"></script>
</body>
</html>