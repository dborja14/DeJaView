@extends('layout.link')

<link rel="icon" type="image/x-icon" href="storage/images/updatedLogo.png">

<div class="row justify-content-center mt-5">
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
                <form action="{{ route('login.submit') }}" method="POST">
                    @csrf
                    <div class="mb-3">

                        <div class="coolinput">
                            <label for="input" class="text">Username</label>
                            <input type="text" placeholder="Write here..." name="name" id="email" class="input" required>
                        </div>
                    </div>
                    <div class="mb-3 position-relative">

                        <div class="coolinput">
                            <label for="input" class="text">Password</label>
                            <input type="password" placeholder="Write here..." name="password" id="password" class="input" required>
                            <i onclick="showPass()" class="bi bi-eye-slash position-absolute" id="togglePassword" style="font-size: large;"></i>
                        </div>
                    </div>

                    <input type="checkbox" name="remember"> Remember Me

                    <div class="mb-3">
                        <div class="d-grid">
                            <button alt="Login">
                                <i>L</i>
                                <i>o</i>
                                <i>g</i>
                                <i>i</i>
                                <i>n</i>
                            </button>

                        </div>

                        <div class="row text-center mt-4">
                            <div class="col-6 d-flex justify-content-center align-items-center">

                                <a href="register" style="text-decoration: none; color:black">
                                    <span class="box">
                                        Register
                                    </span>

                                </a>
                            </div>

                            <div class="col-6 d-flex justify-content-center align-items-center">

                                <a href="/" style="text-decoration: none; color:black">
                                    <span class="box">
                                        Guest Login
                                    </span>

                                </a>
                            </div>

                        </div>
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
        overflow: hidden;
        background-image: url('/storage/Images/gg.png');
        background-size: cover;
        background-position: center;
    }

    .container {
        width: 100%;
        height: 100vh;
        background: rgba(255, 255, 255, 0.5);
        backdrop-filter: blur(10px);

    }


    #togglePassword {
        right: 15px;
        /* Adjust as needed */
        top: 50%;
        /* Vertically center */
        cursor: pointer;
        z-index: 1;
        /* Ensure the icon is above the input */
    }

    button {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 50px;
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

    .box {
        width: 140px;
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

    
</style>

<script>
    function showPass() {
        const passwordInput = document.getElementById('password');
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
</script>