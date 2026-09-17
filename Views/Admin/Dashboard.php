<?php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        :root {
            --bg: #f4f7fb;
            --card: #ffffff;
            --accent: #0d6efd;
            --accent-soft: #e8f1ff;
            --text: #1f2937;
            --muted: #6b7280;
            --border: #e5e7eb;
            --success: #198754;
            --warning: #f59e0b;
            --danger: #dc3545;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: var(--bg);
            color: var(--text);
        }

        .dashboard-container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 24px;
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }

        .topbar h1 {
            margin: 0;
            font-size: 2rem;
        }

        .badge {
            background: var(--accent-soft);
            color: var(--accent);
            border: 1px solid #cfe0ff;
            border-radius: 999px;
            padding: 8px 14px;
            font-size: 0.9rem;
            font-weight: 600;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 28px;
        }

        .stat-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 22px;
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.04);
        }

        .stat-label {
            color: var(--muted);
            font-size: 0.9rem;
            margin-bottom: 10px;
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            margin: 0;
        }

        .stat-value.success { color: var(--success); }
        .stat-value.warning { color: var(--warning); }
        .stat-value.danger { color: var(--danger); }

        .content-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 24px;
        }

        .panel {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 22px;
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.04);
        }

        .panel h2 {
            margin-top: 0;
            margin-bottom: 16px;
            font-size: 1.3rem;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            overflow: hidden;
        }

        th, td {
            text-align: left;
            padding: 12px 10px;
            border-bottom: 1px solid var(--border);
            font-size: 0.95rem;
        }

        th {
            color: var(--muted);
            font-weight: 600;
        }

        .status {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 999px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .status.confirmed { background: #d1fae5; color: #065f46; }
        .status.pending { background: #fef3c7; color: #92400e; }
        .status.cancelled { background: #fee2e2; color: #991b1b; }

        .list {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .list li {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid var(--border);
        }

        .list li:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .mini-tag {
            background: var(--accent-soft);
            color: var(--accent);
            border-radius: 999px;
            padding: 6px 10px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        @media (max-width: 768px) {
            .content-grid {
                grid-template-columns: 1fr;
            }

            .topbar {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <div class="topbar">
            <h1>Dashboard</h1>
            <span class="badge">Admin Panel</span>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-label">Total Bookings</div>
                <p class="stat-value success">128</p>
            </div>
            <div class="stat-card">
                <div class="stat-label">Occupancy</div>
                <p class="stat-value warning">76%</p>
            </div>
            <div class="stat-card">
                <div class="stat-label">Revenue</div>
                <p class="stat-value">$18,420</p>
            </div>
            <div class="stat-card">
                <div class="stat-label">Pending Tasks</div>
                <p class="stat-value danger">9</p>
            </div>
        </div>

        <div class="content-grid">
            <div class="panel">
                <h2>Recent Bookings</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Guest</th>
                            <th>Room</th>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Samira Khan</td>
                            <td>Deluxe Suite</td>
                            <td>Aug 20, 2026</td>
                            <td><span class="status confirmed">Confirmed</span></td>
                        </tr>
                        <tr>
                            <td>Daniel Smith</td>
                            <td>Garden View</td>
                            <td>Aug 22, 2026</td>
                            <td><span class="status pending">Pending</span></td>
                        </tr>
                        <tr>
                            <td>Priya Nair</td>
                            <td>Family Room</td>
                            <td>Aug 24, 2026</td>
                            <td><span class="status confirmed">Confirmed</span></td>
                        </tr>
                        <tr>
                            <td>Emma Wilson</td>
                            <td>Standard Room</td>
                            <td>Aug 26, 2026</td>
                            <td><span class="status cancelled">Cancelled</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="panel">
                <h2>Quick Overview</h2>
                <ul class="list">
                    <li>
                        <span>Available Rooms</span>
                        <span class="mini-tag">24</span>
                    </li>
                    <li>
                        <span>New Reviews</span>
                        <span class="mini-tag">12</span>
                    </li>
                    <li>
                        <span>Messages</span>
                        <span class="mini-tag">5</span>
                    </li>
                    <li>
                        <span>Maintenance</span>
                        <span class="mini-tag">3</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</body>
</html>
