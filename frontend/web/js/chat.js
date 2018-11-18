const conn = new WebSocket('ws://www.server.lan:8080');

const btn = document.getElementById('chat_button_send');
const inp = document.getElementById('chat_new_message');
const list = document.getElementById('chat_messages');

conn.onopen = function(e) {
    console.log("Connection established!");
};

conn.onmessage = function(e) {
	addNewMessage(e.data);
};

function sendChatMessage() {
	
	let message = isMessageCorrect(inp.value);
	
	if (message.length > 0) {
		addNewMessage(message, true);
		conn.send(message);
	}
}

function addNewMessage(message, my=false) {
	message = isMessageCorrect(message);
	
	if (message.length > 0) {
		let newMessage = document.createElement('div');
		newMessage.classList.add("chat_message");
        if (my) {
        	newMessage.classList.add("chat_message_my");
        }
        
        newMessage.innerHTML = message;
        
        list.appendChild(newMessage);
	}
}

function isMessageCorrect(message) {
	return message.trim();
}

window.onload = function () {
	btn.addEventListener("click", sendChatMessage);
}