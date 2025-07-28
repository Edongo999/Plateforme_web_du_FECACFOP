function sendMessage() {
  const msg = document.getElementById("chat-message").value;
  if (!msg) return;

  fetch("/Plateforme_web_du_FECACFOP/public/chatbot.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: "message=" + encodeURIComponent(msg)
  })
  .then(res => res.text())
  .then(rep => {
    const chat = document.getElementById("chat-output");
    chat.innerHTML += `<p><strong>Moi :</strong> ${msg}</p>`;
    chat.innerHTML += `<p><strong>Bot :</strong> ${rep}</p>`;
    document.getElementById("chat-message").value = "";
    chat.scrollTop = chat.scrollHeight;
  });
}
