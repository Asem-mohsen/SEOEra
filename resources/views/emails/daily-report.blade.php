<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Daily Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .stats {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }
        .stat-card {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 15px;
            text-align: center;
        }
        .stat-number {
            font-size: 2em;
            font-weight: bold;
            color: #007bff;
        }
        .stat-label {
            color: #666;
            margin-top: 5px;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            color: #666;
            font-size: 0.9em;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Daily Report</h1>
        <p><strong>Date:</strong> {{ $report['date'] }}</p>
    </div>

    <div class="stats">
        <div class="stat-card">
            <div class="stat-number">{{ $report['new_users'] }}</div>
            <div class="stat-label">New Users Today</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $report['new_posts'] }}</div>
            <div class="stat-label">New Posts Today</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $report['total_users'] }}</div>
            <div class="stat-label">Total Users</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $report['total_posts'] }}</div>
            <div class="stat-label">Total Posts</div>
        </div>
    </div>

    <div class="footer">
        <p>This is an automated daily report generated at midnight.</p>
        <p>Generated on: {{ now()->format('Y-m-d H:i:s') }}</p>
    </div>
</body>
</html>
