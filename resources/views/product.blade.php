@extends('main')

@section('product')

<nav style="--bs-breadcrumb-divider: '>'; display: flex; justify-content: center; align-items:center; margin-top:1rem;" aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="../collection" class="ahover"><i class="bi bi-1-circle-fill"> Select a product</i></a></li>
        <li class="breadcrumb-item active"><i class="bi bi-2-circle-fill"> Choose a Size</i></li>
        <li class="breadcrumb-item active"><i class="bi bi-3-circle"> Checkout!</i></li>
    </ol>
</nav>
<div class="container d-flex flex-wrap productBox mt-5 mb-5">
    <div class="row mt-5 mb-5">
        <div class="col-12 col-sm-4 col-md-4 col-lg-4">
            <!-- For large screens and up: Display the reel image -->
            <div class="d-none d-lg-block">
                @if($photos->isNotEmpty())
                <img src="{{ asset('storage/uploads/' . $photos->first()->image) }}" width="400" height="400"
                    class="reel"
                    id="image"
                    data-images="{{ implode(',', $photos->pluck('image')->map(fn($img) => asset('storage/' . $img))->toArray()) }}"
                    data-cw="false"
                    data-frame="32"
                    data-speed="-0.2"
                    data-duration="0"
                    data-velocity="3"
                    alt="Image Reel">
                @else
                <img src="{{ asset($product->productSecond) }}" alt="" style="width:400px; height:500px;">
                @endif
            </div>

            <!-- For small screens only: Display the alternative image -->
            <div class="d-block d-lg-none">
                <img src="{{ asset($product->productSecond) }}" alt="" style="width:100%; height:auto;">
            </div>
        </div>


        <div class="col-8 col-md-8 col-lg-8 text-center caart">
            <div class="d-flex justify-content-center align-items-center">
                <h2 class="mb-0">{{ $product->productName }}</h2>
                <small class="ms-2 text-body-secondary" style="font-style: italic;">{{ $product->productCategory }} Shoes</small>
            </div>
            <h5 class="card-subtitle mb-2 text-body-secondary">{{ $product->productDescription }}</h5>

            <div class="row">
                @foreach ($product->shoeSizes as $shoeSize)
                <div class="col-6 col-sm-6 col-md-4 col-lg-3" style="gap: 1rem;">

                    @php
                    $size = $shoeSize->size;
                    $quantity = $shoeSize->quantity;
                    @endphp

                    @if ($quantity > 0)
                    <button type="button" onclick="setSize(this)" data-size="{{ $size }}" data-name="all" class="size-btn">{{ $size }}</button>
                    @else
                    <button type="button" class="btn btn-secondary size-btn disabled">{{ $size }}</button>
                    @endif

                </div>
                @endforeach
            </div>

            <!-- Warning message if size is not selected -->
            <div id="sizeWarning" style="color: red; display: none;">Please select a size before adding to cart.</div>

            <div class="submitButton">
                <button type="button" class="Try"><a href="{{ route('PutItON') }}" style="text-decoration:none; color: black;"><i class="bi bi-person-arms-up" style="font-size:large;"></i> Try it Yourself</a></button>
                <form action="{{ route('cart') }}" method="post" onsubmit="return validateSizeSelection()">
                    @csrf
                    <input type="hidden" name="userId" value="{{Session::get('user.id')}}">
                    <input type="hidden" name="productId" value="{{ $product->id }}">
                    <input type="hidden" name="selectedSize" id="selected_size" value="" required>
                    <input type="hidden" name="quantity" value="1">
                    <input type="hidden" name="price" value="{{ $product->productPrice }}">

                    <input type="text" name="addr" value="{{$addr->id}}" hidden>
                    <button type="submit" class="AddToCart"><i class="bi bi-cart"></i>Add to cart</button>

                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .size-btn {
        width: 90%;
        max-width: 100%;
        position: relative;
        height: 3.5em;
        border: 3px ridge #149CEA;
        outline: none;
        background-color: transparent;
        color: black;
        margin: 1rem;
        transition: 1s;
        border-radius: 0.3em;
        font-size: 16px;
        font-weight: bold;
        cursor: pointer;
    }

    .size-btn::after {
        content: "";
        position: absolute;
        top: -10px;
        left: 3%;
        width: 95%;
        height: 40%;
        background-color: transparent;
        transition: 0.5s;
        transform-origin: center;
    }

    .size-btn::before {
        content: "";
        transform-origin: center;
        position: absolute;
        top: 80%;
        left: 3%;
        width: 95%;
        height: 40%;
        background-color: transparent;
        transition: 0.5s;
    }

    .size-btn:hover::before,
    button:hover::after {
        transform: scale(0)
    }

    .size-btn:hover {
        box-shadow: inset 0px 0px 25px #1479EA;
    }

    .reel {
        border-radius: 1%;
        box-shadow: 0 0 10px gray;
    }

    .productBox {
        box-shadow: 0 0 10px gray;
        opacity: 100%;
        border-radius: 1%;
        padding: 10px;
        width: 100%;
        max-width: 80%;
    }

    .submitButton button {
        width: 150x;
        padding: 10px;
        border-radius: 10px;
        font-size: 15px;
    }

    .submitButton {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 1rem;
    }

    .AddToCart {
        background-color: #A5DD9B;
    }

    .Try {
        background-color: #D2E0FB;
    }

    .AddToCart i {
        font-size: large;
        color: black;
    }

    .size-btn.active {
        border: 1px solid black;
        background-color: #D2E0FB;

    }

    .ahover {
        text-decoration: none;
        color: #72BF78;
    }

    .ahover:hover {
        color: #347928;
        transition: 1s ease;
    }
</style>

<script>
    const sizeButtons = document.querySelectorAll(".size-btn");

    sizeButtons.forEach(button => {
        button.addEventListener("click", function() {
            setSize(this);
            // Remove active class from all buttons and add it to the clicked button
            sizeButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
        });
    });

    function setSize(button) {
        var size = button.getAttribute('data-size');
        document.getElementById('selected_size').value = size;
        document.getElementById('sizeWarning').style.display = 'none'; // Hide warning when a size is selected
    }

    function validateSizeSelection() {
        const selectedSize = document.getElementById('selected_size').value;
        if (!selectedSize) {
            document.getElementById('sizeWarning').style.display = 'block'; // Show warning if no size is selected
            return false; // Prevent form submission
        }
        return true; // Allow form submission if size is selected
    }
</script>
@endsection