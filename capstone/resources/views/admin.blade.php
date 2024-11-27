@include('layout.link')

@if (Session::has('success'))
<div class="alert alert-success">
    {{ Session::get('success') }}
</div>
@endif

<div class="row">

    <div class="d-lg-none position-fixed top-0 start-0 m-3" style="z-index: 1050;padding: 10px; background-color: transparent; cursor: pointer;">
        <!-- Offcanvas Toggle Button (Visible only on small screens) -->
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasResponsive" aria-controls="offcanvasResponsive">
            <span class="bi bi-list" style="font-size: 35px; color: black; margin-bottom:1rem;"></span>
        </button>
    </div>
    <!-- Offcanvas for smaller screens -->
    <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasResponsive" aria-labelledby="offcanvasResponsiveLabel">
        <div class="offcanvas-header">
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <ul class="navbar-nav">
                <p class="text-center">Admin Dashboard</p>

                <button data-name="dashboard">
                    <i class="bi bi-person" style="font-size:30px;"></i>
                    <p class="tasks">Dashboard</p>
                </button>
                <button data-name="inventory">
                    <i class="bi bi-backpack3" style="font-size:30px;"></i>
                    <p class="tasks">Inventory</p>
                </button>
                <button data-name="users">
                    <i class="bi bi-person" style="font-size:30px;"></i>
                    <p class="tasks">Users</p>
                </button>

                <button data-name="orders">
                    <i class="bi bi-box2" style="font-size:30px;"></i>
                    <p class="tasks">Manage Orders</p>
                    <span class="badge bg-danger rounded-pill">
                        {{ $pendingOrders > 0 ? $pendingOrders : '0' }} New orders
                    </span>
                </button>

                <button data-name="audit">
                    <i class="bi bi-file-earmark-person" style="font-size:30px;"></i>
                    <p class="tasks">Audit Log</p>
                </button>
            </ul>
        </div>
    </div>

    <!-- Sidebar (Visible on larger screens) -->
    <div class="col-3 d-none d-lg-block">
        <div class="offcanvas-body">
            <ul class="navbar-nav mt-5">
                <p class="text-center">Admin Dashboard</p>

                <button data-name="dashboard">
                    <i class="bi bi-person" style="font-size:30px; width:auto"></i>
                    <p class="tasks">Dashboard</p>
                </button>
                <button data-name="inventory">
                    <i class="bi bi-backpack3" style="font-size:30px;"></i>
                    <p class="tasks">Inventory</p>
                </button>
                <button data-name="users">
                    <i class="bi bi-person" style="font-size:30px;"></i>
                    <p class="tasks">Users</p>
                </button>

                <button data-name="orders">
                    <i class="bi bi-box2" style="font-size:30px;"></i>
                    <p class="tasks">Manage Orders</p>
                    <span class="badge bg-danger rounded-pill">
                        {{ $pendingOrders > 0 ? $pendingOrders : '0' }} New orders
                    </span>
                </button>

                <button data-name="audit">
                    <i class="bi bi-file-earmark-person" style="font-size:30px;"></i>
                    <p class="tasks">Audit Log</p>
                </button>
            </ul>
        </div>
    </div>

    <div class="col-12 col-sm-12 col-md-8 col-lg-9 bg" style="padding: 25px;">
        @if(Session::has('loginId'))
        <div class="row">
            <div class="col-12">
                <div class="d-none d-lg-block" style="position: fixed; right: 10; z-index: 1050;">
                    <!-- Normal layout for larger screens -->
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            {{ Session::get('user.name') }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('logoutAdmin') }}">Logout</a></li>
                            <li><a class="dropdown-item" href="{{ route('messages') }}">View Messages</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="d-none d-lg-block" style="position: fixed; top: 0; right: 0; z-index: 1050;">
            <a class="btn btn-outline-secondary" href="login">Login</a>
        </div>
        @endif

        <!-- For mobile devices, we want it to be always fixed on top -->
        <div class="d-block d-lg-none" style="position: fixed; right:30; z-index: 1050;">
            @if(Session::has('loginId'))
            <div class="dropdown">
                <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    {{ Session::get('user.name') }}
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="{{ route('logoutAdmin') }}">Logout</a></li>
                    <li><a class="dropdown-item" href="{{ route('messages') }}">View Messages</a></li>
                </ul>
            </div>
            @else
            <a class="btn btn-outline-secondary" href="login">Login</a>
            @endif
        </div>



        <div class="filterable_card" data-name="dashboard">
            <div class="container">
                <div class="row mt-5">
                    <div class="col-6 col-sm-6 col-md-4 col-lg-3">
                        <div class="card" style="width: 100%; max-height:100%; height:80%;">
                            <div class="card-body">
                                <h5 class="card-title">Shoes Available</h5>
                                <p class="card-text">{{$productCount}}</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-6 col-sm-6 col-md-4 col-lg-3">
                        <div class="card" style="width: 100%; max-height:100%; height:80%;">
                            <div class="card-body">
                                <h5 class="card-title">Monthly Sales</h5>
                                <p class="card-text">₱{{ number_format($monthlySales, 2) }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-6 col-sm-6 col-md-4 col-lg-3">
                        <div class="card" style="width: 100%; max-width: 100%; height:80%;">
                            <div class="card-body">
                                <h5 class="card-title">Users</h5>
                                <p class="card-text">{{$usersCount}}</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-6 col-sm-6 col-md-4 col-lg-3">
                        <div class="card" style="width: 100%; max-height:100%; height:80%;">
                            <div class="card-body">
                                <h5 class="card-title">Pending Orders</h5>
                                <p class="card-text">{{$pending}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="loadingIndicator" style="display: none;">Loading...</div>


            <div class="row mt-3">

                <div class="col-4 col-sm-4 col-md-3 col-lg-2">

                    <button class="view" onclick="fetchLineChartData('1 week')">1 Week</button>

                </div>

                <div class="col-4 col-sm-4 col-md-3 col-lg-2">
                    <button class="view" onclick="fetchLineChartData('1 month')">1 Month</button>

                </div>

                <div class="col-4 col-sm-4 col-md-3 col-lg-2">
                    <button class="view" onclick="fetchLineChartData('3 months')">3 Months</button>

                </div>

                <div class="col-4 col-sm-4 col-md-3 col-lg-2">
                    <button class="view" onclick="fetchLineChartData('6 months')">6 Months</button>

                </div>

                <div class="col-4 col-sm-4 col-md-3 col-lg-2">
                    <button class="view" onclick="fetchLineChartData('1 year')">1 Year</button>

                </div>

                <div class="col-4 col-sm-4 col-md-3 col-lg-2">

                    <button class="view" onclick="fetchLineChartData('Max')">Max</button>
                </div>


            </div>

            <div id="loadingIndicator" style="display: none;">Loading...</div>
            <canvas id="salesChart"></canvas>

            <div class="row mt-3">

                <button class="view" id="printChart" onclick="printChart()">Print Current Chart</button>
            </div>


            <div class="row mt-5">
                <div class="col-12 col-sm-12 col-md-6 col-lg-6" style="overflow-y: auto; max-height: 600px; box-shadow: 0 0 10px gray; border-radius:10px;">
                    <div style="position: sticky; top: 0; padding: 2rem; z-index: 10; background-color: #F1F1F1;">
                        <h2 style="text-align: center;">ANNOUNCEMENTS!</h2>
                        <hr>
                    </div>

                    <div>
                        @if(count($lowStockSizes) > 0) <!-- Check low stock sizes instead of announc -->
                        @foreach($lowStockSizes as $lowStock)

                        @if($lowStock['quantity'] <= 0)
                            <div class="alert alert-danger">
                            Warning: Only {{$lowStock['quantity']}} pair(s) left for size {{$lowStock['size']}} of {{$lowStock['productName']}}!
                    </div>

                    @else
                    <div class="alert alert-warning">
                        Warning: Only {{$lowStock['quantity']}} pair(s) left for size {{$lowStock['size']}} of {{$lowStock['productName']}}!
                    </div>
                    @endif
                    @endforeach
                    @else
                    <p>No low stock shoe sizes available.</p>
                    @endif
                </div>
            </div>

            <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                <canvas id="pieChart" width="300" height="50"></canvas>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                <h2 style="text-align: center;">Most Sold Shoes!</h2>
                @foreach($mostBoughtShoes as $shoes)
                <div class="boxBackground">
                    <div class="d-flex" style="gap: 1rem;">
                        <img src="{{ $shoes->productSecond }}" alt="{{ $shoes->productName }}" style="width: 100px; height: 100px;">

                        <div>
                            <p>{{ $shoes->productName }}</p>
                            <p>{{ $shoes->productDescription }}</p>

                            <div class="d-flex" style="gap: 1rem;">
                                <p>Price: </p>
                                <p>₱ {{ $shoes->productPrice }} </p>
                            </div>

                        </div>
                        <!-- Display the total quantity sold -->
                        <p style="justify-content: end; margin-left:0;">Sold Quantity: {{ $shoes->total_quantity }}</p>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                <h2 style="text-align: center;">Your top buyer</h2>

                @if($topBuyer)
                <div class="topBuyer">
                    <div class="boxBackground">
                        <div class="d-flex" style="gap: 1rem;">
                            <img src="../storage/Images/updatedLogo.png" alt="{{ $shoes->productName }}" style="width: 100px; height: 100px;">

                            <div class="w-100">
                                <p>{{ $topBuyer->name }}</p>
                                <p>{{ $topBuyer->email }}</p>

                                <div class="d-flex flex-column flex-sm-row" style="gap: 1rem;">
                                    <p class="mb-1 mb-sm-0">Member Since:</p>
                                    <p>{{ $memberSince }}</p>
                                </div>
                            </div>

                            <!-- Display the total quantity sold -->
                        </div>
                    </div>
                </div>
                @else
                <p>No buyers found.</p>
                @endif
            </div>
        </div>

        <div class="container">
            <h2>Sales Dashboard</h2>

            <!-- Comparison Per Month -->
            <div class="card mt-4">
                <div class="card-header">Monthly Sales Comparison of the Year</div>
                <div class="card-body">
                    <canvas id="comparisonChart"></canvas>
                    <div class="row">
                        <div class="d-block lg-block">
                            <p class="d-md-none" style="font-size: small;">We Recommend Viewing it on a larger resolution</p>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Peak and Off Months -->
            <div class="card mt-4">
                <div class="card-header">Peak and Off Months</div>
                <div class="card-body">
                    <p><strong>Peak Month:</strong> <span id="peakMonth"></span></p>
                    <p><strong>Off Month:</strong> <span id="offMonth"></span></p>
                </div>
            </div>

            <!-- Most Profitable Shoe Brand and Type -->
            <div class="card mt-4">
                <div class="card-header">Most Profitable Shoe Brand & Type</div>
                <div class="card-body">
                    <p><strong>Most Profitable Brand:</strong> <span id="profitableBrand"></span></p>
                    <p><strong>Most Profitable Type:</strong> <span id="profitableType"></span></p>
                </div>
            </div>

            <!-- Forecast for Upcoming Releases -->
            <div class="card mt-4">
                <div class="card-header">Revenue Forecast</div>
                <div class="card-body">
                    <p><strong>Next Month's Forecasted Revenue:</strong> <span id="forecastRevenue">Loading...</span></p>
                </div>
            </div>

            <!-- Most Popular Shoes -->
            <div class="card mt-4">
                <div class="card-header">Most Frequent Answers on Users' Shoe Preferences Based on Survey</div>
                <div class="card-body">
                    <p><strong>Kind of shoes users are looking for:</strong> <span id="most-frequent-category">Loading...</span></p>
                    <p><strong>Type of shoes users are most comfortable with:</strong> <span id="most-frequent-shoe-type">Loading...</span></p>
                    <p><strong>Brand of shoes users are looking for:</strong> <span id="most-frequent-brand">Loading...</span></p>
                </div>
            </div>
        </div>
    </div>

    <div class="filterable_card" data-name="inventory">
        <div class="container">

            <div class="row mt-5">
                <div class="col-6 col-sm-6 col-md-4 col-lg-3">
                    <a href="addProducts" style="text-decoration: none;">
                        <div class="card" style="width: 100%; background-color: #A5DD9B">
                            <div class="card-body">
                                <h5 class="card-title"><i class="bi bi-plus-lg"></i> Add Products</h5>

                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-6 col-sm-6 col-md-4 col-lg-3">
                    <a href="editProducts" style="text-decoration: none;">
                        <div class="card" style="width: 100%; background-color: #B4B4B8">
                            <div class="card-body">
                                <h5 class="card-title"><i class="bi bi-pencil-square"></i> Edit Products</h5>

                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-6 col-sm-6 col-md-4 col-lg-3">
                    <a href="manageProducts" style="text-decoration: none;">
                        <div class="card" style="width: 100%; background-color: #6482AD">
                            <div class="card-body">
                                <h5 class="card-title"><i class="bi bi-archive-fill"></i> Manage Quantities</h5>

                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-6 col-sm-6 col-md-4 col-lg-3 ">
                    <a href="removeProducts" style="text-decoration: none;">
                        <div class="card" style="width: 100%; background-color: #c95454">
                            <div class="card-body">
                                <h5 class="card-title"><i class="bi bi-trash-fill"></i> Remove Products</h5>

                            </div>
                        </div>
                    </a>
                </div>


                <div class="row d-flex justify-content-center align-items-center mt-3">
                    @foreach($products as $product)

                    <div class="col-6 col-sm-6 col-md-4 col-lg-4">


                        <div class="card" style="width: 100%;">
                            <div class="card-body">
                                <img src="{{ asset($product->productSecond) }}" alt="" style="width:100%; height:100%; max-height:250px">

                                <h5 class="card-title mt-3">{{$product->productName}}</h5>
                                <h6 class="card-subtitle mb-2 text-body-secondary">{{$product->productCategory}} Shoes</h6>
                                <p class="card-text">
                                    @if($product->photos->isEmpty())
                                    <small>You currently don't have photos for the 3D Spin. <a href="{{ route('upload.form', ['id' => $product->id]) }}">Add Photos</a></small>
                                    @else
                                    <small>You already have 3d spin feature for this product.</small>
                                    @endif
                                </p>
                                <p class="card-text mb-0">
                                    @if(!empty($product->productTryIt) && $product->productTryIt !== 'NULL')
                                <p>Done</p>
                                @else
                                <small>You haven't set the fit for this Shoe. <a href="{{ route('fit.form', ['id' => $product->id]) }}">Fit Shoe</a></small>
                                @endif

                                </p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>


            </div>
        </div>
    </div>

    <div class="filterable_card" data-name="users">
        <input type="text" id="searchInput" placeholder="Search students..." class="form-control mb-3">
        <div id="studentsList">


            <div class="container">
                <div class="row d-flex justify-content-center align-items-center mt-5">
                    @foreach($users as $user)
                    @if($user->user_type != '1')
                    <div class="col-12 col-sm-12 col-md-4 col-lg-3" style="margin:0.5rem;">
                        <div class="card student-item" style="width: 100%; height:auto;">
                            <a href="" data-bs-toggle="modal" data-bs-target="#userrmodal{{$user->id}}" style="text-decoration: none; color: black;">
                                <div class="card-body">
                                    <div class="d-flex justify-content-center mb-3">
                                        <img src="../storage/Images/updatedLogo.png" alt="" style="border-radius: 50%;" width="100px" height="100px">
                                    </div>
                                    <h6 class="card-subtitle mb-2 text-body-secondary text-center" style="font-size: large; font-weight: bold;">
                                        {{$user->name}}
                                    </h6>
                                    <p class="card-text text-center">Dejaview Member since: {{$user->created_at->format('F d, Y')}}</p>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="modal fade" id="userrmodal{{$user->id}}" tabindex="-1" aria-labelledby="exampleModalLabel{{$user->id}}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered ">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel{{$user->id}}">{{$user->name}}'s Information</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>


                                <div class="modal-body">
                                    <div class="row">

                                        <div class="col-12 col-lg-12 col-md-12 col-sm-12 mb-3">
                                            <label for="" class="form-label">Username</label>
                                            <input type="disabled" class="form-control" value="{{$user->name}}" disabled>

                                        </div>
                                        <div class="col-12 col-lg-12 col-md-12 col-sm-12 mb-3">
                                            <label for="" class="form-label">Email</label>
                                            <input type="disabled" class="form-control" value="{{$user->email}}" disabled>

                                        </div>
                                        <div class="col-12 col-lg-12 col-md-12 col-sm-12 mb-3">
                                            <label for="" class="form-label">Verification ID</label>
                                            @if (!empty($user->validationCard))
                                            <div>

                                                <img src="{{ asset($user->validationCard) }}" alt="" class="validationCard">
                                            </div>
                                            @else
                                            <p>Does not have validation provided</p>
                                            @endif



                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @endif
                    @endforeach
                </div>
            </div>

        </div>

    </div>

    <div class="filterable_card" data-name="orders">
        <div class="row mt-5">
            @foreach ($orders as $timestamp => $groupedOrders)
            @if($groupedOrders->isNotEmpty())
            @php
            $pendingOrders = $groupedOrders->filter(function ($order) {
            return $order->orderStatus == 'Pending';
            });
            @endphp

            @if($pendingOrders->isNotEmpty())
            @php
            $sanitizedTimestamp = str_replace([' ', ':'], ['_', '_'], $timestamp);
            @endphp





            <!-- Modal for Gcash Payment Image -->
            <div class="modal fade" id="gcashModal{{ $groupedOrders->first()->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="gcashModalLabel{{ $groupedOrders->first()->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="gcashModalLabel{{ $groupedOrders->first()->id }}">Gcash Payment</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <img src="{{ asset($groupedOrders->first()->paymentImage) }}" alt="Gcash Payment" style="width: 100%; height:auto;">
                        </div>
                    </div>
                </div>
            </div>





            <div class="modal fade" id="viewModal{{ $sanitizedTimestamp }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Order From: {{$groupedOrders->first()->user->name}}</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body m-3">
                            <form action="{{ route('orderUpdate') }}" method="post" enctype="multipart/form-data">
                                @csrf

                                <div class="row">
                                    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                                        @foreach ($groupedOrders as $order)
                                        <input type="hidden" name="orderId[]" value="{{ $order->id }}">
                                        <div class="card" style="width: auto;">
                                            <div class="card-body">
                                                <div class="d-flex">
                                                    <img src="{{ asset($order->product->productThumbnail) }}" alt="" width="100px" height="100px">
                                                    <div class="m-3">
                                                        <h5 class="card-title">{{ $order->product->productName }}</h5>
                                                        <h6 class="card-subtitle mb-2 text-body-secondary">{{ $order->productDescription }}</h6>
                                                        <h6 class="card-subtitle mb-2 text-body-secondary">₱{{ number_format($order->product->productPrice, 2) }}</h6>
                                                        <div class="d-flex mb-0" style="gap: 1rem;">
                                                            <h6 class="card-subtitle mb-2 text-body-secondary">Size: {{ $order->size }}</h6>
                                                            <h6 class="card-subtitle mb-2 text-body-secondary">Quantity: {{ $order->quantity }}</h6>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>

                                    <hr class="mt-5">

                                    @foreach ($address as $addr) <!-- Loop through each address -->
                                    @if($addr->id == $order->addressId)
                                    <div class="col-6 col-sm-6 col-md-6 col-lg-6">
                                        <label><strong>Delivery Address</strong></label>
                                        <div class="row">

                                            <div class="card" style="width: 18rem;">
                                                <div class="card-body">
                                                    <h5 class="card-title">{{ $addr->name }}</h5>
                                                    <h6 class="card-subtitle mb-2 text-body-secondary">{{ $addr->contact }}</h6>
                                                    <p class="card-text">{{ $addr->details }},{{ $addr->region->region_name }}, {{ $addr->province->province_name }}, {{ $addr->municipality->municipality_name }}, {{ $addr->barangay->barangay_name }}</p>
                                                </div>
                                            </div>
                                        </div>

                                        <label for="">Payment Method</label>

                                        <input type="disabled" class="form-control mb-3" value="{{$order->paymentMethod}}" style="width: 100%;" disabled>

                                        <label for="">Delivery Method</label>
                                        <input type="disabled" class="form-control mb-3" value="{{$order->deliveryMethod}}" style="width: 100%;" disabled>

                                    </div>
                                    @endif
                                    @endforeach

                                    <!-- Single Status Selection for All Orders -->
                                    <div class="col-6 col-sm-6 col-md-6 col-lg-6">
                                        <label for="">Payment Status</label>
                                        @if($order->paymentStatus == "Approved")
                                        <select class="form-control mb-3" name="paymentStatus">
                                            <option selected>
                                                {{ $order->paymentStatus ? $order->paymentStatus : 'Select Product Brand' }}
                                            </option>
                                        </select>

                                        @else
                                        <select class="form-control mb-3" name="paymentStatus" aria-label="Default select example">
                                            <option selected disabled>
                                                {{ $order->paymentStatus ? $order->paymentStatus : 'Select Product Brand' }}
                                            </option>
                                            <option value="Pending">Pending</option>
                                            <option value="Approved">Approved</option>
                                        </select>
                                        @endif
                                        <label for="">Delivery Status</label>
                                        <select class="form-control mb-3" name="deliveryStatus" aria-label="Default select example">
                                            <option value="Pending">Pending</option>
                                            <option value="Delivered">Delivered</option>
                                        </select>

                                        <label for="">Order Status</label>
                                        <select class="form-control mb-3" name="orderStatus" aria-label="Default select example">
                                            <option value="Pending">Pending</option>
                                            <option value="Received">Received</option>
                                        </select>
                                    </div>
                                </div>

                                <div style="display: flex; justify-content:end; margin-left:0;">

                                    <button type="submit" class="btn btn-primary">Update Orders</button>
                                </div>
                            </form>



                        </div>
                    </div>
                </div>
            </div>
            @endif
            @endif
            @endforeach

            <div>
                <table class="table">
                    <tr>
                        <th>Name</th>
                        <th>Product(s)</th>
                        <th>Price</th>
                        <th>Action</th>
                        <th>Action</th>
                    </tr>
                    <tbody>
                        @foreach ($orders as $timestamp => $groupedOrders)
                        @if($groupedOrders->isNotEmpty())
                        @php
                        $pendingOrders = $groupedOrders->filter(function ($order) {
                        return $order->orderStatus == 'Pending';
                        });
                        @endphp

                        @if($pendingOrders->isNotEmpty())
                        @php
                        $sanitizedTimestamp = str_replace([' ', ':'], ['_', '_'], $timestamp);
                        @endphp
                        <tr>
                            <td>{{ $groupedOrders->first()->user->name }}</td>
                            <td>{{ $groupedOrders->count() }}</td>
                            <td>₱{{ number_format($groupedOrders->first()->totalPrice, 2) }}</td>

                            @if($groupedOrders->first()->paymentMethod == 'gcash')
                            <td>
                                <button type="button" class="buttonn w-100" data-bs-toggle="modal"
                                    data-bs-target="#viewModal{{ $sanitizedTimestamp }}"
                                    style="border: 1px solid black; border-radius: 10px; background-color: lightblue; box-shadow: 0 0 5px gray; white-space: nowrap; padding: 10px;">
                                    <span class="buttonn-text-one">View</span>
                                    <span class="buttonn-text-two">Go!</span>
                                </button>
                            </td>
                            <td>
                                <button class="buttonn w-100" data-bs-toggle="modal"
                                    data-bs-target="#gcashModal{{ $groupedOrders->first()->id }}"
                                    style="border: 1px solid black; border-radius: 10px; background-color: lightblue; box-shadow: 0 0 5px gray; white-space: nowrap; padding: 10px;">
                                    <span class="buttonn-text-one">View Gcash</span>
                                    <span class="buttonn-text-two">Go!</span>
                                </button>
                            </td>
                            @else
                            <td>
                                <button type="button" class="buttonn w-100" data-bs-toggle="modal"
                                    data-bs-target="#viewModal{{ $sanitizedTimestamp }}"
                                    style="border: 1px solid black; border-radius: 10px; background-color: lightblue; box-shadow: 0 0 5px gray; white-space: nowrap; padding: 10px;">
                                    <span class="buttonn-text-one">View</span>
                                    <span class="buttonn-text-two">Go!</span>
                                </button>
                            </td>
                            <td></td>
                            @endif
                        </tr>
                        @endif
                        @endif
                        @endforeach
                    </tbody>
                </table>
            </div>





        </div>
    </div>

    <div class="filterable_card" data-name="audit">
        <table cellpadding="10" cellspacing="0" style="width: 100%; text-align: left; border: 1px solid black;">
            <thead>
                <tr>
                    <th>Date & Time</th>
                    <th>User</th>
                    <th>Action</th>
                    <th>Details</th>
                </tr>
            </thead>
            <tbody>
                @foreach($auditLogs as $log)
                <tr>
                    <td>{{ $log['date'] ? $log['date']->format('Y-m-d H:i:s') : 'N/A' }}</td>
                    <td>{{ $log['user'] }}</td>
                    <td>{{ $log['action'] }}</td>
                    <td>{{ $log['details'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
</div>

<style>
    body {
        height: 100%;
        margin: 0;
        overflow-x: hidden;
    }

    .active {
        background-color: lightblue;

    }

    .tasks {
        font-size: medium;
        padding: 10px;
        margin-top: 10px;

    }

    .card {
        box-shadow: 5px 7px gray;
        margin: 10px;
    }

    .bg {
        background-color: #F1F1F1;
        min-height: 100vh;
    }

    .col-9 {
        padding: 0;
    }


    .offcanvas-body button {
        position: relative;
        overflow: hidden;
        border: none;
        background-color: transparent;
        display: flex;
        align-items: center;
        width: 90%;
        transition: color 0.3s;
        margin: 10px;

    }

    .table {
        border: 1;
        border-color: 1px solid black;
    }

    hr {
        border: none;
        /* Remove default border */
        border-top: 2px dotted gray;
        /* Add a dotted top border */
        height: 0;
        /* Set the height to 0 to ensure only the border appears */
    }

    .boxBackground {
        margin: 1rem;
        background-color: lightblue;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px gray;
    }

    .offcanvas-body button::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background-color: lightblue;
        z-index: -1;
        transition: left 0.3s;
    }

    .offcanvas-body button.active::before {
        left: 0;

    }

    .offcanvas-body button.active {
        color: #000;
        border-radius: 10px;
        box-shadow: 5px 7px gray;
    }

    .validationCard {
        position: relative;
        width: 100%;
    }

    .textUser {
        background-color: #6482AD;
        padding: 10px;
        border-radius: 50%;
        color: white;
        width: 55px;
        text-align: center;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        margin-left: auto;
        /* Pushes the element to the right */
    }

    .card-title {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    #pieChart {
        max-width: 600px;
        max-height: 600px;
        float: right;
    }

    /* From Uiverse.io by mobinkakei */
    .buttonn {
        width: 140px;
        height: 50px;
        background: lightblue;
        color: black;
        border-radius: 50px;
        border: none;
        outline: none;
        cursor: pointer;
        position: relative;
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.5);
        overflow: hidden;
    }

    .buttonn span {
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: top 0.5s;
    }

    .buttonn-text-one {
        position: absolute;
        width: 100%;
        top: 50%;
        left: 0;
        transform: translateY(-50%);
    }

    .buttonn-text-two {
        position: absolute;
        width: 100%;
        top: 150%;
        left: 0;
        transform: translateY(-50%);
    }

    .buttonn:hover .buttonn-text-one {
        top: -100%;
    }

    .buttonn:hover .buttonn-text-two {
        top: 50%;
    }

    #studentsList {
        display: flex;
        flex-wrap: wrap;
        /* Ensure items wrap to the next row */
        gap: 0.5rem;
        /* Optional: spacing between items */
        justify-content: flex-start;
        /* Align items to the left */
    }

    #salesChart {
        width: 100% !important;
        /* Make the canvas take up full width of its container */
        height: auto !important;
    }

    #comparisonChart {
        width: 100% !important;
        /* Make the canvas take up full width of its container */
        height: auto !important;
    }

    /* From Uiverse.io by alexroumi */
    .view {
        padding: 15px 25px;
        border: unset;
        border-radius: 15px;
        color: #212121;
        z-index: 1;
        background: #e8e8e8;
        position: relative;
        font-weight: 1000;
        font-size: 17px;
        -webkit-box-shadow: 4px 8px 19px -3px rgba(0, 0, 0, 0.27);
        box-shadow: 4px 8px 19px -3px rgba(0, 0, 0, 0.27);
        transition: all 250ms;
        overflow: hidden;
        max-height: 100%;
        height: 100%;
        max-width: 100%;
        width: 100%;
    }

    .view::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        height: 100%;
        width: 0;
        border-radius: 15px;
        background-color: #212121;
        z-index: -1;
        -webkit-box-shadow: 4px 8px 19px -3px rgba(0, 0, 0, 0.27);
        box-shadow: 4px 8px 19px -3px rgba(0, 0, 0, 0.27);
        transition: all 250ms
    }

    .view:hover {
        color: #e8e8e8;
    }

    .view:hover::before {
        width: 100%;
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Automatically click the dashboard button when the page loads
        document.querySelector("button[data-name='dashboard']").click();
    });

    const filterButtons = document.querySelectorAll(".offcanvas-body button");
    const filterableCards = document.querySelectorAll(".filterable_card");

    let lastActiveButton = null;

    const filterCards = e => {
        const button = e.target.closest('button');

        if (button) {
            // Check if the button clicked is not the currently active one
            if (lastActiveButton && lastActiveButton !== button) {
                lastActiveButton.classList.remove("active");
                // Force reflow to reset the transition
                void lastActiveButton.offsetWidth;
            }

            button.classList.add("active");
            lastActiveButton = button;

            filterableCards.forEach(card => {
                if (card.dataset.name === button.dataset.name || button.dataset.name === "all") {
                    card.classList.remove("d-none");
                } else {
                    card.classList.add("d-none");
                }
            });
        }
    };

    // Attach the event listener to each button
    filterButtons.forEach(button => button.addEventListener("click", filterCards));

    //script sa search button
    document.getElementById('searchInput').addEventListener('keyup', function() {
        let filter = this.value.toUpperCase();
        let studentsList = document.getElementById('studentsList');
        let students = studentsList.getElementsByClassName('student-item');

        // Loop through the student items and filter
        Array.from(students).forEach(student => {
            let studentName = student.querySelector('h6').textContent || student.querySelector('h6').innerText;
            if (studentName.toUpperCase().indexOf(filter) > -1) {
                student.style.display = ''; // Show the matching items
            } else {
                student.style.display = 'none'; // Hide non-matching items
            }
        });
    });
