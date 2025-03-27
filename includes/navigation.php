<?php if (isAuthenticated()): ?>
<nav class="sidebar">
    <div class="user-profile">
        <?php if ($_SESSION['photo']): ?>
            <img src="<?php echo $_SESSION['photo']; ?>" alt="Profile Photo" class="user-photo">
        <?php else: ?>
            <div class="user-photo-placeholder">
                <?php echo substr($_SESSION['first_name'], 0, 1) . substr($_SESSION['last_name'], 0, 1); ?>
            </div>
        <?php endif; ?>
        <div class="user-info">
            <strong><?php echo $_SESSION['first_name'] . ' ' . $_SESSION['last_name']; ?></strong>
            <span class="role-badge <?php echo strtolower(str_replace(' ', '-', $_SESSION['role'])); ?>">
                <?php echo $_SESSION['role']; ?>
            </span>
        </div>
    </div>
    
    <ul>
        <li>
            <a href="admin/dashboard.php" class="<?php echo ($_SESSION['current_page'] === 'admin/dashboard.php') ? 'active' : ''; ?>">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
        </li>
        
        <?php if ($_SESSION['role'] === 'System Admin'): ?>
            <li>
                <a href="admin/users.php" class="<?php echo ($_SESSION['current_page'] === 'admin/users.php') ? 'active' : ''; ?>">
                    <i class="fas fa-users-cog"></i> User Accounts
                </a>
            </li>
        <?php endif; ?>
        
        <?php if ($_SESSION['role'] !== 'User'): ?>
            <li>
                <a href="hr/resources.php" class="<?php echo ($_SESSION['current_page'] === 'hr/resources.php') ? 'active' : ''; ?>">
                    <i class="fas fa-briefcase"></i> Human Resources
                </a>
            </li>
        <?php endif; ?>
        
        <li>
            <a href="profile.php" class="<?php echo ($_SESSION['current_page'] === 'profile.php') ? 'active' : ''; ?>">
                <i class="fas fa-user-tie"></i> Employee Profile
            </a>
        </li>
        
        <li>
            <a href="../summary.php" class="<?php echo ($_SESSION['current_page'] === 'summary.php') ? 'active' : ''; ?>">
                <i class="fas fa-list"></i> User Summary
            </a>
        </li>
        
        <li class="logout-item">
            <a href="../logout.php">
                <i class="fas fa-sign-out-alt"></i> Quit
            </a>
        </li>
    </ul>
</nav>
<?php endif; ?>