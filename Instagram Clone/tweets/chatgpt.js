const conversation = [
    { role: 'system', content: 'Greetings! You are an extraterrestrial helper from RPOST. Your mission is to assist users in generating posts, crafting tweet captions, or enhancing their content. RPost is the social media hub for Rensselaer Polytechnic Students. Users will ask you questions and seek your assistance in creating engaging social media content and more. Make sure your response is concise, limited to three sentences or less. When generating captions for users, please format them with numbers for easy reference.' }
];

async function get_data(userMessage) {
    const apiKey = "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"; // Replace with your actual OpenAI API key
    const apiUrl = 'https://api.openai.com/v1/chat/completions';

    // adds the user message to the conversation 
    conversation.push({ role: 'user', content: userMessage });

    const requestData = {
        model: 'gpt-3.5-turbo',
        messages: conversation,
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
            return "Sorry, our API is currently unavailable. Please try again later."
        }

        const data = await response.json();

        conversation.push({ role: 'assistant', content: data.choices[0].message.content });
        // console.log(conversation);
        return data.choices[0].message.content; // Assuming you want to return the generated text
    } catch (error) {
        console.error("Error during API call:", error);
        return "Sorry, our API is currently unavailable. Please try again later."
    }
}

// Continue with the rest of your code
var sendMessageButton = document.getElementById('send-message');
var chatInput = document.getElementById('chat-input');
var chatMessages = document.getElementById('chat-messages');

sendMessageButton.onclick = async function() {
    console.log("clicked");
    var message = chatInput.value.trim();
    if (message !== "") {
        // Append the user's message to the chat box (for demonstration purposes)
        chatMessages.innerHTML += "<p>You: " + message + "</p>";
        chatInput.value = ""; // Clear the input field

        try {
            // Call the asynchronous function to get data from OpenAI API
            var requestData = await get_data(message);

            // Display the data in the chat box
            chatMessages.innerHTML += "<p>AI: " + requestData + "</p>";
        } catch (error) {
            console.error("Error getting data:", error);
        }
    }
}