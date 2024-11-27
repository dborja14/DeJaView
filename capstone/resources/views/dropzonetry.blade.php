@include('layout.link')

<div class="header" style="display: flex; align-items: center; justify-content: space-between; margin-bottom:5rem;">
    <a class="navbar-brand" href="#"><img src="/images/loogoos.png" width="140" height="40" alt="Logo"></a>
    <div class="separator"></div>
    <p class="addText">Upload Images</p>
    <a href="../admin" style="text-decoration: none; color: black; justify-content: end; margin-left: auto;">
        <i class="bi bi-arrow-90deg-left" style="font-size:14px;"></i> Go back
    </a>
</div>

<div class="container">
    <h1>Upload Multiple Images</h1>
    <small style="color: red;">Please upload photos around the shoes so that we can achieve 3d spinnable feature.</small>
    <p style="margin-top: 3rem;">Steps on how to properly upload the photos:</p>
    <ul>
        <li>Take pictures of the shoes from different angles so that when uploaded, they can be viewed in a rotating manner.</li>
        <li>Upload the photos here in the correct order.</li>
        <li>Enjoy your product!</li>
    </ul>

    <form action="{{ route('images.upload') }}" class="dropzone" id="image-dropzone" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="productId" value="{{ $product->id }}" class="inputBox">
    </form>



    <div style="display: flex; justify-content: end; margin-left:0;">

        <button id="upload-button" class="btn btn-primary">Upload All</button>
    </div>



    <div class="row mb-5">
        <div class="col-12 col-sm-12 col-md-6 col-lg-6 d-none d-md-block">
            <h3>One Example of 3D Spinnable Feature.</h3>
            <img src="../storage/uploads/11-jordan01.jpg" width="500" height="500"
                class="reel"
                id="image"
                data-images="../storage/uploads/11-jordan##.jpg|01..40"
                data-cw="false"
                data-frame="32"
                data-speed="-0.2"
                data-duration="6"
                data-velocity="3">
        </div>


        <div class="col-12 col-sm-12 col-md-6 col-lg-6">

            <h3>This is how you can upload it here</h3>

            <img src="../storage/images/upload.png" alt="" style="width: 100%;">
        </div>
    </div>



</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.js"></script>

<style>
    .header {
        width: 100%;
        background-color: white;
        height: 3rem;
        display: flex;
        align-items: center;
        padding: 0 25px;
        box-sizing: border-box;
    }

    .addText {
        margin: 0;
    }

    .navbar-brand img {
        margin-right: 15px;
    }

    .dropzone {
        border-radius: 10px;
    }
</style>


<script>
    Dropzone.autoDiscover = false;
    var myDropzone = new Dropzone("#image-dropzone", {
        autoProcessQueue: false,
        maxFilesize: 2,
        parallelUploads: 60,
        acceptedFiles: "image/*",
        paramName: "file[]", // This will send files as file[] instead of file
        init: function() {
            this.on("sending", function(file, xhr, formData) {
                formData.append("productId", document.querySelector('input[name="productId"]').value);
            });
        }
    });

    document.getElementById("upload-button").addEventListener("click", function() {
        myDropzone.processQueue(); // Start the upload
    });


    myDropzone.on("error", function(file, response) {
        if (typeof response === 'string') {

            console.error(response);
            alert('Error: ' + response);
        } else {

            console.error(response.errors);
            alert('Upload failed: ' + JSON.stringify(response.errors));
        }
    });
</script>