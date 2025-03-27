<?php
require_once '../includes/config.php';
redirectIfNotAuthenticated();
if ($_SESSION['role'] !== 'System Admin') {
    header("Location: ../login.php");
    exit();
}
?>

<?php include '../includes/header.php'; ?>
<?php include '../includes/navigation.php'; ?>

<main class="content">
    <h2><i class="fas fa-tachometer-alt"></i> Admin Dashboard</h2>
    
    <div class="dashboard-cards">
        <div class="card">
            <div class="card-icon bg-primary">
                <i class="fas fa-users"></i>
            </div>
            <div class="card-info">
                <h3>Total Users</h3>
                <p>
                    <?php 
                    $result = $conn->query("SELECT COUNT(*) as total FROM users");
                    echo $result->fetch_assoc()['total'];
                    ?>
                </p>
            </div>
        </div>
        
        <div class="card">
            <div class="card-icon bg-success">
                <i class="fas fa-user-tie"></i>
            </div>
            <div class="card-info">
                <h3>HR Staff</h3>
                <p>
                    <?php 
                    $result = $conn->query("SELECT COUNT(*) as total FROM users WHERE role='HR'");
                    echo $result->fetch_assoc()['total'];
                    ?>
                </p>
            </div>
        </div>
    </div>
</main>

<?php include '../includes/footer.php'; ?>