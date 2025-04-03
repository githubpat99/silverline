<?php
/*
Template Name: Landing Template
*/

get_header();
?>

<div class="landing-container">
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

<style>
/* General Reset */
body {
    margin: 0;
    padding: 0;
    font-family: 'Arial', sans-serif;
    background: linear-gradient(180deg, #f8f9fa, #e9ecef); /* Sehr dezentes Grau */
    color: #696969; /* Adjusted text color for better contrast */
}

/* Landing Page Container */
.landing-container {
    display: flex;
    justify-content: center;
    align-items: flex-start; /* Align content to the top */
    padding-top: 50px; 
    padding-left: 10px;
    padding-right: 10px; 
    text-align: center;
}

/* Content Styling */
.landing-content {
    max-width: 800px;
    background: rgba(255, 255, 255, 0.8); /* Slightly opaque white background */
    padding: 30px; /* Reduce padding */
    border-radius: 12px;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    animation: fadeIn 1.5s ease-in-out;
    margin-top: 20px; /* Add a small margin from the top */
}

.landing-title {
    font-size: 24px;
    margin-bottom: 10px;
    color: #333; /* Darker text for better readability */
}

.landing-subtitle {
    font-size: 28px;
    margin-bottom: 20px;
    color: #0073aa; /* Primary color for emphasis */
}

.landing-description {
    font-size: 18px;
    margin-bottom: 30px;
    line-height: 1.6;
    color: #555; /* Softer text color */
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
    color: #0073aa; /* Primary color for icons */
    font-size: 18px;
}

/* Animations */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Responsive Design */
@media (max-width: 768px) {
    .landing-content {
        padding: 10px;
    }

    .landing-title {
        font-size: 20px;
    }

    .landing-subtitle {
        font-size: 24px;
    }

    .landing-description {
        font-size: 16px;
    }
}
</style>

<?php
get_footer();
?>