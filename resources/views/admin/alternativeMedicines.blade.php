<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>Alternative</title>
<style>
    button{
        cursor: pointer;
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
    .alternative form {
        background-color: #F9F9F9;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        width: 300px;
        margin: auto;
    }
    .alternative .alternative label {
        display: block;
        margin-bottom: 8px;
    }
    .alternative select {
        width: 100%;
        padding: 8px;
        margin-bottom: 16px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }
    .alternative button {
        background-color: #3C91E6;
        color: #fff;
        padding: 10px 15px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
    }
    .alternative button:hover {
        background-color: #3C91E6;
    }
</style>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        updateAlternativeOptions();
    });

    function updateAlternativeOptions() {
        var originalMedicine = document.getElementById('originalMedicine');
        var alternativeMedicine = document.getElementById('alternativeMedicine');

        if (originalMedicine && alternativeMedicine) {
            alternativeMedicine.innerHTML = '';

            for (var i = 0; i < originalMedicine.options.length; i++) {
                if (originalMedicine.options[i].selected) {
                    continue;
                }
                var option = document.createElement('option');
                option.value = originalMedicine.options[i].value;
                option.text = originalMedicine.options[i].text;
                alternativeMedicine.add(option);
            }
        }
    }
</script>
</head>
<body>

	<!-- SIDEBAR -->
	@extends('layouts\master')
	@section('item5')active @endsection
	<!-- SIDEBAR -->

	<!-- CONTENT -->
	@section('content')


	<!-- NAVBAR -->
	<nav>
		<i class='bx bx-menu' ></i>
		<a href="#" class="nav-link"> </a>
		<form action="#">

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

    @if(session('success'))
    <div class="custom-info-alert" role="alert">
        <h1>{{session('success')}}</h1>
        <span class="close-btn"  onclick="hideAlert('.custom-info-alert')">×</span>
    </div>
    @endif

    @if(session('error'))
    <div class="custom-danger-alert" role="alert">
        <h1>{{session('error')}}</h1>
        <span class="close-btn" onclick="hideAlert('.custom-danger-alert')">×</span>
    </div>
    @endif


	<!-- MAIN -->
	<main>
        <div class="alternative">
            <form method="POST" action="{{route('alternativeFunction')}}">
                @csrf
                <label for="originalMedicine">Select Original Medicine:</label>
                <select name="originalMedicine" id="originalMedicine" onchange="updateAlternativeOptions()">
                    @foreach($medicines as $medicine)
                        <option value="{{$medicine->id}}">{{$medicine->name}}</option>
                    @endforeach
                </select>
            
                <label for="alternativeMedicine">Select Alternative Medicine:</label>
                <select id="alternativeMedicine" name="alternativeMedicine">
                </select>
            
                <button type="submit">Submit</button>
            </form>
        </div>


		<div class="table-data">
			<div class="order">
				<div class="head">
					<h3>Alternative Medicines</h3>
				</div>


				<!--print all orders for this pharmacy-->
                <table>
                    <thead>
                        @if(isset($info) && count($info)>0)
                        <tr>
                            <th>Original Medicine</th>
                            <th>Alternative Medicine</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody style="margin-top:1px solid black;">
                        @foreach($info as $medicine)
                            <tr>
                                <td>
                                    {{$medicine->originalMedicine->name}} / {{$medicine->originalMedicine->does}}
                                </td>
                                <td>
                                    {{$medicine->alternativeMedicine->name}} / {{$medicine->alternativeMedicine->does}}
                                </td>
                                <td>
                                    <form action="{{route('deleteAlt')}}" method="POST">
                                        @csrf
                                        <input type="hidden" name="originalMedId" value="{{$medicine->originalMedicine->id}}">
                                        <input type="hidden" name="alternativeMedId" value="{{$medicine->alternativeMedicine->id}}">
										<button role="submit" class="status pending" style="border:none; font-size:17px;">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        @else
                        <p>No Alternative Medicine Added Yet</p>
                        @endif
                    </tbody>
                </table>
			</div>
		</div>
	</main>
	<!-- MAIN -->
	@endsection
	<!-- CONTENT -->

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



