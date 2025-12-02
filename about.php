<?php
$current_page = basename($_SERVER['PHP_SELF']);
$active_class = "active";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Me - Jul-Qarnain E. Cana</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    
    <style>
:root {
    --primary-accent: #34d399;
    --secondary-text: #ced4da;
    --card-bg: #171a1d;
    --border-color: #3d4045;
    --sidebar-width-lg: 250px;
    --sidebar-width-md: 200px;
}

body {
    background-color: #212529;
    min-height: 100vh;
}

.sidebar {
    position: fixed;
    top: 0;
    left: 0;
    height: 100vh;
    z-index: 1050;
    transition: transform 0.3s ease-in-out;
}

@media (min-width: 992px) {
    .sidebar { width: var(--sidebar-width-lg) !important; }
}

@media (min-width: 768px) and (max-width: 991.98px) {
    .sidebar { width: var(--sidebar-width-md) !important; }
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

.content-area {
    background-color: #212529;
    color: var(--secondary-text);
    min-height: 100vh;
    padding: 3rem 4rem;
    margin-left: var(--sidebar-width-lg); 
    width: calc(100% - var(--sidebar-width-lg));
    transition: margin-left 0.3s ease-in-out, width 0.3s ease-in-out;
}

@media (min-width: 768px) and (max-width: 991.98px) {
    .content-area {
        margin-left: var(--sidebar-width-md);
        width: calc(100% - var(--sidebar-width-md));
    }
}

@media (max-width: 767.98px) {
    .content-area {
        margin-left: 0;
        width: 100%;
    }
}

.toggle-btn-container {
    position: sticky;
    top: 0;
    z-index: 1000;
    padding: 15px 20px;
    background-color: #171a1d; 
    border-bottom: 1px solid var(--border-color);
}

.about-intro h1 {
    color: var(--primary-accent) !important;
    text-shadow: 0 0 10px rgba(52, 211, 153, 0.4);
    margin-bottom: 2rem !important;
}

.about-intro h3 {
    color: var(--secondary-text);
    font-weight: 400;
    margin-bottom: 1.5rem;
    font-size: 1.6rem;
}

.about-intro p {
    line-height: 1.6; 
    color: #b0b8c2 !important;
    font-size: 1.20rem;
}

.skill-card {
    background-color: var(--card-bg);
    border: 1px solid var(--border-color);
    border-radius: 12px;
    padding: 1.5rem 1rem;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.5);
    transition: all 0.3s ease-in-out;
    height: 100%; 
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}

.skill-card:hover {
    border-color: var(--primary-accent);
    transform: translateY(-5px); 
    box-shadow: 0 8px 25px rgba(52, 211, 153, 0.25);
}

.gallery-item img {
    width: auto;
    max-height: 100px;
    max-width: 100%; 
    object-fit: contain;
    border-radius: 0;
    margin-bottom: 0.5rem;
}

.skill-label {
    color: var(--primary-accent);
    font-weight: 700;
    font-size: 1.2rem;
    margin-top: 0.5rem;
}

.section-divider {
    border: 0;
    border-top: 1px solid var(--border-color);
    opacity: 0.8;
}

    </style>
</head>

<body>
    
    <?php include 'sidebar.php'; ?>
    
    <div class="toggle-btn-container d-lg-none">
        <button class="btn btn-outline-info" onclick="openSidebar()">
            <i class="fas fa-bars me-2"></i> Menu
        </button>
    </div>

    <div class="content-area">

        <section id="about-intro" class="mb-5 pt-3">
            <h1 class="text-white display-5 mb-3 fw-bold">About Me</h1>
            
            <h3>
                I am <span style="color: #00bfff;">Jul-Qarnain E. Cana</span>,
            </h3>
            <p style="color: #d1d1d1; line-height: 1.6; font-size: 1.20rem;">
                A passionate and dedicated Web Developer with extensive knowledge in full-stack development.
                I love solving complex problems and creating clean, efficient, and user-friendly web applications.
                My main focus is on using modern technologies such as PHP, Python, and JavaScript frameworks.
                I believe that continuous learning and adapting to new technologies is the key to success in the world of programming.
            </p>
        </section>

        <hr class="section-divider my-5">

        <section id="my-gallery">
            <h2 class="text-white mb-4">My Skills</h2>
            
            <div class="row g-4">
                
                <div class="col-6 col-md-4 col-lg-3 gallery-item">
                    <div class="skill-card">
                        <img src="images/html-css.png" alt="HTML and CSS Skill">
                        <span class="skill-label">HTML & CSS</span>
                    </div>
                </div>
                
                <div class="col-6 col-md-4 col-lg-3 gallery-item">
                    <div class="skill-card">
                        <img src="images/phplogo.png" alt="PHP Logo">
                        <span class="skill-label">PHP</span>
                    </div>
                </div>
                
                <div class="col-6 col-md-4 col-lg-3 gallery-item">
                    <div class="skill-card">
                        <img src="images/mysql.png" alt="MySQL Database">
                        <span class="skill-label">MySQL</span>
                    </div>
                </div>
                
                <div class="col-6 col-md-4 col-lg-3 gallery-item">
                    <div class="skill-card">
                        <img src="images/java.png" alt="Java Programming">
                        <span class="skill-label">Java</span>
                    </div>
                </div>
                
                <div class="col-6 col-md-4 col-lg-3 gallery-item">
                    <div class="skill-card">
                        <img src="images/python.png" alt="Python Programming">
                        <span class="skill-label">Python</span>
                    </div>
                </div>
                
                <div class="col-6 col-md-4 col-lg-3 gallery-item">
                    <div class="skill-card">
                        <img src="images/javascript.png" alt="JavaScript">
                        <span class="skill-label">JavaScript</span>
                    </div>
                </div>

                <div class="col-6 col-md-4 col-lg-3 gallery-item">
                    <div class="skill-card">
                        <img src="images/figma.png" alt="Figma">
                        <span class="skill-label">Figma</span>
                    </div>
                </div>
            </div>
        </section>
        
    </div> 
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
