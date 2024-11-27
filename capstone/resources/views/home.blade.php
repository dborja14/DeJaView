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
    <div class="row">
        @foreach($products->take(4) as $product)
        <div class="col-6 col-lg-3 md-3 sm-6 pt-5">
            <div class="card" style="max-width: 18rem; max-height:22rem;">
                <img src="{{ asset($product['productSecond']) }}" class="card-img-top" alt="..." style="max-width: 20rem; max-height:15rem;">
                <div class="card-body">
                    <h5 class="card-title">{{$product->productName}}</h5>
                    <a href="collection" class="btn btn-primary">View</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>


<style>
    body {
        overflow-x: hidden;
    }

    /* SLIDESHOW ---- */
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

    .row h1 {
        text-align: center;
        padding-top: 5%;
    }

    /* END OF SLIDESHOW ---- */
</style>

@endsection