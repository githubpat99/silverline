<?php
/*
Template Name: My New Balance Template
*/

get_header();
?>

<div class="site-content">
    <h1><?php the_title(); ?></h1>
    <form id="balanceForm">
        <div class="form-tables">
            <!-- Aktiva Table -->
            <table class="form-table th-activa">
                <thead>
                    <tr>
                        <th colspan="3"><h2>Aktiva</h2></th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="form-group">
                        <td class="form-label"><label for="bankText">Bank</label></td>
                        <td><input type="text" id="bankText" name="bankText" value="Kontoguthaben" required></td>
                        <td><input type="number" id="bank" name="bank" value="5000" required></td>
                    </tr>
                    <tr class="form-group">
                        <td class="form-label"><label for="depotText">Depot</label></td>
                        <td><input type="text" id="depotText" name="depotText" value="Swissquote" required></td>
                        <td><input type="number" id="depot" name="depot" value="15000" required></td>
                    </tr>
                    <tr class="form-group">
                        <td class="form-label"><label for="aghText">Weiteres Vermögen</label></td>
                        <td><input type="text" id="aghText" name="aghText" value="Altersguthaben" required></td>
                        <td><input type="number" id="agh" name="agh" value="600000" required></td>
                    </tr>
                    <tr class="form-group">
                        <td class="form-label"><label for="s3aText">Säule 3a</label></td>
                        <td><input type="text" id="s3aText" name="s3aText" value="Säule 3a" required></td>
                        <td><input type="number" id="s3a" name="s3a" value="75000" required></td>
                    </tr>
                    <tr class="form-group">
                        <td class="form-label"><label for="efhText">Immobilien</label></td>
                        <td><input type="text" id="efhText" name="efhText" value="EFH Speicherschwendi" required></td>
                        <td><input type="number" id="efh" name="efh" value="1600000" required></td>
                    </tr>
                </tbody>
            </table>

            <!-- Passiva Table -->
            <table class="form-table th-passiva">
                <thead>
                    <tr>
                        <th colspan="3"><h2>Passiva</h2></th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="form-group">
                        <td class="form-label"><label for="loanText">Darlehen</label></td>
                        <td><input type="text" id="loanText" name="loanText" value="kurzfristig" required></td>
                        <td><input type="number" id="loan" name="loan" value="500" required></td>
                    </tr>
                    <tr class="form-group">
                        <td class="form-label"><label for="creditText">Kreditkarte</label></td>
                        <td><input type="text" id="creditText" name="creditText" value="Kreditkartenschuld" required></td>
                        <td><input type="number" id="credit" name="credit" value="2000" required></td>
                    </tr>
                    <tr class="form-group">
                        <td class="form-label"><label for="mortgageText">Hypothek</label></td>
                        <td><input type="text" id="mortgageText" name="mortgageText" value="Hypothekenbetrag" required></td>
                        <td><input type="number" id="mortgage" name="mortgage" value="900000" required></td>
                    </tr>
                    <tr class="form-group">
                        <td class="form-label"><label for="otherDebtText">Andere Schulden</label></td>
                        <td><input type="text" id="otherDebtText" name="otherDebtText" value="Andere Schulden" required></td>
                        <td><input type="number" id="otherDebt" name="otherDebt" value="3000" required></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <button type="button" id="submitForm">Submit</button>
    </form>

    <div id="results"></div>
</div>

<script>
document.getElementById('submitForm').addEventListener('click', function() {
    var formData = {
        bankText: document.getElementById('bankText').value,
        bank: document.getElementById('bank').value,
        depotText: document.getElementById('depotText').value,
        depot: document.getElementById('depot').value,
        aghText: document.getElementById('aghText').value,
        agh: document.getElementById('agh').value,
        s3aText: document.getElementById('s3aText').value,
        s3a: document.getElementById('s3a').value,
        efhText: document.getElementById('efhText').value,
        efh: document.getElementById('efh').value,
        loanText: document.getElementById('loanText').value,
        loan: document.getElementById('loan').value,
        creditText: document.getElementById('creditText').value,
        credit: document.getElementById('credit').value,
        mortgageText: document.getElementById('mortgageText').value,
        mortgage: document.getElementById('mortgage').value,
        otherDebtText: document.getElementById('otherDebtText').value,
        otherDebt: document.getElementById('otherDebt').value,
    };

fetch('https://pythonfinkpi.onrender.com/calculate-kpis', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
    },
    body: JSON.stringify({ test: 'simple' }),
})
.then(response => response.json())
.then(data => console.log(data))
.catch(error => console.error('Error:', error));

});
</script>

<?php
get_footer();
?>
