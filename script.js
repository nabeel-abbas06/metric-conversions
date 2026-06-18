document.getElementById("subscribeForm").addEventListener("submit", function (e) {
    e.preventDefault();

    const formData = new FormData(this);
    const msg = document.getElementById("msg");

    fetch("subscribe.php", {
        method: "POST",
        body: formData
    })
        .then(res => res.json())
        .then(data => {
            msg.textContent = data.message;

            if (data.status === "success") {
                msg.style.color = "green";
                document.getElementById("email").value = "";
            } else {
                msg.style.color = "red";
            }
        })
        .catch(() => {
            msg.textContent = "Network error";
            msg.style.color = "red";
        });
    });

function toggleMenu(button) {
    document.getElementById("mobileMenu")
    .classList.toggle("active");
    button.classList.toggle("active");
}
