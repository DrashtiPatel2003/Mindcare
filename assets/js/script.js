// Smooth page transitions
//document.querySelectorAll('a').forEach(link => {
  //  link.addEventListener('click', function (event) {
    //    event.preventDefault();
      //  const target = this.getAttribute('href');
        //document.body.classList.add('fade-out');
        //setTimeout(() => {
          //  window.location.href = target;
//        }, 500);
//    });
//});
document.querySelectorAll('a').forEach(link => {
    link.addEventListener('click', function (event) {
        event.preventDefault(); // Prevent the default link behavior

        const target = this.getAttribute('href'); // Get the target link
        document.body.classList.add('slide-out'); // Add sliding-out effect to the current page

        // Delay the navigation to give time for the animation to finish
        setTimeout(() => {
            window.location.href = target; // Navigate to the new page
        }, 500); // Wait for the slide-out effect to complete (0.5s)

        // Wait for the new page to load before triggering the slide-in animation
        window.onload = () => {
            document.body.classList.add('slide-in'); // Add slide-in effect to the new page
        };
    });
});

  // Open User Info Panel
function openUserPanel() {
    const panel = document.getElementById('userPanel');
    panel.classList.add('active');
  }
  
  // Close User Info Panel
  function closeUserPanel() {
    const panel = document.getElementById('userPanel');
    panel.classList.remove('active');
  }

  

