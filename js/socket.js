const room = 'identifier';
const socket = new WebSocket(`ws://localhost:8888?${room}`);

socket.onmessage = (event) => {
    const message = JSON.parse(event.data);
    console.log(message);
};
