@extends('main')

@section('survey')
<div class="body">
    <div class="containerr">

        <div class="container p-3">

            <div>
                <h3 style="text-align: center;">Take your quiz, claim your pair!</h3>
                <hr>
            </div>
            <form action="{{ url('/survey') }}" method="POST">
                @csrf
        
                <label for="shoe_category">What kind of shoes you are looking for?</label>
                <select name="shoe_category" id="shoe_category" required>
                    @foreach ($categories as $category)
                        <option value="{{ $category->productCategory }}">{{ $category->productCategory }}</option>
                    @endforeach
                </select>
                <br>
        
                <label for="shoe_type">What type of shoes are you most comfortable with?</label>
                <select name="shoe_type" id="shoe_type" required>
                    @foreach ($shoeTypes as $type)
                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                    @endforeach
                </select>
                <br>
        
                <label for="fit">How wide are your feet?</label>
                <select name="fit" id="fit" required>
                    @foreach ($fits as $fit)
                        <option value="{{ $fit->id }}">{{ $fit->name }}</option>
                    @endforeach
                </select>
                <br>
        
                <label for="outdoor_use">Do you play outdoors a lot?</label>
                <select name="outdoor_use" id="outdoor_use" required>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>
                <br>
        
                <label for="brand">What shoe brands do you like?</label>
                <select name="brand" id="brand" required>
                    @foreach ($brands as $brand)
                        <option value="{{ $brand->productBrand }}">{{ $brand->productBrand }}</option>
                    @endforeach
                </select>
                <br>
        
                <label for="price">How much are you willing to spend?</label>
                <input type="number" name="price" id="price" placeholder="₱" required>
                <br>
        
                <button type="submit">Submit</button>
            </form>

        </div>

    </div>
</div>

<style>
    /* Body styling */
    .body {
        display: flex;
        justify-content: center;
        align-items: center;
        background-image: url('/storage/Images/bg.png');
        background-size: cover;
        background-position: center;
        position: relative;

        /* Remove padding to avoid extra space */
    }

    body {
        overflow: hidden;
    }

    /* Container styling */
    .containerr {
        width: 600px;
        max-height: 80vh;
        /* Limit height to 80% of the viewport */
        background: rgba(255, 255, 255, 0.9);
        /* Slightly more opaque for readability */
        backdrop-filter: blur(10px);
        padding: 2rem;
        /* Padding inside the container */
        border-radius: 10px;
        overflow-y: auto;
        /* Enable scroll when content exceeds the container's height */
        box-sizing: border-box;
        /* Include padding in the height calculation */
        display: flex;
        flex-direction: column;
        margin: 2rem;
        position: relative;
    }

    form {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    label,
    select,
    input,
    button {
        font-size: 1rem;
        padding: 8px;
        border-radius: 5px;
        border: 1px solid #ccc;
    }

    button {
        padding: 10px 20px;
        cursor: pointer;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 5px;
    }

    button:hover {
        background-color: #0056b3;
    }

    .btn-conteiner {
        display: flex;
        justify-content: center;
        --color-text: #ffffff;
        /* Text color remains white */
        --color-background: #007bff;
        /* Blue background */
        --color-outline: #007bff80;
        /* Semi-transparent blue outline */
        --color-shadow: #00000080;
        /* Shadow remains the same */
    }

    .btn-content {
        display: flex;
        align-items: center;
        padding: 3px 15px;
        /* Reduced padding */
        text-decoration: none;
        font-family: 'Poppins', sans-serif;
        font-weight: 600;
        font-size: 20px;
        /* Reduced font size */
        color: var(--color-text);
        background: var(--color-background);
        transition: 1s;
        border-radius: 100px;
        box-shadow: 0 0 0.2em 0 var(--color-background);
    }

    .btn-content:hover,
    .btn-content:focus {
        transition: 0.5s;
        -webkit-animation: btn-content 1s;
        animation: btn-content 1s;
        outline: 0.1em solid transparent;
        outline-offset: 0.2em;
        box-shadow: 0 0 0.4em 0 var(--color-background);
    }

    .btn-content .icon-arrow {
        transition: 0.5s;
        margin-right: 0px;
        transform: scale(0.6);
    }

    .btn-content:hover .icon-arrow {
        transition: 0.5s;
        margin-right: 15px;
        /* Adjusted margin for hover effect */
    }

    .icon-arrow {
        width: 16px;
        /* Reduced icon size */
        margin-left: 10px;
        /* Reduced margin */
        position: relative;
        top: 3%;
        /* Adjusted position */
    }

    /* SVG */
    #arrow-icon-one {
        transition: 0.4s;
        transform: translateX(-60%);
    }

    #arrow-icon-two {
        transition: 0.5s;
        transform: translateX(-30%);
    }

    .btn-content:hover #arrow-icon-three {
        animation: color_anim 1s infinite 0.2s;
    }

    .btn-content:hover #arrow-icon-one {
        transform: translateX(0%);
        animation: color_anim 1s infinite 0.6s;
    }

    .btn-content:hover #arrow-icon-two {
        transform: translateX(0%);
        animation: color_anim 1s infinite 0.4s;
    }

    /* SVG animations */
    @keyframes color_anim {
        0% {
            fill: white;
        }

        50% {
            fill: var(--color-background);
            /* Blue color */
        }

        100% {
            fill: white;
        }
    }

    /* Button animations */
    @-webkit-keyframes btn-content {
        0% {
            outline: 0.2em solid var(--color-background);
            outline-offset: 0;
        }
    }

    @keyframes btn-content {
        0% {
            outline: 0.2em solid var(--color-background);
            outline-offset: 0;
        }
    }


    h3 {
        text-align: center;
        margin-bottom: 1rem;
    }

    /* Scrollbar customization */
    .containerr::-webkit-scrollbar {
        width: 8px;
    }

    .containerr::-webkit-scrollbar-thumb {
        background: rgba(0, 0, 0, 0.3);
        border-radius: 10px;
    }

    .containerr::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
</style>
@endsection