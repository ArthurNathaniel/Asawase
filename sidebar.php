<style>
    .side-logo {
        text-align: center;
    }
</style>
<div class="sidebar_all">
    <div class="logo">

    </div>
    <br>
    <br>
    <div class="links">
        <h3> <span class="icon"><i class="fa-solid fa-chart-simple"></i></span> ADMIN</h3>
       <a href="add_quotation.php">Add Quotation</a>
       <a href="view_quotations.php">View Quotation</a>
       <a href="add_blog.php">Add Events</a>
       <a href="delete_blog.php">Delete Events</a>


        <a href="logout.php">
            <h3> <i class="fas fa-sign-out-alt"></i> LOGOUT
            </h3>
        </a>

    </div>
    <style>
        h3 a {
            background-color: transparent;
        }
    </style>
</div>
<button id="toggleButton">
    <i class="fa-solid fa-bars-staggered"></i>
</button>

<script>
    // Get the button and sidebar elements
    var toggleButton = document.getElementById("toggleButton");
    var sidebar = document.querySelector(".sidebar_all");
    var icon = toggleButton.querySelector("i");

    // Add click event listener to the button
    toggleButton.addEventListener("click", function() {
        // Toggle the visibility of the sidebar
        if (sidebar.style.display === "none" || sidebar.style.display === "") {
            sidebar.style.display = "block";
            icon.classList.remove("fa-bars-staggered");
            icon.classList.add("fa-xmark");
        } else {
            sidebar.style.display = "none";
            icon.classList.remove("fa-xmark");
            icon.classList.add("fa-bars-staggered");
        }
    });
</script>