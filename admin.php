<?php
require_once 'config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$conn = getDBConnection();
$message = '';
$messageType = '';

// Handle project actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    if ($action === 'add') {
        $stmt = $conn->prepare("INSERT INTO projects (title, category, description, url, display_order) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([
            $_POST['title'],
            $_POST['category'],
            $_POST['description'],
            $_POST['url'],
            $_POST['display_order']
        ]);
        $message = 'Project added successfully!';
        $messageType = 'success';
    } elseif ($action === 'edit') {
        $stmt = $conn->prepare("UPDATE projects SET title = ?, category = ?, description = ?, url = ?, display_order = ? WHERE id = ?");
        $stmt->execute([
            $_POST['title'],
            $_POST['category'],
            $_POST['description'],
            $_POST['url'],
            $_POST['display_order'],
            $_POST['id']
        ]);
        $message = 'Project updated successfully!';
        $messageType = 'success';
    } elseif ($action === 'delete') {
        $stmt = $conn->prepare("DELETE FROM projects WHERE id = ?");
        $stmt->execute([$_POST['id']]);
        $message = 'Project deleted successfully!';
        $messageType = 'success';
    }
}

// Fetch all projects
$stmt = $conn->query("SELECT * FROM projects ORDER BY display_order ASC, id ASC");
$projects = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header class="admin-header">
        <div class="container">
            <div class="admin-nav">
                <h1>Portfolio Admin</h1>
                <div class="admin-nav-right">
                    <span>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
                    <a href="index.php" class="btn btn-secondary btn-small">View Site</a>
                    <a href="logout.php" class="btn btn-secondary btn-small">Logout</a>
                </div>
            </div>
        </div>
    </header>

    <main class="admin-main">
        <div class="container">
            <?php if ($message): ?>
                <div class="alert alert-<?php echo $messageType; ?>"><?php echo htmlspecialchars($message); ?></div>
            <?php endif; ?>

            <div class="admin-section">
                <div class="section-header">
                    <h2>Manage Projects</h2>
                    <button onclick="showAddModal()" class="btn btn-primary">Add New Project</button>
                </div>

                <div class="projects-table">
                    <table>
                        <thead>
                            <tr>
                                <th>Order</th>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Description</th>
                                <th>URL</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($projects as $project): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($project['display_order']); ?></td>
                                    <td><?php echo htmlspecialchars($project['title']); ?></td>
                                    <td><span class="badge"><?php echo htmlspecialchars($project['category']); ?></span></td>
                                    <td class="description-cell"><?php echo htmlspecialchars(substr($project['description'], 0, 80)); ?>...</td>
                                    <td><?php echo $project['url'] ? '<a href="' . htmlspecialchars($project['url']) . '" target="_blank">View</a>' : '-'; ?></td>
                                    <td class="actions-cell">
                                        <button onclick='editProject(<?php echo json_encode($project); ?>)' class="btn-icon btn-edit">Edit</button>
                                        <form method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this project?');">
                                            <input type="hidden" name="action" value="delete">
                                            <input type="hidden" name="id" value="<?php echo $project['id']; ?>">
                                            <button type="submit" class="btn-icon btn-delete">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <!-- Add/Edit Project Modal -->
    <div id="projectModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="modalTitle">Add New Project</h3>
                <span class="modal-close" onclick="closeModal()">&times;</span>
            </div>
            <form method="POST" id="projectForm">
                <input type="hidden" name="action" id="formAction" value="add">
                <input type="hidden" name="id" id="projectId">
                
                <div class="form-group">
                    <label for="title">Project Title *</label>
                    <input type="text" id="title" name="title" required>
                </div>
                
                <div class="form-group">
                    <label for="category">Category *</label>
                    <input type="text" id="category" name="category" required>
                    <small>e.g., WordPress Plugin, SaaS Service, Web Application</small>
                </div>
                
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" rows="4"></textarea>
                </div>
                
                <div class="form-group">
                    <label for="url">Project URL</label>
                    <input type="url" id="url" name="url" placeholder="https://">
                </div>
                
                <div class="form-group">
                    <label for="display_order">Display Order</label>
                    <input type="number" id="display_order" name="display_order" value="0" min="0">
                    <small>Lower numbers appear first</small>
                </div>
                
                <div class="modal-footer">
                    <button type="button" onclick="closeModal()" class="btn btn-secondary">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Project</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function showAddModal() {
            document.getElementById('modalTitle').textContent = 'Add New Project';
            document.getElementById('formAction').value = 'add';
            document.getElementById('projectForm').reset();
            document.getElementById('projectId').value = '';
            document.getElementById('projectModal').style.display = 'flex';
        }

        function editProject(project) {
            document.getElementById('modalTitle').textContent = 'Edit Project';
            document.getElementById('formAction').value = 'edit';
            document.getElementById('projectId').value = project.id;
            document.getElementById('title').value = project.title;
            document.getElementById('category').value = project.category;
            document.getElementById('description').value = project.description;
            document.getElementById('url').value = project.url || '';
            document.getElementById('display_order').value = project.display_order;
            document.getElementById('projectModal').style.display = 'flex';
        }

        function closeModal() {
            document.getElementById('projectModal').style.display = 'none';
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('projectModal');
            if (event.target === modal) {
                closeModal();
            }
        }
    </script>
</body>
</html>
