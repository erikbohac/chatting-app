<main class="bg-light">
    <?php
        if (isset($_SESSION['status'])) {
            $status = $_SESSION['status'];
            unset($_SESSION['status']);
            echo '<div class="position-fixed pt-4 pe-sm-5 pe-2 toastpos z-3 d-flex">
                    <div class="container toast align-items-center border-0 float-end bg-dark" id="toast">
                        <div class="d-flex">
                            <div class="toast-body text-white display-6 fs-5">' . $status . '.</div>
                            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>
                    </div>
                </div>';
        }
    ?>
    <div class="container pt-3 text-center z-1 bg-white">
        <div class="chat-container">
            <div class="card">
                <div class="card-header chat-header text-center bg-dark text-white p-3">
                    <h3>
                        <?php 
                            if (isset($_SESSION["chat_name"]))
                            {
                                echo 'Chat: ' . $_SESSION["chat_name"];
                            }
                            else{
                                echo 'Disconnected';
                            }
                        ?>
                    </h3>
                </div>
                <div class="card-body chat-body border border-1">
                    <?php
                        if(isset($_SESSION["messages"]))
                        {
                            foreach ($_SESSION["messages"] as $value)
                            {
                                if($value["name"] == $_SESSION["username"])
                                {
                                    echo '<div class="media justify-content-end mt-3 d-flex">
                                            <div class="media-body bg-primary text-white px-3 py-2 rounded">
                                                <h6 class="mb-0">' . $value["name"] . '</h6>
                                                <p class="mb-1">' . $value["message"] . '</p>
                                            </div>
                                        </div>';
                                }
                                else {
                                    echo '<div class="media mt-3 d-flex">
                                            <div class="media-body bg-light px-3 py-2 rounded">
                                                <h6 class="mb-0">' . $value["name"] . '</h6>
                                                <p class="mb-1">' . $value["message"] . '</p>
                                            </div>
                                        </div>';
                                }
                            }
                        }
                    ?>
                </div>
                <div class="card-footer">
                    <div class="d-flex mt-3">
                        <form class="input-group" action="../dbsystem/chat_manager.php" method="POST">
                            <input type="text" name="message" class="form-control border-1 rounded-0" placeholder="Type your message..." <?= isset($_SESSION["chat_name"]) ? '' : 'disabled' ?>>
                            <div class="input-group-append">
                                <button type="submit" name="message_send" class="btn btn-primary <?= isset($_SESSION["chat_name"]) ? '' : 'disabled' ?>">Send</button>
                            </div>
                        </form>
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
<script type="text/javascript" src="../js/socket.js"></script>