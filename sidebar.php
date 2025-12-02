<?php
$current_page = basename($_SERVER['PHP_SELF']);

if ($current_page == 'note_detail.php') {
    $current_page = 'notes.php'; 
}

$active_class = "active";
?>

<style>

.sidebar {
    
    background-color: #171a1d;
    color: #fff; 
    position: fixed;
    top: 0;
    left: 0;
    height: 100vh;
    width: 250px; 
    overflow-y: auto; 
    scrollbar-width: none;
    z-index: 1050;
    transition: transform 0.3s ease-in-out; 
}


@media (max-width: 991.98px) { 

    .sidebar { 
        transform: translateX(-100%); 
        width: 75%; 
        box-shadow: 4px 0 10px rgba(0, 0, 0, 0.5);
    }
  
    .sidebar.active {
        transform: translateX(0); 
    }
}


@media (min-width: 992px) { 

    .sidebar { 
        width: 250px; 
        transform: translateX(0) !important;
    }
}



.profile-pic {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    background-color: #3b3e41;
    border: 2px solid #555;
}

.sidebar a.nav-link {
    font-size: 1.45rem;
    font-weight: 700;
    color: #fff;
    padding: 12px 10px; 
    line-height: 1.8; 
    border-radius: 8px;
    transition: 0.3s;
    display: block;
}

.sidebar a.nav-link:hover {
    background-color: #2a2d31;
    transform: none; 
}

.sidebar a.nav-link.active { 
    background-color: #20c997; 
    color: #171a1d; 
    font-weight: 800; 
    border-radius: 4px; 
    transform: none;
}
</style>

<div class="sidebar d-flex flex-column p-4" id="sidebar">

    <button class="btn-close btn-close-white d-lg-none position-absolute top-0 end-0 m-3" 
            aria-label="Close" onclick="closeSidebar()"></button>

    <div class="profile-info-container text-center my-4 d-flex flex-column align-items-center">
        <img src="images/id.jpg" alt="Profile Picture" class="profile-pic mx-auto mb-3">
        <div class="name-and-skills">
            <h3 class="text-white mb-0">Jul-Qarnain E. Cana</h3> 
            <p class="text-white">Web Development</p> 
        </div>
    </div>
    <nav class="nav-links flex-grow-1 mt-5">
        <ul class="list-unstyled">
            <li><a href="index.php" class="nav-link <?php echo ($current_page == 'index.php') ? $active_class : ''; ?>">Home</a></li>
            <li><a href="about.php" class="nav-link <?php echo ($current_page == 'about.php') ? $active_class : ''; ?>">About Me</a></li>
            <li><a href="projects.php" class="nav-link <?php echo ($current_page == 'projects.php') ? $active_class : ''; ?>">Project</a></li>
            <li><a href="certificates.php" class="nav-link <?php echo ($current_page == 'certificates.php') ? $active_class : ''; ?>">Certificates</a></li>
            <li><a href="notes.php" class="nav-link <?php echo ($current_page == 'notes.php') ? $active_class : ''; ?>">Notes</a></li>
        </ul>
    </nav>
    <div class="social-icons mt-auto mb-3">
        <a href="https://github.com/JulQarnainCana" class="text-white me-3"><i class="fab fa-github fa-2x"></i></a>
        <a href="https://www.facebook.com/share/17uvdVLBwp/" class="text-white me-3"><i class="fab fa-facebook fa-2x"></i></a>
        <a href="https://www.tiktok.com/@koksiofficial?_r=1&_t=ZS-91tH5O3oQwq" class="text-white"><i class="fab fa-tiktok fa-2x"></i></a>
    </div>
</div>

<script>
   
    function openSidebar() {
        const sidebar = document.getElementById('sidebar');
        if (sidebar) {
            sidebar.classList.add('active');
        }
    }

    function closeSidebar() {
        const sidebar = document.getElementById('sidebar');
        if (sidebar) {
            sidebar.classList.remove('active');
        }
    }
</script>