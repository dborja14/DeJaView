@include('layout.link')

<div class="row full-height">
    <div class="offcanvas offcanvas-start" tabindex="-1" id="chatSidebar" aria-labelledby="chatSidebarLabel">
        <div class="offcanvas-header">
            <h5 id="chatSidebarLabel">Chats</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <!-- New Chat Button -->
            <a href="../admin">
                <button type="button" class="newchat mt-2"><i class="bi bi-plus-circle-dotted"></i>Back</button>
            </a>

            <!-- Chat List -->
            @if ($chats->isNotEmpty())
            @foreach($chats as $chat)
            <button data-id="{{ $chat->id }}" class="chatLeftBox mb-3">
                <div class="d-flex align-items-center">
                    <img src="storage/Images/updatedLogo.png" alt="" class="sneakerhead">
                    <div class="ms-2">
                        <strong>From: {{$chat->user->name}}</strong><br>
                        <strong>Subject: {{$chat->subject}}</strong>
                    </div>
                </div>
            </button>
            @endforeach
            @else
            <p>No chats available.</p>
            @endif
        </div>
    </div>

    <!-- Button to Open Off-Canvas Sidebar (Visible only on mobile) -->
    <div class="d-lg-none position-fixed start-0 m-3" style="z-index: 100;">
        <button class="btn btn-outline-secondary" type="button" data-bs-toggle="offcanvas" data-bs-target="#chatSidebar" aria-controls="chatSidebar">
            <i class="bi bi-chat-left-dots"></i> <!-- Chat icon -->
        </button>
    </div>
    <div class="col-3 d-none d-md-block d-lg-block">
        <a href="../admin">
            <button type="button" class="newchat mt-2"><i class="bi bi-plus-circle-dotted"></i>Back</button>
        </a>

        @if ($chats->isNotEmpty())
        @foreach($chats as $chat)
        <button data-id="{{ $chat->id }}" class="chatLeftBox mb-3">
            <div class="d-flex align-items-center">
                <img src="storage/Images/updatedLogo.png" alt="" class="sneakerhead">
                <div class="ms-2">
                    <strong>From: {{$chat->user->name}}</strong><br>
                    <strong>Subject: {{$chat->subject}}</strong>
                </div>
            </div>
        </button>
        @endforeach
        @else
        <p>No chats available.</p>
        @endif
    </div>

    <div class="col-12 col-sm-12 col-md-9 col-lg-9 d-flex flex-column hugeside">
        <div class="divBox p-2">
            @if(isset($chat))
            <p style="font-size: medium;"><strong></strong></p>
            @else
                <p style="font-size: medium;"><strong>No chat selected</strong></p>
                @endif
        </div>
        <div class="filterable_card content flex-grow-1" id="chatContent">
            <!-- Initially empty -->
            <p>No messages selected. Please select a chat to see messages.</p>
        </div>

        <div class="input-container">
            <form action="{{route('closeChatAdmin')}}" method="post">
                @csrf
                <input type="hidden" value="{{ isset($chat) ? $chat->id : '' }}" name="chatId">
                <button type="submit" {{ isset($chat) ? '' : 'disabled' }}>Close Chat</button>
            </form>
            <form action="{{ route('chatPostAdmin') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div id="imagePreview" class="mb-2" style="display: none;">
                    <img id="previewImage" src="" alt="Selected Image" style="max-width: 100%; height: auto; border-radius: 5px;">
                </div>

                <div class="d-flex align-items-center">
                    <input type="hidden" name="chatId" id="chatIdInput" value="{{ isset($chat) ? $chat->id : '' }}">

                    <input type="text" name="content" class="bottom-input me-2" placeholder="Type your message..." style="flex: 1;" {{ !isset($chat) ? 'disabled' : '' }}>

                    <input type="file" name="photo" accept="image/*" class="d-none" id="photoInput">

                    <label for="photoInput" class="btnn ms-2" style="cursor: pointer;">
                        <i class="bi bi-paperclip"></i>
                    </label>

                    <button type="submit" class="btnn ms-2" {{ !isset($chat) ? 'disabled' : '' }}>
                        <i class="bi bi-send"></i>
                    </button>
                </div>
            </form>
        </div>
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

    .divBox {
        background-color: white;
        width: 100%;
        box-shadow: 0 0 10px gray;
    }

    .chatLeftBox {
        width: 100%;
        height: 80px;
        border-radius: 10px;

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
    }

    .btnn {
        background-color: transparent;
        border: none;
        color: #000;
        font-size: 1.5em;
    }
</style>

<script>
    // mag rrun lang pag lahat ng file is valid
    document.addEventListener('DOMContentLoaded', function() {
        const chatButtons = document.querySelectorAll('.chatLeftBox');
        const chatContentDiv = document.getElementById('chatContent');
        const chatIdInput = document.getElementById('chatIdInput');
        const loggedInUserId = "{{ Session::get('user.id') }}";

        const savedChatId = localStorage.getItem('selectedChatId');
        if (savedChatId) {
            chatIdInput.value = savedChatId;
            fetchChatContent(savedChatId);
        }

        chatButtons.forEach(button => {
            button.addEventListener('click', function() {
                const chatId = this.getAttribute('data-id');

                chatIdInput.value = chatId;
                //save sa local storage ung chat
                localStorage.setItem('selectedChatId', chatId);
                fetchChatContent(chatId);
            });
        });

        function fetchChatContent(chatId) {
            fetch(`/getChatContentAdmin/${chatId}`)
                .then(response => response.json())
                .then(data => {

                    chatContentDiv.innerHTML = '';

                    const displayedImages = new Set();

                    if (data.contents.length > 0) {
                        data.contents.forEach(content => {
                            const contentElement = document.createElement('div');

                            if (parseInt(content.userId) === parseInt(loggedInUserId)) {
                                contentElement.className = 'chatContent chat-right';
                            } else {
                                contentElement.className = 'chatContent chat-left';
                            }

                            if (content.photo && !displayedImages.has(content.created_at)) {
                                const imageWrapper = document.createElement('div');
                                imageWrapper.className = 'chat-image-wrapper';

                                const imageElement = document.createElement('img');
                                imageElement.src = content.photo;
                                imageElement.alt = 'Chat image';
                                imageElement.className = 'chat-image';

                                imageWrapper.appendChild(imageElement);
                                contentElement.appendChild(imageWrapper);

                                displayedImages.add(content.created_at);
                            }

                            function formatDateTime(dateTimeString) {
                                const date = new Date(dateTimeString);
                                const options = {
                                    hour: 'numeric',
                                    minute: 'numeric',
                                    hour12: true
                                };
                                return date.toLocaleTimeString([], options);
                            }

                            if (content.photo) {
                                contentElement.innerHTML += `
                            <p>${content.content}</p>
                            <small>Sent at: ${formatDateTime(content.created_at)}</small>
                        `;
                            } else {
                                contentElement.innerHTML = `
                            <p>${content.content}</p>
                            <small>Sent at: ${formatDateTime(content.created_at)}</small>
                        `;
                            }

                            chatContentDiv.appendChild(contentElement);
                        });

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
                previewImage.src = e.target.result;
                imagePreview.style.display = 'block';
                imagePreview.style.width = '150px';
            }

            reader.readAsDataURL(file);
        } else {
            imagePreview.style.display = 'none';
        }
    });
</script>