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
<link rel="stylesheet" href="../../../css/project.css">
<link rel="stylesheet" href="../../../css/nav.css">

<style>
        .wrapper{
            display: flex;
            width: 100%;
            height: 100%;
            justify-content: center;
            align-items: center;
        }

        footer{
            position: fixed;
        }
    </style>

<header>
    <nav>
        <div class="logo"> <a href = "../show_discussions.php"> <img src="../../../Images/logo.png" width="100" height="100"></a> </div>
        <div class="n"><div class="text">  <a href = "../show_discussions.php"><p> The Tech Ward</p> </a></div>
            <?php $_SESSION['prev_page'] = $_SERVER['REQUEST_URI']; ?>
            <ul><li><a href="../new_discussion.php">New Discussion</a></li>
                <li><a href="../show_discussions.php">Discussions</a></li>
                <li><a href="../account.php">Account</a></li>
                <li><a href="admin.php">Admin</a></li>
                <li><a href="search_for_user.php">Search For User</a></li>
                <li><a href="../../login/logout.php">Logout</a></li> </ul></div></nav>


</header>
<br><br><br><br><br><br><br><br>

<h1>Search For User</h1>

    <label>Search by</label>
    <select name = "by" id = "selectList" onchange="changePlaceholderText()">
        <option value = "Name">Name</option>
        <option value = "Email">Email</option>
        <option value = "Post">Post</option>
    </select>
    <label>:</label>
    <input name = "search" id = "searchBar" type = "search" placeholder = "Search by Name..." style = "width: 500px" onkeydown="displaySearchResultsOnEnterKeyPress(event)">
    <button id = "searchButton" onclick = "displaySearchResults()">Search</button>


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

</div>
        <footer>
            <a href="#">Home</a> | <a href="#">Browse</a> | <a href="#">Search</a><br><br>
            <small><i>Copyright &copy; 2023 The Tech Ward</i></small>
        </footer>
