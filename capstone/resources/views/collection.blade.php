@extends('main')

@section('collection')

<div class="container mb-5">

    @if (Session::has('Success'))
    <div class="alert alert-success mt-5">
        {{ Session::get('Success') }}
        <a href="../cart">View Cart</a>
    </div>


    @endif


    <div class="filter_buttons mt-5">
        <button class="active" data-name="all"> Show All</button>
        <button data-name="Basketball"> Basketball</button>
        <button data-name="Lifestyle"> Lifestyle</button>
    </div>

    <nav style="--bs-breadcrumb-divider: '>'; display: flex; justify-content: center; align-items:center; margin-top:1rem;" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><i class="bi bi-1-circle-fill"> Select a product</i></li>
            <li class="breadcrumb-item active"><i class="bi bi-2-circle"> Choose a Size</i></li>
            <li class="breadcrumb-item active"><i class="bi bi-3-circle"> Checkout!</i></li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-12 col-lg-12 col-md-12 col-sm-12  text-center">

            <div class="row">
                @if(Session::has('loginId') && $addr)
                <input type="text" name="addr" value="{{ $addr->id }}" hidden>

                @foreach($products as $product)
                <div class="col-6 col-lg-3 col-md-3 col-sm-6 filterable_card mt-5 text-center" data-name="{{$product->productCategory}}">
                    <a href="{{ route('product', ['productName' => $product->productName]) }}" style="text-decoration:none;">
                        <div class="card" style="width: 100%; max-width: 18rem; position: relative;">
                            <div class="card-body">
                                <img src="{{ asset($product->productSecond) }}" alt="" style="width:100%;max-width:200px; height:200px">
                                <div class="d-flex justify-content-center align-items-center">
                                    <h5 class="card-title mt-3">{{$product->productName}}</h5>
                                </div>
                                <form action="{{ route('favorites') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="favoriteButton position-absolute" style="top: 10px; right: 10px;">
                                        @if(in_array($product->id, $fav))
                                        <i class="bi bi-heart-fill" style="color: #FF8A8A;font-size: 20px;"></i>
                                        @else
                                        <i class="bi bi-heart" style="font-size: 20px;"></i>
                                        @endif
                                    </button>

                                    <!-- Hidden fields -->
                                    <input type="hidden" name="userId" value="{{ Session::get('user.id') }}" hidden>
                                    <input type="hidden" name="productId" value="{{$product->id}}" hidden>
                                </form>
                                <h6 class="card-subtitle mb-2 text-body-secondary">{{$product->productCategory}} Shoes</h6>
                                <p class="card-text">For as low as ₱ {{ number_format($product->productPrice) }}</p>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
                @elseif(auth()->check())

                @foreach($products as $product)
                <div class="col-6 col-lg-3 col-md-3 col-sm-6 filterable_card mt-5 text-center" data-name="{{$product->productCategory}}">
                    <a data-bs-toggle="modal" data-bs-target="#loginModal" style="text-decoration:none;">
                        <div class="card" style="width: 100%; max-width: 18rem; position: relative;">
                            <div class="card-body">
                                <img src="{{ asset($product->productSecond) }}" alt="" style="width:100%;max-width:200px; height:200px">
                                <div class="d-flex justify-content-center align-items-center">
                                    <h5 class="card-title mt-3">{{$product->productName}}</h5>
                                </div>
                                <form action="{{ route('favorites') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="favoriteButton position-absolute" style="top: 10px; right: 10px;">
                                        @if(in_array($product->id, $fav))
                                        <i class="bi bi-heart-fill" style="color: #FF8A8A;font-size: 20px;"></i>
                                        @else
                                        <i class="bi bi-heart" style="font-size: 20px;"></i>
                                        @endif
                                    </button>

                                    <!-- Hidden fields -->
                                    <input type="hidden" name="userId" value="{{ Session::get('user.id') }}" hidden>
                                    <input type="hidden" name="productId" value="{{$product->id}}" hidden>
                                </form>
                                <h6 class="card-subtitle mb-2 text-body-secondary">{{$product->productCategory}} Shoes</h6>
                                <p class="card-text">For as low as ₱ {{ number_format($product->productPrice) }}</p>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="loginModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-static modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-4">
                                    <p>Please Set your address first!</p>
                                </div>

                                <div>
                                    <a href="../collection" class="addressButtonBack">Back</a>
                                    <a href="../account" class="addressButton">Continue</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                @endif

                @if(Session::has('loginId'))

                <div></div>
                @else

                @foreach($products as $product)
                <div class="col-6 col-lg-3 col-md-3 col-sm-6 filterable_card mt-5 text-center" data-name="{{$product->productCategory}}">
                    <a href="{{ route('product', ['productName' => $product->productName]) }}" style="text-decoration:none;">
                        <div class="card" style="width: 100%; max-width: 18rem; position: relative;">
                            <div class="card-body">
                                <img src="{{ asset($product->productSecond) }}" alt="" style="width:100%;max-width:200px; height:200px">
                                <div class="d-flex justify-content-center align-items-center">
                                    <h5 class="card-title mt-3">{{$product->productName}}</h5>
                                </div>
                                <form action="{{ route('favorites') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="favoriteButton position-absolute" style="top: 10px; right: 10px;">
                                        @if(in_array($product->id, $fav))
                                        <i class="bi bi-heart-fill" style="color: #FF8A8A;font-size: 20px;"></i>
                                        @else
                                        <i class="bi bi-heart" style="font-size: 20px;"></i>
                                        @endif
                                    </button>

                                    <!-- Hidden fields -->
                                    <input type="hidden" name="userId" value="{{ Session::get('user.id') }}" hidden>
                                    <input type="hidden" name="productId" value="{{$product->id}}" hidden>
                                </form>
                                <h6 class="card-subtitle mb-2 text-body-secondary">{{$product->productCategory}} Shoes</h6>
                                <p class="card-text">For as low as ₱ {{ number_format($product->productPrice) }}</p>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach

                @endif
            </div>

        </div>

    </div>

</div>

<script>
    const filterButtons = document.querySelectorAll(".filter_buttons button");
    const filterableCards = document.querySelectorAll(".filterable_card");

    const filterCards = e => {
        // Remove 'active' class from all buttons
        filterButtons.forEach(button => {
            button.classList.remove("active");
            button.style.backgroundColor = ""; // Reset color to default
        });

        // Add 'active' class to the clicked button
        e.target.classList.add("active");
        e.target.style.backgroundColor = "#D2E0FB";

        filterableCards.forEach(card => {
            if (card.dataset.name === e.target.dataset.name || e.target.dataset.name === "all") {
                card.classList.remove("d-none");
            } else {
                card.classList.add("d-none");
            }
        });
    };

    filterButtons.forEach(button => button.addEventListener("click", filterCards));
</script>

<style>
    .favoriteButton {
        border: none;
        background-color: transparent;
    }

    .card {
        transition: 0.2s;
    }

    .card:hover {
        transform: scale(1.1);
        box-shadow: 4px 4px gray;
    }

    .addressButtonBack{
        background-color: gray;
        padding: 2%;
        color: white;
        margin: 2%;
        border-radius: 10%;
    }
    .addressButton{
        background-color: #198754;
        padding: 2%;
        color: white;
        margin: 2%;
        border-radius: 10%;
    }

    a{
        text-decoration: none;
        color: black;
    }
    #flexCheckDefault {
        font-size: 16px;
    }

    .form-check-label {
        font-size: 16px;
    }

    .img-fluid {
        max-height: 300px;
    }
</style>

@endsection