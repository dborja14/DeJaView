@include('layout.link')

<div class="header" style="display: flex; align-items: center; justify-content: space-between; margin-bottom:5rem;">
    <a class="navbar-brand" href="#"><img src="/images/loogoos.png" width="140" height="40" alt="Logo"></a>
    <div class="separator"></div>
    <p class="addText">Manage Quantities</p>
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
            <div class="col-12 col-sm-12 col-md-4 col-lg-3">
                <a type="button" data-bs-toggle="modal" data-bs-target="#exampleModal{{$product->id}}" class="editHover">
                    <div class="card product-item" style="width: 18rem; max-height:11rem">
                        <div class="card-body">
                            <div class="d-flex">
                                <img src="{{ asset($product->productSecond) }}" alt="" class="imageEdit">
                                <div class="m-3">
                                    <h5 class="card-title">{{$product->productName}}</h5>
                                    <h6 class="card-subtitle mb-2 text-body-secondary">{{$product->productDescription}}</h6>
                                    <p class="card-text">₱{{ number_format($product->productPrice, 2) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="modal fade" id="exampleModal{{$product->id}}" tabindex="-1" aria-labelledby="exampleModalLabel{{$product->id}}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel{{$product->id}}">Edit {{$product->productName}}</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <input type="hidden" name="productId" value="{{$product->id}}">
                        <div class="modal-body">

                            <div class="card" style="width: 100%; max-height:11rem">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <img src="{{ asset($product->productThumbnail) }}" alt="" class="imageEdit">
                                        <div class="m-3">
                                            <h5 class="card-title">{{$product->productName}}</h5>
                                            <h6 class="card-subtitle mb-2 text-body-secondary">{{$product->productDescription}}</h6>
                                            <p class="card-text">₱{{ number_format($product->productPrice, 2) }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <form action="{{ route('manageProductsPost') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row text-center">
                                    @foreach($shoeSize as $size)
                                    @if($product->id == $size->productId)
                                    <div class="col-6 col-sm-6 col-md-6 col-lg-6">
                                        <p>Size {{$size->size}}</p>
                                    </div>

                                    @if($size->quantity == 0)
                                    <div class="col-6 col-sm-6 col-md-6 col-lg-6">
                                        <input type="number" name="size[{{$size->id}}]" value="0" placeholder="Out of Stock">
                                    </div>

                                    @else

                                    <div class="col-6 col-sm-6 col-md-6 col-lg-6">
                                        <input type="number" name="size[{{$size->id}}]" value="{{$size->quantity}}" placeholder="Quantity">
                                    </div>

                                    @endif
                                    @endif
                                    @endforeach
                                </div>

                                <button type="submit">Update Quantities</button>
                            </form>


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

    .editHover {
        text-decoration: none;
        color: black;
    }

    .editHover:hover {
        box-shadow: 0 0 10px gray;
        transition: 0.5s ease;
        border-radius: 10%;
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

<script>
    document.getElementById('searchInput').addEventListener('keyup', function() {
        let filter = this.value.toUpperCase();
        let studentsList = document.getElementById('productList');
        let students = studentsList.getElementsByClassName('product-item');

        // Loop through the student items and filter
        Array.from(students).forEach(student => {
            let studentName = student.querySelector('h5').textContent || student.querySelector('h5').innerText;
            if (studentName.toUpperCase().indexOf(filter) > -1) {
                student.style.display = ''; // Show the matching items
            } else {
                student.style.display = 'none'; // Hide non-matching items
            }
        });
    });
</script>