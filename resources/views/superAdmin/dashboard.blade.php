@extends('layouts.masterForSuperAdmin')
<head>
@section('title')
    Dashboard
@endsection
<style>
    .parent{
        height: 65vh;
        
        display: flex;
        flex-direction: row; /*y*/
        flex-wrap: wrap;
        justify-content: space-evenly;/*x*/
        align-items: center;/*y*/

    }
    .item{
        padding:30px;
        margin-bottom: 15vh;
    }
    .item img{
        width: 100%;
        height: 30%;
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
@section('item1')
    active
@endsection

@section('content')
    <h1 style="text-align:center; margin-top:30px;">My Phamracies</h1>
    <div class="parent">
        @foreach($superAdmin as $superAdmin)
            <div class="item">
                <img src="{{asset('img/pharmacy.png')}}" alt=""><br>
                @foreach ($superAdmin->pharmacies as $pharmacy)
                <form action="{{route('pharmacyDetails')}}" method="POST">
                    @csrf
                    <input type="hidden" name="phy_id" value="{{ $pharmacy->id }}">
                    <button>{{ $pharmacy->name }} - {{ $pharmacy->location }}</button>
                </form>
                {{-- <a href="{{route('pharmacyDetails',$pharmacy->id)}}" class="button-link">
                    <button>{{ $pharmacy->name }} - {{ $pharmacy->location }}</button>
                </a>                 --}}
                @endforeach
                
            </div>
        @endforeach
    </div>
@endsection
