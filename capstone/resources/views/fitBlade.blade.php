@include('layout.link')
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DeJaVu</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('../Resources/CSS/css.css')}}" />
    <link rel="stylesheet" href="https://code.jquery.com/jquery.reel.css">
    <link rel="icon" type="image/x-icon" href="storage/images/updatedLogo.png">


    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <!--<script src="https://code.jquery.com/jquery.reel.min.js"></script>-->


    <!--<script src="/js/jquery.reel.min.js"></script>-->

    <script src="/js/jquery.reel.js"></script>


</head>




<body style=" min-height: 100vh; display: flex; flex-direction: column;">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#"><img src="/storage/Images/updatedLogo.png" width="60" height="60" alt="Logo"></a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            @if(Session::has('loginId'))

            <div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="../admin">Go Back</a>
                    </li>
                </ul>
            </div>

            @endif



            <!-- Login/Logout Section -->
            @if(Session::has('loginId'))
            <div class="dropup d-lg-none position-fixed bottom-0 end-0 m-3">
                <button class="btn btn-outline-secondary dropdown-toggle icon-lg" type="button" data-bs-toggle="dropdown">
                    <i class="bi bi-person"></i>
                </button>

                <ul class="dropdown-menu dropdown-menu-end">

                    <li><a class="dropdown-item" href="../sellProduct">Sell Product</a></li>
                    <li><a class="dropdown-item" href="{{ url('logout') }}">Logout</a></li>
                </ul>
            </div>
            @else
            <div class="d-lg-none position-fixed bottom-0 end-0 m-3 icon-lg">
                <a class="btn btn-outline-secondary" href="login">
                    <i class="bi bi-person"></i>
                </a>
            </div>
            @endif

            <!-- Regular Login/Logout Section -->
            @if(Session::has('loginId'))
            <div class="d-none d-lg-block">
                <div class="dropdown">
                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        {{ Session::get('user.name') }}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ url('logout') }}">Logout</a></li>
                        <li><a class="dropdown-item" href="../cart">View Messages</a></li>
                    </ul>
                </div>
            </div>
            @else
            <div class="d-none d-lg-block">
                <a class="btn btn-outline-secondary" href="login">Login</a>
            </div>
            @endif
        </div>
    </nav>

    <style>
        .navbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }


        .navbar-collapse {
            flex-grow: 1;
            display: flex;
            justify-content: center;
        }

        .navbar-nav {
            flex-direction: row;
        }

        .navbar-nav .active {
            border: none;
            border-bottom: 1px solid black;
        }



        .navbar-nav .nav-item {
            margin-left: 1rem;
        }

        .dropdown-menu-end {
            right: 0;
            left: auto;
        }

        .navbar-brand {
            margin-right: auto;
        }

        .navbar-toggler {
            margin-left: auto;
        }
    </style>

    <div class="container">
        <div class="row mt-5">
            <div class="col-3 col-sm-0 col-md-4 col-lg-3 d-none d-md-block">
                <div class="mobile-container">

                    <div class="topnav" onclick="toggleMenu('sex')">
                        <a href="#home" class="active">Choose Sex</a>
                        <div id="sex">
                            <button class="color-button white-button" data-color="Male">Male</button>
                            <button class="color-button brown-button" data-color="Female">Female</button>
                        </div>
                    </div>
                    <!-- skin color -->
                    <div class="topnav" onclick="toggleMenu('skinColor')">
                        <a href="#home" class="active">Choose Skin Color</a>
                        <div id="skinColor" class="justify-content-center align-items-center m-2">
                            <button class="color-button white-button" data-color="FFDFC4" style="background-color: #FFDFC4; width: 70px; height: 40px; border: 2px solid black;"></button>
                            <button class="color-button white-button" data-color="EACBA8" style="background-color: #EACBA8; width: 70px; height: 40px; border: 2px solid black;"></button>
                            <button class="color-button white-button" data-color="F7E2AB" style="background-color: #F7E2AB; width: 70px; height: 40px; border: 2px solid black;"></button>
                            <button class="color-button white-button" data-color="DCB991" style="background-color: #DCB891; width: 70px; height: 40px; border: 2px solid black;"></button>
                            <button class="color-button white-button" data-color="F0C08A" style="background-color: #F0C08A; width: 70px; height: 40px; border: 2px solid black;"></button>
                            <button class="color-button white-button" data-color="E7BC91" style="background-color: #E7BC91; width: 70px; height: 40px; border: 2px solid black;"></button>
                            <button class="color-button white-button" data-color="ECBF83" style="background-color: #ECBF83; width: 70px; height: 40px; border: 2px solid black;"></button>
                            <button class="color-button white-button" data-color="CF9E7C" style="background-color: #CF9E7C; width: 70px; height: 40px; border: 2px solid black;"></button>
                            <button class="color-button white-button" data-color="AC8B64" style="background-color: #AC8B64; width: 70px; height: 40px; border: 2px solid black;"></button>
                            <button class="color-button white-button" data-color="94613C" style="background-color: #94613C; width: 70px; height: 40px; border: 2px solid black;"></button>
                            <button class="color-button white-button" data-color="B26A49" style="background-color: #B26A49; width: 70px; height: 40px; border: 2px solid black;"></button>
                            <button class="color-button white-button" data-color="AE703A" style="background-color: #AE703A; width: 70px; height: 40px; border: 2px solid black;"></button>
                            <button class="color-button white-button" data-color="99644D" style="background-color: #99644D; width: 70px; height: 40px; border: 2px solid black;"></button>
                            <button class="color-button white-button" data-color="623A18" style="background-color: #623A18; width: 70px; height: 40px; border: 2px solid black;"></button>
                            <button class="color-button white-button" data-color="3F281B" style="background-color: #3F2818; width: 70px; height: 40px; border: 2px solid black;"></button>

                        </div>
                    </div>

                    <!-- legs -->
                    <div class="topnav" onclick="toggleMenu('legs')">
                        <a href="#home" class="active">Choose Legs</a>
                        <div id="legs">
                            <button class="color-button white-button" data-color="Pants">Pants</button>
                            <button class="color-button brown-button" data-color="Shorts">Shorts</button>
                            <button class="color-button brown-button" data-color="Skirt">Skirt</button>
                            <button class="color-button brown-button" data-color="Pantss">Pants</button>
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-9 col-sm-9 col-md-8 col-lg-6">
                <img src="../images/male/FFDFC4.png" alt="Legs and Skin" width="900px" height="900px" class="imageImage" id="combinedImage">
                <img id="shoesImage" src="{{asset($product->productThumbnail)}}" alt="Shoes">
            </div>

            <div class="col-9 col-sm-9 col-md-4 col-lg-3">
                <div>
                    <label for="widthSlider">Adjust Shoe Width <span id="widthValue"></span> </label>
                    <input type="range" id="widthSlider" min="100" max="800" value="420">
                </div>
                <div>
                    <label for="heightSlider">Adjust Shoe Height <span id="heightValue"></span> </label>
                    <input type="range" id="heightSlider" min="100" max="800" value="420">
                </div>
                <div>
                    <label for="topSlider">Adjust Top Position <span id="topValue"></span> </label>
                    <input type="range" id="topSlider" min="300" max="700" value="30">
                </div>
                <div>
                    <label for="leftSlider">Adjust Left Position <span id="leftValue"></span> </label>
                    <input type="range" id="leftSlider" min="600" max="1000" value="118">
                </div>

                <form action="{{ route('save.shoe.dimensions') }}" method="post">
                    @csrf

                    <input type="hidden" name="shoe_id" value="{{ $product->id }}">
                    <input type="hidden" name="dimensions" id="dimensionsInput">
                    <input type="hidden" name="top" id="topInput">
                    <input type="hidden" name="left" id="leftInput">
                    <button type="submit" class="btn btn-primary">Save Dimensions</button>
                </form>

            </div>



        </div>
    </div>

    <footer class="bg-dark text-light text-center py-3 mt-5" style="bottom:0; width:100%; margin-top: auto !important;">
        <div class="container">
            <p>&copy; Sole Mate PH Est. 2020</p>
        </div>
    </footer>

