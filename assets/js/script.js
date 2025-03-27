document.addEventListener('DOMContentLoaded', function() {
    // User Modal
    const modal = document.getElementById('userModal');
    const addUserBtn = document.getElementById('addUserBtn');
    const closeModalBtns = document.querySelectorAll('.close, .close-modal');
    const editUserBtns = document.querySelectorAll('.edit-user');
    const userForm = document.getElementById('userForm');
    
    if (addUserBtn) {
        addUserBtn.addEventListener('click', function() {
            document.getElementById('modalTitle').textContent = 'Add New User';
            userForm.reset();
            document.getElementById('user_id').value = '';
            modal.style.display = 'block';
        });
    }
    
    closeModalBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            modal.style.display = 'none';
        });
    });
    
    if (editUserBtns) {
        editUserBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const userId = this.getAttribute('data-id');
                fetch(`../api/get_user.php?id=${userId}`)
                    .then(response => response.json())
                    .then(user => {
                        document.getElementById('modalTitle').textContent = 'Edit User';
                        document.getElementById('user_id').value = user.id;
                        document.getElementById('first_name').value = user.first_name;
                        document.getElementById('last_name').value = user.last_name;
                        document.getElementById('email').value = user.email;
                        document.getElementById('position').value = user.position;
                        document.getElementById('role').value = user.role;
                        modal.style.display = 'block';
                    });
            });
        });
    }
    
    window.addEventListener('click', function(event) {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });
    
    // Password field handling for edit
    if (userForm) {
        userForm.addEventListener('submit', function() {
            const passwordField = document.getElementById('password');
            if (passwordField.value === '') {
                passwordField.disabled = true;
            }
        });
    }
});