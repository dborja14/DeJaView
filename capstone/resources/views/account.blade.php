@extends('main')

@section('account')

@if(Session::has('loginId'))


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<div class="container">

    <div class="row m-5">
        <div class="col-12 p-4 d-flex align-items-center justify-content-between head">
            <div>
                <img src="storage/Images/updatedLogo.png" alt="" class="sneakerhead">
                <span> Welcome Back, {{ Session::get('user.name') }}!</span>
            </div>
            @if($topBuyer && Session::get('user.id') == $topBuyer->id)
            <div class="top-buyer-container">
                <img src="../storage/Images/Badge.png" alt="" class="top-buyer-badge">
                <span class="tooltip-text">Top Buyer</span>
            </div>
            @endif
        </div>
    </div>



    @if (Session::has('success'))
    <div class="alert alert-success">
        {{ Session::get('success') }}
    </div>
    @endif

    @if (Session::has('error'))
    <div class="alert alert-danger">
        {{ Session::get('error') }}
    </div>
    @endif

    <div class="row">

        <div class="col-12 d-flex justify-content-center align-items-center">
            <div class="filter_buttons d-flex flex-wrap justify-content-center align-items-center">
                <button data-name="profile"><i class="bi bi-person-circle" style="color: #3C3D37;"></i></button>
                <button data-name="favorite"> <i class="bi bi-heart-fill" style="color:#FF6969;"></i></button>
                <button data-name="settings"><i class="bi bi-gear-wide-connected" style="color:#3C3D37;"></i></button>
            </div>
        </div>
    </div>

    <div class="row m-5">

        <div class="col-12 col-lg-12 col-md-12 col-sm-12 p-5 filterable_card" data-name="profile">


            <div class="col-12 d-flex justify-content-center align-items-center">
                <div class="loob_buttons d-flex flex-wrap justify-content-center">
                    <button data-name="Delivered">To be Delivered</button>
                    <button data-name="Received">Items Received</button>
                </div>
            </div>

            <hr>

            <div class="col-12 col-lg-12 col-md-12 col-sm-12 loob_cards" data-name="Delivered">

                @forelse($orderSummary['pendingOrder'] as $orders)

                <div class="col-12 p-3">
                    <!-- Display the delivery status only once -->
                    <div class="d-flex flex-column col-12">

                        <div class="d-flex" style="margin-left: auto;">
                            <p>Status: {{$orders->first()->deliveryStatus}}</p>
                        </div>

                        @foreach ($orders as $order)
                        @if($order->orderStatus == "Pending")
                        <div class="d-flex" style="margin-bottom: 20px;">
                            <!-- Product Thumbnail -->
                            <img src="{{ asset($order->product->productThumbnail) }}" alt="" width="100px" height="100px" style="margin-right: 20px;">

                            <!-- Product Information -->
                            <div class="d-flex flex-column">
                                <!-- Product Name and Description -->
                                <p style="font-size: medium; font-weight: bold; margin-bottom: 0;">
                                    {{$order->product->productName}}
                                    <small style="font-style: italic; color: gray; font-weight: normal;">
                                        {{$order->product->productDescription}}
                                    </small>
                                </p>

                                <!-- Quantity -->
                                <div class="d-flex">
                                    <p>Quantity: {{$order->quantity}}</p>
                                </div>

                                <!-- Size -->
                                <div class="d-flex">
                                    <p>Size: {{$order->size}}</p>
                                </div>
                            </div>
                        </div>
                        @endif
                        @endforeach
                    </div>
                    <hr>
                    <div class="d-flex justify-content-end">
                        <p>To be Paid: ₱ {{$orders->first()->totalPrice}}</p>
                    </div>
                </div>
                <hr>

                @empty
                <p style="text-align: center; font-size:large; margin-top:3rem;">You don't have orders yet</p>
                @endforelse
            </div>




            <div class="col-12 col-lg-12 col-md-12 col-sm-12 loob_cards" data-name="Received">
                @forelse($orderSummary['receivedOrder'] as $orders)

                <div class="col-12 p-3">
                    <!-- Display the delivery status only once -->
                    <div class="d-flex flex-column col-12">

                        <div class="d-flex" style="margin-left: auto;">
                            <p>Status: {{$orders->first()->deliveryStatus}}</p>
                        </div>

                        @foreach ($orders as $order)
                        @if($order->orderStatus == "Received")
                        <div class="d-flex" style="margin-bottom: 20px;">
                            <!-- Product Thumbnail -->
                            <img src="{{ asset($order->product->productThumbnail) }}" alt="" width="100px" height="100px" style="margin-right: 20px;">

                            <!-- Product Information -->
                            <div class="d-flex flex-column">
                                <!-- Product Name and Description -->
                                <p style="font-size: medium; font-weight: bold; margin-bottom: 0;">
                                    {{$order->product->productName}}
                                    <small style="font-style: italic; color: gray; font-weight: normal;">
                                        {{$order->product->productDescription}}
                                    </small>
                                </p>

                                <!-- Quantity -->
                                <div class="d-flex">
                                    <p>Quantity: {{$order->quantity}}</p>
                                </div>

                                <!-- Size -->
                                <div class="d-flex">
                                    <p>Size: {{$order->size}}</p>
                                </div>
                            </div>
                        </div>
                        @endif
                        @endforeach
                    </div>
                    <hr>
                </div>


                @empty
                <p style="text-align: center; font-size:large; margin-top:3rem;">You don't have orders yet</p>
                @endforelse



            </div>



        </div>

        <div class="col-12 col-lg-12 col-md-12 col-sm-12 p-5 filterable_card" data-name="favorite">
            @if(!empty($fav))
            <ul>
                <div class="row">
                    @foreach($fav as $productId)
                    @php
                    $product = \App\Models\Product::find($productId);
                    @endphp
                    @if($product)
                    <div class="col-12 col-sm-12 col-md-4 col-lg-3 mt-3 text-center">
                        <a href="{{ route('product', ['productName' => $product->productName]) }}" style="text-decoration:none;">
                            <div class="card" style="width: 100%; max-width: 18rem; position: relative;">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12 col-sm-12 col-md-12 col-lg-12">



                                            <form action="{{ route('favorites') }}" method="POST">
                                                @csrf
                                                <button type="submit" class="favoriteButton" style="float:right; margin-bottom:1rem;">
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
                                        </div>
                                    </div>
                                    <img src="{{ asset($product->productSecond) }}" alt="" style="width:100%;max-width:200px; height:200px">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <h5 class="card-title mt-3">{{$product->productName}}</h5>
                                    </div>
                                    <h6 class="card-subtitle mb-2 text-body-secondary">{{$product->productCategory}} Shoes</h6>
                                    <p class="card-text">For as low as ₱ {{ number_format($product->productPrice) }}</p>
                                </div>
                            </div>
                        </a>

                    </div>



                    @endif
                    @endforeach
                </div>
            </ul>
            @else
            <p>Nothing to see here.</p>
            @endif
        </div>

        <div class="col-12 col-lg-12 col-md-12 col-sm-12 p-5 filterable_card" data-name="settings">
            <!-- settings content here -->
            <h3>Account Information
                <hr>
            </h3>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-10 col-sm-10 col-md-8 col-lg-6 account">
                        <!-- Username -->
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="row w-100">
                                <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                                    <label class="w-25">Username:</label>
                                </div>

                                <div class="col-12 col-sm-12 col-md-6 col-lg-6 d-flex align-items-center">
                                    <input type="text" value="{{ Session::get('user.name') }}" class="form-control w-100" disabled>
                                    <button class="btn btn-primary ms-2" data-bs-toggle="modal" data-bs-target="#user">Edit</button>
                                </div>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="row w-100">
                                <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                                    <label class="w-25">Email:</label>
                                </div>

                                <div class="col-12 col-sm-12 col-md-6 col-lg-6 d-flex align-items-center">
                                    <input type="email" value="{{ Session::get('user.email') }}" class="form-control w-100" disabled>
                                    <button class="disabled btn btn-outline-secondary ms-2" disabled>Edit</button>
                                </div>
                            </div>
                        </div>

                        <!-- Password -->
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="row w-100">
                                <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                                    <label class="w-25">Password:</label>
                                </div>

                                <div class="col-12 col-sm-12 col-md-6 col-lg-6 d-flex align-items-center">
                                    <input type="password" class="form-control w-100" placeholder="••••••••" disabled>
                                    <button class="btn btn-primary ms-2" data-bs-toggle="modal" data-bs-target="#password">Edit</button>
                                </div>
                            </div>
                        </div>

                        <!-- Security Question -->
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="row w-100">
                                <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                                    <label class="w-25">Security Question:</label>
                                </div>

                                <div class="col-12 col-sm-12 col-md-6 col-lg-6 d-flex align-items-center">
                                    <input type="text" value="{{ Session::get('user.security_question') }}" class="form-control w-100" disabled>
                                    <button class="disabled btn btn-outline-secondary ms-2" disabled>Edit</button>
                                </div>
                            </div>
                        </div>

                        <!-- Security Answer -->
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="row w-100">
                                <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                                    <label class="w-25">Security Answer:</label>
                                </div>

                                <div class="col-12 col-sm-12 col-md-6 col-lg-6 d-flex align-items-center">
                                    <input type="text" value="{{ Session::get('user.security_answer') }}" class="form-control w-100" disabled>
                                    <button class="disabled btn btn-outline-secondary ms-2" disabled>Edit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Change Username Modal -->
                <div class="modal fade" id="user" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Change Username</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <label for="Old Username"> Current Username</label>
                                <input type="text" value="{{ Session::get('user.name') }}" class="form-control mb-3" disabled>

                                <label for="Old Username"> New Username</label>
                                <form action="{{ route('updateAccount') }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <input type="text" name="id" value="{{ Session::get('user.id') }}" hidden>
                                    <input type="text" placeholder="Emmorz" name="name" class="form-control mb-3">
                                    <button type="submit" class="btn btn-success" data-bs-dismiss="modal" style="float: right;">Save Changes</button>
                                    <button type="button" class="btn btn-secondary" style="float: right; margin-right:5px">Close</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Change Password Modal -->
                <div class="modal fade" id="password" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Change Password</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('changePass') }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <input type="text" name="id" value="{{ Session::get('user.id') }}" hidden>
                                    <label for="CurrentPass"> Current Password</label>
                                    <input type="password" name="current" class="form-control mb-3">

                                    <label for="NewPass"> New Passowrd</label>
                                    <input type="password" name="newPass" class="form-control mb-3">

                                    <label for="PassConfirmation"> Confirm Password</label>
                                    <input type="password" name="newPassConfirmation" class="form-control mb-3" />

                                    <button type="submit" class="btn btn-success" data-bs-dismiss="modal" style="float: right;">Save Changes</button>
                                    <button type="button" class="btn btn-secondary" style="float: right; margin-right:5px">Close</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="d-flex align-items-center justify-content-between">
                <h3>Address Information</h3>
                <button class="btn btn-success" type="button" data-bs-toggle="modal" data-bs-target="#address">+ Add New Address</button>
            </div>
            <hr>

            <div class="modal fade" id="address" tabindex="-1" aria-labelledby="regionModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                        <form action="{{ route('add') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <div class="container">
                                <h4 class="card-title">Add New Address</h2>
                                <hr>
                                    <div class="row">

                                        <div class="col-6 mb-3">
                                            <label for="name"> Full Name</label>
                                            <input type="text" name="name" class="form-control">
                                        </div>

                                        <div class="col-6 mb-3">
                                            <label for="contact"> Contact Number</label>
                                            <input type="number" name="contact" class="form-control">
                                        </div>

                                        <div class="col-12 mb-3">
                                            <label for="contact"> Address</label>
                                            <input type="text" name="details" class="form-control">
                                        </div>


                                        <div class="col-12 mb-3">
                                            <label for="region">Region</label>
                                            <select id="region" name="region" class="form-control" required>
                                                <option value="">Select Region</option>
                                                @foreach($regions as $region)
                                                <option value="{{ $region->region_id }}">{{ $region->region_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-12 mb-3">
                                            <label for="province">Province</label>
                                            <select id="province" name="province" class="form-control" required>
                                                <option value="">Select Province</option>
                                            </select>
                                        </div>

                                        <div class="col-12 mb-3">
                                            <label for="Municipality">Municipality</label>
                                            <select id="municipality" name="municipality" class="form-control" required>
                                                <option value="">Select Municipality</option>
                                            </select>
                                        </div>

                                        <div class="col-12 mb-3">
                                            <label for="Barangay">Barangay</label>
                                            <select id="barangay" name="barangay" class="form-control" required>
                                                <option value="">Select Barangay</option>
                                            </select>
                                        </div>



                                        <div class="col-12">
                                            <button type="submit" class="btn btn-success float-end">Save Changes</button>
                                            <button type="button" class="btn btn-secondary float-end me-2" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


            <div class="container">

                <div class="row">

                    @if($address->isEmpty())
                    <div class="card d-flex justify-content-center align-items-center" style="width: 18rem; opacity:0.5">
                        <div class="card-body">
                            <h5 class="card-title">You don't have any addresses yet.</h5>
                        </div>
                    </div>
                    @else

                    @foreach($address as $addressItem)
                    <div class="col-12 col-sm-12 col-md-6 col-lg-4">
                        <div class="card mt-3" style="width: 100%; max-width: 18rem;">
                            <div class="card-body">
                                <h5 class="card-title">{{ $addressItem->name }}</h5>
                                <h6 class="card-subtitle mb-2 text-body-secondary">{{ $addressItem->contact }}</h6>

                                <p class="card-text">
                                    {{$addressItem->details}}
                                </p>
                                <p class="card-text">
                                    {{ $addressItem->region->region_name }}, {{ $addressItem->province->province_name }},
                                    {{ $addressItem->municipality->municipality_name }}, {{ $addressItem->barangay->barangay_name }}
                                </p>
                            </div>
                        </div>
                    </div>

                    @endforeach
                    @endif

                </div>

            </div>


        </div>

    </div>


</div>

@endif

<style>
    .loob_buttons {
        display: flex;
        justify-content: center;
        gap: 10px;
    }

    .loob_buttons button {
        border: transparent;
        background-color: transparent;
        width: auto;
        padding: 10px 100px;
        text-align: center;
    }

    .account button {
        border: none;
        background-color: transparent;
        color: blue;
        text-decoration: underline;
    }

    .form-controll {
        border-radius: 5px;
        border: 1px gray;
        background-color: transparent;
    }

    .account button.disabled {
        color: gray;
        text-decoration: none;
    }

    .sneakerhead {
        width: 150px;
        height: 150px;
        position: relative;
        border-radius: 50%;
        margin-right: 10px;
    }

    .filterable_card {
        border: 1px solid black;
        border-radius: 15px;
        box-shadow: 0 0 10px gray;
    }

    .favoriteButton {
        border: none;
        background-color: transparent;
    }

    .head {
        border: 1px solid black;
        border-radius: 15px;
        box-shadow: 0 0 10px gray;
        background-color: #E8E8E8;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    span {
        font-size: large;
        margin: 5px;
    }

    .filter_buttons button {
        width: 10rem;
        border: none;
        transition: background-color 0.3s ease, color 0.3s ease, border 0.3s ease, box-shadow 0.3s ease;
    }

    .filter_buttons i {
        font-size: 30px;
    }


    .filter_buttons {
        gap: 2rem;
    }

    .card {
        box-shadow: 0 0 10px gray;
    }

    .top-buyer-container {
        position: relative;
        display: inline-block;
    }

    .top-buyer-badge {
        width: 80px;
        height: 80px;
    }

    /* Tooltip text styling */
    .tooltip-text {
        visibility: hidden;
        width: 100px;
        background-color: #EEE2B5;
        color: black;
        text-align: center;
        border-radius: 5px;
        padding: 5px 0;
        position: absolute;
        top: 100%;
        left: 50%;
        transform: translateX(-50%);
        margin-bottom: 10px;
        opacity: 0;
        transition: opacity 0.3s;
    }

    /* Show the tooltip on hover */
    .top-buyer-container:hover .tooltip-text {
        visibility: visible;
        opacity: 1;
    }
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).on('change', '#region', function() {
        let regionId = $(this).val();
        let provinceDropdown = $('#province');

        provinceDropdown.empty().append('<option value="">Select Province</option>');
        $('#municipality').empty().append('<option value="">Select Municipality</option>');
        $('#barangay').empty().append('<option value="">Select Barangay</option>');

        if (regionId) {
            $.ajax({
                url: "{{ route('get.provinces', '') }}/" + regionId,
                type: "GET",
                success: function(data) {
                    if (data && data.length > 0) {
                        $.each(data, function(index, value) {
                            provinceDropdown.append('<option value="' + value.province_id + '">' + value.province_name + '</option>');
                        });
                    }
                },
                error: function(xhr) {
                    console.error('AJAX Error:', xhr.responseText);
                }
            });
        }
    });

    // When Province changes
    $(document).on('change', '#province', function() {
        let provinceId = $(this).val();
        let municipalityDropdown = $('#municipality');

        municipalityDropdown.empty().append('<option value="">Select Municipality</option>'); // Reset dropdown
        $('#barangay').empty().append('<option value="">Select Barangay</option>'); // Reset Barangay dropdown

        if (provinceId) {
            $.ajax({
                url: "{{ route('get.municipalities', '') }}/" + provinceId, // Pass provinceId dynamically
                type: "GET",
                success: function(data) {
                    if (data && data.length > 0) {
                        $.each(data, function(index, value) {
                            municipalityDropdown.append('<option value="' + value.municipality_id + '">' + value.municipality_name + '</option>');
                        });
                    }
                },
                error: function(xhr) {
                    console.error('AJAX Error:', xhr.responseText);
                }
            });
        }
    });

    // When Municipality changes
    $(document).on('change', '#municipality', function() {
        let municipalityId = $(this).val();
        let barangayDropdown = $('#barangay');

        barangayDropdown.empty().append('<option value="">Select Barangay</option>'); // Reset dropdown

        if (municipalityId) {
            $.ajax({
                url: "{{ route('get.barangays', '') }}/" + municipalityId, // Pass municipalityId dynamically
                type: "GET",
                success: function(data) {
                    if (data && data.length > 0) {
                        $.each(data, function(index, value) {
                            barangayDropdown.append('<option value="' + value.barangay_id + '">' + value.barangay_name + '</option>');
                        });
                    }
                },
                error: function(xhr) {
                    console.error('AJAX Error:', xhr.responseText);
                }
            });
        }
    });
</script>



<script>
    document.addEventListener("DOMContentLoaded", function() {
        // kung ano maglload kapag nirefresh ung page, parang auto clicker ba
        document.querySelector(".filter_buttons button[data-name='profile']").click();
    });

    document.addEventListener("DOMContentLoaded", function() {
        // kung ano maglload kapag nirefresh ung page, parang auto clicker ba
        document.querySelector(".loob_buttons button[data-name='Delivered']").click();
    });

    const filterButtonsContainer = document.querySelector(".filter_buttons");
    const filterableCards = document.querySelectorAll(".filterable_card");

    // Function to handle filtering
    const filterCards = cards => {
        const target = cards.target.closest('button');

        if (!target) return;

        // Remove 'active' class from all buttons and reset styles
        filterButtonsContainer.querySelectorAll('button').forEach(button => {
            button.classList.remove("active");
            button.style.backgroundColor = "transparent";
            button.style.color = "";
            button.style.border = "transparent";
            button.style.boxShadow = "none";
        });

        // Add 'active' class to the clicked button and set styles
        target.classList.add("active");
        target.style.backgroundColor = "#F8EDED";
        target.style.color = "black";
        target.style.border = "1px solid black";
        target.style.boxShadow = "0 0 10px gray";

        // Show or hide cards based on the button clicked
        const filterValue = target.dataset.name;
        filterableCards.forEach(card => {
            if (card.dataset.name === filterValue || filterValue === "all") {
                card.classList.remove("d-none");
            } else {
                card.classList.add("d-none");
            }
        });
    };

    // Add click event listener to the container that holds filter buttons
    filterButtonsContainer.addEventListener("click", filterCards);

    //end 

    // Loob to ng account
    // Select the button container and all content sections (loob_cards)
    const containerLoob = document.querySelector(".loob_buttons");
    const cardsLoob = document.querySelectorAll(".loob_cards");

    const filterMoLang = account => {
        // Get the closest button to the clicked target
        const target = account.target.closest('button');

        // If no button is clicked, exit function
        if (!target) return;

        // Reset all buttons' styles and remove 'active' class
        containerLoob.querySelectorAll('button').forEach(button => {
            button.classList.remove("active");
            button.style.backgroundColor = "transparent";
            button.style.color = ""; // Reset color
            button.style.border = "none"; // Remove any existing borders
            button.style.boxShadow = "none"; // Remove box shadow
        });

        // Add 'active' styles to the clicked button
        target.classList.add("active");
        target.style.color = "black";
        target.style.borderBottom = "1px solid black"; // Bottom border
        target.style.boxShadow = "0 0 10px gray"; // Add shadow

        // Get the 'data-name' attribute of the clicked button
        const filterValue = target.dataset.name;

        // Loop through all cards and display the one that matches the filter
        cardsLoob.forEach(card => {
            if (card.dataset.name === filterValue || filterValue === "all") {
                card.classList.remove("d-none"); // Show the card
            } else {
                card.classList.add("d-none"); // Hide other cards
            }
        });
    };

    // Attach the event listener to the container
    containerLoob.addEventListener("click", filterMoLang);
</script>




@endsection