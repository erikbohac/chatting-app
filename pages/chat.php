<main>
    <?php
        if (isset($_SESSION['status'])) {
            $status = $_SESSION['status'];
            unset($_SESSION['status']);
            echo '<div class="position-fixed pt-4 pe-sm-5 pe-2 toastpos d-none d-md-flex"><div class="container toast align-items-center border-0 float-end bg-dark" id="toast"><div class="d-flex"><div class="toast-body text-white display-6 fs-5">' . $status . '.</div><button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button></div></div></div>';
        }
    ?>
    <div class="container pt-3 text-center">
        <div class="chat-container">
            <div class="card">
                <div class="card-header chat-header text-center bg-dark text-white p-3">
                    <h3>Disconnected</h3>
                </div>
                <div class="card-body chat-body border border-1 p-3">
                </div>
                <div class="card-footer">
                    <div class="input-group mt-3">
                        <input type="text" class="form-control border-1 rounded-0" placeholder="Type your message...">
                        <div class="input-group-append">
                            <button class="btn btn-primary">Send</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-4">
                <h5>Create or Join a Chat</h5>
                <form action="../dbsystem/chat_manager.php" method="POST">
                    <div class="input-group mt-3">
                        <input type="text" name="name" class="form-control border-1 rounded-0" placeholder="Enter Chat Name...">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-success" name="create">Create Chat</button>
                            <button type="submit" class="btn btn-primary" name="join">Join Chat</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

<script type="text/javascript" src="../js/toast.js"></script>