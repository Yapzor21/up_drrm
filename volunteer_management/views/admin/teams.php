<?php
require_once __DIR__ . '../../../controllers/volunteer_control.php';

// Initialize controller
$controller = new VolunteerTeamsController();

// Get data from controller
$teamVolunteers = $controller->getVolunteersByTeam();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Volunteer Teams</title>
    <link rel="stylesheet" href="../../assets/css/admin/super_admin_dashboard.css">
    <link rel="icon" type="image/svg+xml" href="../../assets/images/iconLogo1.svg">
    <style>
        :root {
            --primary-color: #4a6fdc;
            --primary-hover: #3a5fc9;
            --light-bg: #f8f9fa;
            --border-color: #e9ecef;
            --text-color: #333;
            --text-secondary: #6c757d;
            --shadow: 0 2px 10px rgba(0,0,0,0.05);
            --header-bg: #0099ff;
            --header-text: white;
            --row-even: #f8f9fa;
            --row-odd: white;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: var(--text-color);
            background-color: #f5f7fa;
        }
        
        .form-container {
            max-width: 1200px;
            margin: 30px auto;
            background-color: white;
            border-radius: 8px;
            box-shadow: var(--shadow);
            padding: 25px;
        }
        
        .form-header {
            margin-bottom: 25px;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 15px;
        }
        
        .form-header h2 {
            margin: 0 0 10px 0;
            color: var(--primary-color);
            font-size: 24px;
        }
        
        .form-header p {
            margin: 0;
            color: var(--text-secondary);
        }
        
        .back-button {
            display: inline-flex;
            align-items: center;
            margin-bottom: 25px;
            padding: 8px 16px;
            background-color: var(--primary-color);
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: 500;
            transition: background-color 0.2s;
        }
        
        .back-button:hover {
            background-color: var(--primary-hover);
        }
        
        .volunteer-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
            border: 1px solid #ccc;
        }
        
        .volunteer-table th {
            background-color: var(--header-bg);
            color: var(--header-text);
            text-align: left;
            padding: 12px 15px;
            font-weight: 600;
            border: 1px solid #ccc;
        }
        
        .volunteer-table td {
            padding: 12px 15px;
            border: 1px solid #ccc;
        }
        
        .volunteer-table tr:nth-child(even) {
            background-color: var(--row-even);
        }
        
        .volunteer-table tr:nth-child(odd) {
            background-color: var(--row-odd);
        }
        
        .sort-icon {
            margin-left: 5px;
            font-size: 0.8em;
        }
        
        .no-volunteers {
            padding: 20px;
            text-align: center;
            font-style: italic;
            color: var(--text-secondary);
            background-color: var(--light-bg);
            border-radius: 6px;
        }
        
        @media (max-width: 768px) {
            .volunteer-table {
                display: block;
                overflow-x: auto;
            }
            
            .form-container {
                margin: 15px;
                padding: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="form-container">
        <div class="form-header">
            <h2>Volunteer Teams</h2>
           
        </div>
        <!--
        
         <a href="teams.php" class="back-button">← Back to Teams</a>
        
        -->
       
        <?php if (empty($teamVolunteers)): ?>
            <div class="no-volunteers">No volunteers have been assigned to teams yet.</div>
        <?php else: ?>
            <table class="volunteer-table">
                <thead>
                    <tr>
                        <th>Team <span class="sort-icon">↕</span></th>
                        <th>First Name <span class="sort-icon">↕</span></th>
                        <th>Last Name <span class="sort-icon">↕</span></th>
                        <th>Admin Id <span class="sort-icon">↕</span></th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    // Flatten the team structure to display in a single table
                    $allVolunteers = [];
                    foreach ($teamVolunteers as $teamName => $teamMembers) {
                        foreach ($teamMembers as $volunteer) {
                            $volunteer['team_name'] = $teamName;
                            $allVolunteers[] = $volunteer;
                        }
                    }
                    
                    // If no volunteers, display an empty row
                    if (empty($allVolunteers)): 
                    ?>
                        <tr>
                            <td colspan="4" class="no-volunteers">No volunteers have been assigned to teams yet.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($allVolunteers as $volunteer): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($volunteer['team_name']); ?></td>
                                <td><?php echo htmlspecialchars($volunteer['first_name']); ?></td>
                                <td><?php echo htmlspecialchars($volunteer['last_name']); ?></td>
                                <td><?php echo htmlspecialchars($volunteer['admin_id']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>