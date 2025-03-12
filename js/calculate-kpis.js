document.addEventListener('DOMContentLoaded', function() {
    const inputs = document.querySelectorAll('.formatted-input');

    /*
    if (!document.getElementById('submit-button')) {
        console.log('Submit button not found on this page. Exiting script. Which is OK');
        return; // Stop running the script on the result page
    }

    console.log('Submit button found. Proceeding...'); */
    
    const submitButton = document.getElementById('submit-button');
    const investButton = document.getElementById('invest-button');

    if (investButton) {
        document.getElementById("invest-button").addEventListener("click", function (event) {
            console.log("Invest button clicked!");
        
            event.preventDefault(); // Stop instant navigation
            const url = "/invest/";
            console.log("Redirecting to:", url);
        
            window.location.href = url;
        });
    }
    
    
    inputs.forEach(input => {
        input.addEventListener('input', function() {
            let value = input.value.replace(/\./g, '');
            if (!isNaN(value) && value !== '') {
                if (Number(value) > 999999999) {
                    value = '999999999';
                }
                input.value = Number(value).toLocaleString('de-DE');
            }
            updateTotal(input);
        });
    });

    if (submitButton) {
        submitButton.addEventListener('click', function(event) {
            event.preventDefault(); // Stop instant navigation
        
            console.log('Submit button clicked! Calculating KPIs...');
        
            const kpis = calculateKPIs();
            
            console.log("KPIs returned before redirect:", kpis);

            if (!kpis || Object.keys(kpis).length === 0) {
                console.error("No KPI data found! Stopping redirect.");
                alert("Fehler: Berechnungen sind nicht verfügbar.");
                return; // ⛔️ Prevent redirecting if no valid data
            }

            // Send data to the server via AJAX
            fetch('/wp-content/themes/my-custom-theme/save-kpis.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(kpis)
            })
            .then(response => response.json())
            .then(data => {
                console.log('Server response:', data);
                if (data.status === 'success') {
                    const resultsString = encodeURIComponent(JSON.stringify(kpis));
                    const url = `/step4/?results=${resultsString}`;
                    console.log("Redirecting to:", url);
                    window.location.href = url;
                } else {
                    alert('Fehler: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Fehler: Daten konnten nicht gespeichert werden.');
            });
        });
    } else {
        console.warn('Submit button not found on this page. Exiting script.'); // Stop running the script on the result page
        return;
    }

    function updateTotal(input) {
        const table = input.closest('table');
        const inputValues = table.querySelectorAll('.formatted-input');
        let total = 0;

        inputValues.forEach(input => {
            let value = input.value.replace(/\./g, '');
            if (!isNaN(value) && value !== '') {
                total += Number(value);
            }
        });

        const group = input.dataset.group;
        document.querySelector(`#total-${group}`).textContent = total.toLocaleString('de-DE');

        updateOverallTotal();
    }

    function updateOverallTotal() {
        const totalAktiven = document.querySelector('#total-aktiven');
        const totalPassiven = document.querySelector('#total-passiven');
        const kurzfristigAktivenInputs = document.querySelectorAll('.formatted-input[data-group="kurzfristig"]');
        const langfristigAktivenInputs = document.querySelectorAll('.formatted-input[data-group="langfristig"]');
        const kurzfristigPassivenInputs = document.querySelectorAll('.formatted-input[data-group="kurzfristig-passiven"]');
        const langfristigPassivenInputs = document.querySelectorAll('.formatted-input[data-group="langfristig-passiven"]');
        let aktivenTotal = 0;
        let passivenTotal = 0;

        kurzfristigAktivenInputs.forEach(input => {
            let value = input.value.replace(/\./g, '');
            if (!isNaN(value) && value !== '') {
                aktivenTotal += Number(value);
            }
        });

        langfristigAktivenInputs.forEach(input => {
            let value = input.value.replace(/\./g, '');
            if (!isNaN(value) && value !== '') {
                aktivenTotal += Number(value);
            }
        });

        kurzfristigPassivenInputs.forEach(input => {
            let value = input.value.replace(/\./g, '');
            if (!isNaN(value) && value !== '') {
                passivenTotal += Number(value);
            }
        });

        langfristigPassivenInputs.forEach(input => {
            let value = input.value.replace(/\./g, '');
            if (!isNaN(value) && value !== '') {
                passivenTotal += Number(value);
            }
        });

        totalAktiven.textContent = aktivenTotal.toLocaleString('de-DE');
        totalPassiven.textContent = passivenTotal.toLocaleString('de-DE');
    }

    function calculateKPIs() {
        const data = {
            bank: document.querySelector('input[placeholder="Wert 1"]').value.replace(/\./g, ''),
            depot: document.querySelector('input[placeholder="Wert 2"]').value.replace(/\./g, ''),
            cash: document.querySelector('input[placeholder="Wert 3"]').value.replace(/\./g, ''),
            immo: document.querySelector('input[placeholder="Wert 4"]').value.replace(/\./g, ''),
            priv: document.querySelector('input[placeholder="Wert 5"]').value.replace(/\./g, ''),
            agh: document.querySelector('input[placeholder="Wert 6"]').value.replace(/\./g, ''),
            ccard: document.querySelector('input[placeholder="Wert 7"]').value.replace(/\./g, ''),
            credit: document.querySelector('input[placeholder="Wert 8"]').value.replace(/\./g, ''),
            pkfr: document.querySelector('input[placeholder="Wert 9"]').value.replace(/\./g, ''),
            hypo: document.querySelector('input[placeholder="Wert 10"]').value.replace(/\./g, ''),
            darlehen: document.querySelector('input[placeholder="Wert 11"]').value.replace(/\./g, ''),
            plfr: document.querySelector('input[placeholder="Wert 12"]').value.replace(/\./g, '')
        };

        console.log('Calculating KPIs with data:', data);

        const kpis = performKPIcalculation(data);
        console.log('Calculated KPIs:', kpis);

        return kpis;
    }

    function performKPIcalculation(data) {
        // Extract and convert values to numbers
        const bank = parseFloat(data.bank) || 0;
        const depot = parseFloat(data.depot) || 0;
        const cash = parseFloat(data.cash) || 0;
        const immo = parseFloat(data.immo) || 0;
        const priv = parseFloat(data.priv) || 0;
        const agh = parseFloat(data.agh) || 0;
        const ccard = parseFloat(data.ccard) || 0;
        const credit = parseFloat(data.credit) || 0;
        const pkfr = parseFloat(data.pkfr) || 0;
        const hypo = parseFloat(data.hypo) || 0;
        const darlehen = parseFloat(data.darlehen) || 0;
        const plfr = parseFloat(data.plfr) || 0;

        // Calculate Liquidität (Liquidity)
        console.log('Info: Liquidität: bank: ', bank, ' - depot: ', depot, ' - cash: ', cash);
        
        const liquidity = bank + depot + cash;
        const activa = bank + depot + cash + immo + priv + agh;

        console.log('Info: Liquidität: ', liquidity);

        // Calculate Schuldenquote (Debt Ratio)
        const passiva = ccard + credit + pkfr + hypo + darlehen + plfr;
        const debtRatio = passiva / activa;

        // Return the results
        return {
            bank: bank,
            depot: depot,
            cash: cash, 
            immo: immo,
            priv: priv,
            agh: agh,
            ccard: ccard,
            credit: credit,
            pkfr: pkfr,
            hypo: hypo,
            darlehen: darlehen,
            plfr: plfr,
            Liquidität: liquidity,
            Schuldenquote: debtRatio,
            message: 'Analyse Deiner privaten Bilanz!',
        };
    }

    // Initial calculation of totals
    inputs.forEach(input => updateTotal(input));
});