</body>

</html>


<script>
    function toggleMenu(menuId) {
        var menu = document.getElementById(menuId);
        if (menu.style.height === "0px" || menu.style.height === "") {
            menu.style.height = menu.scrollHeight + "px"; // Expand to the full height of the content
        } else {
            menu.style.height = "0"; // Collapse the menu
        }
    }

    // Prevent buttons from closing the topnav
    document.querySelectorAll('.color-button').forEach(button => {
        button.addEventListener('click', function(event) {
            event.stopPropagation(); // Prevent the click from reaching the topnav
            console.log('Button clicked:', this.dataset.color);
        });
    });

    var colorButtons = document.querySelectorAll('.color-button');
    var combinedImage = document.getElementById('combinedImage'); // Updated to use the combined image
    var shoesImage = document.getElementById('shoesImage');

    // Add click event listener to each color button
    colorButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            var selectedColor = this.getAttribute('data-color');
            var shoeImagePath = this.getAttribute('data-image');

            // Check for Male or Female selection
            if (['Male', 'Female'].includes(selectedColor)) {
                $("#sex button").removeClass('selected');
                if (selectedColor === 'Male') {
                    $(this).addClass('selected');
                    $('#legs button').show();
                    $('#legs button[data-color="Skirt"]').hide();
                    $('#legs button[data-color="Pantss"]').hide();
                    combinedImage.src = '../images/male/FFDFC4.png'; // Default Male image
                } else if (selectedColor === 'Female') {
                    $(this).addClass('selected');
                    $('#legs button').show();
                    $('#legs button[data-color="Shorts"], button[data-color="Pants"]').hide();
                    combinedImage.src = '../images/female/FFDFC4.png'; // Default Female image
                }
            }
            // Check for legwear selection
            else if (['Shorts', 'Pants', 'Skirt', 'Pantss'].includes(selectedColor)) {
                var gender = $('#sex button.selected').data('color');
                if (gender === 'Male') {
                    if (selectedColor === 'Shorts') {
                        combinedImage.src = '../images/male/FFDFC4.png';
                    } else if (selectedColor === 'Pants') {
                        combinedImage.src = '../images/pants.png';
                    }
                } else if (gender === 'Female') {
                    if (selectedColor === 'Skirt') {
                        combinedImage.src = '../images/female/FFDFC4.png';
                    } else if (selectedColor === 'Pantss') {
                        combinedImage.src = '../images/pants.png';
                    }
                }
            }
            // Check for skin color selection
            else if (['FFDFC4', 'EACBA8', 'F7E2AB', 'DCB991', 'F0C08A', 'E7BC91', 'ECBF83', 'CF9E7C', 'AC8B64', '94613C', 'B26A49', 'AE703A', '99644D', '623A18', '3F281B'].includes(selectedColor)) {
                combinedImage.src = `../images/${$('#sex button.selected').data('color').toLowerCase()}/${selectedColor}.png`;
            }
            // Check for shoe selection
            else {
                if (selectedColor === 'None') {
                    shoesImage.style.display = 'none';
                } else {
                    shoesImage.style.display = 'block';
                    shoesImage.src = shoeImagePath;
                }
            }
        });
    });



    document.addEventListener('DOMContentLoaded', function() {
        const pantsImage = document.getElementById('combinedImage');
        const shoesImage = document.getElementById('shoesImage');

        const widthSlider = document.getElementById("widthSlider");
        const heightSlider = document.getElementById("heightSlider");
        const topSlider = document.getElementById("topSlider");
        const leftSlider = document.getElementById("leftSlider");

        const dimensionsInput = document.getElementById("dimensionsInput");
        const topInput = document.getElementById("topInput");
        const leftInput = document.getElementById("leftInput");

        // Initial percentages for shoe dimensions relative to pantsImage
        let shoeWidthPercent = 22;
        let shoeHeightPercent = 40;
        let shoeTopPercent = 50;
        let shoeLeftPercent = 70;

        function adjustShoePosition() {
            const pantsRect = pantsImage.getBoundingClientRect();

            // Apply calculated percentage values
            shoesImage.style.width = (pantsRect.width * shoeWidthPercent / 100) + 'px';
            shoesImage.style.height = (pantsRect.height * shoeHeightPercent / 100) + 'px';

            shoesImage.style.top = (pantsRect.top + (pantsRect.height * shoeTopPercent / 100)) + 'px';
            shoesImage.style.left = (pantsRect.left + (pantsRect.width * shoeLeftPercent / 100)) + 'px';

            shoesImage.style.display = 'block';
        }

        function updateHiddenInputs() {
            // Set hidden inputs for form submission
            dimensionsInput.value = `${shoeWidthPercent.toFixed(2)}x${shoeHeightPercent.toFixed(2)}`;
            topInput.value = shoeTopPercent.toFixed(2);
            leftInput.value = shoeLeftPercent.toFixed(2);

            // Display the current percentage values
            document.getElementById("widthValue").innerText = `${shoeWidthPercent.toFixed(2)}%`;
            document.getElementById("heightValue").innerText = `${shoeHeightPercent.toFixed(2)}%`;
            document.getElementById("topValue").innerText = `${shoeTopPercent.toFixed(2)}%`;
            document.getElementById("leftValue").innerText = `${shoeLeftPercent.toFixed(2)}%`;
        }

        // Event listeners to update values based on sliders
        widthSlider.addEventListener('input', function() {
            shoeWidthPercent = Math.min(100, (parseInt(this.value, 10) / pantsImage.clientWidth) * 100);
            updateHiddenInputs();
            adjustShoePosition();
        });

        heightSlider.addEventListener('input', function() {
            shoeHeightPercent = Math.min(100, (parseInt(this.value, 10) / pantsImage.clientHeight) * 100);
            updateHiddenInputs();
            adjustShoePosition();
        });

        topSlider.addEventListener('input', function() {
            shoeTopPercent = Math.min(100, ((parseInt(this.value, 10) - pantsImage.offsetTop) / pantsImage.clientHeight) * 100);
            updateHiddenInputs();
            adjustShoePosition();
        });

        leftSlider.addEventListener('input', function() {
            shoeLeftPercent = Math.min(100, ((parseInt(this.value, 10) - pantsImage.offsetLeft) / pantsImage.clientWidth) * 100);
            updateHiddenInputs();
            adjustShoePosition();
        });

        // Initialize on page load
        window.addEventListener('resize', adjustShoePosition);
        adjustShoePosition();
        updateHiddenInputs();
    });
