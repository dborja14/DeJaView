@extends('layout.link')
<link rel="icon" type="image/x-icon" href="storage/images/updatedLogo.png">

<div class="row justify-content-center mt-5 mb-5">
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header d-flex justify-content-center align-items-center">
                <img src="storage/Images/updatedLogo.png" alt="" width="150px" height="150px">
            </div>
            <div class="card-body">
                @if(Session::has('error'))
                <div class="alert alert-danger" role="alert">
                    {{ Session::get('error') }}
                </div>
                @endif
                <form action="{{ route('registerpost')}}" method="post" enctype="multipart/form-data">
                    @csrf


                    <div class="form-outline mb-1">
                        <div class="coolinput">
                            <label for="input" class="text">Email</label>
                            <input type="text" placeholder="Write here..." name="email" id="email" class="input" required>
                        </div>
                    </div>

                    <div class="form-outline mb-1">
                        <div class="coolinput">
                            <label for="input" class="text">Username</label>
                            <input type="text" placeholder="Write here..." name="username" id="username" class="input" required>
                        </div>
                    </div>

                    <div class="form-outline mb-1">
                        <div class="coolinput">
                            <label for="input" class="text">Password</label>
                            <input type="password" placeholder="Write here..." name="password" id="passShow" class="input" required>
                            <i onclick="showPass()" class="bi bi-eye-slash position-absolute" id="togglePassword" style="font-size: large;"></i>
                        </div>
                    </div>

                    <div class="form-outline mb-1">
                        <div class="coolinput">
                            <label for="inputState" class="text">Security Question</label>
                            <select id="inputState" name="security_question" class="input">
                                <option selected>Choose...</option>
                                <option value="What was your first sneaker?">What was your first sneaker?</option>
                                <option value="Who inspires you to collect shoes?">Who inspires you to collect shoes?</option>
                                <option value="What is your favorite pair?">What is your favorite shoe?</option>
                            </select>
                        </div>
                    </div>


                    <div class="form-outline mb-1">
                        <div class="coolinput">
                            <label for="input" class="text">Answer</label>
                            <input type="text" placeholder="Write here..." name="security_answer" class="input" required>
                        </div>
                    </div>


                    <div id="thumbnailBox">
                        <label class="form-label" for="form2Example27">Insert ID</label>

                        <div class="thumbnailPicture" id="thumbnailDisplay">
                            <p>Please insert Identification Card here</p>
                        </div>
                        <input type="file" id="thumbnailInput" class="box2" name="productSecond" accept="image/*" style="display: none;">
                    </div>

                    <label for="" style="color: red; display:flex; justify-content:center; align-items: center;">"Please be advised that this photo will stored in our records."</label>

                    <div class="pt-1 mt-3 mb-3 d-flex justify-content-center align-items-center">
                        <button alt="REGISTER" name="submit" type="submit">
                            <i>R</i>
                            <i>E</i>
                            <i>G</i>
                            <i>I</i>
                            <i>S</i>
                            <i>T</i>
                            <i>E</i>
                            <i>R</i>
                        </button>
                    </div>
                    <div class="d-flex justify-content-center align-items-center">

                        <a href="../login" style="text-decoration: none; color:black">
                            <span class="box">
                                Already have an account?
                            </span>

                        </a>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>

