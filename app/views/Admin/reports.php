<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Reports - Admin | Mind Haven</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/admin/style.css">
    <style>
        :root {
            --primary:#3D8B6E; --primary-light:#6BB89A; --primary-dark:#2A6B52;
            --bg-deep:#1C2B2A; --bg-soft:#F5F0E8; --bg-mid:#EEF6F2;
            --text-primary:#1E3A34; --text-secondary:#6B8C7E;
            --surface:#FFFFFF; --border:#D6E4DD;
            --radius-sm:8px; --radius-lg:20px; --radius-full:9999px;
            --shadow-sm:0 1px 3px rgba(30,58,52,.06);
        }
        body { font-family:'DM Sans','Inter',system-ui,sans-serif; background:var(--bg-soft); }

        .main-content { margin-left: 280px; width: calc(100% - 280px); flex: 1; display: flex; flex-direction: column; min-height: 100vh; }

        .reports-container {
            display: grid;
            grid-template-columns: 1fr;
            gap: 2rem;
            padding: 2rem 0;
        }
        
        .report-section {
            background: #fff;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            border: 1px solid #e5e7eb;
        }

        .report-section h2 {
            font-size: 1.5rem;
            color: #1e293b;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .stats-summary {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-box {
            background: #f8fafc;
            padding: 1.5rem;
            border-radius: 8px;
            border-left: 4px solid #3b82f6;
        }

        .stat-box h4 {
            margin: 0;
            color: #64748b;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .stat-box .value {
            font-size: 2rem;
            font-weight: 700;
            color: #0f172a;
            margin-top: 0.5rem;
        }

        /* --- Line Chart CSS --- */
        .chart-container {
            width: 100%;
            height: 350px;
            position: relative;
            background: #f8fafc;
            border-radius: 8px;
            padding: 20px 40px 40px 60px; /* space for axes */
            box-sizing: border-box;
            border: 1px solid #e2e8f0;
        }
        .svg-chart {
            width: 100%;
            height: 100%;
            overflow: visible;
        }
        .chart-line {
            fill: none;
            stroke: #3b82f6;
            stroke-width: 3;
            stroke-linecap: round;
            stroke-linejoin: round;
        }
        .chart-point {
            fill: #fff;
            stroke: #2563eb;
            stroke-width: 2;
            transition: r 0.2s;
        }
        .chart-point:hover {
            r: 6;
            fill: #bfdbfe;
        }
        .axis-line {
            stroke: #cbd5e1;
            stroke-width: 1;
        }
        .grid-line {
            stroke: #e2e8f0;
            stroke-width: 1;
            stroke-dasharray: 4;
        }
        .axis-label {
            fill: #64748b;
            font-size: 12px;
            font-family: sans-serif;
        }

        /* --- Pie Chart CSS --- */
        .pie-container {
            display: flex;
            align-items: center;
            gap: 3rem;
            justify-content: center;
            margin-top: 2rem;
            flex-wrap: wrap;
        }
        
        <?php
        // Process Pie Chart Data
        $pieColors = ['#f43f5e', '#ec4899', '#d946ef', '#a855f7', '#8b5cf6', '#6366f1', '#3b82f6', '#0ea5e9', '#06b6d4', '#14b8a6', '#10b981', '#22c55e', '#84cc16'];
        $pieDataFormatted = [];
        $colorIndex = 0;
        $gradientStops = [];
        $currentPercentage = 0;

        if ($totalResources > 0) {
            foreach ($resourcesByCategory as $cat => $count) {
                // Ensure exactly 100% distribution across floating point precision
                $percent = ($count / $totalResources) * 100;
                $color = $pieColors[$colorIndex % count($pieColors)];
                
                $start = $currentPercentage;
                $end = $currentPercentage + $percent;
                
                $gradientStops[] = "{$color} {$start}% {$end}%";
                
                $pieDataFormatted[] = [
                    'category' => $cat,
                    'count' => $count,
                    'percent' => round($percent, 1),
                    'color' => $color
                ];
                
                $currentPercentage = $end;
                $colorIndex++;
            }
        }
        $conicGradient = !empty($gradientStops) ? implode(', ', $gradientStops) : '#cbd5e1 0% 100%';
        ?>

        .native-pie-chart {
            width: 250px;
            height: 250px;
            border-radius: 50%;
            background: conic-gradient(<?= $conicGradient ?>);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            border: 4px solid #fff;
            transition: transform 0.3s;
        }

        .native-pie-chart:hover {
            transform: scale(1.05);
        }

        .pie-legend {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            min-width: 200px;
        }
        .legend-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.95rem;
            color: #334155;
        }
        .legend-color {
            width: 16px;
            height: 16px;
            border-radius: 4px;
        }
        .legend-count {
            margin-left: auto;
            font-weight: 600;
            color: #0f172a;
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
    <?php 
    $activePage = 'reports';
    include '_sidebar.php'; 
    ?>

    <!-- Main Content -->
    <div class="main-content">
        <div class="topbar">
            <h1>System Reports</h1>
            <div class="topbar-right">
                <div class="admin-profile">
                    <span>Admin User</span>
                    <div class="avatar">A</div>
                </div>
            </div>
        </div>

        <div class="content-wrapper">
            
            <div class="reports-container">
                
                <!-- FORUM SECTION -->
                <div class="report-section">
                    <h2>💬 Forum Section</h2>
                    
                    <div class="stats-summary">
                        <div class="stat-box">
                            <h4>Total Posts</h4>
                            <div class="value"><?= htmlspecialchars((string) ($totalPosts ?? 0)) ?></div>
                        </div>
                        <div class="stat-box" style="border-left-color: #10b981;">
                            <h4>Posts This Month</h4>
                            <div class="value"><?= htmlspecialchars((string) ($postsThisMonth ?? 0)) ?></div>
                        </div>
                    </div>

                    <h3>📈 Posts Over Time (Current Year)</h3>
                    
                    <?php
                    // Line Chart Math
                    $paddedMonths = [];
                    for($i=1; $i<=12; $i++) {
                        $paddedMonths[$i] = $postsByMonth[$i] ?? 0;
                    }
                    
                    $maxVal = max($paddedMonths) ?: 10; // Avoid dev by zero, force a scale
                    $targetScale = ceil($maxVal / 5) * 5; // Round highest point up to nearest 5
                    
                    $canvasW = 800; // viewBox w
                    $canvasH = 300; // viewBox h
                    
                    $points = [];
                    foreach ($paddedMonths as $m => $count) {
                        $x = (($m - 1) / 11) * $canvasW;
                        $y = $canvasH - (($count / $targetScale) * $canvasH);
                        $points[] = "{$x},{$y}";
                    }
                    $polylinePath = implode(' ', $points);
                    
                    $monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                    ?>

                    <div class="chart-container">
                        <svg class="svg-chart" viewBox="0 0 <?= $canvasW ?> <?= $canvasH ?>" preserveAspectRatio="none">
                            
                            <!-- Grid / Y Axis Labels -->
                            <?php
                            for ($i = 0; $i <= 5; $i++) {
                                $yFactor = $i / 5;
                                $gridY = $canvasH - ($yFactor * $canvasH);
                                $labelVal = round($targetScale * $yFactor);
                                echo '<line x1="0" y1="' . $gridY . '" x2="' . $canvasW . '" y2="' . $gridY . '" class="grid-line" />';
                                echo '<text x="-10" y="' . ($gridY + 4) . '" class="axis-label" text-anchor="end">' . $labelVal . '</text>';
                            }
                            ?>

                            <!-- X Axis Lines -->
                            <line x1="0" y1="<?= $canvasH ?>" x2="<?= $canvasW ?>" y2="<?= $canvasH ?>" class="axis-line" stroke-width="2" />
                            <line x1="0" y1="0" x2="0" y2="<?= $canvasH ?>" class="axis-line" stroke-width="2" />

                            <!-- The Line -->
                            <polyline points="<?= $polylinePath ?>" class="chart-line" />

                            <!-- Data Points and X Labels -->
                            <?php
                            foreach ($paddedMonths as $m => $count) {
                                $x = (($m - 1) / 11) * $canvasW;
                                $y = $canvasH - (($count / $targetScale) * $canvasH);
                                $label = $monthNames[$m - 1];
                                echo '<circle cx="' . $x . '" cy="' . $y . '" r="4" class="chart-point"><title>' . $label . ': ' . $count . ' posts</title></circle>';
                                echo '<text x="' . $x . '" y="' . ($canvasH + 20) . '" class="axis-label" text-anchor="middle">' . $label . '</text>';
                            }
                            ?>
                            
                        </svg>
                    </div>
                </div>

                <!-- RESOURCE HUB SECTION -->
                <div class="report-section">
                    <h2>📚 Resource Hub Section</h2>
                    
                    <div class="stats-summary">
                        <div class="stat-box" style="border-left-color: #8b5cf6;">
                            <h4>Total Resources</h4>
                            <div class="value"><?= htmlspecialchars((string) ($totalResources ?? 0)) ?></div>
                        </div>
                    </div>

                    <h3>🥧 Resources by Category</h3>
                    
                    <?php if (empty($pieDataFormatted)): ?>
                        <p style="text-align: center; color: #64748b; padding: 2rem;">No resource category data available.</p>
                    <?php else: ?>
                        <div class="pie-container">
                            <div class="native-pie-chart" title="Distribution of Resource Categories"></div>
                            
                            <div class="pie-legend">
                                <?php foreach ($pieDataFormatted as $data): ?>
                                    <div class="legend-item">
                                        <div class="legend-color" style="background-color: <?= $data['color'] ?>;"></div>
                                        <span><?= htmlspecialchars($data['category'] ?: 'Uncategorized') ?></span>
                                        <span class="legend-count"><?= $data['count'] ?> (<?= $data['percent'] ?>%)</span>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </div>
    <?php endif; ?>
</body>
</html>
