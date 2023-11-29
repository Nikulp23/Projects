<?php
session_start();

if (!isset($_SESSION['rcsid'])) {
    // Redirect if the user is not logged in
    header("Location: ../login/login.html");
    exit();
}

include("../php/db_connection.php");

$senderRcsid = $_SESSION['rcsid'];

// Query to get users with whom the logged-in user has had a conversation
$sqlConversations = "SELECT DISTINCT ad.first_name, ad.last_name, ad.profile_picture, ad.rcsid 
                     FROM account_details ad
                     JOIN messages m ON (m.sender_id = ad.rcsid OR m.receiver_id = ad.rcsid)
                     WHERE (m.sender_id = '$senderRcsid' OR m.receiver_id = '$senderRcsid') AND ad.rcsid != '$senderRcsid'";
$resultConversations = mysqli_query($conn, $sqlConversations);

if ($resultConversations) {
    while ($details = mysqli_fetch_assoc($resultConversations)) {
        $profileImageUrl = !empty($details['profile_picture']) ? htmlspecialchars($details['profile_picture']) : "https://static.vecteezy.com/system/resources/thumbnails/009/734/564/small/default-avatar-profile-icon-of-social-media-user-vector.jpg";

        echo '<div class="tweet-wrap">';
        echo '  <div class="tweet-header">';
        echo '    <img src="' . $profileImageUrl . '" alt="Avatar" class="avator">';
        
        echo '    <div class="tweet-header-info">';
        echo '      <a href="#" class="receiver-link" data-rcsid="' . htmlspecialchars($details['rcsid']) . '">' . htmlspecialchars($details['first_name']) . ' ' . htmlspecialchars($details['last_name']) . '</a>';
        echo '      <br>';
        echo '      View Messages';
        echo '    </div>';  
        echo '  </div>';
        echo '</div>';
    }
} else {
    echo "Error: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
