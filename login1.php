<?php
session_start();
include("connection.php");
include("functions.php");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $id_no = $_POST['id_no'];
    $contact = $_POST['contact'];

    if (!empty($id_no)) {
        if ($con) {
            $query = "SELECT * FROM student WHERE id_no = '$id_no' LIMIT 1";
            $result = mysqli_query($con, $query);

            if ($result) {
                if (mysqli_num_rows($result) > 0) {
                    $student_data = mysqli_fetch_assoc($result);
                    $default_contact = "Bitm123#";

                    if ($student_data['contact'] === $contact || $contact === $default_contact) {
                        $_SESSION['id_no'] = $student_data['id_no'];
                        header("Location: student_page.php");
                        die;
                    } else {
                        $error_message = "Incorrect ID number or contact.";
                    }
                } else {
                    $error_message = "No student found with this ID number.";
                }
            } else {
                $error_message = "Database query error.";
            }
        } else {
            $error_message = "Database connection failed!";
        }
    } else {
        $error_message = "ID number is required!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Login</title>
    <style type="text/css">
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background: url('https://source.unsplash.com/1920x1080/?education,school') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            overflow: hidden;
        }

        #box {
            background-color: rgba(255, 255, 255, 0.9);
            width: 400px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            padding: 20px;
            text-align: center;
            position: relative;
            animation: slide-in 1s ease-out;
        }

        #box h2 {
            margin-bottom: 20px;
            color: #333333;
        }

        #text {
            height: 40px;
            border-radius: 5px;
            padding: 10px;
            border: 1px solid #ddd;
            width: 90%;
            margin-bottom: 20px;
            font-size: 16px;
            animation: fade-in 1.5s ease-out;
        }

        #button {
            padding: 12px 20px;
            width: 90%;
            color: white;
            background: linear-gradient(to right, #ff6a00, #ee0979);
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            animation: pulse 2s infinite;
        }

        #button:hover {
            background: linear-gradient(to right, #ee0979, #ff6a00);
        }

        .error-message {
            color: #ff4d4d;
            font-size: 14px;
            margin-bottom: 20px;
            animation: shake 0.5s ease;
        }

        @keyframes slide-in {
            from {
                transform: translateY(-50px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes fade-in {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
            100% {
                transform: scale(1);
            }
        }

        @keyframes shake {
            0%, 100% {
                transform: translateX(0);
            }
            25% {
                transform: translateX(-5px);
            }
            75% {
                transform: translateX(5px);
            }
        }
    </style>
</head>
<body>
<div id="box">
    <h2>Student Login</h2>

    <?php if (isset($error_message)): ?>
        <div class="error-message">
            <?php echo $error_message; ?>
        </div>
    <?php endif; ?>

    <form method="post">
        <input id="text" type="text" name="id_no" placeholder="Enter your ID number"><br>
        <input id="text" type="password" name="contact" placeholder="Enter your contact"><br>
        <input id="button" type="submit" value="Login">
    </form>
</div>
</body>
</html>