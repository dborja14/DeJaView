@extends('main')

@section('sellProduct')


<div class="row full-height">

    <div class="offcanvas offcanvas-start" tabindex="-1" id="chatSidebar" aria-labelledby="chatSidebarLabel">
        <div class="offcanvas-header">
            <h5 id="chatSidebarLabel">Chats</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <!-- New Chat Button -->
            <button type="button" id="newChatBtn" class="newchat mb-3">
                <i class="bi bi-plus-circle-dotted"></i> New Chat
            </button>

            @if ($chats->isNotEmpty())
            @foreach($chats as $chat)
            <button data-id="{{ $chat->id }}" class="chatLeftBox">
                <div class="d-flex">
                    <img src="storage/Images/updatedLogo.png" alt="" class="sneakerhead">
                    <div class="ms-2">
                        <strong>{{$chat->subject}}</strong>
                    </div>
                </div>
            </button>
            @endforeach
            @else
            <p>Start a new Chat!</p>
            @endif
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="start" tabindex="-1" aria-labelledby="startLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="startLabel">Start a chat</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('newchat') }}" method="post">
                    <div class="modal-body">
                        @csrf
                        <label for="subject">Choose subject</label>
                        <select class="form-select" name="subject" required>
                            <option selected>Choose</option>
                            <option value="Inquiries">Inquiries</option>
                            <option value="Concern">Concern</option>
                            <option value="Sell Product">Sell A Product</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>


        </div>
    </div>

    <!-- Button to Open Off-Canvas Sidebar (Visible only on mobile) -->
    <div class="d-lg-none position-fixed start-0 m-3" style="z-index: 100;">
        <button class="btn btn-outline-secondary" type="button" data-bs-toggle="offcanvas" data-bs-target="#chatSidebar" aria-controls="chatSidebar">
            <i class="bi bi-chat-left-dots"></i> <!-- Chat icon -->
        </button>
    </div>

    <div class="col-3 d-none d-md-block d-lg-block">

        <button type="button" data-bs-toggle="modal" data-bs-target="#start" class="newchat"><i class="bi bi-plus-circle-dotted"></i> New Chat</button>

        <div class="modal fade" id="start" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Start a chat</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('newchat') }}" method="post">
                        <div class="modal-body">
                            @csrf
                            <label for="">Choose subject</label>
                            <select class="form-select" name="subject" aria-label="Default select example" required>
                                <option selected>Choose</option>
                                <option value="Inquiries">Inquiries</option>
                                <option value="Concern">Concern</option>
                                <option value="Sell Product">Sell A Product</option>
                            </select>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Check if there are any chats -->
        @if ($chats->isNotEmpty())
        @foreach($chats as $chat)
        <button data-id="{{ $chat->id }}" class="chatLeftBox">
            <div class="d-flex">
                <img src="storage/Images/updatedLogo.png" alt="" class="sneakerhead">
                <div class="ms-2">
                    <strong>{{$chat->subject}}</strong>
                </div>
            </div>
        </button>
        @endforeach
        @else
        <p>Start a new Chat!</p>
        @endif
    </div>

    <div class="col-12 col-sm-12 col-md-9 col-lg-9 d-flex flex-column hugeside">
        <div class="filterable_card content flex-grow-1 mb-5" id="chatContent" style="max-height: 80%;">
            <!-- Initially empty -->
            <p>No messages selected. Please select a chat to see messages.</p>
        </div>



        @if ($chats->isNotEmpty())


        <div class="input-container">

            <form action="{{ route('chatPost') }}" method="POST" enctype="multipart/form-data">
                @csrf <!-- Include CSRF token -->

                <!-- Image preview area -->
                <div id="imagePreview" class="mb-2" style="display: none;">
                    <img id="previewImage" src="" alt="Selected Image" style="max-width: 100%; height: auto; border-radius: 5px;">
                </div>

                <div class="d-flex align-items-center">
                    <input type="hidden" name="chatId" id="chatIdInput" value="">

                    <!-- Text input for chat message -->
                    <input type="text" name="content" class="bottom-input me-2" placeholder="Type your message..." style="flex: 1;">

                    <!-- Hidden file input -->
                    <input type="file" name="photo" accept="image/*" class="d-none" id="photoInput">

                    <!-- Label styled as a clip icon -->
                    <label for="photoInput" class="btnn ms-2" style="cursor: pointer;">
                        <i class="bi bi-paperclip"></i> <!-- Clip icon -->
                    </label>

                    <!-- Submit button -->
                    <button type="submit" class="btnn ms-2">
                        <i class="bi bi-send"></i>
                    </button>
                </div>
            </form>

        </div>

        @else
        <p>Start a new Chat!</p>
        @endif

    </div>
