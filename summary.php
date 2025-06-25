<?php
session_start();
include 'config.php';

if (!isset($_SESSION['logged_in'])) {
    header("Location: login.html");
    exit();
}

$username = $_SESSION['username'];

// Handle "Clear All" only for this user's entries
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['clear'])) {
    $clearStmt = $conn->prepare("DELETE FROM savings WHERE MONTH(created_at) = MONTH(CURRENT_DATE()) AND username = ?");
    if ($clearStmt) {
        $clearStmt->bind_param("s", $username);
        $clearStmt->execute();
        $clearStmt->close();
        echo "<script>alert('All your expenses for this month have been cleared.'); window.location.href='summary.php';</script>";
        exit();
    } else {
        die("Error in delete prepare: " . $conn->error);
    }
}

// Fetch only this user's expenses for the current month
$stmt = $conn->prepare("SELECT amount, purpose, created_at FROM savings WHERE MONTH(created_at) = MONTH(CURRENT_DATE()) AND username = ?");
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Monthly Expense Summary</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #c2ffd8, #465e79);
            padding: 40px 20px;
            margin: 0;
            text-align: center;
            color: #004d40;
        }

        .container {
            background: rgba(255, 255, 255, 0.15);
            padding: 30px;
            max-width: 900px;
            margin: auto;
            border-radius: 20px;
            box-shadow: 0 12px 40px rgba(0,0,0,0.25);
            backdrop-filter: blur(15px);
            animation: fadeIn 0.6s ease;
        }

        h2 {
            color: #1b5e20;
            margin-bottom: 25px;
        }

        table {
            width: 100%;
            margin: 20px auto;
            border-collapse: collapse;
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 16px;
            border: 1px solid #ddd;
            font-size: 15px;
        }

        th {
            background-color: #2e7d32;
            color: white;
        }

        h3 {
            margin: 30px 0 10px;
            color: #2e7d32;
        }

        input[type='submit'] {
            background-color: #d9534f;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 30px;
            cursor: pointer;
            font-weight: 600;
            margin-top: 20px;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        input[type='submit']:hover {
            background-color: #c9302c;
            transform: scale(1.03);
        }

        a {
            display: inline-block;
            margin-top: 30px;
            padding: 12px 25px;
            text-decoration: none;
            background-color: #2e7d32;
            color: white;
            border-radius: 30px;
            transition: background-color 0.3s ease, transform 0.2s;
        }

        a:hover {
            background-color: #1b5e20;
            transform: scale(1.03);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }

            th, td {
                padding: 12px;
            }

            input[type='submit'], a {
                width: 100%;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <h2><?= htmlspecialchars($username) ?>'s Expenses This Month</h2>

    <table>
        <tr><th>Amount</th><th>Purpose</th><th>Date</th></tr>
        <?php
        $total = 0;
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>₹" . $row['amount'] . "</td>
                    <td>" . htmlspecialchars($row['purpose']) . "</td>
                    <td>" . $row['created_at'] . "</td>
                  </tr>";
            $total += $row['amount'];
        }
        ?>
    </table>

    <h3>Total Expenses: ₹<?= number_format($total, 2) ?></h3>

    <form method="POST" onsubmit="return confirm('Are you sure you want to delete all your expenses for this month?');">
        <input type="submit" name="clear" value="Clear All">
    </form>

    <a href="index.php">Back to Dashboard</a>
</div>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
