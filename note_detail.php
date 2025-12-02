<?php
// 1. PHP SETUP & DATA LOADING
$note_id = isset($_GET['id']) ? htmlspecialchars($_GET['id']) : null;
$current_note = null;
$error_message = '';

// Path to the Index/Manifest file
$manifest_file_path = 'mynotes/note_manifest.json'; 

// Check if manifest exists and note ID is provided
if ($note_id && file_exists($manifest_file_path)) {
    
    // Step 1: Read the Manifest to find the specific note's filename
    $manifest_content = file_get_contents($manifest_file_path);
    $all_notes_manifest = json_decode($manifest_content, true);
    
    $target_filename = null;

    if (is_array($all_notes_manifest)) {
        // Find the manifest entry that matches the ID
        foreach ($all_notes_manifest as $entry) {
            if (isset($entry['id']) && $entry['id'] === $note_id) {
                $target_filename = $entry['filename'];
                break;
            }
        }
    }

    if ($target_filename) {
       
        $note_file_path = 'mynotes/' . $target_filename;

        if (file_exists($note_file_path)) {
            $note_content = file_get_contents($note_file_path);
       
            $current_note = json_decode($note_content, true);
        } else {
            $error_message = "Error: Note file '{$target_filename}' found in manifest but is missing from the server.";
        }
        
    } else {
        $error_message = "Error: Note with ID '{$note_id}' was not found in the manifest file.";
    }

} else {
    $error_message = "Error: Note ID not specified or the manifest file ({$manifest_file_path}) is missing. Cannot display details.";
}

