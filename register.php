<?php
include 'header.php';
// Include config file
require "DB.php";
require_once "Helper.php";
// Define variables and initialize with empty values
$username = $fname = $lname = $password = $confirm_password = "";
$username_err = $fname_err = $lname_err = $password_err = $confirm_password_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate email
    if (empty(trim($_POST["username"]))) {
        $username_err = "Введіть вашу пошту.";
    } elseif (!filter_var($_POST["username"], FILTER_VALIDATE_EMAIL)) {
        $username_err = "Введіть коректну пошту.";
    } else {
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE username = ?";

        if ($stmt = mysqli_prepare($conn, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set parameters
            $param_username = trim($_POST["username"]);

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                /* store result */
                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) == 1) {
                    $username_err = "Користувач з такою поштою вже зареєстрований в системі";
                } else {
                    $username = trim($_POST["username"]);
                }
            } else {
                echo "Щось пішло не так. Спробуйте ще раз.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Validate first name
    if (empty(trim($_POST["fname"]))) {
        $fname_err = "Введіть ваше ім'я.";
    }else {
        $param_fname = trim($_POST["fname"]);
    }

    // Validate last name
    if (empty(trim($_POST["lname"]))) {
        $lname_err = "Введіть ваше прізвище.";
    }else {
        $param_lname = trim($_POST["lname"]);
    }

    // Validate phone number
    if (empty(trim($_POST["phone"]))) {
        $phone_err = "Введіть ваш номер телефону.";
    }elseif (strlen(trim($_POST["password"])) >= 9){
        $phone_err = "Введіть ваш номер телефону коректно.";
    }
    else {
        $param_phone = trim($_POST["phone"]);
    }

    // Validate password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Введіть пароль.";
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $password_err = "Пароль має містити 6 символів.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate confirm password
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Підтвердіть пароль.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "Паролі не співпадають.";
        }
    }

    // Validate role
    if($_POST['roles'] > 2){
        $confirm_role_err = "Неправильна роль!";
    }else{
        $param_role = $_POST['roles'];
    }


    // Check input errors before inserting in database
    if (empty($username_err) && empty($password_err) && empty($confirm_password_err)) {

        // Prepare an insert statement
        $sql = "INSERT INTO users (username, password, role_id, first_name, last_name, phone_number) VALUES (?, ?, ?, ?, ?, ?)";

        if ($stmt = mysqli_prepare($conn, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssssss", $param_username, $param_password, $param_role, $param_fname, $param_lname, $param_phone);

            // Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Redirect to login page
                Helper::redirect("login.php");
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    // Close connection
    mysqli_close($conn);
}

?>
<body>
<div class="callback" style="width:400px; margin:0 auto;">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form">
            <label><strong>Пошта<strong/></label>
            <input type="text" name="username" class="required <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
            <span style="color=red"><?php echo $username_err; ?></span>
        </div>
        <div class="form">
            <label><strong>Ім'я<strong/></label>
            <input type="text" name="fname" class="required <?php echo (!empty($fname_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $param_fname; ?>">
            <span style="color=red"><?php echo $fname_err; ?></span>
        </div>
        <div class="form">
            <label><strong>Прізвище<strong/></label>
            <input type="text" name="lname" class="required <?php echo (!empty($lname_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $param_lname; ?>">
            <span style="color=red"><?php echo $lname_err; ?></span>
        </div>
        <div class="form">
            <label><strong>Номер телефону<strong/></label>
            <input type="text" name="phone" class="required <?php echo (!empty($phone_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $param_phone; ?>" placeholder="0977777777">
            <span style="color=red"><?php echo $phone_err; ?></span>
        </div>
        <div class="form">
            <label><strong>Пароль</strong></label>
            <input type="password" name="password" class="required <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
            <span style="color=red"><?php echo $password_err; ?></span>
        </div>
        <div class="form">
            <label><strong>Підтвердити пароль</strong></label>
            <input type="password" name="confirm_password" class="required <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
            <span style="color=red"><?php echo $confirm_password_err; ?></span>
        </div>
        <div class="form">
            <label><strong>Вибрати роль</strong></label>
            <select style="height: 50px; margin: 10px 0 10px 0" id="roles" name="roles">
                <option value="1">Користувач</option>
                <option value="2">Фотограф</option>
            </select>
            <span style="color=red"><?php echo $confirm_role_err; ?></span>
        </div>
        <div class="form">
            <input type="submit" class="submit" value="Підтвердити">
        </div>
        <p>Вже зареєстровані? <a href="/login.php">Увійти</a></p>
    </form>
</div>
</body>
<?php

include 'footer.php';

