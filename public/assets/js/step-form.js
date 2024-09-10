function initializeWizardForm(form) {
    // Get references
    const steps = form.querySelectorAll(".wizard-step");
    const formSteps = form.querySelectorAll(".wizard-form-step");
    const nextBtn = form.querySelector(".next-button2");
    const prevBtn = form.querySelector(".prev-button");

    let currentStep = 0;

    // Hide all steps except the first one
    for (let i = 1; i < steps.length; i++) {
        steps[i].classList.remove("active");
        formSteps[i].classList.remove("active");
    }

    // Add event listeners to the buttons

    nextBtn?.addEventListener("click", () => {
        // Check if the current step has required fields and if they are filled
        if (currentStep < steps.length - 1 && validateStep(currentStep)) {
            currentStep++;
            updateStep();
        }
    });

    prevBtn?.addEventListener("click", () => {
        if (currentStep > 0) {
            currentStep--;
            updateStep();
            for (let i = 0; i < steps.length; i++) {
                steps[i].classList.remove("passed");
            }
            updateStep();
        }
    });

    function validateStep(step) {
        const stepFields = formSteps[step].querySelectorAll("[required]");
        for (let i = 0; i < stepFields.length; i++) {
            if (!stepFields[i].value) {
                alert("Please fill in all required fields.");
                return false;
            }
        }
        return true;
    }

    function updateStep() {
        // Update the active step and form step
        for (let i = 0; i < steps.length; i++) {
            if (i === currentStep) {
                steps[i].classList.add("active");
                formSteps[i].classList.add("active");
            } else {
                steps[i].classList.remove("active");
                formSteps[i].classList.remove("active");
            }
        }

        // Add class 'passed'
        for (let i = 0; i < currentStep; i++) {
            steps[i].classList.add("passed");
        }

        // Remove class 'passed'
        for (let i = currentStep; i < steps.length; i++) {
            steps[i].classList.remove("passed");
        }

        // Show/hide the buttons based on the current step
        if (currentStep === 0) {
            prevBtn.style.display = "none";
            prevBtn?.parentNode?.classList.remove("justify-between", "flex");
            prevBtn?.parentNode?.classList.add("text-right");
        } else {
            prevBtn.style.display = "inline-block";
            prevBtn?.parentNode?.classList.remove("text-right");
            prevBtn?.parentNode?.classList.add("justify-between", "flex");
        }

        if (currentStep === steps.length - 1) {
            nextBtn.innerHTML = "Submit";
            setTimeout(() => {
                nextBtn.type = "submit";
            }, 1000);
        } else {
            nextBtn.innerHTML = "Next";
        }
    }

    // Initialize the first step
    updateStep();
}

// Get all the forms
const forms = document.querySelectorAll(".wizard");

// Initialize each form
forms.forEach((form) => initializeWizardForm(form));
