<?php

$current_page = basename($_SERVER['PHP_SELF']);
$active_class = "active"; 
$notes_data = [];
$json_file_path = 'mynotes/note_manifest.json'; 

$search_query = isset($_GET['q']) ? strtolower(trim($_GET['q'])) : '';

// Load JSON
if (file_exists($json_file_path)) {

    $json_content = file_get_contents($json_file_path);
    $all_notes = json_decode($json_content, true);

    if (!empty($search_query) && is_array($all_notes)) {
        foreach ($all_notes as $note) {
            if (isset($note['title']) && stripos($note['title'], $search_query) !== false) {
                $notes_data[] = $note;
            }
        }
    } elseif (is_array($all_notes)) {
        $notes_data = $all_notes;
    }

} else {
    // Missing JSON file
    $notes_data = [
        [
            'title' => 'Sample Note: Data File Missing!',
            'id' => 'ERROR-404',
            'excerpt' => "Manifest file ({$json_file_path}) is missing. Cannot display notes list."
        ],
    ];
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notes - Technical & Career Insights</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>
/* ROOT VARIABLES */
:root {
    --sidebar-width-lg: 250px;
    --sidebar-width-md: 200px;
    --toggle-width-lg: 65px; /* Collapsed sidebar width (for desktop) */
}

/* BASE */
body { 
    background-color: #0d0f11; 
    color: #f8f9fa;
    min-height: 100vh;
}

/* SIDEBAR */
.sidebar { 
    background-color: #171a1d; 
    color: #fff; 
    position: fixed; 
    top: 0; 
    left: 0; 
    height: 100vh; 
    width: var(--sidebar-width-lg); 
    overflow-y: auto; 
    z-index: 2000;
    transition: transform 0.3s ease-in-out, width 0.3s ease-in-out;
}

/* DESKTOP (>= 992px) */
@media (min-width: 992px) {
    /* Collapse state for sidebar */
    .sidebar.hidden {
        width: var(--toggle-width-lg) !important;
    }
}

/* MOBILE/TABLET (< 992px) */
@media (max-width: 991.98px) {
    .sidebar { 
        width: var(--sidebar-width-lg); 
        transform: translateX(-100%); /* Itago sa simula */
    }
    .sidebar.expanded { 
        transform: translateX(0%);
    }
    
    /* Close Button Styling */
    .sidebar .close-btn {
        display: block; 
        position: absolute;
        top: 15px; 
        right: 15px; 
        z-index: 2010;
        font-size: 1.5rem;
        color: #f8f9fa;
        background: transparent;
        border: none;
        padding: 5px;
        cursor: pointer;
    }
}

/* Itago ang close button sa desktop */
@media (min-width: 992px) {
    .sidebar .close-btn {
        display: none !important;
    }
}


.sidebar a.nav-link { 
    font-size: 1.45rem; 
    font-weight: 700; 
    color: #fff; 
    padding: 12px 10px; 
    border-radius: 8px; 
    transition: 0.3s; 
}

.sidebar a.nav-link.active { 
    background-color: #20c997; 
    color: #171a1d; 
    font-weight: 800; 
}


.main-content { 
    padding: 30px; 
    margin-left: var(--sidebar-width-lg);
    width: calc(100% - var(--sidebar-width-lg));
    transition: margin-left 0.3s ease-in-out, width 0.3s ease-in-out;
}


@media (min-width: 992px) {
    .main-content.expanded {
        margin-left: var(--toggle-width-lg); 
        width: calc(100% - var(--toggle-width-lg));
    }
}


@media (min-width: 768px) and (max-width: 991.98px) {
    .main-content {
        margin-left: var(--sidebar-width-md);
        width: calc(100% - var(--sidebar-width-md));
    }
    
   
    .main-content.expanded {
        margin-left: var(--toggle-width-lg);
        width: calc(100% - var(--toggle-width-lg));
    }
}


@media (max-width: 767.98px) {
    .main-content {
        margin-left: 0 !important;
        width: 100% !important;
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



.search-container { 
    background-color: #171a1d; 
    padding: 20px; 
    border-radius: 8px; 
    margin-bottom: 40px; 
    border: 1px solid #3b3e41; 
}


.note-card { 
    background-color: #1c2024; 
    border-radius: 10px; 
    padding: 30px; 
    margin-bottom: 30px; 
    border: 1px solid #3b3e41; 
}

.note-card h2 { 
    color: #20c997;
    border-bottom: 2px solid #20c997; 
    padding-bottom: 10px; 
    margin-bottom: 20px; 
}

.note-id-badge { 
    font-size: 0.75rem; 
    font-weight: 700; 
    padding: 4px 8px; 
    border-radius: 4px; 
    color: #20c997; 
    border: 1px solid #20c997; 
}

.btn-outline-info {
    color: #20c997;
    border-color: #20c997;
}
.btn-outline-info:hover {
    background-color: #20c997;
    color: #1c2024;
}
</style>
</head>

<body>

<?php include 'sidebar.php'; ?>

<div class="toggle-btn-container">
    <button class="btn btn-outline-info" onclick="openSidebar()">
        <i class="fas fa-bars me-2"></i> Menu
    </button>
</div>

<div class="main-content" id="main-content">

    <h1 class="display-5 mb-4 text-white">Technical Notes & Articles</h1>

    <div class="search-container">
        <form action="notes.php" method="GET">
            <div class="input-group">
                <input type="text" class="form-control form-control-lg bg-dark text-white border-0" 
                    placeholder="Search notes by title or keywords..." 
                    name="q"
                    value="<?php echo htmlspecialchars($search_query); ?>">

                <button class="btn btn-primary" type="submit">
                    <i class="fas fa-search"></i> Search
                </button>
            </div>
        </form>
    </div>
    
    <p class="lead text-white mb-5">A collection of technical articles, career insights, and learning documentation.</p>

    <div id="notes-list">

        <?php if (count($notes_data) > 0): ?>
            <?php foreach ($notes_data as $note): ?>
                
                <?php 
                    $note_title = $note['title'] ?? 'Untitled Note';
                    $note_id = $note['id'] ?? 'N/A';
                    $note_excerpt = $note['excerpt'] ?? 'No excerpt available.';
                ?>

                <div class="note-card" id="note-<?php echo strtolower($note_id); ?>">
                    <h2>
                        <?php echo htmlspecialchars($note_title); ?> 
                        <span class="note-id-badge">ID: <?php echo htmlspecialchars($note_id); ?></span>
                    </h2>

                    <p><strong>Excerpt:</strong> <?php echo htmlspecialchars($note_excerpt); ?></p>

                    <a href="note_detail.php?id=<?php echo urlencode($note_id); ?>" 
                        class="btn btn-outline-info mt-3">
                        Read Full Note <i class="fas fa-arrow-right"></i>
                    </a>
                </div>

            <?php endforeach; ?>

        <?php else: ?>

            <div class="alert alert-warning" role="alert">
                No notes found matching "<?php echo htmlspecialchars($search_query); ?>".
            </div>

        <?php endif; ?>

    </div>
</div>

<script>

function openSidebar() {
    const sidebar = document.querySelector('.sidebar');
    const mainContent = document.getElementById('main-content');
    
    const isDesktop = window.matchMedia("(min-width: 992px)").matches;

    if (isDesktop) {
       
        sidebar.classList.remove('hidden');
        mainContent.classList.remove('expanded');
    } else {
        
        sidebar.classList.add('expanded');
    }
}

function closeSidebar() {
    const sidebar = document.querySelector('.sidebar');
    const mainContent = document.getElementById('main-content');

    const isDesktop = window.matchMedia("(min-width: 992px)").matches;
    
    if (isDesktop) {
        
        sidebar.classList.add('hidden');
        mainContent.classList.add('expanded');
    } else {
      
        sidebar.classList.remove('expanded');
    }
}
</script>

</body>
</html>