<style>
    body {
        margin: 0;
        width: 100%;
        overflow-x: hidden;
        background-image: url('/storage/Images/gg.png');
        /* Corrected */
        background-size: cover;
        /* Ensure the image covers the entire background */
        background-position: center;
    }

    .thumbnailPicture {
        width: 100%;
        padding: 5px;
        height: 150px;
        display: flex;
        justify-content: center;
        align-items: center;
        border: none;
        border-top: 2px dotted #ddd;
        border-bottom: 2px dotted #ddd;
        border-left: 2px dotted #ddd;
        border-right: 2px dotted #ddd;
        margin: 0 auto;
        position: relative;
        border-radius: 10px;
    }

    .thumbnailPicture img {
        max-width: 100%;
        max-height: 100%;
        object-fit: cover;
        display: block;
    }

    .container {
        width: 100%;
        height: 100vh;
        background: rgba(255, 255, 255, 0.5);
        /* Semi-transparent layer */
        backdrop-filter: blur(10px);
        /* Blurs the background behind the content */
    }

    #togglePassword {
        right: 32px;
        /* Adjust as needed */
        top: 39%;
        /* Vertically center */
        cursor: pointer;
        z-index: 1;
        /* Ensure the icon is above the input */
    }

    .coolinput {
        display: flex;
        flex-direction: column;
        width: fit-content;
        position: static;
        max-width: 100%;
        width: 100%;
    }

    .coolinput label.text {
        font-size: 0.75rem;
        color: #818CF8;
        font-weight: 700;
        position: relative;
        top: 0.5rem;
        margin: 0 0 0 7px;
        padding: 0 3px;
        background: white;
        width: fit-content;
    }

    .coolinput input[type=text].input {
        padding: 11px 10px;
        font-size: 0.75rem;
        border: 2px #818CF8 solid;
        border-radius: 5px;
        background: white;
        width: 100%;
    }

    .coolinput input[type=text].input:focus {
        outline: none;
    }

    .coolinput input[type=password].input {
        padding: 11px 10px;
        font-size: 0.75rem;
        border: 2px #818CF8 solid;
        border-radius: 5px;
        background: white;
        width: 100%;
    }

    .coolinput input[type=password].input:focus {
        outline: none;
    }

    .coolinput select.input {
        padding: 11px 10px;
        font-size: 0.75rem;
        border: 2px #818CF8 solid;
        border-radius: 5px;
        background: white;
        color: #333;
        width: 100%;
        appearance: none;
        /* Removes default dropdown arrow */
    }

    .coolinput select.input:focus {
        outline: none;
    }

    .coolinput select.input option {
        color: #333;
        /* Ensures options text is visible */
    }

    .coolinput select.input {
        background-image: url('data:image/svg+xml;charset=UTF-8,<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="%23818CF8" class="bi bi-caret-down-fill" viewBox="0 0 16 16"><path d="M3.204 5h9.592L8 10.481 3.204 5z"/></svg>');
        background-repeat: no-repeat;
        background-position: right 10px center;
        background-size: 12px;
    }

    .box {
        width: 260px;
        height: auto;
        float: left;
        transition: .5s linear;
        position: relative;
        display: block;
        overflow: hidden;
        padding: 15px;
        text-align: center;
        margin: 0 5px;
        background: transparent;
        text-transform: uppercase;
        font-weight: 900;
    }

    .box:before {
        position: absolute;
        content: '';
        left: 0;
        bottom: 0;
        height: 4px;
        width: 100%;
        border-bottom: 4px solid transparent;
        border-left: 4px solid transparent;
        box-sizing: border-box;
        transform: translateX(100%);
        border-radius: 10px;
    }

    .box:after {
        position: absolute;
        content: '';
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        border-top: 4px solid transparent;
        border-right: 4px solid transparent;
        box-sizing: border-box;
        transform: translateX(-100%);
        border-radius: 10px;
    }

    .box:hover {
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.5);
        border-radius: 10px;
    }

    .box:hover:before {
        border-color: #262626;
        height: 100%;
        transform: translateX(0);
        transition: .3s transform linear, .3s height linear .3s;
        border-radius: 10px;
    }

    .box:hover:after {
        border-color: #262626;
        height: 100%;
        transform: translateX(0);
        transition: .3s transform linear, .3s height linear .5s;
        border-radius: 10px;
    }

    .buttonn {
        color: black;
        text-decoration: none;
        cursor: pointer;
        outline: none;
        border: none;
        background: transparent;
    }

    button {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 50px;
        width: 100%;
        position: relative;
        padding: 0 20px;
        font-size: 18px;
        text-transform: uppercase;
        border: 0;
        box-shadow: hsl(210deg 87% 36%) 0px 7px 0px 0px;
        background-color: hsl(210deg 100% 44%);
        border-radius: 12px;
        overflow: hidden;
        transition: 31ms cubic-bezier(.5, .7, .4, 1);
    }

    button:before {
        content: attr(alt);
        display: flex;
        align-items: center;
        justify-content: center;
        position: absolute;
        inset: 0;
        font-size: 15px;
        font-weight: bold;
        color: white;
        letter-spacing: 4px;
        opacity: 1;
    }

    button:active {
        box-shadow: none;
        transform: translateY(7px);
        transition: 35ms cubic-bezier(.5, .7, .4, 1);
    }

    button:hover:before {
        transition: all .0s;
        transform: translateY(100%);
        opacity: 0;
    }

    button i {
        color: white;
        font-size: 15px;
        font-weight: bold;
        letter-spacing: 4px;
        font-style: normal;
        transition: all 2s ease;
        transform: translateY(-20px);
        opacity: 0;
    }

    button:hover i {
        transition: all .2s ease;
        transform: translateY(0px);
        opacity: 1;
    }

    button:hover i:nth-child(1) {
        transition-delay: 0.045s;
    }

    button:hover i:nth-child(2) {
        transition-delay: calc(0.045s * 3);
    }

    button:hover i:nth-child(3) {
        transition-delay: calc(0.045s * 4);
    }

    button:hover i:nth-child(4) {
        transition-delay: calc(0.045s * 5);
    }

    button:hover i:nth-child(6) {
        transition-delay: calc(0.045s * 6);
    }

    button:hover i:nth-child(7) {
        transition-delay: calc(0.045s * 7);
    }

    button:hover i:nth-child(8) {
        transition-delay: calc(0.045s * 8);
    }

    button:hover i:nth-child(9) {
        transition-delay: calc(0.045s * 9);
    }

    button:hover i:nth-child(10) {
        transition-delay: calc(0.045s * 10);
    }

</style>

<script>
    function showPass() {
        const passwordInput = document.getElementById('passShow');
        const toggleIcon = document.getElementById('togglePassword');

        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            toggleIcon.classList.remove('bi-eye-slash');
            toggleIcon.classList.add('bi-eye');
        } else {
            passwordInput.type = "password";
            toggleIcon.classList.remove('bi-eye');
            toggleIcon.classList.add('bi-eye-slash');
        }
    }

    // Get elements
    const thumbnailBox = document.getElementById('thumbnailBox');
    const thumbnailInput = document.getElementById('thumbnailInput');
    const thumbnailDisplay = document.getElementById('thumbnailDisplay');
    const insertTextThumbnail = document.getElementById('insertTextThumbnail');

    // Add click event to thumbnail box
    thumbnailBox.addEventListener('click', function() {
        thumbnailInput.click(); // Trigger file input click
    });

    // Add change event to file input
    thumbnailInput.addEventListener('change', function(event) {
        const file = event.target.files[0]; // Get the selected file
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                // Create an image element and set its source
                const img = document.createElement('img');
                img.src = e.target.result;
                img.alt = 'Selected Image';
                img.style.maxWidth = '100%'; // Set max width to fit in the box
                img.style.maxHeight = '100%'; // Set max height to fit in the box

                // Clear the display and show the image
                thumbnailDisplay.innerHTML = ''; // Remove previous content
                thumbnailDisplay.appendChild(img); // Append the image

                // Remove the p tag for input validation
                insertTextThumbnail.style.display = 'none'; // Hide input validation text
            };
            reader.readAsDataURL(file); // Read the selected file
        }
    });
</script>