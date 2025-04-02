window.addEventListener('load', function() {
  const menuToggle = document.getElementById("menu-toggle");
  const navMenu = document.querySelector(".nav-menu");
  const menuUl = navMenu.querySelector("ul");  // Get the <ul> element inside the nav-menu

  if (menuToggle && navMenu && menuUl) {
    // Toggle the 'active' class on the nav menu and its <ul> when the toggle button is clicked
    menuToggle.addEventListener("click", function() {
      navMenu.classList.toggle("active");  // Toggle on the .nav-menu
      menuUl.classList.toggle("active");   // Toggle on the <ul> inside .nav-menu
    });

    // Close the menu if clicked outside
    document.addEventListener("click", function(event) {
      if (!navMenu.contains(event.target) && !menuToggle.contains(event.target)) {
        navMenu.classList.remove("active");
        menuUl.classList.remove("active");
      }
    });
  }
});

document.addEventListener("DOMContentLoaded", function () {
  const steps = document.querySelectorAll(".step");
  const progressBar = document.getElementById("progress-bar");

  // Get current step from URL path (Pretty Permalinks)
  const pathParts = window.location.pathname.split("/").filter(Boolean); // Removes empty parts
  let currentStep = 1; // Default step

  console.log("Path Parts:", pathParts);

  pathParts.forEach((part) => {
    if (part.includes("step")) {
        let stepNumber = parseInt(part.replace("step", ""), 10);
        if (!isNaN(stepNumber)) {
            currentStep = stepNumber;
        }
    } else {
        currentStep = 4; // Treat "invest" as step 4
    }
  });

  console.log("MyFull URL:", window.location.href);
  console.log("Extracted step:", currentStep);

  steps.forEach((step, index) => {
      if (index + 1 <= currentStep) {
          step.classList.add("active");
      }
  });

  progressBar.style.width = (currentStep / steps.length) * 100 + "%";
});
