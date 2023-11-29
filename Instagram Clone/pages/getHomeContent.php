<?php
include("./php/db_connection.php");

echo ' <div class = "options">
            <hr>
            <button class="for-you">For You</button>
            <button class="following">Following</button>
            <hr>
        </div>
';

// SQL query to join Tweets with account_details
$sql = "SELECT T.*, A.first_name, A.last_name, A.profile_picture 
        FROM Tweets T 
        INNER JOIN account_details A ON T.rcsid = A.rcsid 
        ORDER BY T.created_at DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Default image URL in case the user doesn't have a profile picture
        $defaultImageUrl = "https://static.vecteezy.com/system/resources/thumbnails/009/734/564/small/default-avatar-profile-icon-of-social-media-user-vector.jpg";

        // Use user's profile picture or default image
        $profileImageUrl = !empty($row['profile_picture']) ? htmlspecialchars($row['profile_picture']) : $defaultImageUrl;

        echo '<div class="tweet-wrap">';
        echo '  <div class="tweet-header">';
        echo '    <img src="' . $profileImageUrl . '" alt="Avatar" class="avator">';
        
        echo '    <div class="tweet-header-info">';
        echo '      ' . htmlspecialchars($row['first_name']) . ' ' . htmlspecialchars($row['last_name']) . ' <span>@' . htmlspecialchars($row['rcsid']) . '</span><span> · ' . date('M d', strtotime($row['created_at'])) . '</span>';
        echo '      <p>' . htmlspecialchars($row['tweet_text']) . '</p>';  
        echo '    </div>';
        echo '  <button class="analyze-button" id="analyze-button">Analyze</button>';
        echo '  </div>';

        if (!empty($row['image_url'])) {
            echo '  <div class="tweet-img-wrap">';
            echo '    <img src="' . htmlspecialchars($row['image_url']) . '" alt="" class="tweet-img">';
            echo '  </div>';
        }

          echo '  <div class="tweet-info-counts">';
          echo '  <div class="comments">';
          echo '  <svg class="feather feather-message-circle sc-dnqmqq jxshSx" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>';
          echo '      <div class="comment-count">33</div>';
          echo '    </div>';

          echo '    <div class="retweets">';
          echo ' <svg class="feather feather-repeat sc-dnqmqq jxshSx" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="17 1 21 5 17 9"></polyline><path d="M3 11V9a4 4 0 0 1 4-4h14"></path><polyline points="7 23 3 19 7 15"></polyline><path d="M21 13v2a4 4 0 0 1-4 4H3"></path></svg>';
          echo '    <div class="retweet-count">397</div>';
          echo '    </div>';

          echo '    <div class="likes">';
          echo '    <svg class="feather feather-heart sc-dnqmqq jxshSx" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>';
          echo '    <div class="likes-count">2.6k</div>';
          echo '    </div>';

          echo '<div class="report">
            <svg id="reportIcon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <polygon points="12 2 2 22 22 22 12 2"></polygon>
            </svg>
        </div>';
        
          echo '  </div>';

          echo '</div>'; // Close tweet-wrap
    }
} else {
    echo "<p>No tweets to display.</p>";
}
?>

