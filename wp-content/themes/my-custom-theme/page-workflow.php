<?php
/* Template Name: Workflow Page */

// Start session if not already started
if (!session_id()) {
    session_start();
}

// Check if the user is logged in
$user_id = get_current_user_id();

// If the user is not logged in, use a session or other identifier
if (!$user_id) {
    // Use a session identifier for anonymous users
    if (!isset($_SESSION['anonymous_user_id'])) {
        $_SESSION['anonymous_user_id'] = uniqid('anon_', true); // Generate a unique ID
    }
    $user_id = $_SESSION['anonymous_user_id'];
}

get_header();

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
            <input type="text" class="amount-field" max="99999999" id="depot" name="depot" value="" required>
            <label for="investments">Immobilien</label>
            <input type="text" class="amount-field" max="99999999" id="immo" name="immo" value="" required>
            <button type="submit" class="ok-btn" data-step-number="1">OK</button>
        </form>
</template>
<template id="step-2-template">
    <h3 style="margin-top: 0;">Hast du Schulden bzw. Hypotheken?</h3>
        <form id="step-2-form">
            <label for="consumer_loans">Kreditkarte(n)</label>
            <input type="text" class="amount-field" max="99999999" id="ccard" name="ccard" value="" required>
            <label for="consumer_loans">Konsumkredite</label>
            <input type="text" class="amount-field" max="99999999" id="credit" name="credit" value="" required>
            <label for="mortgages">Hypotheken</label>
            <input type="text" class="amount-field" max="99999999" id="hypo" name="hypo" value="" required>
            <button type="submit" class="ok-btn" data-step-number="2">OK</button>
        </form>
</template>
<template id="step-3-template">
    <h3 style="margin-top: 0;">Wie steht's um deine Altersvorsorge?</h3>
        <form id="step-3-form">
            <label for="mortgages">Private Vorsorge <sup>*</sup></label>
            <input type="text" class="amount-field" max="99999999" id="priv" name="priv" value="" required>
            <h6 style="margin-top: 0; font-weight: normal">
                <sup>*</sup> Aktuelles Guthaben in der Säule 3a
            </h6>
            
            <label for="consumer_loans">Pensionskasse <sup>*</sup></label>
            <input type="text" class="amount-field" max="99999999" id="agh" name="agh" value="" required>
            <h6 style="margin-top: 0; font-weight: normal">
                <sup>*</sup> Aktuelles Guthaben in der Pensionskasse
            </h6>
            
            <button type="submit" class="ok-btn" data-step-number="3">OK</button>
        </form>
</template>
<template id="step-4-template">
<h3 style="margin-top: 0;">Anschaffung oder sogar Erbe in Aussicht? &#128540</h3>
    <form id="step-4-form">
        <label for="mortgages">Anschaffungen</label>
        <input type="text" class="amount-field" max="99999999" id="purchase" name="purchase" value="" required>
        <label for="consumer_loans">Erbe</label>
        <input type="text" class="amount-field" max="99999999" id="inherit" name="inherit" value="" required>
        <button type="submit" class="ok-btn" data-step-number="4">OK</button>
    </form>
</template>
<template id="step-5-template">
    <h3 style="margin-top: 0;">Wie sieht dein Investitionsplan aus?</h3>
    <form id="step-5-form">
        <label for="risk_quote">Risikoquote <sup>*</sup></label>
        <select id="risk_quote" id="risk_quote" name="risk_quote" class="drop-down" required>
            <option value="20">20% Sicherheit</option>
            <option value="40">40% Balance</option>
            <option value="60">60% Wachstum</option>
            <option value="80">80% Aggressiv</option>
        </select>
        <h6 style="margin-top: 0; font-weight: normal">
            <sup>*</sup> Wie ist deine Risikobereitschaft?
        </h6>

        <label for="divers_quote">Diversifikation <sup>*</sup></label>
        <select id="divers_quote" id="divers_quote" name="divers_quote" class="drop-down" required>
            <option value="A">A: Aktien</option>
            <option value="E">E: ETFs</option>
            <option value="G">G: Gemischt</option>
            <option value="O">O: Obligationen</option>
        </select>
        <h6 style="margin-top: 0; font-weight: normal">
            <sup>*</sup> Wie diversifiziert soll dein Portfolio sein?
        </h6>

        <button type="submit" class="ok-btn" data-step-number="5">OK</button>
    </form>
</template>
<template id="step-6-template">
    <h3 style="margin-top: 0;">Wie hoch ist deine Sparquote?</h3>
        <form id="step-6-form">
            <label for="mortgages">Sparquote <sup>*</sup></label>
            <input type="text" class="amount-field" max="99999999" id="spar_quote" name="spar_quote" value="${stepData.spar_quote || ''}" required>
            <h6 style="margin-top: 0; font-weight: normal">
                <sup>*</sup> Wie viel möchtest du monatlich sparen?
            </h6>

            <label for="consumer_loans">Liquiditätsquote <sup>*</sup></label>
            <input type="text" class="amount-field" max="99999999" id="liq_quote" name="liq_quote" value="${stepData.liq_quote || ''}" required>
            <h6 style="margin-top: 0; font-weight: normal">
                <sup>*</sup> Wie viel Liquidität möchtest du vorhalten?
            </h6>

            <button type="submit" class="ok-btn" data-step-number="6">OK</button>
        </form>
</template>
<!-- End of Hidden Templates -->

<div class="workflow-container-background">

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
                        <span class="step-number">3</span> Vorsorge
                    </a>
                </li>
                <li data-step-number="4">
                    <a href="javascript:void(0)">
                        <span class="step-number">4</span> Erwartungen
                    </a>
                </li>
                <li data-step-number="5">
                    <a href="javascript:void(0)">
                        <span class="step-number">5</span> Planung
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
</div>
<?php get_footer(); ?>
