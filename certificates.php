<?php
// PHP logic para ma-determine ang active page
$current_page = basename($_SERVER['PHP_SELF']);
$active_class = "active";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificates - Jul-Qarnain E. Cana</title>
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


.toggle-btn-container {
    position: sticky;
    top: 0;
    z-index: 1000;
    padding: 15px 20px;
    background-color: #171a1d; 
    border-bottom: 1px solid var(--border-color);
}


.cert-card {
    background-color: var(--card-bg);
    border: 1px solid var(--border-color);
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
    transition: all 0.3s ease-in-out;
    height: 100%;
    overflow: hidden;
}


.cert-card:hover {
    border-color: var(--primary-accent);
    transform: translateY(-5px) scale(1.01); 
    box-shadow: 0 10px 25px rgba(52, 211, 153, 0.3);
}


.cert-image-container {
    background-color: #2c3035; 
    position: relative;
    width: 100%;
    padding-bottom: 75%; 
    overflow: hidden;
    border-top-left-radius: 12px;
    border-top-right-radius: 12px;
    border-bottom: 1px solid var(--border-color);
}

.cert-image {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: contain; 
    cursor: pointer; 
    transition: transform 0.3s ease;
    padding: 10px; 
}


.card-body {
    padding: 1.2rem 1.5rem;
    display: flex;
    flex-direction: column;
}

.cert-title {
    color: var(--primary-accent);
    font-weight: 700;
    font-size: 1.25rem;
    margin-bottom: 0.25rem;
}

.cert-issuer {
    color: #9ca3af;
    font-size: 0.95rem;
    margin-bottom: 0;
}

.cert-date {
    color: #b0b8c2; 
    font-size: 0.85rem;
    margin-top: 0.8rem; 
    border-top: 1px solid #2c3035; 
    padding-top: 0.6rem;
}

/* Modal Styling */
.modal-content {
    background-color: #2c3035; /* Darker background for the modal content */
    border: none;
}

.modal-body {
    padding: 0; /* Remove padding for the image to fill the body */
}

.modal-header {
    border-bottom: 1px solid var(--border-color);
}

.modal-title {
    color: var(--primary-accent);
}

.modal-backdrop.show {
    opacity: 0.8; /* Make backdrop a bit darker */
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

        <section id="certificate-list" class="pt-3">
            <h1 class="display-5 fw-bold text-white mb-5">
                <i class="fas fa-graduation-cap me-3" style="color: var(--primary-accent);"></i>My Certifications
            </h1>
            
            <div id="cert-container" class="row g-4">
                <div class="col-12 text-center text-secondary py-5">
                    Loading certifications...
                </div>
            </div>
            
        </section>
        
    </div> <div class="modal fade" id="certificateModal" tabindex="-1" aria-labelledby="certificateModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="certificateModalLabel">Certificate Preview</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalCertImage" src="" class="img-fluid" alt="Full Certificate Image" style="max-height: 90vh; width: auto;">
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Tiyakin na ang openSidebar() at closeSidebar() ay nandoon sa sidebar.php
        document.addEventListener('DOMContentLoaded', () => {
            const certContainer = document.getElementById('cert-container');
            const modalCertImage = document.getElementById('modalCertImage');
            const certificateModal = document.getElementById('certificateModal');

            const renderCertificates = (certificates) => {
                certContainer.innerHTML = ''; // Linisin ang 'Loading' message

                if (certificates.length === 0) {
                    certContainer.innerHTML = 
                        '<div class="col-12 text-center text-warning py-5">No certifications data available.</div>';
                    return;
                }
                
                certificates.forEach(cert => {
                    const card = document.createElement('div');
                    card.className = 'col-sm-6 col-lg-4';
                    
                    const imageUrl = cert.image_url || 'images/default_cert.png';

                    card.innerHTML = `
                        <div class="cert-card">
                            <div class="cert-image-container">
                                <img 
                                    src="${imageUrl}" 
                                    class="cert-image" 
                                    alt="${cert.title} Certificate"
                                    data-bs-toggle="modal" 
                                    data-bs-target="#certificateModal"
                                    data-image-url="${imageUrl}"
                                >
                            </div>
                            <div class="card-body">
                                <h5 class="cert-title">${cert.title}</h5>
                                <p class="cert-issuer">Issuing Body: ${cert.issuer || 'N/A'}</p>
                                <p class="cert-date">Issued: ${cert.date || 'N/A'}</p>
                            </div>
                        </div>
                    `;
                    certContainer.appendChild(card);
                });
                
                setupImageClickListeners();
            };

            const setupImageClickListeners = () => {
                // Gamitin ang 'show.bs.modal' event ng Bootstrap sa modal mismo
                certificateModal.addEventListener('show.bs.modal', function (event) {
                    // Button that triggered the modal
                    const button = event.relatedTarget; 
                    // Extract info from data-* attributes
                    const clickedImageUrl = button.getAttribute('data-image-url');
                    const certTitle = button.getAttribute('alt'); 
                    
                    // Update the modal's content.
                    modalCertImage.src = clickedImageUrl;
                    document.getElementById('certificateModalLabel').textContent = `${certTitle} Preview`;
                });
            };

            const loadCertificates = async () => {
                try {
                    // Fetch data mula sa certificates.json
                    const response = await fetch('certificates.json'); 
                    const certificatesData = await response.json();
                    renderCertificates(certificatesData);
                } catch (err) {
                    console.error("Error loading certificates.json:", err);
                    certContainer.innerHTML = 
                        '<div class="col-12 text-center text-danger py-5">Error loading certificates.json. Please ensure the file exists and is formatted correctly.</div>';
                }
            };

            loadCertificates();
            // Setup listener on modal element for better practice
            setupImageClickListeners(); 
        });
    </script>

</body>
</html>