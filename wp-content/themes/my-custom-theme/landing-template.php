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


/* Landing Page Container */
/* Landing Page Container */
.landing-container {
    display: flex;
    justify-content: center;
    align-items: flex-start;
    padding-top: 50px;
    padding-left: 10px;
    padding-right: 10px;
    text-align: center;
    min-height: calc(100vh - 100px); /* Adjusted height to account for reduced padding */
    background-image: url('<?php echo get_template_directory_uri(); ?>/images/Background_Silverline.png');
    background-size: cover; /* Ensure the background covers the entire container */
    position: relative; /* For overlay positioning */
}

/* Add a semi-transparent overlay */
.landing-container::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(255, 255, 255, 0.8); /* Light overlay for better readability */
    z-index: 0; /* Place it behind the content */
}

/* Content Styling */
.landing-content {
    position: relative; /* Ensure content is above the overlay */
    z-index: 1;
    max-width: 800px;
    padding: 30px;
    border-radius: 12px;
    animation: fadeIn 1.5s ease-in-out;
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
    color: black; /* Softer text color */
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

}
</style>

<?php
get_footer();
?>