@extends('main')

@section('reco')
<div class="body">
    <div class="containerr">

        <div class="container p-3">
            <div>
                <h3 style="text-align: center;">Here are your recomended shoes!</h3>
                <hr>
            </div>
            @if (empty($recommendedShoes))
            <p>No shoes match your preferences.</p>
            @else

            @foreach ($recommendedShoes as $shoe)

            <div class="boxBackground">

                <div class="d-flex" style="gap:1rem;">

                    <img src="{{$shoe['productSecond']}}" alt="" style="width: 100px; height:100px;">
                    <!--  {{ number_format($shoe['productPrice'], 2) }} PHP -->
                    <div>

                        <p>{{ $shoe['productName'] }} </p>
                        <p>{{ $shoe['productDescription'] }} </p>

                        <div class="d-flex" style="gap: 1rem;">
                            <p>Price: </p>
                            <p>₱ {{ $shoe['productPrice'] }} </p>
                        </div>
                    </div>
                </div>
                <div style="display: flex; justify-content: end; margin-left:0;">

                    <a href="{{ route('product', ['productName' => $shoe['productName']]) }}">
                        <button>View Product!</button>
                    </a>
                </div>
            </div>

            @endforeach
            </ul>
            @endif
            <a href="{{ url('/survey') }}">Go back</a>


        </div>
    </div>
</div>

<style>
    /* Body styling */
    .body {
        display: flex;
        justify-content: center;
        align-items: center;
        background-image: url('/storage/Images/bg.png');
        background-size: cover;
        background-position: center;
        position: relative;
        height: 85vh;
        /* Remove padding to avoid extra space */
    }

    .boxBackground {
        margin: 1rem;
        background-color: lightblue;
        padding: 20px;
        border-radius: 10px;
    }

    body {
        overflow: hidden;
    }

    /* Container styling */
    .containerr {
        width: 600px;
        max-height: 80vh;
        /* Limit height to 80% of the viewport */
        background: rgba(255, 255, 255, 0.9);
        /* Slightly more opaque for readability */
        backdrop-filter: blur(10px);
        padding: 2rem;
        /* Padding inside the container */
        border-radius: 10px;
        overflow-y: auto;
        /* Enable scroll when content exceeds the container's height */
        box-sizing: border-box;
        /* Include padding in the height calculation */
        display: flex;
        flex-direction: column;
        margin: 2rem;
        position: relative;
    }

    form {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    label,
    select,
    input,
    button {
        font-size: 1rem;
        padding: 8px;
        border-radius: 5px;
        border: 1px solid #ccc;
    }

    button {
        padding: 10px 20px;
        cursor: pointer;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 5px;
    }

    button:hover {
        background-color: #0056b3;
    }

    h3 {
        text-align: center;
        margin-bottom: 1rem;
    }

    /* Scrollbar customization */
    .containerr::-webkit-scrollbar {
        width: 8px;
    }

    .containerr::-webkit-scrollbar-thumb {
        background: rgba(0, 0, 0, 0.3);
        border-radius: 10px;
    }

    .containerr::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
</style>
@endsection