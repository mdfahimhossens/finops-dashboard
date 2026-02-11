setTimeout(function(){
	$('.alert_success').slideUp(100);
},2000);


setTimeout(function(){
	$('.alert_error').slideUp(100);
},2000);

setTimeout(() => {
	const alert = document.getElementById('success-alert');
	if(alert){
		alert.style.transition = 'opacity 0.5s';
		alert.style.opacity = '0';
		setTimeout(() => {alert.remove(), 500});
	}
}, 3000);

$(document).ready( function () {
    $('#myTable').DataTable();
} );

document.addEventListener("DOMContentLoaded", function () {
  const btn = document.getElementById("sidebarToggle");
  const backdrop = document.getElementById("sidebarBackdrop");
  const body = document.body;

  if (!btn) return;

  const isMobile = () => window.matchMedia("(max-width: 991.98px)").matches;

  // Restore desktop collapsed state
  const savedCollapsed = localStorage.getItem("sidebarCollapsed") === "1";
  if (!isMobile() && savedCollapsed) body.classList.add("sidebar-collapsed");

  btn.addEventListener("click", function () {
    if (isMobile()) {
      // mobile: open/close overlay
      body.classList.toggle("sidebar-open");
    } else {
      // desktop: collapse/expand
      body.classList.toggle("sidebar-collapsed");
      localStorage.setItem("sidebarCollapsed", body.classList.contains("sidebar-collapsed") ? "1" : "0");
    }
  });

  // Close on backdrop click (mobile)
  if (backdrop) {
    backdrop.addEventListener("click", function () {
      body.classList.remove("sidebar-open");
    });
  }

  // ESC to close (mobile)
  document.addEventListener("keydown", function (e) {
    if (e.key === "Escape") body.classList.remove("sidebar-open");
  });

  // On resize: clean states
  window.addEventListener("resize", function () {
    if (!isMobile()) {
      body.classList.remove("sidebar-open"); // remove mobile overlay
    }
  });
});
