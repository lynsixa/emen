let nisData = [];

document.getElementById('nisForm').addEventListener('submit', function(event) {
    event.preventDefault();
    
    const numero = document.getElementById('numero').value;
    const piso = document.getElementById('piso').value;
    const sillas = document.getElementById('sillas').value;
    const mesas = document.getElementById('mesas').value;

    const nis = { numero, piso, sillas, mesas };
    nisData.push(nis);
    updateList();
    this.reset(); // Limpiar el formulario
});

function updateList() {
    const list = document.getElementById('nisList');
    list.innerHTML = '';

    nisData.forEach((nis, index) => {
        const li = document.createElement('li');
        li.innerHTML = `
            ${nis.numero} - Piso: ${nis.piso}, Sillas: ${nis.sillas}, Mesas: ${nis.mesas}
            <button class="edit-btn" onclick="editNis(${index})">Editar</button>
            <button class="delete-btn" onclick="deleteNis(${index})">Borrar</button>
        `;
        list.appendChild(li);
    });
}

function editNis(index) {
    const nis = nisData[index];
    document.getElementById('numero').value = nis.numero;
    document.getElementById('piso').value = nis.piso;
    document.getElementById('sillas').value = nis.sillas;
    document.getElementById('mesas').value = nis.mesas;
    deleteNis(index); // Borrar el registro para poder agregarlo de nuevo
}

function deleteNis(index) {
    nisData.splice(index, 1);
    updateList();
}
