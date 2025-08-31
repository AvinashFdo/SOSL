let inquiries = [];
let currentId = null;

// Load data when page loads
window.onload = function () {
    loadInquiries();
};

// Load inquiries from backend
function loadInquiries() {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'simple_admin_backend.php?action=list', true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            inquiries = JSON.parse(xhr.responseText);
            displayInquiries(inquiries);
            updateStats();
        }
    };
    xhr.send();
}

// Display inquiries in table
function displayInquiries(data) {
    const tbody = document.getElementById('tableBody');
    tbody.innerHTML = '';

    data.forEach(inquiry => {
        const row = tbody.insertRow();
        row.innerHTML = `
                    <td>${inquiry.id}</td>
                    <td>${inquiry.name}</td>
                    <td>${inquiry.email}</td>
                    <td>${inquiry.phone_number || 'N/A'}</td>
                    <td>
                        <button class="btn btn-view" onclick="viewInquiry(${inquiry.id})">View</button>
                        <button class="btn btn-edit" onclick="editInquiry(${inquiry.id})">Edit</button>
                        <button class="btn btn-delete" onclick="deleteInquiry(${inquiry.id})">Delete</button>
                    </td>
                `;
    });
}

// Update statistics
function updateStats() {
    const total = inquiries.length;
    document.getElementById('total-count').textContent = total;
}

// Search function
function searchTable() {
    var searchTerm = document.getElementById('search').value.toLowerCase();
    var filtered = [];

    for (var i = 0; i < inquiries.length; i++) {
        var inquiry = inquiries[i];
        if (inquiry.name.toLowerCase().indexOf(searchTerm) !== -1 ||
            inquiry.email.toLowerCase().indexOf(searchTerm) !== -1 ||
            inquiry.message.toLowerCase().indexOf(searchTerm) !== -1) {
            filtered.push(inquiry);
        }
    }

    displayInquiries(filtered);
}

// View inquiry
function viewInquiry(id) {
    var inquiry = null;
    for (var i = 0; i < inquiries.length; i++) {
        if (inquiries[i].id == id) {
            inquiry = inquiries[i];
            break;
        }
    }

    currentId = id;

    document.getElementById('viewContent').innerHTML =
        '<p><strong>Name:</strong> ' + inquiry.name + '</p>' +
        '<p><strong>Email:</strong> ' + inquiry.email + '</p>' +
        '<p><strong>Phone:</strong> ' + (inquiry.phone_number || 'N/A') + '</p>' +
        '<p><strong>Message:</strong></p>' +
        '<div style="background: #f8f9fa; padding: 15px; border-radius: 5px;">' + inquiry.message + '</div>';

    document.getElementById('viewModal').style.display = 'block';
}

// Edit inquiry
function editInquiry(id) {
    var inquiry = null;
    for (var i = 0; i < inquiries.length; i++) {
        if (inquiries[i].id == id) {
            inquiry = inquiries[i];
            break;
        }
    }

    document.getElementById('editId').value = inquiry.id;
    document.getElementById('editName').value = inquiry.name;
    document.getElementById('editEmail').value = inquiry.email;
    document.getElementById('editPhone').value = inquiry.phone_number || '';
    document.getElementById('editMessage').value = inquiry.message;

    document.getElementById('editModal').style.display = 'block';
}

// Delete inquiry
function deleteInquiry(id) {
    if (confirm('Are you sure you want to delete this inquiry?')) {
        var xhr = new XMLHttpRequest();
        var formData = new FormData();
        formData.append('action', 'delete');
        formData.append('id', id);

        xhr.open('POST', 'simple_admin_backend.php', true);
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                if (xhr.responseText == 'success') {
                    loadInquiries();
                    alert('Inquiry deleted successfully!');
                } else {
                    alert('Error deleting inquiry');
                }
            }
        };
        xhr.send(formData);
    }
}

// Mark as read
function markAsRead() {
    const formData = new FormData();
    formData.append('action', 'mark_read');
    formData.append('id', currentId);

    fetch('simple_admin_backend.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                loadInquiries();
                closeModal('viewModal');
            }
        })
        .catch(error => console.error('Error:', error));
}

// Handle edit form submission
document.getElementById('editForm').addEventListener('submit', function (e) {
    e.preventDefault();

    var xhr = new XMLHttpRequest();
    var formData = new FormData();
    formData.append('action', 'update');
    formData.append('id', document.getElementById('editId').value);
    formData.append('name', document.getElementById('editName').value);
    formData.append('email', document.getElementById('editEmail').value);
    formData.append('phone_number', document.getElementById('editPhone').value);
    formData.append('message', document.getElementById('editMessage').value);

    xhr.open('POST', 'simple_admin_backend.php', true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            if (xhr.responseText == 'success') {
                loadInquiries();
                closeModal('editModal');
                alert('Inquiry updated successfully!');
            } else {
                alert('Error updating inquiry');
            }
        }
    };
    xhr.send(formData);
});

// Close modal
function closeModal(modalId) {
    document.getElementById(modalId).style.display = 'none';
}

// Close modal when clicking outside
window.onclick = function (event) {
    if (event.target.classList.contains('modal')) {
        event.target.style.display = 'none';
    }
}