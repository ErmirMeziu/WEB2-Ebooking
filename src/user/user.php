<?php
include '../db.php';
session_start();
$user_id = $_SESSION['user_id'] ?? 1;

$sql = "SELECT name, surname, email, phone, birthdate, gender, bio FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Compact Profile Settings</title>
    <link rel="stylesheet" href="user.css" />
    <link rel="stylesheet" href="../styles/navbar.css" />
    <link rel="stylesheet" href="../styles/footer.css" />
    <script src="https://kit.fontawesome.com/c2f2fe035b.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet" />
    <style>
        header {
            position: relative !important;
            background-color: #041625 !important;
        }
    </style>
</head>

<body>
    <header>
        <?php include($_SERVER['DOCUMENT_ROOT'] . '/WEB2-Ebooking/src/components/navbar.php'); ?>
    </header>

    <div class="container">
        <main class="main-content">

            <!-- Personal Info -->
            <section class="card">
                <h3>👤 Personal Info</h3>

                <form method="POST" action="update_profile.php" class="profile-form">
                    <div class="form-grid">
                        <input type="text" name="name" placeholder="First Name"
                            value="<?php echo htmlspecialchars($user['name'] ?? ''); ?>" required />
                        <input type="text" name="surname" placeholder="Last Name"
                            value="<?php echo htmlspecialchars($user['surname'] ?? ''); ?>" required />
                        <input type="email" name="email" placeholder="Email"
                            value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>" readonly />
                        <input type="tel" name="phone" placeholder="Mobile"
                            value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>" />
                        <input type="date" name="birthdate"
                            value="<?php echo htmlspecialchars($user['birthdate'] ?? ''); ?>" />
                        <select name="gender" required>
                            <option value="Male" <?php if (($user['gender'] ?? '') === 'Male')
                                echo 'selected'; ?>>Male
                            </option>
                            <option value="Female" <?php if (($user['gender'] ?? '') === 'Female')
                                echo 'selected'; ?>>
                                Female</option>
                            <option value="Other" <?php if (($user['gender'] ?? '') === 'Other')
                                echo 'selected'; ?>>Other
                            </option>
                        </select>
                        <textarea name="bio"
                            placeholder="About you..."><?php echo htmlspecialchars($user['bio'] ?? ''); ?></textarea>
                    </div>
                    <button class="btn-red" type="submit">Save Changes</button>
                </form>
            </section>

            <!-- Update Password -->
            <section class="card">
                <h3>🔒 Update Password</h3>
                <form method="POST" action="update_password.php" class="update-password">
                    <input type="password" name="old_password" placeholder="Old Password" required />
                    <input type="password" name="new_password" placeholder="New Password" required />
                    <input type="password" name="confirm_password" placeholder="Confirm Password" required />
                    <button class="btn-red" type="submit">Change Password</button>
                </form>
            </section>

        </main>
    </div>

    <footer>
        <?php include($_SERVER['DOCUMENT_ROOT'] . '/WEB2-Ebooking/src/components/footer.php'); ?>
    </footer>
</body>

</html>