document.addEventListener("DOMContentLoaded", function () {
    const messagePanel = document.querySelector(".message-panel");
    const toggleButton = document.getElementById("toggle-button");
    const arrowIcon = document.getElementById("arrow-icon");
    const messagesContainer = document.querySelector(".message-content");
    const messageInputContainer = document.querySelector(".message-input-container");
    const sendButton = document.getElementById("send-button");


    // Initially hide the messages container
    messagesContainer.style.display = "none";
    messageInputContainer.style.display = "none";

    // open up the message bar
    toggleButton.addEventListener("click", function () {

        if (messagePanel.style.height === "500px") {
            messagePanel.style.height = "60px";
            arrowIcon.classList.remove("collapsed");
            arrowIcon.innerHTML = '<span>&#8657;</span>'; // Change to up arrow
            // Hide the messages container when the up arrow is clicked
            messagesContainer.style.display = "none";
        }
        
        // close the message bar
        else {
            messagePanel.style.height = "500px";
            arrowIcon.classList.add("collapsed");
            arrowIcon.innerHTML = '<span>&#8659;</span>'; // Change to down arrow
            // Show the messages container when the down arrow is clicked
            messagesContainer.style.display = "block";

            document.querySelectorAll('.receiver-link').forEach(item => {
                item.addEventListener('click', function (e) {
                    e.preventDefault();

                    const receiverRcsid = this.getAttribute('data-rcsid');
                    document.getElementById('receiver-id-input').value = receiverRcsid;

                    // AJAX request to PHP script
                    fetch(`./messages/load_messages.php?receiver=${receiverRcsid}`)
                        .then(response => response.text())
                        .then(data => {
                            // Assuming you have a div with ID 'messages-container' to display messages
                            document.getElementById('messages-container').innerHTML = data;
                        })
                        .catch(error => console.error('Error:', error));
                        messageInputContainer.style.display = "block"; 
                });
            });
            messageInputContainer.style.display = "none";
        }
    });

    arrowIcon.addEventListener("click", function () {
        toggleButton.click(); // Trigger the click event of the button when the arrow is clicked
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const messagesContainer = document.getElementById("messages-container");

    // // Function to load and display the list of users
    function loadUserList() {
        // Perform an AJAX request to load the list of users
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // Display the list of users in the messages-container div
                messagesContainer.innerHTML = xhr.responseText;

            }
        };
        xhr.open('GET', './messages/load_user_list.php', true); // Create a new PHP file to load the user list
        xhr.send();
    }

    loadUserList();
});