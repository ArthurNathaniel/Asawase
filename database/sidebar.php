<div class="sidebar_all">
<i class="fa-solid fa-xmark close-icon" onclick="this.parentElement.style.display='none';"></i>

    <div class="side_header">
       <div class="logo"></div>
    </div>
    <div class="links">
    <a href="dashboard.php"><i class="fa-solid fa-chart-pie"></i>Dashboard</a>
        <a href="register.php"><i class="fa-solid fa-user-plus"></i>Register Member</a>
        <a href="view_members.php"><i class="fa-solid fa-users"></i>View Members</a>
    </div>
    <div class="logout">
        <a href="logout.php"><i class="fa-solid fa-power-off"></i> Logout</a>
    </div>
   
</div>
<button id="toggleButton">
            <i class="fa-solid fa-bars-staggered"></i>
        </button>

<script>
        // Get the button and sidebar elements
        var toggleButton = document.getElementById("toggleButton");
        var sidebar = document.querySelector(".sidebar_all");

        // Add click event listener to the button
        toggleButton.addEventListener("click", function() {
            // Toggle the visibility of the sidebar
            if (sidebar.style.display === "none" || sidebar.style.display === "") {
                sidebar.style.display = "block";
            } else {
                sidebar.style.display = "none";
            }
        });
    </script>