</script>


<style>
    /* General Slider Styling */
    input[type="range"] {
        -webkit-appearance: none;
        width: 100%;
        height: 10px;
        background: #ddd;
        border-radius: 5px;
        outline: none;
        opacity: 0.7;
        transition: opacity 0.2s;
        margin-bottom: 20px;
    }


    input[type="range"]::-webkit-slider-thumb {
        -webkit-appearance: none;
        appearance: none;
        width: 20px;
        height: 20px;
        background: #33372C;
        border-radius: 50%;
        cursor: pointer;
        box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.2);
        transition: background-color 0.3s;
    }

    #widthSlider,
    #heightSlider,
    #topSlider,
    #leftSlider {
        border-radius: 10px;
        background-color: #f0f0f0;
    }

    #shoesImage {
        position: absolute;
        /* Allows positioning within the container */
        display: none;
        /* Initially hide the shoe image until selected */
    }


    #combinedImage {
        max-width: 100%;
        /* Ensure it scales down on smaller screens */
        height: auto;
        /* Maintain aspect ratio */
        display: block;
        /* Center the image */
        margin: 0 auto;
        /* Centering */
        position: relative;
        /* Necessary for absolute positioning of shoes */
    }


    .mobile-container {
        max-width: 100%;
        color: white;
        border-radius: 10px;
    }

    .topnav {
        overflow: hidden;
        background-color: #33372C;
        position: relative;
        border-radius: 10px;
        margin: 1rem;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .topnav div {
        height: 0;
        overflow: hidden;
        transition: height 0.4s ease-out;
    }

    .topnav a {
        color: white;
        padding: 14px 16px;
        text-decoration: none;
        font-size: 17px;
        display: block;
    }

    .topnav a.icon {
        display: block;
        position: absolute;
        right: 0;
        top: 0;
    }

    .topnav a:hover {
        background-color: #ddd;
        color: black;
    }

    .active {
        background-color: #33372C;
        color: white;
    }

    .color-button {
        background-color: transparent;
        border: 1px solid white;
        color: white;
        padding: 10px;
        margin: 5px;
        cursor: pointer;
    }

    .color-button:hover {
        background-color: white;
        color: black;
    }
</style>