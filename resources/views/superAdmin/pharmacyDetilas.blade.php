@extends('layouts.masterForSuperAdmin')

@section('title')
    Pharmacy Details
@endsection

<style>
    .parent form {
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
        justify-content: space-evenly;
        align-items: flex-start;
        height: auto;
        background: white;
    }

    /* Adjust styles for input containers */
    .parent form div {
        padding: 10px;
        margin: 10px;
        width: 30%;
        background-color: #f4f4f4; /* Light gray background */
        border-radius: 5px; /* Rounded corners */
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Light shadow for depth */
    }

    /* Adjust input styles */
    .parent form input {
        width: 100%;
        padding: 10px;
        box-sizing: border-box; /* Include padding in the width */
        border: 1px solid #ccc; /* Light border */
        border-radius: 3px; /* Rounded corners for input */
    }

    /* Adjust submit button styles */
    .parent form input[type="submit"] {
        width: 100%;
        padding: 10px;
        background-color: #3C91E6; /* Green background color */
        color: white; /* White text color */
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease; /* Smooth transition on hover */
    }

    .parent form input[type="submit"]:hover {
        background-color: #3C91E6; /* Darker green on hover */
    }
</style>

@section('content')
<div class="parent">
    <form method="POST" action="{{route('pharmacyInfo')}}">
        @csrf
        <input type="hidden" name="id"  value="{{$pharmacy->id}}">
        <div class="item">
            <label for="name">
                Name:
            </label>
            <input type="text" id="name" name="name"  value="{{$pharmacy->name}}">
        </div>

        <div class="item">
            <label for="location">
                Location:
            </label>
            <input type="text" id="location" name="location" value="{{$pharmacy->location}}">
        </div>

        <div class="item">
            <label for="number">
                Number:
            </label>
            <input type="text" id="number" name="number"  value="{{$pharmacy->number}}">
        </div>

        <div class="item">
            <input type="submit" value="Change!">
        </div>
    </form>
</div>

@if(session('success'))
	<script>
		Swal.fire({
		title: "Successfully Updated",
		icon: "success"
	  });
	  </script>
@endif

@endsection
