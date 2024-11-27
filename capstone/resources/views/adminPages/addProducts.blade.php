@include('layout.link')


<div class="header" style="display: flex; align-items: center; justify-content: space-between;">
    <a class="navbar-brand" href="#"><img src="/images/loogoos.png" width="140" height="40" alt="Logo"></a>
    <div class="separator"></div>
    <p class="addText">Add Products</p>
    <a href="admin" style="text-decoration: none; color: black; justify-content: end; margin-left: auto;">
        <i class="bi bi-arrow-90deg-left" style="font-size:14px;"></i> Go back
    </a>
</div>

@if (Session::has('success'))
<div class="alert alert-success">
    {{ Session::get('success') }}
</div>
@endif

<diV class="containerr">
    <div class="row justify-content-center">
        <div class="col-12 col-sm-6 col-md-4 d-flex justify-content-center cardone">
            <a href="#" class="card-link" id="addProductLink">
                <div class="card justify-content-center align-items-center" style="width: 13rem; height: 12rem;">
                    <div class="card-body">
                        <h5 class="card-title"><img src="../images/charity.png" alt="" width="100px" height="100px"></h5>
                        <h6 class="card-subtitle mb-2 text-body-secondary text-center" style="font-size:large">Add a new product</h6>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-12 col-sm-6 col-md-4 d-flex justify-content-center cardone">
            <a type="button" data-bs-toggle="modal" data-bs-target="#exampleModal" class="card-link">
                <div class="card justify-content-center align-items-center" style="width: 13rem; height: 12rem;">
                    <div class="card-body d-flex flex-column justify-content-center align-items-center">
                        <h5 class="card-title"><i class="bi bi-bookmark-plus" style="font-size:50px;"></i></h5>
                        <h6 class="card-subtitle mb-2 text-body-secondary" style="font-size: large;">Add Brand</h6>
                    </div>
                </div>
            </a>
        </div>
    </div>


    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Add a New Brand</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <h6 class="card-title"> Brands Available:</h6>

                    <!-- design here if ever na meron ka na brands -->

                    <hr>
                    <h6 class="card-title" style="font-weight: bold;">Add a New Brand</h6>

                    <form id="brandForm" action="{{ route('addBrand') }}" method="post" enctype="multipart/form-data">
                        @csrf

                        <div id="brandInputs">
                            <div class="brand-row">
                                <label for="ProductBrand" class="form-label mt-2 text-center">Brand Name</label>
                                <input class="form-control mb-2" type="text" name="brand[]" placeholder="Jordan" aria-label="default input example">
                            </div>

                        </div>

                        <button type="button" id="addRowBtn" style="text-decoration: none; border:none; background-color: white; color: blue; text-align:right;">+ Add New Row</button>


                        <div class="modal-footer mt-2">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Add Product</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <div id="addProductForm" class="hidden">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-4 col-lg-3">
                    <p>Product Information</p>
                    <p>Product Pricing</p>
                </div>

                <div class="col-12 col-sm-12 col-md-8 col-lg-9">
                    <h5>Product Information</h5>
                    <hr>

                    <form action="{{ route('addProductsPost') }}" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="row mt-2">
                            <div class="col-6">
                                <label for="ProductName" class="form-label">Product Name</label>
                                <input class="form-control" type="text" name="productName" placeholder="Jordan 1 High" aria-label="default input example">

                                <label for="ProductBrand" class="form-label mt-2">Product Brand</label>
                                <select class="form-select" name="productBrand">
                                    <option selected>Select Product Brand</option>
                                    @foreach($brands as $brand)
                                    <option value="{{$brand->id}}">{{$brand->productBrand}}</option>
                                    @endforeach
                                </select>

                                <label for="ProductFit" class="form-label mt-2">Product Fit</label>
                                <select class="form-select" name="productFit">
                                    <option selected>Select Product Fit</option>
                                    @foreach($fits as $fit)
                                    <option value="{{$fit->id}}">{{$fit->name}}</option>
                                    @endforeach
                                </select>

                                <div class="container">
                                    <div class="row">
                                        <div class="col-6 col-sm-6 col-md-4 col-lg-3">
                                            <label for="ProductTraction" class="form-label mt-2 text-center">Traction</label>
                                            <input class="form-control" name="productTraction" type="number" placeholder="" aria-label="default input example" min=1 max=10 style="height: 3rem; font-size:large; text-align: center;">
                                        </div>

                                        <div class="col-6 col-sm-6 col-md-4 col-lg-3">
                                            <label for="ProductCushion" class="form-label mt-2 text-center">Cushion</label>
                                            <input class="form-control" name="productCushion" type="number" placeholder="" aria-label="default input example" min=1 max=10 style="height: 3rem; font-size:large; text-align: center;">
                                        </div>

                                        <div class="col-6 col-sm-6 col-md-4 col-lg-3">
                                            <label for="ProductMaterial" class="form-label mt-2 text-center">Material</label>
                                            <input class="form-control" name="productMaterial" type="number" placeholder="" aria-label="default input example" min=1 max=10 style="height: 3rem; font-size:large; text-align: center;">
                                        </div>

                                        <div class="col-6 col-sm-6 col-md-4 col-lg-3">
                                            <label for="ProductUse" class="form-label mt-2 text-center">Outside Use</label>
                                            <input class="form-control" name="productUse" type="number" placeholder="" aria-label="default input example" min=1 max=10 style="height: 3rem; font-size:large; text-align: center;">
                                        </div>

                                        <small class="mt-2">Note: You can base from other websites for more information about the shoe.</small>

                                        <label for="ProductDescription" class="form-label mt-2">Product Description</label>
                                        <input class="form-control" name="productDescription" type="text" placeholder="" aria-label="default input example" style="height: 5rem;">
                                    </div>
                                </div>
                            </div>

                            <div class="col-6">
                                <label for="ProductCategory" class="form-label">Product Category</label>
                                <select class="form-select" name="productCategory">
                                    <option selected>Select Product Category</option>
                                    <option value="Lifestyle">Lifestyle</option>
                                    <option value="Basketball">Basketball</option>
                                </select>

                                <label for="ProductCategory" class="form-label">Product Type</label>
                                <select class="form-select" name="productType">
                                    <option selected>Select Product Type</option>
                                    @foreach($types as $type)
                                    <option value="{{$type->id}}">{{$type->name}}</option>
                                    @endforeach
                                </select>

                                <label for="ThumbnailInsert" class="form-label mt-2">Insert Thumbnail Image</label><br>
                                <small>"This is the image that users will view as part of your collection."</small>

                                <div id="thumbnailBoxx">
                                    <p id="insertTextThumbnail">Insert thumbnail here</p>
                                    <img id="thumbnailImagee" name="thumbnailPicturee" src="" alt="Thumbnail Image">
                                </div>

                                <input type="file" id="thumbnailInputt" name="productSecond" accept="image/*" style="display: none;">

                                <label for="ThumbnailInsert" class="form-label ">Insert Thumbnail Image</label><br>
                                <small>"Please insert an image with a clean, plain background for easy and neat background removal."</small>
                                <div id="thumbnailBox">
                                    <p id="insertTextThumbnail">Insert thumbnail here</p>
                                    <img id="thumbnailImage" name="thumbnailPicture" src="" alt="Thumbnail Image">
                                </div>

                                <input type="file" id="thumbnailInput" name="productThumbnail" accept="image/*" style="display: none;">

                            </div>
                        </div>

                        <label for="ProductPricing" class="form-label mt-2">Product Pricing</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text">₱</span>
                            <input type="number" class="form-control" name="productPrice" aria-label="Amount (to the nearest dollar)">
                            <span class="input-group-text">.00</span>
                        </div>

                        <div class="container">
                            <div class="row">
                                <label for="ProductSizes" class="form-label mt-2">Sizes</label>

                                <!-- Size input fields -->
                                @foreach([7, 8, 9, '9.5', 10, '10.5', 11, 12, 13] as $size)
                                <div class="col-6 col-sm-6 col-md-6 col-lg-4 mt-2 size-selector">
                                    <label for="ProductSize{{$size}}" class="form-label">Size {{ $size }}</label>
                                    <div class="input-group">
                                        <button class="btn btn-outline-secondary btn-minus" type="button" style="height:3rem; width:2rem; background-color: #C7C8CC;">-</button>
                                        <input type="number" value="Size {{$size}}" name="sizes[{{$size}}]" hidden>
                                        <input class="form-control text-center size-input" name="sizes[{{$size}}]" type="number" value="0" min="0" max="10" style="height: 3rem; font-size: large;">
                                        <button class="btn btn-outline-secondary btn-plus" type="button" style="height:3rem; width:2rem; background-color:#90D26D">+</button>
                                    </div>
                                </div>
                                @endforeach

                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-3">
                            <button id="submit" class="btn btn-success" type="submit">Add Product <i class="bi bi-arrow-right"></i></button>
                        </div>
                    </form>
                </div>
            </div>



        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const thumbnailBox = document.getElementById('thumbnailBox');
            const thumbnailInput = document.getElementById('thumbnailInput');
            const uploadButton = document.getElementById('submit'); // Your upload button
            const thumbnailImage = document.getElementById('thumbnailImage');
            const insertTextThumbnail = document.getElementById('insertTextThumbnail');

            let processedImageBlob = null; // To hold the processed image blob

            // Click event to open file input
            thumbnailBox.addEventListener('click', function() {
                thumbnailInput.click();
            });

            // Change event to process the selected file
            thumbnailInput.addEventListener('change', async function(event) {
                const file = event.target.files[0]; // Only allow one file

                if (file) {
                    const formData = new FormData();
                    formData.append('image_file', file); // Original image for processing
                    formData.append('size', 'auto');

                    try {
                        const response = await fetch('https://api.remove.bg/v1.0/removebg', {
                            method: 'POST',
                            headers: {
                                'X-Api-Key': 'CtYArsrQUCrFHbajjVi9pbM9', // Replace with your Remove.bg API key
                            },
                            body: formData
                        });

                        if (response.ok) {
                            const blob = await response.blob(); // Get the processed image as a blob
                            const url = URL.createObjectURL(blob);

                            // Display the processed image
                            thumbnailImage.src = url; // Set the processed image to <img>
                            thumbnailImage.style.display = 'block'; // Make the image visible
                            insertTextThumbnail.style.display = 'none'; // Hide the insert text

                            // Store the processed image blob for later upload
                            processedImageBlob = blob; // Save the blob for later use

                            // Update the input file with the processed image
                            const processedFile = new File([blob], 'thumbnail.png', {
                                type: 'image/png'
                            });
                            const dataTransfer = new DataTransfer();
                            dataTransfer.items.add(processedFile);
                            thumbnailInput.files = dataTransfer.files; // Update the input's files
                        } else {
                            console.error('Failed to remove background:', response.statusText);
                        }
                    } catch (error) {
                        console.error('Error:', error);
                    }
                } else {
                    console.log('No file selected');
                }
            });

            // Add an event listener to the upload button
            uploadButton.addEventListener('click', function() {
                if (processedImageBlob) {
                    uploadProcessedImage(processedImageBlob); // Upload the processed image
                } else {
                    console.error('No processed image to upload.');
                }
            });

            // Function to upload the processed image to the server
            function uploadProcessedImage(blob) {
                const formData = new FormData();
                formData.append('productThumbnail', blob, 'thumbnail.png'); // Append the blob as a file with a name

                // Send the processed image to the server
                fetch('/addProducts-post', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // Add CSRF token for Laravel
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log('Image uploaded successfully:', data);
                    })
                    .catch(error => {
                        console.error('Error uploading image:', error);
                    });
            }
        });


        //plus minus sign

        // Get all the size selectors
        const sizeSelectors = document.querySelectorAll('.size-selector');

        // Loop through each size selector and attach event listeners
        sizeSelectors.forEach(selector => {
            const input = selector.querySelector('.size-input');
            const btnMinus = selector.querySelector('.btn-minus');
            const btnPlus = selector.querySelector('.btn-plus');

            // Minus button event
            btnMinus.addEventListener('click', () => {
                let currentValue = parseInt(input.value) || 0;
                if (currentValue > parseInt(input.min)) {
                    input.value = currentValue - 1;
                }
            });

            // Plus button event
            btnPlus.addEventListener('click', () => {
                let currentValue = parseInt(input.value) || 0;
                if (currentValue < parseInt(input.max)) {
                    input.value = currentValue + 1;
                }
            });
        });

        document.getElementById('addRowBtn').addEventListener('click', function() {
            var brandInputs = document.getElementById('brandInputs');
            var newRow = document.createElement('div');
            newRow.className = 'brand-row';
            newRow.innerHTML = '<label for="ProductBrand" class="form-label mt-2 text-center">Brand Name</label>';
            newRow.innerHTML = '<input class="form-control mb-2" type="text" name="brand[]" placeholder="Jordan" aria-label="default input example">';
            brandInputs.appendChild(newRow);
        });


        const thumbnailBox = document.getElementById('thumbnailBoxx');
        const thumbnailInput = document.getElementById('thumbnailInputt');
        const thumbnailImage = document.getElementById('thumbnailImagee');
        const insertText = document.getElementById('insertTextThumbnail');

        // When thumbnailBox is clicked, trigger the file input click
        thumbnailBox.addEventListener('click', function() {
            thumbnailInput.click();
        });

        // When an image is selected
        thumbnailInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    // Display the image and hide the placeholder text
                    thumbnailImage.src = e.target.result;
                    thumbnailImage.style.display = 'block';
                    insertText.style.display = 'none';
                }
                reader.readAsDataURL(file);
            }
        });
    </script>