// 2. SIDEBAR ACTIVE STATE LOGIC
$current_page = basename($_SERVER['PHP_SELF']);
$active_class = "active";
// Para maging active ang NOTES link kahit nasa note_detail.php tayo.
if ($current_page == 'note_detail.php') {
    $current_page = 'notes.php'; 
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $current_note ? htmlspecialchars($current_note['title']) : 'Note Not Found'; ?> | Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <style>
        /* ROOT VARIABLES (Gaya ng sa notes.php/index.php) */
        :root {
            --sidebar-width-lg: 250px;
            --sidebar-width-md: 200px;
            --toggle-width-lg: 65px; /* Collapsed sidebar width (for desktop) */
        }

        body { 
            background-color: #0d0f11; 
            color: #f8f9fa;
            min-height: 100vh; 
        }
        
        /* SIDEBAR STYLES */
        .sidebar { 
            background-color: #171a1d; 
            color: #fff; 
            position: fixed; 
            top: 0; 
            left: 0; 
            height: 100vh; 
            width: var(--sidebar-width-lg); 
            overflow-y: auto; 
            scrollbar-width: none; 
            z-index: 2000; 
            transition: transform 0.3s ease-in-out, width 0.3s ease-in-out;
        }

       
        @media (min-width: 992px) {
            .sidebar { width: var(--sidebar-width-lg); }
           
            .sidebar.hidden {
                width: var(--toggle-width-lg) !important;
            }
        }

        /* MOBILE/TABLET (< 992px) */
        @media (max-width: 991.98px) {
            .sidebar { 
                width: var(--sidebar-width-lg); 
                transform: translateX(-100%); 
            }
            .sidebar.expanded { 
                transform: translateX(0%);
            }
            
            
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
     
        @media (min-width: 992px) {
            .sidebar .close-btn {
                display: none !important;
            }
        }

        /* Iba pang sidebar styles... */
        .profile-pic { width: 150px; height: 150px; border-radius: 50%; background-color: #3b3e41; border: 2px solid #555; }
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
        .sidebar a.nav-link:hover { background-color: #2a2d31; transform: none; }
        .sidebar a.nav-link.active { 
            background-color: #20c997; 
            color: #171a1d; 
            font-weight: 800; 
            border-radius: 4px; 
            transform: none;
        } 

        /* MAIN CONTENT STYLES */
        .main-content { 
            padding: 30px; 
            margin-left: var(--sidebar-width-lg);
            width: calc(100% - var(--sidebar-width-lg));
            transition: margin-left 0.3s ease-in-out, width 0.3s ease-in-out;
        }
        
        /* DESKTOP CONTENT ADJUSTMENT (>= 992px) */
        @media (min-width: 992px) {
            .main-content.expanded {
                margin-left: var(--toggle-width-lg); 
                width: calc(100% - var(--toggle-width-lg));
            }
        }

        /* MEDIUM SCREEN (Tablet: 768px - 991.98px) */
        @media (min-width: 768px) and (max-width: 991.98px) {
            .main-content {
                margin-left: var(--sidebar-width-md);
                width: calc(100% - var(--sidebar-width-md));
            }
            
            /* Tablet Content Adjustment when collapsed */
            .main-content.expanded {
                margin-left: var(--toggle-width-lg);
                width: calc(100% - var(--toggle-width-lg));
            }
        }
        
        /* MOBILE FULL WIDTH (< 767.98px) */
        @media (max-width: 767.98px) { 
            .main-content { 
                margin-left: 0 !important; 
                width: 100% !important; 
            } 
        }
        
        /* TOGGLE BUTTON CONTAINER */
        .toggle-btn-container {
            position: sticky;
            top: 0;
            z-index: 1000; 
            padding: 15px 20px;
            background-color: #171a1d;
            border-bottom: 1px solid #3d4045;
        }
        
        /* Note Detail Styling */
        .note-container { 
            padding: 30px 40px; 
            background-color: #1c2024; 
            border-radius: 10px; 
            border: 1px solid #3b3e41;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
        }
        .note-title { color: #20c997; font-weight: 700; }
        
        /* Note ID Badge */
        .note-id-badge { 
            font-size: 0.8rem; 
            font-weight: 700; 
            padding: 5px 10px; 
            border-radius: 4px; 
            background-color: #0d0f11; 
            color: #20c997; 
            vertical-align: middle; 
            margin-left: 10px; 
            border: 1px solid #20c997;
        }
        
        
        .content-block h2 { color: #f8f9fa; margin-top: 25px; border-bottom: 2px solid #3b3e41; padding-bottom: 5px; font-weight: 600;}
        .content-block p { line-height: 1.8; color: #adb5bd;} 
        .content-block ul { padding-left: 20px; }

        
        .comparison-card { background-color: #2a2d31; border: none; }
        .comparison-card h5 { color: #f8f9fa; border-bottom: 1px solid #555; padding-bottom: 5px; margin-bottom: 15px;}
        .comparison-list-item { background-color: #2a2d31; border: none; color: #f8f9fa;}
        
       
        .pillar-card { 
            background-color: #2a2d31; 
            border: 1px solid #20c997; 
            height: 100%;
            transition: 0.3s;
        }
        .pillar-card:hover {
            box-shadow: 0 0 15px rgba(32, 201, 151, 0.5); 
            transform: translateY(-5px);
        }
        
        /* Bullet List Fix */
        .list-group-item { background-color: transparent !important; }
        .text-info { color: #20c997 !important; } 
        .btn-outline-info { color: #20c997; border-color: #20c997; }
        .btn-outline-info:hover { background-color: #20c997; color: #1c2024; }
        
    </style>
</head>
<body>

<?php 
// 🔑 INCLUSION ng Sidebar
include 'sidebar.php'; 
?>

<div class="toggle-btn-container">
    <button class="btn btn-outline-info" onclick="openSidebar()">
        <i class="fas fa-bars me-2"></i> Menu
    </button>
</div>

<div class="main-content" id="main-content">

    <?php if ($error_message): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $error_message; ?>
            <p class="mt-2"><a href="notes.php" class="btn btn-danger btn-sm">Go Back to Notes List</a></p>
        </div>
    <?php elseif ($current_note): ?>

    <div class="note-container">
        
        <a href="notes.php" class="btn btn-sm btn-outline-secondary mb-4"><i class="fas fa-arrow-left"></i> Back to Notes</a>
        <h1 class="note-title display-5 mb-3">
            <?php echo htmlspecialchars($current_note['title']); ?>
            <span class="note-id-badge">ID: <?php echo htmlspecialchars($current_note['id']); ?></span>
        </h1>
        <p class="lead text-secondary border-bottom pb-3 mb-5">
            <?php echo htmlspecialchars($current_note['excerpt']); ?>
        </p>

        <div class="content-block">
            <?php 
            if (isset($current_note['full_content']) && is_array($current_note['full_content'])):
                foreach ($current_note['full_content'] as $block):
            ?>
                <h2 class="mt-5 mb-4 text-white"><?php echo htmlspecialchars($block['heading']); ?></h2>

                <?php switch ($block['type']): 
                    
                    case 'paragraph': ?>
                        <p><?php echo $block['text']; ?></p>
                        <?php break; 
                        
                    case 'stat_list': ?>
                        <div class="row g-3">
                            <?php foreach ($block['items'] as $item): ?>
                                <div class="col-md-6">
                                    <div class="card p-3 h-100 pillar-card">
                                        <h5 class="card-title text-info"><?php echo $item['subtitle']; ?></h5> 
                                        <p class="card-text text-light"><?php echo $item['detail']; ?></p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <?php break;
                        
                    case 'comparison': ?>
                        <div class="row mt-4 g-4">
                            <div class="col-md-6">
                                <div class="card p-3 h-100 comparison-card">
                                    <h5 class="text-danger"><i class="fas fa-skull me-2"></i> <?php echo $block['left_title']; ?></h5>
                                    <ul class="list-group list-group-flush">
                                        <?php foreach ($block['left_items'] as $item): ?>
                                            <li class="list-group-item comparison-list-item comparison-list-item-left"><?php echo $item; ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card p-3 h-100 comparison-card">
                                    <h5 class="text-success"><i class="fas fa-shield-alt me-2"></i> <?php echo $block['right_title']; ?></h5>
                                    <ul class="list-group list-group-flush">
                                        <?php foreach ($block['right_items'] as $item): ?>
                                            <li class="list-group-item comparison-list-item comparison-list-item-right"><?php echo $item; ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <?php break;

                    case 'bullet_points': ?>
                        <p><?php echo $block['intro']; ?></p>
                        <ul class="list-group list-group-flush mt-3">
                            <?php foreach ($block['points'] as $point): ?>
                                <li class="list-group-item bg-transparent text-white border-secondary"><i class="fas fa-dot-circle me-2 text-info"></i> <?php echo $point; ?></li>
                            <?php endforeach; ?>
                        </ul>
                        <?php break;
                        
                    case 'pillar_list': ?>
                        <div class="row mt-4 g-4">
                            <?php foreach ($block['pillars'] as $pillar): ?>
                                <div class="col-md-4">
                                    <div class="card p-4 text-center pillar-card">
                                        <h4 class="text-warning"><?php echo $pillar['name']; ?></h4>
                                        <p class="text-secondary mb-0"><?php echo $pillar['description']; ?></p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <?php break;

                    case 'detailed_text': ?>
                        <p><?php echo $block['text']; ?></p>
                        <?php break;

                    default: ?>
                        <div class="alert alert-danger">Error: Unknown content type '<?php echo $block['type']; ?>'</div>
                <?php endswitch; ?>
            <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
    <?php else: ?>
    <div class="alert alert-danger" role="alert">
        Note was not loaded or could not be displayed.
        <p class="mt-2"><a href="notes.php" class="btn btn-danger btn-sm">Go Back to Notes List</a></p>
    </div>
    <?php endif; ?>
    
    <div class="mt-5 pt-3 border-top border-secondary">
        <a href="notes.php" class="btn btn-outline-info"><i class="fas fa-th-list me-2"></i> View All Notes</a>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>