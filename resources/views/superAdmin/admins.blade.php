<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <title>Add Admin</title>
  <link rel="stylesheet" href="{{asset('addCashier/addCashier.css')}}">
</head>

<body>
    @extends('layouts\masterForSuperAdmin')
	@section('item2')active @endsection
    
    @section('content')



    <!-- Modal Container for the add cashier -->
    <div id="myModal" class="modal" style="{{ $errors->any() ? 'display: block;' : 'display: none;' }}">
        <div class="modal-content">
            <!-- Close button for the modal -->
            <span class="close" onclick="closeModal()">&times;</span>
            
            <!-- Form content -->
            <div class="container">
                <h2>Add Admin To Our Family</h2>
                <form method="POST" action="{{route('addAdmin')}}">
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
                @foreach($pharmacy as $ph)
                    <div class="input-field">
                        <input type="radio" id="{{$ph->id}}" value="{{$ph->id}}" name="pharmacy_id" />
                        <label style="width:auto;" for="{{$ph->id}}"> Pharmacy Id: {{$ph->id}}</label>
                    </div>
                @endforeach
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
                <span class="status completed"><button style="background:transparent; border:none; color:white; font-size:17px; padding:10px;" id="openModalButton">Add Admin</button></span>
            </div>
        </div>


        <div class="table-data">
            <div class="order">
                <div class="head">
                    <h3>Admins</h3>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>Pharmacy Id</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Joined At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pharmacy as $pharmacy)
                        @foreach($pharmacy->admins as $admin)
                            <tr>
                                <td>
                                    {{$pharmacy->id}}
                                </td>
                                <td>
                                    {{$admin->user->name}}
                                </td>
                                <td>
                                    {{$admin->user->email}}
                                </td>
                                <td>
                                    @php
                                        $createdAt=$admin->user->created_at;
                                        $createdAt=$createdAt->format('Y-M-d');   
                                    @endphp
                                    {{$createdAt}}
                                </td>
                            </tr>
                        @endforeach
                        @endforeach
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