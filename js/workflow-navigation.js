jQuery(document).ready(function($) {
    const navigationItems = $('.workflow-navigation li');
    const formContainer = $('#workflow-form');
    let currentStep = sessionStorage.getItem("stepNumber") || 1;

    initializeForm(currentStep);

    // Initialize the form by loading the current step
    function initializeForm(stepNumber) {
        fetchStepData(stepNumber);
    }

    // Save workflow step data (via AJAX)
    function saveStepData(stepNumber, formData) {
        console.log("Saving Step Data for Step", stepNumber);

        $.ajax({
            url: workflowAjax.ajaxurl,
            method: 'POST',
            data: {
                action: 'save_workflow_step',
                user_id: workflowAjax.user_id,
                step_number: stepNumber,
                step_data: JSON.stringify(formData)
            },
            success: function(response) {
                console.log("Step saved successfully:", response);
            },
            error: function(error) {
                console.error("Error saving step:", error);
            }
        });
    }

    // Handle navigation clicks
    navigationItems.on('click', function() {
        const stepNumber = $(this).data('step-number');
        console.log("Navigating to Step", stepNumber);

        navigationItems.removeClass('active');
        $(this).addClass('active');

        fetchStepData(stepNumber);
    });

    // Handle form submission (OK button click)
    $(document).on("click", ".ok-btn", function(event) {
        event.preventDefault();

        const stepNumber = $(this).data("step-number");
        console.log("Step clicked:", stepNumber);

        let formData = getFormData(stepNumber);
        console.log("Saving data for Step", stepNumber, formData);

        saveStepData(stepNumber, formData);

        // Move to next step
        navigateToNextStep(stepNumber);
    });

    // Fetch step data from the server
    function fetchStepData(stepNumber) {
        let userId = workflowAjax.user_id || 0;

        $.ajax({
            url: workflowAjax.ajaxurl,
            method: 'GET',
            data: {
                action: 'get_workflow_step_data',
                user_id: userId,
                step_number: stepNumber
            },
            success: function(response) {
                console.log("Step Data:", response.data.data);
                renderStepContent(stepNumber, response.data.data);
            },
            error: function(xhr, status, error) {
                console.log("Error fetching step data:", xhr.responseText);
                renderStepContent(stepNumber, {});
            }
        });
    }

    // Render the step content based on the template and data
    function renderStepContent(stepNumber, stepData) {
        const template = document.getElementById(`step-${stepNumber}-template`);
        if (!template) {
            console.error(`Template not found for Step ${stepNumber}`);
            return;
        }

        const content = template.content.cloneNode(true);
        fillFormData(content, stepData);
        formContainer.empty().append(content);

        // Reapply the input formatting and validation after rendering
        reapplyInputFormatting();
    }

    // Fill form fields with data dynamically
    function fillFormData(content, stepData) {
        Object.keys(stepData).forEach((key) => {
            const field = content.querySelector(`[name="${key}"]`);
            if (!field) return;

            if (field.type === "checkbox") {
                field.checked = stepData[key];
            } else if (field.type === "radio") {
                const radioToCheck = content.querySelector(`[name="${key}"][value="${stepData[key]}"]`);
                if (radioToCheck) radioToCheck.checked = true;
            } else {
                field.value = stepData[key];
            }
        });
    }

    // Get the form data for a specific step
    function getFormData(stepNumber) {
        let formData = {};
        $(`#step-${stepNumber}-form`).find("input, textarea, select").each(function() {
            formData[$(this).attr("name")] = $(this).val();
        });
        return formData;
    }

    // Navigate to the next step after saving current data
    function navigateToNextStep(currentStep) {
        const nextStep = parseInt(currentStep) + 1;
        window.location.href = `?step_number=${nextStep}`;
    }

    // Reapply input formatting for amount fields
    function reapplyInputFormatting() {
        // Apply to all input fields with class 'amount-field'
        $('#workflow-form').on('input', 'input.amount-field', function() {
            let input = $(this);
            let rawValue = input.val().replace(/[^0-9]/g, ''); // Remove non-numeric characters

            // Strip non-numeric characters before max-value validation
            let rawNumericValue = parseFloat(rawValue.replace(/,/g, ''));

            // Check if the value exceeds the max attribute
            let maxValue = parseFloat(input.attr('max') || Infinity);
            if (rawNumericValue > maxValue) {
                // If it exceeds, set the value to the max value
                rawValue = maxValue.toString();
            }

            // Add thousand separators (e.g., 1000 becomes 1,000)
            let formattedValue = formatWithThousandSeparator(rawValue);

            // Set the input value back
            input.val(formattedValue);
        });
    }

    // Format number with thousand separator (e.g., 1000 becomes 1,000)
    function formatWithThousandSeparator(value) {
        // Ensure that value is a string and apply thousand separators
        return value.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
    }
});
