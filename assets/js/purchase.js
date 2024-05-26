document.addEventListener("DOMContentLoaded", function () {
  const buyTicketButtons = document.querySelectorAll(".buy-ticket-btn");
  const ticketPopup = document.getElementById("ticketPopup");
  const closeBtn = document.querySelector(".close-btn");
  const ticketForm = document.getElementById("ticketForm");
  const ticketQuantity = document.getElementById("ticketQuantity");
  const ticketSummary = document.getElementById("ticketSummary");
  const popupEventTitle = document.getElementById("popupEventTitle");

  const receiptPopup = document.getElementById("receiptPopup");
  const closeReceiptBtn = document.getElementById("closeReceiptBtn");
  const receiptContent = document.getElementById("receiptContent");
  const printReceiptBtn = document.getElementById("printReceiptBtn");

  let selectedTierName = "";
  let selectedTierPrice = 0;

  buyTicketButtons.forEach((button) => {
    button.addEventListener("click", function () {
      selectedTierName = this.getAttribute("data-tier-name");
      selectedTierPrice = parseFloat(this.getAttribute("data-tier-price"));
      ticketPopup.classList.remove("hidden-popup");
      ticketPopup.style.display = "flex";
      ticketQuantity.value = 1;
      updateTicketSummary();
    });
  });

  closeBtn.addEventListener("click", function () {
    ticketPopup.classList.add("hidden-popup");
    ticketPopup.style.display = "none";
  });

  closeReceiptBtn.addEventListener("click", function () {
    receiptPopup.classList.add("hidden-popup");
    receiptPopup.style.display = "none";
  });

  window.addEventListener("click", function (event) {
    if (event.target === ticketPopup) {
      ticketPopup.classList.add("hidden-popup");
      ticketPopup.style.display = "none";
    }
    if (event.target === receiptPopup) {
      receiptPopup.classList.add("hidden-popup");
      receiptPopup.style.display = "none";
    }
  });

  ticketForm.addEventListener("input", updateTicketSummary);

  function updateTicketSummary() {
    const quantity = parseInt(ticketQuantity.value, 10);
    if (quantity > 0) {
      const total = (selectedTierPrice * quantity).toFixed(2);
      ticketSummary.innerHTML = `<h3>Ticket Summary:</h3>
                                       <p>${selectedTierName}: $${selectedTierPrice} x ${quantity} = $${total}</p>`;
    } else {
      ticketSummary.innerHTML = "";
    }
  }

  ticketForm.addEventListener("submit", function (event) {
    event.preventDefault();
    const userName = document.getElementById("userName").value;
    const userEmail = document.getElementById("userEmail").value;
    const quantity = parseInt(ticketQuantity.value, 10);
    const total = (selectedTierPrice * quantity).toFixed(2);

    receiptContent.innerHTML = `
            <h2>Receipt</h2>
            <p><strong>Name:</strong> ${userName}</p>
            <p><strong>Email:</strong> ${userEmail}</p>
            <p><strong>Event:</strong> ${popupEventTitle.innerText}</p>
            <p><strong>Tier:</strong> ${selectedTierName}</p>
            <p><strong>Quantity:</strong> ${quantity}</p>
            <p><strong>Total Price:</strong> $${total}</p>
        `;

    ticketPopup.classList.add("hidden-popup");
    ticketPopup.style.display = "none";

    receiptPopup.classList.remove("hidden-popup");
    receiptPopup.style.display = "flex";
  });

  printReceiptBtn.addEventListener("click", function () {
    const printContent = document.getElementById("receiptContent").innerHTML;
    const originalContent = document.body.innerHTML;
    document.body.innerHTML = printContent;
    window.print();
    document.body.innerHTML = originalContent;
    window.location.reload();
  });
});
