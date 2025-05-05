document.addEventListener('DOMContentLoaded', function() {
    // Check if we're on the balance template
    const isBalanceTemplate = document.querySelector('.wp-block-column.has-text-color.has-background.has-link-color') !== null;
    
    if (!isBalanceTemplate) {
        return; // Exit if not on balance template
    }

    const inputs = document.querySelectorAll('.formatted-input');

    /*
    if (!document.getElementById('submit-button')) {
        console.log('Submit button not found on this page. Exiting script. Which is OK');
        return; // Stop running the script on the result page
    }

    console.log('Submit button found. Proceeding...'); */

    // Run updateTotal for each input on page load  
    inputs.forEach(input => updateTotal(input));
    
    const analysisButton = document.getElementById('analysis-button');
    const submitButton = document.getElementById('submit-button');

    if (analysisButton) {
        document.getElementById("analysis-button").addEventListener("click", function (event) {
            console.log("Analysis button clicked!");
        
            event.preventDefault(); // Stop instant navigation
            const fullUrl = workflowAjax.homeUrl;
            const base_url = fullUrl.split('/').slice(0, 4).join('/'); // Keeps protocol + domain + first path segment
            const url = base_url + "/877-2/";

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

    // Calculate KPIs - new function with AJAX
    function calculateKPIs() {
        $.ajax({
            url: workflowAjax.ajaxurl, // WordPress AJAX URL
            method: 'POST',
            data: {
                action: 'get_kpi_data', // The action name must match the backend handler
                user_id: workflowAjax.user_id // Assuming user_id is needed to fetch user-specific data
            },
            success: function(response) {
                console.log("Fetched KPI data:", response);
    
                if (response.success) {
                    const kpis = performKPIcalculation(response.data);
                    console.log("Calculated KPIs:", kpis);
                } else {
                    console.error("Error fetching KPI data:", response.message);
                }
            },
            error: function(error) {
                console.error("AJAX error fetching KPI data:", error);
            }
        });
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