<?php
session_start();

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

// Handle logout
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: login.php');
    exit;
}

$db_file = 'database.json';

// Load database
function loadDatabase() {
    global $db_file;
    $json = file_get_contents($db_file);
    return json_decode($json, true);
}

// Save database
function saveDatabase($data) {
    global $db_file;
    file_put_contents($db_file, json_encode($data, JSON_PRETTY_PRINT));
}

// Handle CRUD operations
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = loadDatabase();
    
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'create':
                $newId = empty($db['data']) ? 1 : max(array_column($db['data'], 'id')) + 1;
                $db['data'][] = [
                    'id' => $newId,
                    'label' => $_POST['label'],
                    'value' => $_POST['value']
                ];
                saveDatabase($db);
                $success = 'Record created successfully!';
                break;
                
            case 'update':
                foreach ($db['data'] as &$item) {
                    if ($item['id'] == $_POST['id']) {
                        $item['label'] = $_POST['label'];
                        $item['value'] = $_POST['value'];
                        break;
                    }
                }
                saveDatabase($db);
                $success = 'Record updated successfully!';
                break;
                
            case 'delete':
                $db['data'] = array_filter($db['data'], function($item) {
                    return $item['id'] != $_POST['id'];
                });
                $db['data'] = array_values($db['data']);
                saveDatabase($db);
                $success = 'Record deleted successfully!';
                break;
        }
    }
}

$db = loadDatabase();
$editItem = null;

if (isset($_GET['edit'])) {
    foreach ($db['data'] as $item) {
        if ($item['id'] == $_GET['edit']) {
            $editItem = $item;
            break;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #ff6b35;
            --dark: #1a1a2e;
            --light: #f7f7f7;
            --accent: #0f3460;
            --success: #2ecc71;
            --danger: #e74c3c;
        }

        body {
            font-family: 'Outfit', sans-serif;
            background: var(--light);
            min-height: 100vh;
        }

        .header {
            background: linear-gradient(135deg, var(--dark) 0%, var(--accent) 100%);
            color: white;
            padding: 2rem;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }

        .header-content {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        h1 {
            font-family: 'Bebas Neue', cursive;
            font-size: 2.5rem;
            letter-spacing: 3px;
        }

        .logout-btn {
            background: var(--primary);
            color: white;
            padding: 0.7rem 1.5rem;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
        }

        .logout-btn:hover {
            background: #e85d00;
            transform: translateY(-2px);
        }

        .container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 2rem;
        }

        .success {
            background: var(--success);
            color: white;
            padding: 1rem;
            border-radius: 10px;
            margin-bottom: 2rem;
            animation: slideDown 0.5s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .form-section {
            background: white;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
            margin-bottom: 2rem;
        }

        .form-section h2 {
            font-family: 'Bebas Neue', cursive;
            font-size: 2rem;
            color: var(--primary);
            margin-bottom: 1.5rem;
            letter-spacing: 2px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        label {
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--dark);
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 1px;
        }

        input[type="text"] {
            padding: 0.9rem;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
            font-family: 'Outfit', sans-serif;
        }

        input[type="text"]:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(255,107,53,0.1);
        }

        .btn {
            padding: 0.9rem 2rem;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            font-family: 'Bebas Neue', cursive;
            font-size: 1.1rem;
            letter-spacing: 1px;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background: #e85d00;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255,107,53,0.3);
        }

        .btn-cancel {
            background: #95a5a6;
            color: white;
            margin-left: 1rem;
        }

        .btn-cancel:hover {
            background: #7f8c8d;
        }

        .table-section {
            background: white;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        }

        .table-section h2 {
            font-family: 'Bebas Neue', cursive;
            font-size: 2rem;
            color: var(--primary);
            margin-bottom: 1.5rem;
            letter-spacing: 2px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background: var(--dark);
            color: white;
        }

        th {
            padding: 1rem;
            text-align: left;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 0.9rem;
        }

        td {
            padding: 1rem;
            border-bottom: 1px solid #e0e0e0;
        }

        tr:hover {
            background: #f9f9f9;
        }

        .action-btns {
            display: flex;
            gap: 0.5rem;
        }

        .btn-small {
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-edit {
            background: #3498db;
            color: white;
        }

        .btn-edit:hover {
            background: #2980b9;
        }

        .btn-delete {
            background: var(--danger);
            color: white;
        }

        .btn-delete:hover {
            background: #c0392b;
        }

        .user-link {
            text-align: center;
            margin-top: 2rem;
        }

        .user-link a {
            color: var(--accent);
            text-decoration: none;
            font-weight: 600;
            font-size: 1.1rem;
        }

        .user-link a:hover {
            color: var(--primary);
        }

        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr;
            }

            .header-content {
                flex-direction: column;
                gap: 1rem;
            }

            table {
                font-size: 0.9rem;
            }

            th, td {
                padding: 0.7rem;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-content">
            <h1>Admin Dashboard</h1>
            <a href="?logout=1" class="logout-btn">Logout</a>
        </div>
    </div>

    <div class="container">
        <?php if (isset($success)): ?>
            <div class="success"><?php echo htmlspecialchars($success); ?></div>
        <?php endif; ?>

        <div class="form-section">
            <h2><?php echo $editItem ? 'Edit Record' : 'Create New Record'; ?></h2>
            <form method="POST">
                <input type="hidden" name="action" value="<?php echo $editItem ? 'update' : 'create'; ?>">
                <?php if ($editItem): ?>
                    <input type="hidden" name="id" value="<?php echo $editItem['id']; ?>">
                <?php endif; ?>
                
                <div class="form-grid">
                    <div class="form-group">
                        <label for="label">Label</label>
                        <input type="text" id="label" name="label" value="<?php echo $editItem ? htmlspecialchars($editItem['label']) : ''; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="value">Value</label>
                        <input type="text" id="value" name="value" value="<?php echo $editItem ? htmlspecialchars($editItem['value']) : ''; ?>" required>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary">
                    <?php echo $editItem ? 'Update' : 'Create'; ?>
                </button>
                <?php if ($editItem): ?>
                    <a href="admin.php" class="btn btn-cancel">Cancel</a>
                <?php endif; ?>
            </form>
        </div>

        <div class="table-section">
            <h2>All Records</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Label</th>
                        <th>Value</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($db['data'] as $item): ?>
                        <tr>
                            <td><?php echo $item['id']; ?></td>
                            <td><?php echo htmlspecialchars($item['label']); ?></td>
                            <td><?php echo htmlspecialchars($item['value']); ?></td>
                            <td>
                                <div class="action-btns">
                                    <a href="?edit=<?php echo $item['id']; ?>" class="btn-small btn-edit">Edit</a>
                                    <form method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this record?');">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                                        <button type="submit" class="btn-small btn-delete">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="user-link">
            <a href="index.php">→ View User Chatbot</a>
        </div>
    </div>
</body>
</html>
