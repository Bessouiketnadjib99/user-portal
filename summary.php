<?php
require_once 'includes/config.php';
redirectIfNotAuthenticated();
?>

<?php include 'includes/header.php'; ?>
<?php include 'includes/navigation.php'; ?>

<main class="content">
    <h2><i class="fas fa-list"></i> User Summary</h2>
    
    <div class="card">
        <div class="card-body">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Photo</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Position</th>
                        <th>Role</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $users = $conn->query("SELECT * FROM users");
                    while ($user = $users->fetch_assoc()): 
                    ?>
                    <tr>
                        <td>
                            <?php if ($user['photo']): ?>
                                <img src="<?php echo $user['photo']; ?>" alt="User Photo" class="user-photo">
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
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>