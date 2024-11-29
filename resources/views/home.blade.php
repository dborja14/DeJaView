@extends('main')

@section('home')

<div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="../images/ngenge.jpg" class="d-block w-100" alt="...">
        </div>
        <div class="carousel-item">
            <img src="../images/awd.jpg" class="d-block w-100" alt="...">
        </div>
        <div class="carousel-item">
            <img src="../images/hehe.jpg" class="d-block w-100" alt="...">
        </div>
        <div class="carousel-caption">SoleMatePh</div>
    </div>
</div>


<div class="container mb-5">
    <div class="row mt-5">
        <div class="col-12">
            <h3 class="section-title">✨ New Release!</h3>
        </div>
        @foreach($products->take(4) as $product)
        <div class="col-6 col-lg-3 mb-4">
            <div class="card product-card shadow-sm">
                <div class="card-img-container">
                    <img src="{{ asset($product['productSecond']) }}" class="card-img-top" alt="{{ $product->productName }}">
                </div>
                <div class="card-body text-center">
                    <h5 class="card-title">{{ $product->productName }}</h5>
                    <a href="collection" class="btn btn-primary btn-sm">View</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="row mt-5">
        <div class="col-12">
            <h3 class="section-title">🔥 Most Bought Shoes</h3>
        </div>
        @foreach($mostBoughtShoes as $sold)
        <div class="col-4 col-lg-4 mb-4">
            <div class="card product-card shadow-sm">
                <div class="card-img-container">
                    <img src="{{ $sold->productSecond }}" alt="{{ $sold->productName }}" class="card-img-top">
                </div>
                <div class="card-body text-center">
                    <h5 class="card-title">{{$sold->productName}}</h5>
                    <a href="collection" class="btn btn-primary btn-sm">View</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

</div>




<style>
    /* General Body Styling */
    body {
        overflow-x: hidden;
        background-color: #f8f9fa;
        font-family: 'Roboto', sans-serif;
    }


    .section-title {
        font-size: 1.75rem;
        font-weight: bold;
        color: #333;
        margin-bottom: 1.5rem;
        text-align: center;
    }

    /* Ensure all cards are the same height */
    .product-card {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        height: 100%;
        /* Match card height */
        min-height: 320px;
        /* Adjust based on your needs */
    }

    /* Set a fixed height for the image container */
    .product-card .card-img-container {
        height: 400px;
        /* Adjust this value as needed */
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        background-color: #f8f9fa;
        /* Fallback background */
        border-bottom: 1px solid #ddd;
        /* Optional styling */
    }

    .product-card .card-img-container img {
        max-height: 100%;
        max-width: 100%;
    }

    /* Align card body and text consistently */
    .product-card .card-body {
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
        text-align: center;
    }


    .product-card .card-title {
        font-size: 1rem;
        font-weight: bold;
        color: #555;
        margin-bottom: 0.75rem;
    }

    .product-card .btn-primary {
        background-color: #007bff;
        border: none;
        transition: background-color 0.3s ease, transform 0.2s ease;
    }

    .product-card .btn-primary:hover {
        background-color: #0056b3;
        transform: scale(1.1);
    }

    /* Slideshow Styling */
    .carousel-container {
        position: relative;
        max-height: 600px;
        opacity: 0.5;
    }

    .carousel-inner {
        max-height: 600px;

        img {
            max-height: 500px;
            opacity: 0.7;
        }
    }

    .carousel-caption {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: white;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        font-size: 3.5rem;
        font-weight: bold;
        text-align: center;
    }
</style>


@endsection