<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Portal</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="./assets/css/style.css">
</head>
<body>
    <div class="container">
        <header class="header">
            <div class="logo">
                <h1><i class="fas fa-user-shield"></i> User Portal</h1>
            </div>
            <?php if (isAuthenticated()): ?>
            <div class="user-info">
                <span><?php echo $_SESSION['first_name'] . ' ' . $_SESSION['last_name']; ?></span>
                <span class="role-badge <?php echo strtolower(str_replace(' ', '-', $_SESSION['role'])); ?>">
                    <?php echo $_SESSION['role']; ?>
                </span>
                <a href="../logout.php" class="logout-btn"><i class="fas fa-sign-out-alt"></i></a>
            </div>
            <?php endif; ?>
        </header>