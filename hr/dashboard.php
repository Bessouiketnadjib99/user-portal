<?php
require_once '../includes/config.php';
redirectIfNotAuthenticated();

// Only allow System Admin access
if ($_SESSION['role'] !== 'System Admin') {
    header("Location: ../login.php");
    exit();
}

// Set current page for navigation highlighting
$_SESSION['current_page'] = 'admin/dashboard.php';

// Get user counts
$totalUsers = $conn->query("SELECT COUNT(*) as total FROM users")->fetch_assoc()['total'];
$hrStaff = $conn->query("SELECT COUNT(*) as total FROM users WHERE role='HR'")->fetch_assoc()['total'];
?>

<?php include '../includes/header.php'; ?>
<?php include '../includes/navigation.php'; ?>

<main class="content">
    <div class="page-header">
        <h1><i class="fas fa-tachometer-alt"></i> Admin Dashboard</h1>
        <div class="user-greeting">
            Welcome back, <?php echo $_SESSION['first_name']; ?>
        </div>
    </div>
    
    <div class="dashboard-grid">
        <!-- Total Users Card -->
        <div class="dashboard-card">
            <div class="card-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="card-content">
                <h3>Total Users</h3>
                <p class="count"><?php echo $totalUsers; ?></p>
                <p class="card-description">All system users</p>
            </div>
        </div>
        
        <!-- HR Staff Card -->
        <div class="dashboard-card">
            <div class="card-icon bg-success">
                <i class="fas fa-user-tie"></i>
            </div>
            <div class="card-content">
                <h3>HR Staff</h3>
                <p class="count"><?php echo $hrStaff; ?></p>
                <p class="card-description">Human Resources personnel</p>
            </div>
        </div>
        
        <!-- Recent Activity Card -->
        <div class="dashboard-card">
            <div class="card-icon bg-warning">
                <i class="fas fa-clock"></i>
            </div>
            <div class="card-content">
                <h3>Recent Activity</h3>
                <div class="activity-list">
                    <div class="activity-item">
                        <i class="fas fa-user-plus"></i>
                        <span>New user registered</span>
                        <small>2 hours ago</small>
                    </div>
                    <div class="activity-item">
                        <i class="fas fa-edit"></i>
                        <span>Profile updated</span>
                        <small>5 hours ago</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="quick-actions">
        <a href="users.php" class="btn btn-primary">
            <i class="fas fa-users-cog"></i> Manage Users
        </a>
        <a href="#" class="btn btn-secondary">
            <i class="fas fa-cog"></i> Settings
        </a>
    </div>
</main>

<?php include '../includes/footer.php'; ?>