@include('layout.link')
<div class="header" style="display: flex; align-items: center; justify-content: space-between; margin-bottom:5rem;">
    <a class="navbar-brand" href="#"><img src="/images/loogoos.png" width="140" height="40" alt="Logo"></a>
    <div class="separator"></div>
    <p class="addText">Edit Products</p>
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
            <div class="col-12 col-sm-12 col-md-6 col-lg-3">
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
                <div class="modal-dialog modal-dialog-centered ">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel{{$product->id}}">Edit {{$product->productName}}</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <form action="{{ route('editProductsPost') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="productId" value="{{$product->id}}">
                            <div class="modal-body">
                                <div id="thumbnailBox{{$product->id}}">
                                    <p id="insertTextThumbnail{{$product->id}}">Update thumbnail here</p>
                                    <div class="thumbnailPicture">
                                        <img id="thumbnailImage{{$product->id}}" src="{{$product->productSecond}}" alt="Product Thumbnail">
                                    </div>
                                    <input type="file" id="thumbnailInput{{$product->id}}" class="box2" name="productSecond" accept="image/*" style="display: none;">
                                </div>

                                <div class="row p-3 inputText d-flex justify-content-center align-items-center">
                                    <label for="productName{{$product->id}}">Product Name</label>
                                    <input type="text" name="productName" value="{{$product->productName}}" class="form-control">

                                    <label for="productDescription{{$product->id}}">Product Description</label>
                                    <input type="text" name="productDescription" value="{{$product->productDescription}}" class="form-control">

                                    <label for="productPrice{{$product->id}}">Product Price</label>
                                    <input type="number" name="productPrice" value="{{$product->productPrice}}" class="form-control">

                                    <label for="ProductBrand" class="form-label mt-2">Product Brand</label>
                                    <select class="form-control" name="productBrandd" style="box-shadow: 0 0 5px gray;">
                                        <option selected disabled>{{ $product->features->isNotEmpty() ? $product->features->first()->brand->productBrand : 'Select Product Brand' }}</option>
                                        @foreach($brands as $brand)
                                        <option value="{{$brand->id}}">{{$brand->productBrand}}</option>
                                        @endforeach
                                    </select>

                                    <label for="ProductBrand" class="form-label mt-2">Product Type</label>
                                    <select class="form-control" name="productType" style="box-shadow: 0 0 5px gray;">
                                        <option selected disabled>{{ $product->features->isNotEmpty() ? $product->features->first()->type->name : 'Select Product Brand' }}</option>
                                        @foreach($types as $type)
                                        <option value="{{$type->id}}">{{$type->name}}</option>
                                        @endforeach
                                    </select>

                                    <div class="container mt-3">
                                        <div class="row p-2 d-flex justify-content-center align-items-center">
                                            @foreach ($product->features as $feature)
                                            <div class="col-6 col-sm-6 col-md-4 col-lg-3">
                                                <label for="ProductTraction" class="form-label mt-2 text-center">Traction</label>
                                                <input class="form-control" name="productTraction" type="number" value="{{ $feature->traction ?? '' }}" min=1 max=10 style="height: 3rem; font-size:large; text-align: center;">
                                            </div>

                                            <div class="col-6 col-sm-6 col-md-4 col-lg-3">
                                                <label for="ProductCushion" class="form-label mt-2 text-center">Cushion</label>
                                                <input class="form-control" name="productCushion" type="number" value="{{ $feature->cushion ?? '' }}" min=1 max=10 style="height: 3rem; font-size:large; text-align: center;">
                                            </div>

                                            <div class="col-6 col-sm-6 col-md-4 col-lg-3">
                                                <label for="ProductMaterial" class="form-label mt-2 text-center">Material</label>
                                                <input class="form-control" name="productMaterial" type="number" value="{{ $feature->material ?? '' }}" min=1 max=10 style="height: 3rem; font-size:large; text-align: center;">
                                            </div>

                                            <div class="col-6 col-sm-6 col-md-4 col-lg-3">
                                                <label for="ProductUse" class="form-label mt-2 text-center">Outside Use</label>
                                                <input class="form-control" name="productUse" type="number" value="{{ $feature->outdoorUse ?? '' }}" min=1 max=10 style="height: 3rem; font-size:large; text-align: center;">
                                            </div>
                                            @endforeach
                                            <small class="mt-2">Note: You can base from other websites for more information about the shoe.</small>
                                        </div>
                                    </div>


                                    <input type="hidden" name="productCategory" value="{{$product->productCategory}}" class="form-control">
                                </div>

                                <div class="buttons">
                                    <button type="button" class="cancel" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="save">Save Changes</button>
                                </div>
                            </div>
                        </form>
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

    .thumbnailPicture {
        width: 100%;
        padding: 5px;
        height: 150px;
        display: flex;
        justify-content: center;
        align-items: center;
        border: 1px solid #ddd;
        margin: 0 auto;
        position: relative;
        overflow: hidden;
    }

    .thumbnailPicture img {
        max-width: 100%;
        max-height: 100%;
        object-fit: cover;
        display: block;
    }


    .buttons .cancel {
        padding: 7px;
        background-color: #B4B4B8;
    }

    .editHover{
        text-decoration: none;
        color: black;
    }

    .editHover:hover{
        box-shadow: 0 0 10px gray;
        transition: 0.5s ease;
        border-radius: 10%;
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

    .box1 {
        cursor: pointer;
        border: 1px dashed #aaa;
        padding: 10px;
        width: 100%;
        height: 100px;
        display: flex;
        justify-content: center;
        align-items: center;
        /* Fixed height for thumbnail box */
        position: relative;
        /* For positioning the instruction text */
        margin-bottom: 10px;
        /* Space between elements */
    }

    .box2 {
        display: none;
        width: 90px;
        height: 90px;
        object-fit: cover;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const thumbnailBoxes = document.querySelectorAll('[id^=thumbnailBox]');

        thumbnailBoxes.forEach(thumbnailBox => {
            const productId = thumbnailBox.id.replace('thumbnailBox', '');
            const thumbnailInput = document.getElementById(`thumbnailInput${productId}`);
            const thumbnailImage = document.getElementById(`thumbnailImage${productId}`);
            const insertTextThumbnail = document.getElementById(`insertTextThumbnail${productId}`);

            // Open file input when the thumbnail box is clicked
            thumbnailBox.addEventListener('click', function() {
                thumbnailInput.click();
            });

            // Handle file input change
            thumbnailInput.addEventListener('change', function(event) {
                const file = event.target.files[0];

                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        // Update the thumbnail image's src with the selected file
                        thumbnailImage.src = e.target.result;
                        thumbnailImage.style.display = 'block';
                        insertTextThumbnail.style.display = 'none';
                    };
                    reader.readAsDataURL(file); // Convert the file to a data URL
                }
            });
        });
    });

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