</script>

{{-- Line Chart --}}
<script>
    let salesChart;

    function initializeLineChart() {
        const salesCtx = document.getElementById('salesChart').getContext('2d');
        window.fetchLineChartData = function(view = '1 week') {
            document.getElementById('loadingIndicator').style.display = 'block'; // Show loading indicator

            fetch(`{{ route('shoe.sales.line') }}?view=${view}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('loadingIndicator').style.display = 'none'; // Hide loading indicator

                    let chartTitle = '';
                    let datasetColor = '';

                    switch (view) {
                        case '1 week':
                            chartTitle = 'Weekly Shoe Sales';
                            datasetColor = 'rgba(75, 192, 192, 1)';
                            break;

                        case '1 month':
                            chartTitle = 'Daily Sales for the Month';
                            datasetColor = 'rgba(153, 102, 255, 1)';
                            break;

                        case '3 months':
                            chartTitle = 'Sales in the Last 3 Months';
                            datasetColor = 'rgba(255, 159, 64, 1)';
                            break;

                        case '6 months':
                            chartTitle = 'Sales in the Last 6 Months';
                            datasetColor = 'rgba(255, 99, 132, 1)';
                            break;

                        case '1 year':
                            chartTitle = 'Monthly Sales for the Year';
                            datasetColor = 'rgba(54, 162, 235, 1)';
                            break;

                        case 'Max':
                            chartTitle = 'Sales Over Time';
                            datasetColor = 'rgba(255, 206, 86, 1)';
                            break;
                    }

                    // If the chart already exists, destroy it
                    if (salesChart) {
                        salesChart.destroy();
                    }

                    // Create the new chart
                    salesChart = new Chart(salesCtx, {
                        type: 'line',
                        data: {
                            labels: data.labels, // Use the prepared labels from the controller
                            datasets: [{
                                label: 'Total Revenue',
                                data: data.data.map(num => (num)), // Ensure data is rounded
                                borderColor: datasetColor,
                                borderWidth: 2,
                                fill: false,
                                tension: 0.1
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'top'
                                },
                                title: {
                                    display: true,
                                    text: chartTitle
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        stepSize: 0, // Set step size to 1 for whole numbers only
                                        callback: function(value) {
                                            return Number.isInteger(value) ? value : null;
                                        }
                                    }
                                }
                            }
                        }
                    });
                })
                .catch(error => console.error('Error fetching line chart data:', error));
        };

        // Initial load for line chart
        fetchLineChartData(); // Default view is '1 year'
    }
</script>

{{-- Pie Chart --}}
<script>
    // Function to initialize and update the pie chart
    function initializePieChart() {
        const pieCtx = document.getElementById('pieChart').getContext('2d');
        let pieChart;

        window.fetchPieChartData = function() {
            fetch(`{{ route('shoe.sales.pie') }}?chartType=pie`)
                .then(response => response.json())
                .then(data => {
                    console.log("Pie chart data:", data);

                    if (pieChart) {
                        pieChart.destroy();
                    }
                    pieChart = new Chart(pieCtx, {
                        type: 'pie',
                        data: {
                            labels: data.labels,
                            datasets: [{
                                data: data.data,
                                backgroundColor: [
                                    'rgba(255, 99, 132, 0.2)',
                                    'rgba(54, 162, 235, 0.2)',
                                    'rgba(255, 206, 86, 0.2)',
                                    'rgba(75, 192, 192, 0.2)',
                                    'rgba(153, 102, 255, 0.2)',
                                    'rgba(255, 159, 64, 0.2)'
                                ],
                                borderColor: [
                                    'rgba(255, 99, 132, 1)',
                                    'rgba(54, 162, 235, 1)',
                                    'rgba(255, 206, 86, 1)',
                                    'rgba(75, 192, 192, 1)',
                                    'rgba(153, 102, 255, 1)',
                                    'rgba(255, 159, 64, 1)'
                                ],
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'top'
                                },
                                title: {
                                    display: true,
                                    text: 'Most Bought Shoes'
                                }
                            }
                        }
                    });
                })
                .catch(error => console.error('Error fetching pie chart data:', error));
        };

        // Initial load for pie chart
        fetchPieChartData();
    }

    // Call the initialize functions on DOMContentLoaded
    document.addEventListener('DOMContentLoaded', function() {
        initializeLineChart();
        initializePieChart();
    });
</script>

{{-- Other Charts --}}
<script>
    // Fetch Monthly Comparison
    fetch("{{ route('admin.comparison') }}")
        .then(response => response.json())
        .then(data => {
            let labels = data.map(item => item.month);
            let revenues = data.map(item => item.revenue);
            let differences = data.map(item => item.difference);

            const ctx = document.getElementById('comparisonChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                            label: 'Total Revenue',
                            data: revenues,
                            backgroundColor: 'rgba(54, 162, 235, 0.6)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 0.5
                        },
                        {
                            label: 'Difference from Previous Month',
                            data: differences,
                            backgroundColor: 'rgba(255, 99, 132, 0.6)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 0.5
                        }
                    ]
                },
                options: {
                    responsive: true,
                    scales: {
                        x: {
                            title: {
                                display: true,
                            }
                        },
                        y: {
                            title: {
                                display: true,
                                text: 'Revenue'
                            },
                            beginAtZero: true
                        }
                    }
                }
            });
        })
        .catch(error => console.error('Error fetching monthly comparison data:', error));

    // Fetch Peak and Off Months
    fetch("{{ route('admin.peakoff') }}")
        .then(response => response.json())
        .then(data => {
            document.getElementById('peakMonth').innerText = data.peak_month;
            document.getElementById('offMonth').innerText = data.off_month;
        });

    // Fetch Most Profitable Brand and Type
    fetch("{{ route('admin.profitable') }}")
        .then(response => response.json())
        .then(data => {
            console.log(data); // Log the response data for debugging
            document.getElementById('profitableBrand').innerText = data.most_profitable_brand.brand_name;
            document.getElementById('profitableType').innerText = data.most_profitable_category.category_name;
        })
        .catch(error => console.error('Error fetching most profitable data:', error));

    // Fetch Forecast for Upcoming Releases
    fetch("{{ route('admin.forecast') }}")
        .then(response => response.json())
        .then(data => {
            document.getElementById('forecastRevenue').innerText = data.forecast_next_month;
        })
        .catch(error => console.error('Error fetching forecasted revenue:', error));

    // Fetch Survey Results
    fetch("{{ route('admin.surveyresults') }}")
        .then(response => response.json())
        .then(data => {
            document.getElementById('most-frequent-category').innerText = data.most_frequent_category || 'No data';
            document.getElementById('most-frequent-shoe-type').innerText = data.most_frequent_shoe_type || 'No data';
            document.getElementById('most-frequent-brand').innerText = data.most_frequent_brand || 'No data';
        })
        .catch(error => console.error('Error fetching survey results:', error));
</script>

{{--Print Function--}}
<script>
    function printChart() {
        const chartContainer = document.createElement('div');
        const chartTitle = salesChart.options.plugins.title.text; // Get the chart title
        const labels = salesChart.data.labels; // Get x-axis labels
        const data = salesChart.data.datasets[0].data; // Get chart data (total sales)

        // Create a printable summary
        const summary = `
            <table border="1" style="border-collapse: collapse; width: 50%; text-align: left;">
                <thead>
                    <tr>
                        <th>${chartTitle}</th>
                        <th>Total Sales</th>
                    </tr>
                </thead>
                <tbody>
                    ${labels.map((label, index) => `<tr><td>${label}</td><td>₱${data[index]}</td></tr>`).join('')}
                </tbody>
            </table>
            <br>
        `;

        // Add chart and summary to the print container
        chartContainer.innerHTML = summary;

        // Create an iframe to hold the content for printing
        const iframe = document.createElement('iframe');
        iframe.style.position = 'absolute';
        iframe.style.width = '0px';
        iframe.style.height = '0px';
        iframe.style.border = 'none';
        document.body.appendChild(iframe);

        // Write the content to the iframe and trigger printing
        const iframeDoc = iframe.contentWindow.document;
        iframeDoc.open();
        iframeDoc.write(`
            <html>
                <head>
                    <title>Property of DejaView</title>
                </head>
                <body>
                    ${chartContainer.innerHTML}
                </body>
            </html>
        `);
        iframeDoc.close();
        iframe.contentWindow.focus();
        iframe.contentWindow.print();

        // Remove the iframe after printing
        iframe.remove();
    }
</script>