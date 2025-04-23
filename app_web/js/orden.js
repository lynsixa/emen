let orders = [];

function displayOrders() {
    const orderList = document.getElementById('orderList');
    orderList.innerHTML = '';
    orders.forEach((order, index) => {
        const li = document.createElement('li');
        li.innerHTML = `
            <span>${order.description} - ${order.item} - $${order.price} - ${order.orderDate} - ${order.delivered ? 'Sí' : 'No'}</span>
            <button class="edit-btn" onclick="editOrder(${index})">Editar</button>
            <button class="delete-btn" onclick="deleteOrder(${index})">Eliminar</button>
        `;
        orderList.appendChild(li);
    });
}

function addOrder(event) {
    event.preventDefault();
    const description = document.getElementById('description').value;
    const item = document.getElementById('item').value;
    const price = document.getElementById('price').value;

    // Establecer la fecha y hora actual automáticamente
    const orderDate = new Date().toLocaleString(); // Formato de fecha y hora
    const delivered = document.getElementById('delivered').checked;

    orders.push({ description, item, price, orderDate, delivered });
    displayOrders();
    document.getElementById('orderForm').reset();
}

function editOrder(index) {
    const order = orders[index];
    document.getElementById('description').value = order.description;
    document.getElementById('item').value = order.item;
    document.getElementById('price').value = order.price;
    document.getElementById('delivered').checked = order.delivered;

    // Eliminar la orden actual para evitar duplicados
    orders.splice(index, 1);
    displayOrders();
}

function deleteOrder(index) {
    orders.splice(index, 1);
    displayOrders();
}

document.getElementById('orderForm').addEventListener('submit', addOrder);
