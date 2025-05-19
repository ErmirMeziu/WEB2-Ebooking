<?php
include '../db.php';
session_start();

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    header('Location: /login.php');
    exit;
}

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

            <section class="card">
                <h3>🔒 Update Password</h3>
                <form method="POST" action="update_password.php" class="update-password">
                    <input type="password" name="old_password" placeholder="Old Password" required />
                    <input type="password" name="new_password" placeholder="New Password" required />
                    <input type="password" name="confirm_password" placeholder="Confirm Password" required />
                    <div>
                        <button class="btn-red update-password" type="submit">Change Password</button>
                        <span class="message"></span>
                    </div>
                </form>
            </section>
        </main>
    </div>

    <footer>
        <?php include($_SERVER['DOCUMENT_ROOT'] . '/WEB2-Ebooking/src/components/footer.php'); ?>
    </footer>
</body>

</html>

<script>
    document.querySelector('.update-password').addEventListener('submit', function (e) {
        e.preventDefault();

        const form = e.target;
        const old_password = form.old_password.value.trim();
        const new_password = form.new_password.value.trim();
        const confirm_password = form.confirm_password.value.trim();
        const messageSpan = form.querySelector('.message');

        if (new_password.length < 8) {
            messageSpan.style.color = 'red';
            messageSpan.textContent = 'New password must be at least 8 characters.';
            return;
        }

        if (new_password !== confirm_password) {
            messageSpan.style.color = 'red';
            messageSpan.textContent = 'New password and confirm password do not match.';
            return;
        }

        if (old_password === new_password) {
            messageSpan.style.color = 'red';
            messageSpan.textContent = 'New password cannot be the same as old password.';
            return;
        }

        fetch('update_password.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams({
                old_password,
                new_password,
                confirm_password
            })
        })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    messageSpan.style.color = 'green';
                    form.reset();
                } else {
                    messageSpan.style.color = 'red';
                }
                messageSpan.textContent = data.message;
            })
            .catch(err => {
                messageSpan.style.color = 'red';
                messageSpan.textContent = 'Something went wrong. Please try again.';
                console.error(err);
            });
    });
</script>