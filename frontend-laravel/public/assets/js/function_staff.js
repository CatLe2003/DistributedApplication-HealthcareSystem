function addNewRow()  {
    let tbody = document.getElementById("prescriptionBody");
    if (!tbody) {
        console.error("prescriptionBody not found");
        return;
    }

    let newRow = document.createElement("tr");
    newRow.innerHTML = `
        <td class="text-column" scope="row">
            <select name="medicine_id[]" class="form-control" required>
                <option value="">-- Select --</option>
                ${window.medicinesOptionsHtml}
            </select>
        </td>
        <td class="text-column" scope="row">
            <input type="text" name="dosage[]" class="form-control" required>
        </td>
        <td class="text-column" scope="row">
            <input type="text" name="duration[]" class="form-control">
        </td>
        <td class="text-column" scope="row">
            <div class="text-column__action">
                <a href="#" class="btn-control btn-control-delete" onclick="removeRow(this)">
                    <i class="fa-solid fa-trash-can btn-control-icon"></i> Delete
                </a>
            </div>
        </td>
    `;

    tbody.appendChild(newRow);
}


function removeRow(button) {
    const row = button.closest('tr');
    row.remove();
    updateRowNumbers();
}

function updateRowNumbers() {
    const rows = document.querySelectorAll('#prescriptionBody tr');
    rows.forEach((row, index) => {
        row.querySelector('td').innerText = index + 1;
    });
}