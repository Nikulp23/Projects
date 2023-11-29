$(document).ready(function() {
    $.ajax({
        type: "GET",
        url: "links.json",
        dataType: "json",
        success: function(responseData, status) {
            displayItems(responseData.items);
        },
        error: function(msg) {
            alert("There was a problem: " + msg.status + " " + msg.statusText);
        }
    });
});

// displays the item
function displayItems(items) {
    var output = "";
    $.each(items, function(i, item) {
        output += '<div class="exercise-item">';
        output += '<h1><a href="' + item.links + '"><u>' + item.name + '</a></h1>';
        output += '</div>';
    });
    $('#items').html(output);
}

// this function filter out's the items
function filterItems(category) {
    $.ajax({
        type: "GET",
        url: "links.json",
        dataType: "json",
        success: function(responseData, status) {
            var filteredItems = responseData.items.filter(function(item) {
                return item.category === category;
            });
            displayItems(filteredItems);
        },
        error: function(msg) {
            alert("There was a problem: " + msg.status + " " + msg.statusText);
        }
    });
}

// the function shows all the links
function showAll(category) {
    $.ajax({
        type: "GET",
        url: "links.json",
        dataType: "json",
        success: function(responseData, status){
          var output = "";  
          $.each(responseData.items, function(i, item) {
            output += '<h1><a href="' + item.links + '"><u>' + item.name + '</a></h1>';
          });
          $('#items').html(output);
        }, 
        // prints the error message, if there is something wrong
        error: function(msg) {
          alert("There was a problem: " + msg.status + " " + msg.statusText);
        }
    });
}
function selected(){
    alert("I've been clicked!");
    

}