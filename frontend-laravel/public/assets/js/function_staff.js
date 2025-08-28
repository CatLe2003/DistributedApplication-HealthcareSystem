function addNewRow() {
    const tbody = document.getElementById('prescriptionBody');

    const newRow = document.createElement('tr');

    newRow.innerHTML = `
        <td class="text-column-emphasis" scope="row">1</td>
        <td class="text-column" scope="row">
            <select name="medicine_id" class="form-control" required>
                <option value="">-- Select --</option>
                <option value="1">Paracetamol</option>
                <option value="2">Amoxicillin</option>
                <option value="3">Ibuprofen</option>
            </select>                                                
        </td> 
        <td class="text-column" scope="row">
            <input type="text" name="dosage" value="2 viên/ngày" class="form-control" required>
        </td> 
        <td class="text-column" scope="row">
            <input type="text" name="duration" value="Max 200 mg/day" class="form-control">
        </td> 
        <td class="text-column" scope="row">
            <div class="text-column__action">
                <a href="" class="btn-control btn-control-delete" onclick="removeRow(this)">
                    <i class="fa-solid fa-trash-can btn-control-icon"></i>
                    Delete
                </a>
            </div>
        </td> 
    `;

    tbody.appendChild(newRow);
    updateRowNumbers();
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