@extends('main')

@section('putiton')

<div class="container">
    <div class="row mt-5">
    <div class="col-4 col-sm-4 col-md-4 col-lg-3">
            <div class="mobile-container">
                <div class="topnav" onclick="toggleMenu('sex')">
                    <a href="#home" class="active">Choose Sex</a>
                    <div id="sex">
                        <button class="color-button white-button" data-color="Male">Male</button>
                        <button class="color-button brown-button" data-color="Female">Female</button>
                    </div>
                </div>

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

                <!-- shoes -->
                <div class="topnav" onclick="toggleMenu('shoes')">
                    <a href="#home" class="active">Choose Shoe</a>
                    <div id="shoes">
                        <button class="color-button white-button" data-color="None">No Shoes</button>

                        @foreach($shoes as $shoe)
                        @if($shoe->productTryIt) <!-- Check if the JSON data is available -->
                        <button class="color-button white-button"
                            data-color="{{ $shoe->id }}"
                            data-image="{{ asset($shoe->productThumbnail) }}"
                            data-width="{{ $shoe->productTryIt['width'] }}"
                            data-height="{{ $shoe->productTryIt['height'] }}"
                            data-top="{{ $shoe->productTryIt['top'] }}"
                            data-left="{{ $shoe->productTryIt['left'] }}">
                            {{ $shoe->productName }}
                        </button>
                        @endif
                        @endforeach
                    </div>
                </div>


            </div>
        </div>

        <div class="col-8 col-sm-8 col-md-8 col-lg-6 mb-5 trryy">
            <img src="../images/male/FFDFC4.png" alt="Legs and Skin" class="imageImage" id="combinedImage">
            <img id="shoesImage" src="../images/shoeques.png" alt="Shoes" style="display: none;">
        </div>

        


    </div>
</div>


<script>
    // Prevent buttons from closing the topnav
    document.querySelectorAll('.color-button').forEach(button => {
        button.addEventListener('click', function(event) {
            event.stopPropagation(); // Prevent the click from reaching the topnav
            console.log('Button clicked:', this.dataset.color);
        });
    });

    var colorButtons = document.querySelectorAll('.color-button');
    var combinedImage = document.getElementById('combinedImage');
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



    var gPantsImage = null;
    var gShoesImage = null;

    document.addEventListener('DOMContentLoaded', function() {
        const pantsImage = document.getElementById('combinedImage');
        const shoesImage = document.getElementById('shoesImage');

        gPantsImage = pantsImage;
        gShoesImage = shoesImage;

        // Function to log the size of the combined image
        function logCombinedImageSize() {
            const combinedRect = pantsImage.getBoundingClientRect();
            console.log('Combined Image Size:', combinedRect);
            console.log('Width:', combinedRect.width);
            console.log('Height:', combinedRect.height);
            console.log('Top:', combinedRect.top);
            console.log('Left:', combinedRect.left);
        }


        // Event listener for color button selection
        document.querySelectorAll('.color-button').forEach(button => {
            button.addEventListener('click', function() {
                if (this.getAttribute('data-color') === 'None') {
                    shoesImage.style.display = 'none';
                } else {
                    updateShoeDimensions(this);
                }
            });
        });

        // Ensure the first shoe is selected when the page loads (if available)
        const firstShoe = document.querySelector('.color-button[data-color]:not([data-color="None"])');
        if (firstShoe) {
            firstShoe.click();
        }

        // Event listener for window resize to log the combined image size
        window.addEventListener('resize', function() {
            /* const shoeSrc = shoesImage.src;
            if (shoeSrc) {
                const button = document.querySelector(`button[data-image="${shoeSrc}"]`);
                if (button) {
                    updateShoeDimensions(button);
                }
            } */

            resizeShoes();
        });


    });

    function toggleMenu(menuId) {
        var menu = document.getElementById(menuId);
        if (menu.style.height === "0px" || menu.style.height === "") {
            menu.style.height = menu.scrollHeight + "px"; // Expand to the full height of the content
        } else {
            menu.style.height = "0"; // Collapse the menu
        }

        resizeShoes();
    }

    function resizeShoes() {
        const shoeSrc = gShoesImage.src;
        if (shoeSrc) {
            const button = document.querySelector(`button[data-image="${shoeSrc}"]`);
            if (button) {
                updateShoeDimensions(button);
            }
        }
    }

    // Function to adjust the shoe size and position based on the pants container
    function adjustShoePosition(widthPercent, heightPercent, topPercent, leftPercent) {
        const pantsRect = gPantsImage.getBoundingClientRect(); // Get dimensions of the combined image containergPantsImage.getBoundingClientRect(); // Get dimensions of the combined image container
        //const pantsRect = $("#combinedImage");
        console.log(pantsRect);
        /*var shoeImageHeight = $("#shoesImage").height();
            var shoeImageWidth = $("#shoesImage").width();
           */
        //alert(pantsRect);

        // Calculate shoe dimensions as a percentage of pants container
        const shoeWidth = (pantsRect.width * widthPercent) / 100;
        const shoeHeight = (pantsRect.height * heightPercent) / 100;
        const shoeTop = (pantsRect.top + (pantsRect.height * topPercent) / 100);
        const shoeLeft = (pantsRect.left + (pantsRect.width * leftPercent) / 100);


        // Set the shoe's dimensions based on the calculated values
        gShoesImage.style.width = shoeWidth + 'px';
        gShoesImage.style.height = shoeHeight + 'px';
        gShoesImage.style.top = shoeTop + 'px';
        gShoesImage.style.left = shoeLeft + 'px';

        // Ensure the shoe is visible and correctly positioned
        gShoesImage.style.display = 'block';
    }

    // Function to update the shoe based on button click
    function updateShoeDimensions(shoeButton) {
        const shoeSrc = shoeButton.getAttribute('data-image');
        const widthPercent = parseFloat(shoeButton.getAttribute('data-width'));
        const heightPercent = parseFloat(shoeButton.getAttribute('data-height'));
        const topPercent = parseFloat(shoeButton.getAttribute('data-top'));
        const leftPercent = parseFloat(shoeButton.getAttribute('data-left'));

        gShoesImage.style.visibility = 'hidden';
        gShoesImage.src = shoeSrc;

        gShoesImage.onload = function() {
            // Adjust the shoe's size and position based on the shoe's specific percentage values
            adjustShoePosition(widthPercent, heightPercent, topPercent, leftPercent);
            gShoesImage.style.visibility = 'visible';
        };
    }
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

    #combinedImage {
        width: 100%;
        /* Make sure the image is responsive */
        height: auto;
        /* Automatically adjust the height to maintain aspect ratio */
        position: relative;
        /* Make sure shoesImage is positioned relative to this */
    }

    #shoesImage {
        position: absolute;
        /* Position relative to #combinedImage */
        display: none;
        /* Hide the shoe initially */
        z-index: 2;
        /* Ensure it's above the combined image */
    }
</style>

@endsection