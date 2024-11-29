@extends('main')

@section('cart')

<script src="https://www.paypal.com/sdk/js?client-id=AcK0OKNydJhucW11-HfccF96OB6OVLxw67irncl3czo0ylrSpiTBMMA_W7ZV7tIGwFFTNdB0bs1iIgiF"></script>

@if ($carts->isEmpty())
<div></div>
@else
<nav style="--bs-breadcrumb-divider: '>'; display: flex; justify-content: center; align-items:center; margin-top:1rem;" aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="../collection" class="ahover"><i class="bi bi-1-circle-fill"> Select a product</i></a></li>
        <li class="breadcrumb-item active"><i class="bi bi-2-circle-fill" style="color: #72BF78;"> Choose a Size</i></li>
        <li class="breadcrumb-item active"><i class="bi bi-3-circle-fill"> Checkout!</i></li>
    </ol>
</nav>
@endif
<div class="container productBox mt-3 mb-3">

    @if (Session::has('removed'))
    <div class="alert alert-danger">
        {{ Session::get('removed') }}
    </div>

    @elseif ($carts->isEmpty())
    <div class="alert alert-warning" role="alert">
        You don't have products to check out.
    </div>
    @else
    <form action="{{ route('checkout') }}" method="post" enctype="multipart/form-data" onsubmit="handleFormSubmit(event)">
        @csrf
        <div class="row m-3">

            <div class="col-md-7 col-lg-7">

                <h2>Please fillup your Information</h2>

                <label for="">How would you like to get your order?</label>
                <select class="form-select" name="receiveMethod" aria-label="Default select example" onchange="showDeliveryMethod(this)">
                    <option selected>Options...</option>
                    <option value="Pickup">Pickup</option>
                    <option value="Delivery">Delivery</option>
                </select>

                <hr>

                <div class="d-flex mb-0 mt-4" style="gap: 1rem;">
                    <!-- Delivery Address (associated with cart) -->
                    <div class="row">

                        <div class="col-12 col-sm-12 col-md-6 col-lg-6">

                            <label><strong>Delivery Address</strong></label>
                            @if ($carts->isEmpty())
                            <p>No items in the cart.</p>
                            @else
                            <!-- Display the address of the first cart item (or any cart item) -->
                            @php
                            $firstCart = $carts->first(); // Get the first cart item
                            $address = $firstCart->address; // Get the address associated with the first cart item
                            @endphp

                            @if ($address)
                            <div class="card mb-3" style="width: 18rem;">
                                <div class="card-body">
                                    <input type="text" name="addressId" value="{{ $address->id }}" hidden>
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <h5 class="card-title mb-0">{{ $address->name }}</h5>
                                        <a href="" data-bs-toggle="modal" data-bs-target="#addressModal">Edit</a>
                                    </div>
                                    <h6 class="card-subtitle mb-2 text-body-secondary">{{ $address->contact }}</h6>
                                    <p class="card-text">
                                        {{ $address->details }}, <br>
                                        {{ $address->region->region_name }}, {{ $address->province->province_name }},
                                        {{ $address->municipality->municipality_name }}, {{ $address->barangay->barangay_name }}
                                    </p>
                                </div>
                            </div>
                            @else
                            <p>No address selected for this cart item.</p>
                            @endif
                            @endif
                        </div>


                        <!-- Billing Address (can be same as delivery address, but displayed only once) -->
                        <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                            <label><strong>Billing Address</strong></label>
                            @if ($carts->isEmpty())
                            <p>No items in the cart.</p>
                            @else
                            <!-- You can reuse the same address as for the Delivery address -->
                            @if ($address)
                            <div class="card mb-3" style="width: 18rem;">
                                <div class="card-body">
                                    <input type="text" name="addressId" value="{{ $address->id }}" hidden>
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <h5 class="card-title mb-0">{{ $address->name }}</h5>
                                    </div>
                                    <h6 class="card-subtitle mb-2 text-body-secondary">{{ $address->contact }}</h6>
                                    <p class="card-text">
                                        {{ $address->details }}, <br>
                                        {{ $address->region->region_name }}, {{ $address->province->province_name }},
                                        {{ $address->municipality->municipality_name }}, {{ $address->barangay->barangay_name }}
                                    </p>
                                </div>
                            </div>
                            @else
                            <p>No address selected for this cart item.</p>
                            @endif
                            @endif
                        </div>
                    </div>
                </div>




                <hr>

                <div id="deliveryOption" style="display: none;">

                    <div class="d-flex mb-0" style="gap: 1rem;">
                        <label><strong>Delivery Method</strong></label>
                    </div>
                    <select class="form-select" name="deliveryMethod" aria-label="Default select example">
                        <option selected value="None">Choose Delivery Method...</option>
                        <option value="JnT">JnT</option>
                        <option value="LBC">LBC</option>
                        <option value="Lalamove">Lalamove</option>
                    </select>
                    <hr>
                </div>




                <label for=""><strong>Payment Method</strong></label>
                <select id="paymentType" name="paymentType" class="form-select" onchange="showPaymentOptions(this)">
                    <option value="" selected disabled>Choose Payment Method</option>
                    <option value="cod">Cash on delivery</option>
                    <option value="gcash">Gcash</option>
                    <option value="paypal">PayPal</option>
                </select>


                <!-- if gcash is selected, display additional options -->
                <div id="gcashOption" style="display: none;">
                    <p class="mt-2">Details</p>
                    <input class="form-control mb-2" type="text" value="Name:    Charles Dee" disabled>
                    <input class="form-control" type="text" value="Number:  09516637462" disabled>
                    <label class="form-label mt-2" for="form2Example17">Please Provide a screenshot</label>
                    <input class="form-control" name="paymentImage" type="file" id="photo">
                    <p class="text-center" style="color: red;">Note!! Proven fake can lead to cancellation of orders!!</p>
                </div>
            </div>

            <div class="col-12 col-sm-12 col-md-5 col-lg-5 right">
                <h2>Order Summary</h2>
                @php
                $total = 0; // Variable to store the running total
                @endphp

                @foreach ($carts as $cart)
                @if($cart->product)
                <div class="row m-3">
                    <div class="col-12">
                        <div class="boxbox d-flex align-items-center">
                            <img class="cartImage" src="{{ asset($cart->product->productSecond) }}" alt="{{ $cart->product->productName }}" style="max-width: 200px; margin-right: 20px;">

                            <div>
                                <input type="hidden" name="products[{{ $loop->index }}][productId]" value="{{$cart->productId}}">
                                <div class="d-flex">

                                    <h2 class="mb-0">{{ $cart->product->productName }}</h2>

                                    <form action="{{ route('removeCart') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="cartId" value="{{ $cart->id }}">
                                        <button type="submit"><i class="bi bi-trash"></i></button>
                                    </form>

                                </div>
                                <small class="text-body-secondary" style="font-style: italic;">{{ $cart->product->productCategory }} Shoes</small>
                                <p>Price: {{ $cart->price }}</p>

                                <div class="d-flex mb-0" style="gap: 1rem;">
                                    <p>Quantity: {{ $cart->quantity }}</p>
                                    <p>Size: {{ $cart->size }} </p>
                                    <input type="text" name="products[{{ $loop->index }}][size]" value="{{ $cart->size }}" hidden>
                                    <input type="number" name="products[{{ $loop->index }}][quantity]" value="{{ $cart->quantity }}" min="1" hidden>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @php
                // Calculate and add the subtotal for this product to the running total
                $subtotal = $cart->product->productPrice * $cart->quantity;
                $total += $subtotal; // Add to the running total
                @endphp
                @endif
                @endforeach

                <!-- Display the final total outside of the loop -->
                <div class="d-flex mb-0" style="gap: 6.2rem;">
                    <p><strong>Subtotal:</strong></p>
                    <p>P {{ $total }}</p>
                </div>

                <div class="d-flex mb-0" style="gap: 4.7rem;">
                    <p><strong>Delivery Fee:</strong></p>
                    <p>The delivery fee will be paid upon delivery.</p>
                </div>

                <hr>

                <div class="d-flex mb-0" style="gap: 3rem;">
                    <p><strong>Total of all items:</strong></p>
                    <p>P {{ $total }}</p>
                </div>


                <button id="submit-button" type="submit" class="submitButton">Proceed to checkout <i class="bi bi-arrow-right"></i></button>
                <div id="paypal-button-container" style="display: none;"></div>

            </div>

        </div>


    </form>

    <div class="modal fade" id="addressModal" tabindex="-1" aria-labelledby="addressModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addressModalLabel">Select a New Address</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('changeAddr') }}" method="POST">
                        @csrf
                        <select name="addressId" class="form-select" required>
                            @foreach ($addresses as $addr)
                            <option value="{{ $addr->id }}">{{ $addr->name }} ({{ $addr->details }})</option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-primary mt-3">Select Address</button>
                    </form>


                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="orderSuccessModal" tabindex="-1" aria-labelledby="orderSuccessLabel" aria-hidden="true"
        data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow-lg" style="border-radius: 15px;">
                <div class="modal-header border-0">
                    <h5 class="modal-title text-center w-100" id="orderSuccessLabel">🎉 Order Placed Successfully!</h5>
                </div>
                <div class="modal-body text-center">
                    <p class="fs-5">Thank you for your order! Your order has been placed successfully.</p>
                    <p class="text-muted">Visit your account to check the status of your order.</p>
                    <i class="bi bi-check-circle-fill text-success fs-1"></i>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-primary w-100" data-bs-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>



    @endif
