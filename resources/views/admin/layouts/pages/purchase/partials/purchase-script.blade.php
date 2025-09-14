<script>
    document.addEventListener("DOMContentLoaded", function() {
        const tableBody = document.querySelector("#stockTable tbody");
        const subTotalEl = document.getElementById("subTotal");
        const discountInput = document.getElementById("discount");
        const grandTotalEl = document.getElementById("grandTotal");
        const paidInput = document.getElementById("paidAmount");
        const dueAmountEl = document.getElementById("dueAmount");

        function updateRowNumbers() {
            tableBody.querySelectorAll("tr").forEach((row, index) => {
                row.querySelector(".row-index").innerText = index + 1;
            });
        }

        function updateTotals() {
            let subTotal = 0;
            tableBody.querySelectorAll("tr").forEach(row => {
                const qty = parseFloat(row.querySelector(".qty").value) || 0;
                const price = parseFloat(row.querySelector(".price").value) || 0;
                const total = qty * price;
                row.querySelector(".total").value = total.toFixed(2);
                subTotal += total;
            });

            // Apply discount
            let discount = parseFloat(discountInput.value) || 0;
            let grandTotal = subTotal - discount;
            if (grandTotal < 0) grandTotal = 0;

            // Calculate due
            let paid = parseFloat(paidInput.value) || 0;
            let due = grandTotal - paid;
            if (due < 0) due = 0;

            // Update UI
            subTotalEl.innerText = subTotal.toFixed(2);
            grandTotalEl.innerText = grandTotal.toFixed(2);
            dueAmountEl.innerText = due.toFixed(2);

            // ✅ Update hidden inputs
            document.getElementById("subTotalInput").value = subTotal.toFixed(2);
            document.getElementById("grandTotalInput").value = grandTotal.toFixed(2);
            document.getElementById("dueAmountInput").value = due.toFixed(2);
        }

        // Item add
        document.getElementById("itemSelect").addEventListener("change", function() {
            const selected = this.options[this.selectedIndex];
            const itemId = selected.value;
            const itemName = selected.dataset.name;
            if (!itemId) return;

            if (tableBody.querySelector(`tr[data-item-id="${itemId}"]`)) {
                alert("Item already added!");
                this.value = "";
                return;
            }

            const row = document.createElement("tr");
            row.setAttribute("data-item-id", itemId);
            row.innerHTML = `
                <td class="row-index"></td>
                <td>
                    ${itemName}
                    <input type="hidden" name="items[${itemId}][stock_item_id]" value="${itemId}">
                </td>
                <td><input type="number" name="items[${itemId}][item_qty]" class="form-control qty" value="1" min="1"></td>
                <td>
                    <select class="form-select unit" name="items[${itemId}][item_unit]">
                        <option value="pcs">Pcs</option>
                        <option value="kg">Kg</option>
                        <option value="ltr">Ltr</option>
                    </select>
                </td>
                <td><input type="number" name="items[${itemId}][item_purchase_price]" class="form-control price" value="0" min="0"></td>
                <td><input type="text" class="form-control total" value="0" readonly></td>
                <td class="text-center">
                    <button type="button" class="btn btn-sm btn-danger removeRow"><i class="ti ti-trash"></i></button>
                </td>
            `;
            tableBody.appendChild(row);
            updateRowNumbers();
            updateTotals();
            this.value = "";
        });

        // Remove row
        tableBody.addEventListener("click", function(e) {
            if (e.target.closest(".removeRow")) {
                e.target.closest("tr").remove();
                updateRowNumbers();
                updateTotals();
            }
        });

        // Update totals on qty/price input
        tableBody.addEventListener("input", function(e) {
            if (e.target.classList.contains("qty") || e.target.classList.contains("price")) {
                updateTotals();
            }
        });

        // Update totals on discount or paid input
        discountInput.addEventListener("input", updateTotals);
        paidInput.addEventListener("input", updateTotals);
    });
</script>
