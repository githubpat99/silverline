<?php
/* Template Name: Workflow Page */

get_header();

// Check if the user is logged in
$user_id = get_current_user_id();

// If the user is not logged in, use a session or other identifier
if (!$user_id) {
    if (!session_id()) {
        session_start(); // Start the session if it hasn't started
    }

    // Use a session identifier for anonymous users
    if (!isset($_SESSION['anonymous_user_id'])) {
        $_SESSION['anonymous_user_id'] = uniqid('anon_', true); // Generate a unique ID
    }
    $user_id = $_SESSION['anonymous_user_id'];
}

?>

<!-- Hidden Templates -->
<template id="step-1-template">
    <h3 style="margin-top: 0;">Wie hoch ist dein aktuelles Vermögen?</h3>
        <form id="step-1-form">
            <label for="cash">Bargeld</label>
            <input type="text" class="amount-field" max="99999999" id="cash" name="cash" value="" required>
            <label for="bank">Bank</label>
            <input type="text" class="amount-field" max="99999999" id="bank" name="bank" value="" required>
            <label for="securities">Wertpapiere</label>
            <input type="text" class="amount-field" max="99999999" id="securities" name="securities" value="" required>
            <label for="investments">Investitionen</label>
            <input type="text" class="amount-field" max="99999999" id="investments" name="investments" value="" required>
            <button type="submit" class="ok-btn" data-step-number="1">OK</button>
        </form>
</template>
<template id="step-2-template">
    <h3 style="margin-top: 0;">Hast du Schulden bzw. Hypotheken?</h3>
        <form id="step-2-form">
            <label for="mortgages">Hypotheken</label>
            <input type="text" class="amount-field" max="99999999" id="mortgages" name="mortgages" value="" required>
            <label for="consumer_loans">Konsumkredite</label>
            <input type="text" class="amount-field" max="99999999" class="amount-field" max="99999999" id="consumer_loans" name="consumer_loans" value="" required>
            <button type="submit" class="ok-btn" data-step-number="2">OK</button>
        </form>
</template>
<template id="step-3-template">
<h3 style="margin-top: 0;">Anschaffung oder sogar Erbe in Aussicht? &#128540</h3>
    <form id="step-3-form">
        <label for="mortgages">Anschaffungen</label>
        <input type="text" class="amount-field" max="99999999" id="mortgages" name="mortgages" value="" required>
        <label for="consumer_loans">Erbe</label>
        <input type="text" class="amount-field" max="99999999" id="consumer_loans" name="consumer_loans" value="" required>
        <button type="submit" class="ok-btn" data-step-number="3">OK</button>
    </form>
</template>
<template id="step-4-template">
    <h3 style="margin-top: 0;">Wie soll deine Finanzstrategie aussehen?</h3>
        <form id="step-4-form">
            <label for="mortgages">sicher investieren</label>
            <input type="text" class="amount-field" max="99999999" id="mortgages" name="mortgages" value="" required>
            <label for="consumer_loans">Steuern optimieren</label>
            <input type="text" class="amount-field" max="99999999" id="consumer_loans" name="consumer_loans" value="${stepData.consumer_loans || ''}" required>
            <button type="submit" class="ok-btn" data-step-number="4">OK</button>
        </form>
</template>
<template id="step-5-template">
    <h3 style="margin-top: 0;">Wie sieht dein Investitionsplan aus?</h3>
    <form id="step-5-form">
        <label for="risk_appetite">Risikoquote <sup>*</sup></label>
        <select id="risk_appetite" name="risk_appetite" required>
            <option value="20">20% Sicherheit</option>
            <option value="40">40% Balance</option>
            <option value="60">60% Wachstum</option>
            <option value="80">80% Aggressiv</option>
        </select>
        <h6 style="margin-top: 0; font-weight: normal">
            <sup>*</sup> Wie ist deine Risikobereitschaft? (20% Sicherheit, 40% Balance, 60% Wachstum, 80% Aggressiv)
        </h6>

        <label for="diversification">Diversifikation <sup>*</sup></label>
        <select id="diversification" name="diversification" required>
            <option value="A">A: Aktien</option>
            <option value="E">E: ETFs</option>
            <option value="G">G: Gemischt</option>
            <option value="O">O: Obligationen</option>
        </select>
        <h6 style="margin-top: 0; font-weight: normal">
            <sup>*</sup> Wie diversifiziert soll dein Portfolio sein? (A: Aktien, E: ETFs, G: Gemischt, O: Obligationen)
        </h6>

        <button type="submit" class="ok-btn" data-step-number="5">OK</button>
    </form>
</template>
<template id="step-6-template">
    <h3 style="margin-top: 0;">Wie hoch ist deine Sparquote?</h3>
        <form id="step-6-form">
            <label for="mortgages">Sparquote</label>
            <input type="text" class="amount-field" max="99999999" id="mortgages" name="mortgages" value="${stepData.mortgages || ''}" required>
            <label for="consumer_loans">Liquidität</label>
            <input type="text" class="amount-field" max="99999999" id="consumer_loans" name="consumer_loans" value="${stepData.consumer_loans || ''}" required>
            <button type="submit" class="ok-btn" data-step-number="6">OK</button>
        </form>
</template>
<!-- End of Hidden Templates -->

<div id="workflow-container" class="workflow-container">

    <div class="workflow-form" id="workflow-form">
        <!-- The form content will be dynamically rendered here by JavaScript -->

        
    </div>
    
    <div class="workflow-navigation">
        <ul>
            <li class="active" data-step-number="1">
                <a href="javascript:void(0)">
                    <span class="step-number">1</span> Vermögen
                </a>
            </li>
            <li data-step-number="2">
                <a href="javascript:void(0)">
                    <span class="step-number">2</span> Schulden
                </a>
            </li>
            <li data-step-number="3">
                <a href="javascript:void(0)">
                    <span class="step-number">3</span> Erwartungen
                </a>
            </li>
            <li data-step-number="4">
                <a href="javascript:void(0)">
                    <span class="step-number">4</span> Strategie
                </a>
            </li>
            <li data-step-number="5">
                <a href="javascript:void(0)">
                    <span class="step-number">5</span> Investition
                </a>
            </li>
            <li data-step-number="6">
                <a href="javascript:void(0)">
                    <span class="step-number">6</span> Liquidität
                </a>
            </li>
        </ul>
    </div>


</div>

<?php get_footer(); ?>
