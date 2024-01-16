<style>
    body {
      background-color: #f8f9fa;
    }

    .chat-container {
      max-width: 800px;
      margin: 0 auto;
    }

    .chat-header {
      background-color: #343a40;
      color: #fff;
      padding: 15px;
      text-align: center;
    }

    .chat-body {
      background-color: #fff;
      border: 1px solid #ddd;
      padding: 15px;
      height: 450px;
      overflow-y: scroll;
    }

    .message {
      margin-bottom: 15px;
    }

    .user-message {
      background-color: #007bff;
      color: #fff;
      border-radius: 5px;
      padding: 10px;
      max-width: 70%;
    }

    .other-message {
      background-color: #f8f9fa;
      border-radius: 5px;
      padding: 10px;
      max-width: 70%;
    }

    .input-group {
      margin-top: 15px;
    }

    .input-group input {
      border-radius: 0;
    }

    .btn-create-chat {
      background-color: #28a745;
      color: #fff;
      border: none;
    }

    .btn-join-chat {
      background-color: #007bff;
      color: #fff;
      border: none;
    }
  </style>

<main>
    <div class="container pt-3">
        <div class="chat-container">
            <div class="card">
                <div class="card-header chat-header">
                    <h4>Modern Chat</h4>
                </div>
                <div class="card-body chat-body">
                </div>
                <div class="card-footer">
                    <div class="input-group">
                        <input type="text" class="form-control" id="messageInput" placeholder="Type your message...">
                        <div class="input-group-append">
                            <button class="btn btn-primary">Send</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-4">
                <h5>Create or Join a Chat</h5>
                <div class="input-group">
                    <input type="text" class="form-control" id="chatIdInput" placeholder="Enter Chat ID...">
                    <div class="input-group-append">
                        <button class="btn btn-create-chat">Create Chat</button>
                        <button class="btn btn-join-chat">Join Chat</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>