</div>

<style>
    body {
        background-color: #C7C8CC;
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

    .addText {
        margin: 0;
    }

    .containerr {
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .card {
        margin: 40px;
        height: auto;
        box-shadow: 5px 7px gray;
        transition: background-color 0.3s ease, box-shadow 0.3s ease;
    }

    .card-link {
        text-decoration: none;
        display: block;
        width: 100%;
    }

    .card:hover {
        background-color: gray;
        box-shadow: none;
    }

    .card-body {
        padding: 25px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        height: 100%;
    }

    .hidden {
        display: none;
    }

    #addProductForm {
        position: absolute;
        top: 10%;
        left: 10%;
        width: 80%;
        padding: 20px;
        background-color: white;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        z-index: 1000;
        border-radius: 10px;
    }

    .cardone {
        transition: opacity 0.5s ease;
        margin: 15px;
    }

    .cardone.hidden {
        opacity: 0;
        pointer-events: none;
    }


    #thumbnailImage {
        display: none;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    #thumbnailImagee {
        display: none;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    #thumbnailBox {
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

    #thumbnailBoxx {
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


    .remove-btn {
        position: absolute;
        /* Position the button relative to the image box */
        top: 0;
        right: 0;
        background: red;
        /* Button color */
        color: white;
        /* Text color */
        border: none;
        /* Remove border */
        border-radius: 50%;
        /* Circular button */
        width: 20px;
        /* Button size */
        height: 20px;
        /* Button size */
        cursor: pointer;
        /* Pointer cursor */
    }

    .remove-btn:hover {
        background: darkred;
        /* Change color on hover */
    }

    input,
    select {
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        border-radius: 5px;
        /* Rounded corners for inputs */
    }

    .input-group {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
</style>

<script>
    document.getElementById('addProductLink').addEventListener('click', function(event) {
        event.preventDefault();

        // Hide all card items
        document.querySelectorAll('.cardone').forEach(function(card) {
            card.classList.add('hidden');
        });

        // Show the hidden section
        document.getElementById('addProductForm').style.display = 'block';
    });

    document.getElementById('closeForm').addEventListener('click', function() {
        // Show all card items
        document.querySelectorAll('.cardone').forEach(function(card) {
            card.classList.remove('hidden');
        });

        // Hide the hidden section
        document.getElementById('addProductForm').style.display = 'none';
    });
</script>