</div>

<style>
    body.modal-active {
        backdrop-filter: blur(8px);
        overflow: hidden;
    }

    .modal-content {
        transform: scale(0.8);
        opacity: 0;
        transition: transform 0.3s ease-out, opacity 0.3s ease-out;
    }

    .modal.fade.show .modal-content {
        transform: scale(1);
        opacity: 1;
    }

    .modal-content {
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    }


    .submitButton {
        width: 100%;
        padding: 10px;
        background-color: #373A40;
        color: white;
        border-radius: 10px;
    }

    .boxbox {
        box-shadow: 0 0 10px gray;
    }

    .productBox {
        box-shadow: 0 0 10px gray;
        opacity: 100%;
        border-radius: 1%;
        padding: 10px;
    }

    .ahover {
        text-decoration: none;
        color: #72BF78;
    }

    .ahover:hover {
        color: #347928;
        transition: 1s ease;
    }

    .cartImage {
        width: 150px;
        height: 150px;
    }

    hr {
        border: none;
        /* Remove default border */
        border-top: 2px dotted gray;
        /* Add a dotted top border */
        height: 0;
        /* Set the height to 0 to ensure only the border appears */
    }
</style>

<script>
    function showGcashOption(select) {
        var option = select.value;
        var gcashOption = document.getElementById("gcashOption");
        if (option === "gcash") {
            gcashOption.style.display = "block";
        } else {
            gcashOption.style.display = "none";
        }
    }

    function showDeliveryMethod(select) {
        var option = select.value;
        var gcashOption = document.getElementById("deliveryOption");
        if (option === "Delivery") {
            gcashOption.style.display = "block";
        } else {
            gcashOption.style.display = "none";
        }
    }

    function showPaymentOptions(select) {
        var option = select.value;
        var gcashOption = document.getElementById("gcashOption");
        var paypalButtonContainer = document.getElementById("paypal-button-container");
        var submitButton = document.getElementById("submit-button"); // Get the submit button

        // Show or hide Gcash options and PayPal button
        if (option === "gcash") {
            gcashOption.style.display = "block"; // Show Gcash options
            paypalButtonContainer.style.display = "none"; // Hide PayPal button
            submitButton.style.display = "block"; // Show submit button
        } else if (option === "paypal") {
            gcashOption.style.display = "none"; // Hide Gcash options
            paypalButtonContainer.style.display = "block"; // Show PayPal button
            submitButton.style.display = "none"; // Hide submit button
        } else {
            gcashOption.style.display = "none"; // Hide Gcash options
            paypalButtonContainer.style.display = "none"; // Hide PayPal button
            submitButton.style.display = "block"; // Show submit button
        }
    }

    paypal.Buttons({
        createOrder: function(data, actions) {
            return actions.order.create({
                purchase_units: [{
                    amount: {
                        value: '1.00' // Set the amount to 1.00 regardless of the original price
                    }
                }]
            });
        },
        onApprove: function(data, actions) {
            return actions.order.capture().then(function(details) {
                // Automatically submit the form after payment is successful
                document.querySelector('form').submit(); // Submit the form
            });
        },
        onError: function(err) {
            console.error(err);
        }
    }).render('#paypal-button-container'); // Display the PayPal button

    function handleFormSubmit(event) {
        event.preventDefault(); // Prevent immediate submission to show modal

        // Show the success modal
        const successModal = new bootstrap.Modal(document.getElementById('orderSuccessModal'), {
            keyboard: false
        });

        successModal.show();

        // Automatically submit the form after the modal is dismissed
        const modalElement = document.getElementById('orderSuccessModal');
        modalElement.addEventListener('hidden.bs.modal', () => {
            // Submit the form programmatically
            event.target.submit();
        });

        // Add background blur
        document.body.classList.add('modal-active');

        // Remove blur when the modal is hidden
        modalElement.addEventListener('hidden.bs.modal', () => {
            document.body.classList.remove('modal-active');
        });
    }
</script>
@endsection