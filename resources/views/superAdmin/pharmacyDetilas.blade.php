@extends('layouts.masterForSuperAdmin')
<head>
@section('title')
    Pharmacy Details
@endsection
<style>
    .parent{
        height:100px;

        display: flex;
        flex-direction: row; /*y*/
        flex-wrap: wrap;
        justify-content: space-evenly;/*x*/
        align-items: flex-start;/*y*/
        

    }
    .parent div div{
        padding:20px 10px;
        box-shadow: 0 0 10px 2px rgba(170, 221, 1, 0.5); /* Adjusted with spread value and alpha channel */
    border-radius: 10px; /* Added 'px' unit */
    margin: 10px; /* Added margin for spacing */

    }
    .item{
        width:340px;
    }
    .parent div label{
        display: inline-block;
        width: 150px;
    }
    input[type='submit']{
        justify-content: center;/*x*/
        align-items: center;/*y*/
    }
    input{
        width: 150px;
        padding: 5px;
    }
    
    .item button {
    width:100%;
    margin-top: 30px; 
    padding: 10px 15px;
    font-size: 14px;
    font-weight: bold;
    color: #fff;
    background-color: #3C91E6;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.5s ease;
}

.item button:hover {
    background-color: black;
}

</style>
</head>

@section('content')
<div class="parent">
    <form action="">
        <div>
            <div style="background:white;" class="item">
                <label for="">Pharmacy Name:</label>
                <input type="text" value="name">
    
            </div>
            <div style="background:white;" class="item">
                <label for="">Pharmacy Location</label>
                <input type="text" value="location">    
            </div>
            <div style="background:white;" class="item">
                <label for="">Pharmacy Location</label>
                <input type="text" value="location">    
            </div>
            <div style="text-align:center;">
                <input type="submit">
            </div>
        </div>
    </form>
</div>
@endsection
