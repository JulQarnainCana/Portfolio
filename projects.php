<?php
$current_page = basename($_SERVER['PHP_SELF']);
$active_class = "active";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projects - Jul-Qarnain E. Cana</title>
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

.project-card {
    background-color: var(--card-bg);
    border: 1px solid var(--border-color);
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.4);
    transition: all 0.3s ease-in-out;
    height: 100%;
    overflow: hidden; 
    display: flex;
    flex-direction: column;
}

.project-card:hover {
    border-color: var(--primary-accent);
    transform: translateY(-5px); 
    box-shadow: 0 8px 20px rgba(52, 211, 153, 0.2);
}

.project-image {
    width: 100%;
    height: 200px; 
    object-fit: cover; 
    border-top-left-radius: 12px;
    border-top-right-radius: 12px;
}

.card-body {
    padding: 1.5rem;
    display: flex;
    flex-direction: column;
    flex-grow: 1;
}

.card-title {
    margin-top: 0.8rem; 
    margin-bottom: 0.8rem; 
    letter-spacing: 1.5px; 
    text-transform: uppercase; 
    color: var(--primary-accent);
    font-weight: 700;
    text-align: center;
}

.card-text {
    color: #b0b8c2;
    font-size: .95rem;
    flex-grow: 1; 
    max-width: 90%; 
    margin: 0 auto; 
    text-align: left;
}

.btn-outline-accent {
    color: #FFFFFF !important; 
    border-color: var(--primary-accent); 
    background-color: transparent; 
    font-weight: 600; 
    padding: 0.5rem 1.5rem; 
    border-radius: 6px; 
    text-transform: uppercase; 
    letter-spacing: 0.5px;
    transition: all 0.3s ease;
}

.btn-outline-accent:hover {
    background-color: var(--primary-accent);
    color: #000000ff !important;
    border-color: var(--primary-accent);
    transform: translateY(-2px); 
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

        <section id="project-list" class="pt-3">
            <h1 class="display-5 fw-bold text-white mb-5">
                <i class="fas fa-folder-open me-3" style="color: var(--primary-accent);"></i>My Portfolio Projects
            </h1>
            
            <div id="project-list-container" class="row g-4"></div>

        </section>
        
    </div> 

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
<script>
    document.addEventListener('DOMContentLoaded', () => {
        fetchProjects();
    });

    async function fetchProjects() {
        const container = document.getElementById('project-list-container');
        container.innerHTML = ''; 

        try {
            const response = await fetch('projects.json'); 
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            const data = await response.json();
            
            let projectsArray = [];

            if (Array.isArray(data)) {
                projectsArray = data;
            } else if (data && data.projects && Array.isArray(data.projects)) {
                projectsArray = data.projects;
            } else {
                console.error('Project data error', data);
                container.innerHTML = `<p class="text-danger">Failed to display projects. Please ensure the JSON file is correctly formatted.</p>`;
                return; 
            }

            projectsArray.forEach(project => {
                    const projectHtml = `
                        <div class="col-md-6 col-lg-4">
                            <div class="project-card">
                                <img src="${project.image}" class="project-image" alt="${project.title} Image">
                                <div class="card-body">
                                    <h5 class="card-title">${project.title}</h5>
                                    <p class="card-text">
                                        ${project.description}
                                    </p>
                                    <a href="${project.link}" class="btn btn-outline-accent mt-3" target="_blank">
                                        View Details
                                    </a>
                                </div>
                            </div>
                        </div>
                `;
                container.innerHTML += projectHtml;
            });

        } catch (error) {
            console.error('Error:', error);
            container.innerHTML = `
                <p class="text-danger">Failed to load projects. Ensure projects.json exists and is valid. (${error.message})</p>
            `;
        }
    }
</script>

</body>
</html>
