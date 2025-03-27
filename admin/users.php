<?php
require_once '../includes/config.php';
redirectIfNotAuthenticated();

if ($_SESSION['role'] !== 'System Admin') {
    header("Location: ../login.php");
    exit();
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete'])) {
        $id = sanitizeInput($_POST['id']);
        $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    } elseif (isset($_POST['add_user'])) {
        // Handle add/edit user
        $first_name = sanitizeInput($_POST['first_name']);
        $last_name = sanitizeInput($_POST['last_name']);
        $email = sanitizeInput($_POST['email']);
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $position = sanitizeInput($_POST['position']);
        $role = sanitizeInput($_POST['role']);
        
        // Handle file upload
        $photo = null;
        if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
            $target_dir = "../assets/images/";
            $target_file = $target_dir . basename($_FILES["photo"]["name"]);
            move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file);
            $photo = "assets/images/" . basename($_FILES["photo"]["name"]);
        }
        
        if (isset($_POST['user_id'])) {
            // Update existing user
            $id = sanitizeInput($_POST['user_id']);
            $stmt = $conn->prepare("UPDATE users SET first_name=?, last_name=?, email=?, position=?, role=?, photo=? WHERE id=?");
            $stmt->bind_param("ssssssi", $first_name, $last_name, $email, $position, $role, $photo, $id);
        } else {
            // Add new user
            $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, email, password, position, role, photo) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssss", $first_name, $last_name, $email, $password, $position, $role, $photo);
        }
        $stmt->execute();
    }
}

// Get all users
$users = $conn->query("SELECT * FROM users");
?>

<?php include '../includes/header.php'; ?>
<?php include '../includes/navigation.php'; ?>

<main class="content">
    <h2><i class="fas fa-users-cog"></i> User Accounts</h2>
    
    <div class="card">
        <div class="card-header">
            <h3>User List</h3>
            <button id="addUserBtn" class="btn-primary"><i class="fas fa-plus"></i> Add User</button>
        </div>
        
        <div class="card-body">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Photo</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Position</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($user = $users->fetch_assoc()): ?>
                    <tr>
                        <td>
                            <?php if ($user['photo']): ?>
                                <img src="../<?php echo $user['photo']; ?>" alt="User Photo" class="user-photo">
                            <?php else: ?>
                                <div class="user-photo-placeholder">
                                    <i class="fas fa-user"></i>
                                </div>
                            <?php endif; ?>
                        </td>
                        <td><?php echo $user['first_name'] . ' ' . $user['last_name']; ?></td>
                        <td><?php echo $user['email']; ?></td>
                        <td><?php echo $user['position']; ?></td>
                        <td><span class="role-badge <?php echo strtolower(str_replace(' ', '-', $user['role'])); ?>"><?php echo $user['role']; ?></span></td>
                        <td>
                            <button class="btn-edit edit-user" data-id="<?php echo $user['id']; ?>"><i class="fas fa-edit"></i></button>
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                                <button type="submit" name="delete" class="btn-delete" onclick="return confirm('Are you sure?')"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<!-- User Modal -->
<div id="userModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h3 id="modalTitle">Add New User</h3>
        <form id="userForm" method="POST" enctype="multipart/form-data">
            <input type="hidden" id="user_id" name="user_id">
            
            <div class="form-group">
                <label for="first_name">First Name</label>
                <input type="text" id="first_name" name="first_name" required>
            </div>
            
            <div class="form-group">
                <label for="last_name">Last Name</label>
                <input type="text" id="last_name" name="last_name" required>
            </div>
            
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password">
                <small>Leave blank to keep current password</small>
            </div>
            
            <div class="form-group">
                <label for="position">Position</label>
                <input type="text" id="position" name="position" required>
            </div>
            
            <div class="form-group">
                <label for="role">Role</label>
                <select id="role" name="role" required>
                    <option value="System Admin">System Admin</option>
                    <option value="HR">HR</option>
                    <option value="User">User</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="photo">Photo</label>
                <input type="file" id="photo" name="photo" accept="image/*">
            </div>
            
            <div class="form-actions">
                <button type="submit" name="add_user" class="btn-primary">Save</button>
                <button type="button" class="btn-secondary close-modal">Cancel</button>
            </div>
        </form>
    </div>
</div>

<script src="../assets/js/script.js"></script>
<?php include '../includes/footer.php'; ?>