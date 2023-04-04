<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);

session_start();
if(empty($_SESSION['visited']))
{
    $_SESSION['prev_page'] = $_SERVER['REQUEST_URI'];
    header("Location: ../../login/logincheckadmin.php");
}
else{
    unset($_SESSION['visited']);
}

?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<h1>Search For User</h1>

    <label>Search by</label>
    <select name = "by" id = "selectList" onchange="changePlaceholderText()">
        <option value = "Name">Name</option>
        <option value = "Email">Email</option>
        <option value = "Post">Post</option>
    </select>
    <label>:</label>
    <input name = "search" id = "searchBar" type = "search" placeholder = "Search by Name..." style = "width: 500px" onkeydown="displaySearchResultsOnEnterKeyPress(event)">
    <button id = "searchButton" onclick = displaySearchResults()>Search</button>


<div id = "searchResults"></div>

<script>


    function displaySearchResultsOnEnterKeyPress(e)
    {
        if(e.key == "Enter")
            displaySearchResults();
    }

    function displaySearchResults(){
        const searchQuery = document.getElementById("searchBar").value;
        const by = document.getElementById("selectList").value;
        $.get("search.php", {search: searchQuery, by: by}, function(data){
            const searchResultsDiv = $("#searchResults");
            searchResultsDiv.html(data); // We are overwriting the previous changes/data
            const selectList = document.getElementById("selectList");
            searchResultsDiv.prepend($("<h2>Search Results By "+selectList.value+"</h2>"));
            });
    }


    function changePlaceholderText() {
        const searchBar = document.getElementById("searchBar");
        const selectList = document.getElementById("selectList");
        const valueOfSelectList = selectList.value;
        searchBar.setAttribute("placeholder", "Search by "+valueOfSelectList+"...");

    }



</script>
