const chatInput = document.querySelector("#chat-input");
const sendButton = document.querySelector("#send-btn");
const chatContainer = document.querySelector(".chat-container");
const themeButton = document.querySelector("#theme-btn");
const deleteButton = document.querySelector("#delete-btn");

let userText = null;

const createChatElement = (content, className) => {
    // Create new div and apply chat, specified class and set html content of div
    const chatDiv = document.createElement("div");
    chatDiv.classList.add("chat", className);
    chatDiv.innerHTML = content;
    return chatDiv; // Return the created chat div
}

// const conversation = [
//     { role: 'system', content: 'Greetings! You are an extraterrestrial helper from RPOST. Your mission is to assist users in generating posts, crafting tweet captions, or enhancing their content. RPost is the social media hub for Rensselaer Polytechnic Students. Users will ask you questions and seek your assistance in creating engaging social media content and more. Make sure your response is concise, limited to three sentences or less. When generating captions for users, please format them with numbers for easy reference.' }
// ];

// this is where we will make the api call and get the results
const getChatResponse = async (incomingChatDiv) => {

    const apiKey = ""; // Replace with your actual OpenAI API key
    const apiUrl = 'https://api.openai.com/v1/chat/completions';
    // conversation.push({ role: 'user', content: userText });

    // creating the element
    const pElement = document.createElement("p");

    const requestData = {
        model: 'gpt-3.5-turbo',
        // messages: conversation,
        messages: [    { role: 'system', content: 'You are the dedicated chatbot assistant of RPOST, here to guide users. RPost is an ultimate social media hub for the community of Rensselaer Polytechnic Institute (RPI) students, offering a portal to the heart of campus life and more. Here are the features you need to know. You can see what other people are posting and going through. You get RPI event-focused updates, ensuring you"re always in the know. You can message your friends one on one. You just need to make an account and register. One of our real main features is, our AI integration opens doors to generating captions effortlessly. You are the chatbot who users can talk to and ask questions. Customize your profile and let your voice resonate across the platform by crafting RPOSTS and engaging with fellow members in the master feed.' },
                       { role: 'user', content: userText }],
        max_tokens: 200,
    };

    try {
        const response = await fetch(apiUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${apiKey}`,
            },
            body: JSON.stringify(requestData),
        });

        if (!response.ok) {
            pElement.textContent = "Sorry, our API is currently unavailable. Please try again later.";
        }

        const data = await response.json();
        const reply = data.choices[0].message.content;
        // conversation.push({ role: 'assistant', content: reply });
        pElement.textContent = reply;

    } catch (error){
        console.log = ("Error during API call:", error);
        pElement.classList.add("error");
        pElement.textContent = "Sorry, our API is currently unavailable. Please try again later.";
    }

    // Remove the typing animation, append the paragraph element and save the chats to local storage
    incomingChatDiv.querySelector(".typing-animation").remove();
    incomingChatDiv.querySelector(".chat-details").appendChild(pElement);
    localStorage.setItem("all-chats", chatContainer.innerHTML);
    chatContainer.scrollTo(0, chatContainer.scrollHeight);
}

const handleOutgoingChat = () => {
    userText = chatInput.value.trim(); // Get chatInput value and remove extra spaces
    if(!userText) return; // If chatInput is empty return from here

    // Clear the input field and reset its height
    chatInput.value = "";
    chatInput.style.height = `${initialInputHeight}px`;

    const html = `<div class="chat-content">
                    <div class="chat-details">
                        <img src="./ai.png" alt="user-img">
                        <p>${userText}</p>
                    </div>
                </div>`;

    // Create an outgoing chat div with user's message and append it to chat container
    const outgoingChatDiv = createChatElement(html, "outgoing");
    chatContainer.querySelector(".default-text")?.remove();
    chatContainer.appendChild(outgoingChatDiv);
    chatContainer.scrollTo(0, chatContainer.scrollHeight);
    setTimeout(showTypingAnimation, 500);
}

deleteButton.addEventListener("click", () => {
    // Remove the chats from local storage and call loadDataFromLocalstorage function
    if(confirm("Are you sure you want to delete all the chats?")) {
        localStorage.removeItem("all-chats");
        loadDataFromLocalstorage();
    }
});

const initialInputHeight = chatInput.scrollHeight;

// size of the chat bar input
chatInput.addEventListener("input", () => {   
    chatInput.style.height =  `${initialInputHeight}px`;
    chatInput.style.height = `${chatInput.scrollHeight}px`;
});

chatInput.addEventListener("keydown", (e) => {
    // If the Enter key is pressed without Shift and the window width is larger 
    // than 800 pixels, handle the outgoing chat
    if (e.key === "Enter" && !e.shiftKey && window.innerWidth > 800) {
        e.preventDefault();
        handleOutgoingChat();
    }
});

const showTypingAnimation = () => {
    // Display the typing animation and call the getChatResponse function
    const html = `<div class="chat-content">
                    <div class="chat-details">
                        <img src="./chatbot.png" alt="chatbot-img">
                        <div class="typing-animation">
                            <div class="typing-dot" style="--delay: 0.2s"></div>
                            <div class="typing-dot" style="--delay: 0.3s"></div>
                            <div class="typing-dot" style="--delay: 0.4s"></div>
                        </div>
                    </div>
                    <span onclick="copyResponse(this)" class="material-symbols-rounded">content_copy</span>
                </div>`;
    // Create an incoming chat div with typing animation and append it to chat container
    const incomingChatDiv = createChatElement(html, "incoming");
    chatContainer.appendChild(incomingChatDiv);
    chatContainer.scrollTo(0, chatContainer.scrollHeight);
    getChatResponse(incomingChatDiv);
}

// copy's the response
const copyResponse = (copyBtn) => {
    // Copy the text content of the response to the clipboard
    const reponseTextElement = copyBtn.parentElement.querySelector("p");
    navigator.clipboard.writeText(reponseTextElement.textContent);
    copyBtn.textContent = "done";
    setTimeout(() => copyBtn.textContent = "content_copy", 1000);
}

// changes the theme color
themeButton.addEventListener("click", () => {
    // Toggle body's class for the theme mode and save the updated theme to the local storage 
    document.body.classList.toggle("light-mode");
    localStorage.setItem("themeColor", themeButton.innerText);
    themeButton.innerText = document.body.classList.contains("light-mode") ? "dark_mode" : "light_mode";
});

const loadDataFromLocalstorage = () => {
    // Load saved chats and theme from local storage and apply/add on the page
    const themeColor = localStorage.getItem("themeColor");

    document.body.classList.toggle("light-mode", themeColor === "light_mode");
    themeButton.innerText = document.body.classList.contains("light-mode") ? "dark_mode" : "light_mode";

    const defaultText = `<div class="default-text">
                            <h1>CHATBOT for RPOST</h1>
                            <p>Start a conversation with us.<br> Ask any questions you want!</p>
                        </div>`

    chatContainer.innerHTML = localStorage.getItem("all-chats") || defaultText;
    chatContainer.scrollTo(0, chatContainer.scrollHeight); // Scroll to bottom of the chat container
}

loadDataFromLocalstorage();
sendButton.addEventListener("click", handleOutgoingChat);

// Get a reference to the "Go back" button
const goBackButton = document.getElementById('goBackButton');

// Add a click event listener to the button
goBackButton.addEventListener('click', function() {
    // Redirect to the homepage URL
    window.location.href = '../homepage.php'; // Replace 'your-homepage-url.html' with your actual homepage URL
});