@include('layout.link')

<div class="header" style="display: flex; align-items: center; justify-content: space-between; margin-bottom:5rem;">
    <a class="navbar-brand" href="#"><img src="/images/loogoos.png" width="140" height="40" alt="Logo"></a>
    <div class="separator"></div>
    <p class="addText">Remove Products</p>
    <a href="admin" style="text-decoration: none; color: black; justify-content: end; margin-left: auto;">
        <i class="bi bi-arrow-90deg-left" style="font-size:14px;"></i> Go back
    </a>
</div>


<div id="productList">
    <div class="container p-5">
        <div class="row d-flex justify-content-center align-items-center">
            @if (Session::has('success'))
            <div class="alert alert-success">
                {{ Session::get('success') }}
            </div>
            @endif
            <div class="d-flex mb-0">
                <h3>Products Available</h3>
                <input type="text" id="searchInput" placeholder="Search Products..." class="form-control mb-3 ms-auto" style="width: 300px;">
            </div>

            <hr>

            @foreach($products as $product)
            <div class="col-12 col-sm-12 col-md-4 col-lg-4">
                <div class="card product-item" style="width: 100%; max-height:12rem;">
                    <div class="card-body">
                        <div class="d-flex">
                            <img src="{{ asset($product->productSecond) }}" alt="" class="imageEdit">
                            <div class="m-3">
                                <div>

                                    <h5 class="card-title">{{$product->productName}}</h5>
                                </div>

                                <div>

                                    <form action="{{ route('removeProductsPost') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="productId" value="{{$product->id}}">
                                        <button type="submit" style="border: 1px solid black;position:relative; background-color:#c95454; color:white; padding:5px; margin-top:2rem;"><i class="bi bi-trash"></i>Remove</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>


<style>
    .buttons {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 1rem;
    }

    .buttons button {
        border: 1px solid black;
        border-radius: 10px;
    }

    .buttons .cancel {
        padding: 7px;
        background-color: #B4B4B8;
    }

    .buttons .save {
        padding: 7px;
        background-color: #A5DD9B;
    }

    .inputText input {
        margin: 10px;
        box-shadow: 0 0 5px gray;
    }

    hr {
        border: none;
        border-top: 2px dotted gray;
        height: 0;
    }

    .col-12 {
        margin-top: 10px;
        margin-bottom: 10px;
    }

    .imageEdit {
        width: fit-content;
        height: 150px;
    }

    body {
        background-color: #C7C8CC;
    }

    .container {
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 0 10px gray;
    }

    .addText {
        margin: 0;
    }

    .header {
        width: 100%;
        background-color: white;
        height: 3rem;
        display: flex;
        align-items: center;
        padding: 0 25px;
        box-sizing: border-box;
    }

    .navbar-brand img {
        margin-right: 15px;
    }

    .separator {
        width: 1px;
        height: 30px;
        background-color: #000;
        margin-right: 15px;
    }
</style>