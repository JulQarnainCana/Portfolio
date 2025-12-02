<?php
// Function to load project from JSON
function getProjectDetails($id) {
    // Assuming 'learn_data.json' holds the project details (as used in index.php)
    if (!file_exists('learn_data.json')) {
        return null;
    }

    $json_data = file_get_contents('learn_data.json');
    $projects = json_decode($json_data, true);

    if (!is_array($projects)) {
        return null;
    }

    foreach ($projects as $project) {
        if (isset($project['id']) && $project['id'] == $id) {
            return $project;
        }
    }

    return null;
}

// GET ?id=123
$project_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$project = getProjectDetails($project_id);

// DEFAULT VALUES
$page_title = "Project Not Found";
$project_title = "Project Not Found";
$project_description = "No project found for this ID.";
$project_long_description = "";
// Default image URL is now an array containing a single default path
$project_image_urls = ["images/default_placeholder.jpg"];

if ($project) {
    $page_title = $project['title'];
    $project_title = $project['title'];
    $project_description = $project['description'] ?? "";
    $project_long_description = $project['long_description'] ?? "";
    
    // Check if image_url is an array (for multiple images) or a string (for one image)
    if (isset($project['image_url'])) {
        if (is_array($project['image_url'])) {
            $project_image_urls = $project['image_url'];
        } else {
            // If it's a single string, put it into an array
            $project_image_urls = [$project['image_url']];
        }
    }
}
// PHP logic para ma-determine ang active page
$current_page = basename($_SERVER['PHP_SELF']);
$active_class = "active";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
/* ---------------------------------- */
/* DESIGN VARIABLES */
/* ---------------------------------- */
:root {
    --primary-accent: #34d399; 
    --secondary-text: #ced4da;
    --card-bg: #171a1d;
    --border-color: #3d4045;
    /* 🚩 NEW: Responsive Sidebar Widths 🚩 */
    --sidebar-width-lg: 250px;
    --sidebar-width-md: 200px;
}

/* ---------------------------------- */
/* BASE LAYOUT STYLES (Responsive) */
/* ---------------------------------- */
body {
    background-color: #212529;
    min-height: 100vh;
}

/* ---------------------------------- */
/* CONTENT AREA LAYOUT (RESPONSIVE) */
/* ---------------------------------- */
.content-area {
    background-color: #212529;
    color: #e9ecef;
    min-height: 100vh;
    padding: 2.5rem;
    
    /* Desktop Offset: Content starts after the fixed sidebar */
    margin-left: var(--sidebar-width-lg); 
    width: calc(100% - var(--sidebar-width-lg));
    transition: margin-left 0.3s ease-in-out, width 0.3s ease-in-out;
}

/* Medium Screen Content Offset */
@media (min-width: 768px) and (max-width: 991.98px) {
    .content-area {
        margin-left: var(--sidebar-width-md);
        width: calc(100% - var(--sidebar-width-md));
    }
}

/* MOBILE: No Margin Offset */
@media (max-width: 767.98px) {
    .content-area {
        margin-left: 0;
        width: 100%;
    }
}

/* -------------------------------------- */
/* HAMBURGER BUTTON CONTAINER             */
/* -------------------------------------- */
.toggle-btn-container {
    position: sticky;
    top: 0;
    z-index: 1000;
    padding: 15px 20px;
    background-color: #171a1d; 
    border-bottom: 1px solid var(--border-color);
}

/* ---------------------------------- */
/* IMAGE GALLERY STYLES */
/* ---------------------------------- */
.project-divider {
    border: 0;
    border-top: 1px solid #3d4045;
    opacity: 0.8;
}

.image-gallery {
    display: flex;
    flex-wrap: wrap; 
    justify-content: center;
    gap: 20px; 
    margin-top: 30px;
    margin-bottom: 30px;
}

.project-detail-image-container {
    width: 100%; 
    max-width: 450px; 
    text-align: center;
    border: 1px solid var(--border-color);
    border-radius: 8px;
    padding: 10px;
    background-color: var(--card-bg);
    box-shadow: 0 4px 15px rgba(0,0,0,0.4);
}

.project-detail-image-container img {
    width: 100%; 
    height: auto; 
    border-radius: 4px;
    display: block;
}

@media (min-width: 992px) {
    .project-detail-image-container {
        max-width: calc(50% - 10px); 
    }
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

        <a href="index.php" class="text-muted d-block mb-4">← Back to Projects</a>

        <h1 class="text-white"><?php echo htmlspecialchars($project_title); ?></h1>
        <p class="lead text-white-50"><?php echo htmlspecialchars($project_description); ?></p>

        <hr class="project-divider my-4">

        <?php if ($project): ?>

        <h2 class="text-white mb-3">Overview</h2>
        <p style="color: #ffffffff; font-size: 1.1rem; line-height: 1.6;"><?php echo nl2br(htmlspecialchars($project_long_description)); ?></p>

        <div class="image-gallery">
            <?php foreach ($project_image_urls as $url): ?>
                <div class="project-detail-image-container">
                    <img src="<?php echo htmlspecialchars($url); ?>" alt="<?php echo htmlspecialchars($project_title); ?> Image">
                </div>
            <?php endforeach; ?>
        </div>
        <a href="index.php" class="btn btn-outline-success mt-4">Return to Portfolio</a>

        <?php else: ?>

        <p class="text-danger mt-5">No project found with this ID.</p>
        <a href="index.php" class="btn btn-outline-success mt-4">Go Back</a>

        <?php endif; ?>

    </div> <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>