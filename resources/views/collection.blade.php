@extends('main')

@section('collection')
<div class="container mb-5">
    <!-- Success Alert -->
    @if (Session::has('Success'))
    <div class="alert alert-success mt-5">
        {{ Session::get('Success') }}
        <a href="../cart" class="alert-link">View Cart</a>
    </div>
    @endif

    <!-- Filter Buttons -->
    <div class="filter_buttons mt-5 text-center">
        <button class="btn filter-btn active" data-name="all">Show All</button>
        <button class="btn filter-btn" data-name="Basketball">Basketball</button>
        <button class="btn filter-btn" data-name="Lifestyle">Lifestyle</button>
    </div>

    <!-- Breadcrumb Navigation -->
    <nav class="breadcrumb-container mt-4 text-center" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <i class="bi bi-1-circle-fill"></i> Select a product
            </li>
            <li class="breadcrumb-item">
                <i class="bi bi-2-circle"></i> Choose a Size
            </li>
            <li class="breadcrumb-item">
                <i class="bi bi-3-circle"></i> Checkout!
            </li>
        </ol>
    </nav>

    <!-- Product Grid -->
    <div class="row">
        @if(Session::has('loginId') && $addr)
        <input type="text" name="addr" value="{{ $addr->id }}" hidden>

        @foreach($products as $product)
        <div class="col-6 col-lg-3 col-md-4 col-sm-6 filterable_card mt-5 text-center" data-name="{{ $product->productCategory }}">
            <a href="{{ route('product', ['productName' => $product->productName]) }}" class="product-link">
                <div class="card product-card">
                    <div class="card-body">
                        <img src="{{ asset($product->productSecond) }}" alt="{{ $product->productName }}" class="card-img-top">
                        <h5 class="card-title mt-3">{{ $product->productName }}</h5>
                        <form action="{{ route('favorites') }}" method="POST" class="favorite-form">
                            @csrf
                            <button type="submit" class="favoriteButton">
                                @if(in_array($product->id, $fav))
                                <i class="bi bi-heart-fill" style="color: #FF8A8A;"></i>
                                @else
                                <i class="bi bi-heart"></i>
                                @endif
                            </button>
                            <input type="hidden" name="userId" value="{{ Session::get('user.id') }}">
                            <input type="hidden" name="productId" value="{{ $product->id }}">
                        </form>
                        <h6 class="card-subtitle text-muted">{{ $product->productCategory }} Shoes</h6>
                        <p class="card-text">₱ {{ number_format($product->productPrice) }}</p>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
        @endif
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginModalLabel">Set Your Address</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Please set your address first to continue!</p>
                <div class="d-flex justify-content-center">
                    <a href="../collection" class="btn btn-secondary mx-2">Back</a>
                    <a href="../account" class="btn btn-success mx-2">Continue</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const filterButtons = document.querySelectorAll(".filter-btn");
    const filterableCards = document.querySelectorAll(".filterable_card");

    filterButtons.forEach(button => button.addEventListener("click", (e) => {
        filterButtons.forEach(btn => btn.classList.remove("active"));
        e.target.classList.add("active");

        const filter = e.target.dataset.name;

        filterableCards.forEach(card => {
            if (filter === "all" || card.dataset.name === filter) {
                card.classList.remove("d-none");
            } else {
                card.classList.add("d-none");
            }
        });
    }));
</script>



<style>
/* General Styling */
body {
    font-family: 'Roboto', sans-serif;
    background-color: #f8f9fa;
}

a{
    text-decoration: none;
}

/* Filter Buttons */
.filter-btn {
    margin: 0 5px;
    border-radius: 20px;
    padding: 10px 20px;
    background-color: #007bff;
    color: black;
    border: none;
    transition: background-color 0.3s;
}

.filter-btn.active,
.filter-btn:hover {
    background-color: #0056b3;
    color: white;
}

/* Breadcrumb Styling */
.breadcrumb-container .breadcrumb {
    display: inline-flex;
    justify-content: center;
    background: none;
    padding: 0;
}

.breadcrumb li {
    font-size: 1rem;
    color: #6c757d;
}

/* Card Styling */
.product-card {
        border: none;
        transition: all 0.3s ease;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        height: 100%;
        /* Match card height */
        min-height: 220px;
        overflow: hidden;
    }

.product-card:hover {
    transform: scale(1.05);
    box-shadow: 0 8px 12px rgba(0, 0, 0, 0.2);
}

.card-img-top {
    max-height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.product-card:hover .card-img-top {
    transform: scale(1.1);
}

/* Favorite Button */
.favoriteButton {
    position: absolute;
    top: 10px;
    right: 10px;
    background: transparent;
    border: none;
    font-size: 1.2rem;
    cursor: pointer;
    transition: color 0.3s ease;
}

.favoriteButton:hover i {
    color: red;
}

/* Modal Styling */
.modal-content {
    border-radius: 15px;
    padding: 20px;
}

.modal-header {
    border-bottom: none;
}

.modal-body {
    text-align: center;
}
</style>


@endsection