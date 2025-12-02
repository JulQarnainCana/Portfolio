<?php

function getAllProjects() {
   
    if (!file_exists('learn_data.json')) {
        return [];
    }
    
   
    $json_data = file_get_contents('learn_data.json');
    // Decode the JSON data into a PHP array
    $projects = json_decode($json_data, true);

  
    if (!is_array($projects)) {
        return [];
    }

    return $projects;
}

$all_projects = getAllProjects();


$data_error = false;
if (empty($all_projects)) {
    $data_error = true;
}


$current_page = basename($_SERVER['PHP_SELF']);
$active_class = "active";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfolio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    
    <style>

:root {
    --sidebar-width-lg: 250px; 
    --sidebar-width-md: 200px;
}

body {
    background-color: #212529;
    min-height: 100vh;
}


@media (min-width: 992px) {
    .sidebar { width: var(--sidebar-width-lg) !important; }
}

@media (min-width: 768px) and (max-width: 991.98px) {
    .sidebar { width: var(--sidebar-width-md) !important; }
}


.content-area {
    background-color: #212529;
    color: #e9ecef;
    min-height: 100vh;
    padding: 1.2rem 2.5rem;
    
   
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
    border-bottom: 1px solid #3d4045;
}



.project-item {
    margin-bottom: 25px !important;
    padding-bottom: 5px;
}

.project-item h3 {
    margin: 0 !important; 
    padding: 0 !important; 
    height: auto !important;
    color: #34d399;
    cursor: pointer;
    font-size: 1.65rem;
    font-weight: 700;
    letter-spacing: 0.3px;
    transition: color 0.3s ease-in-out;
}
.project-item .project-link:hover h3 {
    color: #f59e0b; 

.project-item p.description {
    margin: 0.1rem 0 !important;
    line-height: 1.45;
    font-size: 1.05rem;
    color: #ffffff;
    opacity: 0.9;
}

.project-divider {
    border: 0;
    border-top: 1px solid #3d4045;
    opacity: 0.8;
    margin: 0.25rem 0 0.45rem 0 !important;
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

    <div class="content-area p-5">

        <section id="home" class="content-section">
            <h1 class="text-white">Home</h1> 
            <p class="text-muted">A showcase of my recent work and capabilities. (Total Projects: <?php echo count($all_projects); ?>)</p>
        </section>
        <hr class="project-divider">

        <section id="projects" class="content-section pt-4">
            
            <?php if ($data_error): ?>
                <div class="alert alert-danger" role="alert">
                    Error: The <code>learn_data.json</code> file could not be loaded or is empty. Please check the file.
                </div>
            <?php else: ?>
                
                <?php foreach ($all_projects as $project): ?>
                    <div class="project-item mb-4 pb-3">
                        <a href="details.php?id=<?php echo htmlspecialchars($project['id'] ?? '0'); ?>" class="project-link text-decoration-none">
                            <h3><?php echo htmlspecialchars($project['title'] ?? 'Untitled Project'); ?></h3>
                        </a>
                        <p class="description"><?php echo htmlspecialchars($project['description'] ?? 'No description provided.'); ?></p>
                        <hr class="project-divider">
                    </div>
                <?php endforeach; ?>

            <?php endif; ?>

        </section>

    </div> <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    </body>
</html>