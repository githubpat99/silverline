<?php
/*
Template Name: Landing Template
*/

get_header();
?>

<div class="landing-container">
    <div class="hero-box">
        <h1>Reicht dein Geld bis zur Pension?</h1>
        <p>Silverline zeigt dir, wo du finanziell stehst – einfach, sicher, individuell.</p>
        <a href="/membership-login" class="cta-button">Jetzt kostenlos starten</a>
        <button class="video-button" onclick="openModal()">Wie funktioniert Silverline?</button>

        <!-- Vertrauens-Sektion (kompakt) -->
        <div class="trust-section">
            <h2>Vertrauen & Sicherheit</h2>
            <div class="trust-icons">
                <div class="trust-icon-box">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/f/f3/Flag_of_Switzerland.svg" alt="Schweizer Hosting">
                    <p>Schweizer Hosting</p>
                </div>
                <div class="trust-icon-box">
                <img src="<?php echo get_template_directory_uri(); ?>/images/icon-lock.svg" alt="Datensicherheit">
                    <p>100% Datensicherheit</p>
                </div>
                <div class="trust-icon-box">
                <img src="<?php echo get_template_directory_uri(); ?>/images/icon-no-tracking.svg" alt="Keine Datenweitergabe">
                    <p>Keine Datenweitergabe</p>
                </div>
            </div>
        </div>

    </div>

    <div class="landing-content">
        <h4 class="landing-title">Wir möchten Dir gerne dabei helfen, Deine Finanzen besser zu verstehen.</h4>
        <h3 class="landing-subtitle">Bist Du dabei?</h3>
        <p class="landing-description">
            Deine persönliche Finanzanalyse wird Dir bestimmt dabei helfen, die folgenden Fragen besser beantworten zu können:
        </p>

        <ul class="landing-questions">
            <li>Reicht mein Altersguthaben, um meinen Lebensstandard halten zu können?</li>
            <li>Kann ich in meinem Einfamilienhaus bleiben?</li>
            <li>Wie sehen meine persönlichen Finanzen aktuell und in Zukunft aus?</li>
        </ul>
    </div>
</div>

<!-- Modal Video -->
<div id="videoModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <video id="modalVideo" controls>
            <source src="<?php echo get_template_directory_uri(); ?>/videos/silverline2.mp4" type="video/mp4">
            Dein Browser unterstützt dieses Videoformat nicht.
        </video>
    </div>
</div>

<style>
/* Base Styles */
body {
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
}

.landing-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 60px 20px 55px 20px;
    text-align: center;
    min-height: calc(100vh - 115px);
    background-image: url('<?php echo get_template_directory_uri(); ?>/images/Background_Silverline.png');
    background-size: cover;
    background-position: center;
    position: relative;
}

.landing-container::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(255, 255, 255, 0.8);
    z-index: 0;
}

.landing-content, .hero-box {
    position: relative;
    z-index: 1;
    max-width: 800px;
    margin-bottom: 40px;
}

/* Hero Section */
.hero-box h1 {
    font-size: 32px;
    margin-bottom: 15px;
    color: #0073aa;
}

.hero-box p {
    font-size: 18px;
    margin-bottom: 25px;
    color: #333;
}

.cta-button, .video-button {
    display: inline-block;
    margin: 8px;
    padding: 12px 22px;
    font-size: 16px;
    border-radius: 8px;
    cursor: pointer;
    text-decoration: none;
    border: none;
}

.cta-button {
    background-color: #0073aa;
    color: white;
}

.video-button {
    background-color: transparent;
    color: #0073aa;
    border: 2px solid #0073aa;
}

/* Vertrauenssektion */
.trust-section {
    background: #f4f4f4;
    padding: 40px 20px;
    text-align: center;
}

.trust-section h2 {
    font-size: 24px;
    margin-bottom: 30px;
    color: #0073aa;
}

.trust-icons {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    gap: 30px;
}

.trust-icon-box {
    max-width: 150px;
    text-align: center;
}

.trust-icon-box img {
    width: 48px;
    height: 48px;
    margin-bottom: 10px;
}

.trust-icon-box p {
    font-size: 14px;
    color: #333;
    margin: 0;
}

/* Landing Content */
.landing-title {
    font-size: 24px;
    margin-bottom: 10px;
    color: #333;
}

.landing-subtitle {
    font-size: 28px;
    margin-bottom: 20px;
    color: #0073aa;
}

.landing-description {
    font-size: 18px;
    margin-bottom: 30px;
    line-height: 1.6;
    color: black;
}

.landing-questions {
    list-style: none;
    padding: 0;
}

.landing-questions li {
    font-size: 16px;
    margin: 10px 0;
    position: relative;
    padding-left: 25px;
    color: #333;
}

.landing-questions li::before {
    content: '✔';
    position: absolute;
    left: 0;
    color: #0073aa;
    font-size: 18px;
}

/* Modal Styles */
.modal {
    display: none;
    position: fixed;
    z-index: 999;
    padding-top: 60px;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0,0,0,0.7);
}

.modal-content {
    background-color: #fefefe;
    margin: auto;
    padding: 0;
    border-radius: 12px;
    max-width: 90%;
    width: 800px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.3);
}

.modal-content video {
    width: 100%;
    border-radius: 12px;
}

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
    margin: 8px 12px 0 0;
    cursor: pointer;
}

.close:hover {
    color: black;
}

/* Responsive Design */
@media (max-width: 768px) {
    .hero-box h1 {
        font-size: 24px;
    }

    .landing-title {
        font-size: 20px;
    }

    .landing-subtitle {
        font-size: 24px;
    }

    .cta-button, .video-button {
        font-size: 14px;
        padding: 10px 18px;
    }

    .trust-item {
        width: 100px;
    }

    .trust-item img {
        width: 36px;
        height: 36px;
    }

    .trust-item p {
        font-size: 13px;
    }
}
</style>

<script>
function openModal() {
    document.getElementById("videoModal").style.display = "block";
}
function closeModal() {
    document.getElementById("videoModal").style.display = "none";
    const video = document.getElementById("modalVideo");
    video.pause();
    video.currentTime = 0;
}
</script>

<?php
get_footer();
?>