</div>


<style>
    body,
    html {
        height: 100%;
        margin: 0;
        padding: 0;
        overflow: hidden;
    }

    .newchat {
        width: 100%;
        padding: 1rem;
        border: 0;
        border-top: 2px dotted white;
        border-bottom: 2px dotted white;
        border-left: 2px dotted white;
        border-right: 2px dotted white;
        border-radius: 10px;
        background-color: #295F98;
        color: white;
        margin-bottom: 1rem;
    }

    .sneakerhead {
        width: 70px;
        height: 70px;
        position: relative;
        border-radius: 50%;
    }

    .chatLeftBox {
        width: 100%;
        height: 80px;
        border-radius: 10px;
        padding: 5px;
        margin-bottom: 1rem;
    }

    .full-height {
        height: 100vh;
    }

    .hugeside {
        background-color: #F1F1F1;
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .content {
        flex-grow: 1;
        padding: 10px;
        overflow-y: auto;
    }

    .input-container {
        background-color: #ffffff;
        padding: 10px;
        border-top: 1px solid #ccc;
        position: sticky;
        bottom: 0;
        width: 100%;
    }

    .bottom-input {
        width: 100%;
        padding: 10px;
        box-sizing: border-box;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .btnn {
        background-color: transparent;
        /* or any color you prefer */
        border: none;
        /* Remove border */
        color: #000;
        /* Change icon color if necessary */
        font-size: 1.5em;
        /* Adjust size */
    }



    .chatContent {
        background-color: #f8f9fa;
        border-radius: 5px;
        padding: 10px;
        margin-bottom: 10px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        width: fit-content;
    }

    .chat-left {
        align-self: flex-start;
        margin-left: 0;
        margin-right: auto;
    }

    .chat-right {
        align-self: flex-end;
        margin-left: auto;
        background-color: #295F98;
        color: white;
    }

    .chat-image-wrapper {
        border: 1px solid #ccc;
        border-radius: 5px;
        margin: 10px 0;
        display: inline-block;

    }

    .chat-image {
        max-width: 250px;
        height: auto;
        border-radius: 5px;
        /* Rounded corners */
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const chatButtons = document.querySelectorAll('.chatLeftBox');
        const chatContentDiv = document.getElementById('chatContent');
        const chatIdInput = document.getElementById('chatIdInput');
        const loggedInUserId = "{{ Session::get('user.id') }}";

        // Check if there's a saved chat ID in localStorage
        const savedChatId = localStorage.getItem('selectedChatId');
        if (savedChatId) {
            chatIdInput.value = savedChatId;
            fetchChatContent(savedChatId); // Fetch and display the saved chat content
        }

        chatButtons.forEach(button => {
            button.addEventListener('click', function() {
                const chatId = this.getAttribute('data-id');

                // Update the hidden input field for the chat form
                chatIdInput.value = chatId;

                // Save the selected chat ID in localStorage
                localStorage.setItem('selectedChatId', chatId);

                // Fetch chat content dynamically
                fetchChatContent(chatId);
            });
        });

        function fetchChatContent(chatId) {
            fetch(`/getChatContent/${chatId}`)
                .then(response => response.json())
                .then(data => {
                    // Clear previous content
                    chatContentDiv.innerHTML = '';

                    // Set to track displayed images based on unique timestamps
                    const displayedImages = new Set();

                    if (data.contents.length > 0) {
                        data.contents.forEach(content => {
                            const contentElement = document.createElement('div');

                            // Compare content.userId with loggedInUserId
                            if (parseInt(content.userId) === parseInt(loggedInUserId)) {
                                contentElement.className = 'chatContent chat-right';
                            } else {
                                contentElement.className = 'chatContent chat-left';
                            }

                            // Create a wrapper for the image
                            if (content.photo && !displayedImages.has(content.created_at)) {
                                const imageWrapper = document.createElement('div');
                                imageWrapper.className = 'chat-image-wrapper'; // Class for styling

                                const imageElement = document.createElement('img');
                                imageElement.src = content.photo;
                                imageElement.alt = 'Chat image';
                                imageElement.className = 'chat-image';

                                // Append the image to the wrapper
                                imageWrapper.appendChild(imageElement);
                                contentElement.appendChild(imageWrapper);

                                // Add the timestamp of the image to the set to prevent future duplication
                                displayedImages.add(content.created_at);
                            }

                            // Function to format the date/time
                            function formatDateTime(dateTimeString) {
                                const date = new Date(dateTimeString);
                                const options = {
                                    hour: 'numeric',
                                    minute: 'numeric',
                                    hour12: true // Set to true for AM/PM format
                                };
                                return date.toLocaleTimeString([], options);
                            }

                            // Display message content and timestamp below the image if an image was displayed
                            if (content.photo) {
                                contentElement.innerHTML += `
                            <p>${content.content}</p>
                            <small>Sent at: ${formatDateTime(content.created_at)}</small>
                        `;
                            } else {
                                // If no image, just display the message content and timestamp
                                contentElement.innerHTML = `
                            <p>${content.content}</p>
                            <small>Sent at: ${formatDateTime(content.created_at)}</small>
                        `;
                            }

                            // Append the entire content element to chatContentDiv
                            chatContentDiv.appendChild(contentElement);
                        });

                        // Scroll to the bottom of the chat content
                        chatContentDiv.scrollTop = chatContentDiv.scrollHeight;
                    } else {
                        chatContentDiv.innerHTML = '<p>No messages in this chat yet.</p>';
                    }
                })
                .catch(error => {
                    console.error('Error fetching chat content:', error);
                });
        }


    });

    document.getElementById('photoInput').addEventListener('change', function(event) {
        const file = event.target.files[0];
        const imagePreview = document.getElementById('imagePreview');
        const previewImage = document.getElementById('previewImage');

        if (file) {
            const reader = new FileReader();

            reader.onload = function(e) {
                // Set the image source to the selected file
                previewImage.src = e.target.result;
                imagePreview.style.display = 'block';
                imagePreview.style.width = '150px';
            }

            reader.readAsDataURL(file); // Read the selected file as a Data URL
        } else {
            // If no file is selected, hide the preview area
            imagePreview.style.display = 'none';
        }
    });
    
    document.getElementById('newChatBtn').addEventListener('click', function() {
        const chatSidebar = document.getElementById('chatSidebar');
        const offcanvasInstance = bootstrap.Offcanvas.getInstance(chatSidebar);

        offcanvasInstance.hide();

        chatSidebar.addEventListener(
            'hidden.bs.offcanvas',
            function() {
                // Ensure modal visibility
                const modalElement = document.getElementById('start');
                modalElement.classList.add('show');
                modalElement.style.display = 'block';
                modalElement.setAttribute('aria-modal', 'true');
                modalElement.removeAttribute('aria-hidden');

                // Prevent body scroll (Bootstrap behavior)
                document.body.classList.add('modal-open');
            }, {
                once: true
            }
        );
    });
    
     const modal = new bootstrap.Modal(document.getElementById('start'));
    
    // If you need to open the modal from JS
    document.getElementById('newChatBtn').addEventListener('click', function () {
        modal.show();  // Open the modal
    });
    
    // If you want to manually hide the modal (for example, after form submission)
    document.querySelector('[data-bs-dismiss="modal"]').addEventListener('click', function () {
        modal.hide(); 
    });
</script>






@endsection