<!DOCTYPE html>
<html>
<head>
    <title>Crisis Hotline Call</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/call-responder/call-responder.css?v=<?= time() ?>">
</head>
<body>
    <div class="call-container">
        <h1>📞 Crisis Hotline</h1>

        <button id="acceptCall" class="btn">Accept</button>
        <button id="declineCall" class="btn danger">Decline</button>

        <!-- Notes box -->
        <div class="notes-container">
            <textarea id="callNotes" class="notes-textarea" placeholder="notes..."></textarea>
        </div>

        <!-- Call status -->
        <p id="status">Status: Waiting...</p>
    </div>

    <!-- Call Logs -->
    <section class="logs-section">
        <div class="section-header">
            <h2 class="section-title">Call Logs</h2>
            <p class="section-subtitle">Recent calls handled by responders</p>
        </div>
        <div class="logs-card">
            <table class="logs-table">
                <thead>
                    <tr>
                        <th>Call ID</th>
                        <th>Call Status</th>
                        <th>Call Notes</th>
                        <th>Escalated To</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>#10234</td>
                        <td>Accepted</td>
                        <td>Caller experiencing exam stress; provided breathing techniques and campus resources.</td>
                        <td>Counselor - Dr. Smith</td>
                    </tr>
                    <tr>
                        <td>#10235</td>
                        <td>Declined</td>
                        <td>Wrong number; no intervention required.</td>
                        <td>-</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>

    <script>
    // Minimal button wiring to reflect status
    const statusEl = document.getElementById('status');
    const acceptBtn = document.getElementById('acceptCall');
    const declineBtn = document.getElementById('declineCall');

    acceptBtn?.addEventListener('click', () => {
        statusEl.textContent = 'Status: Accepted';
    });
    declineBtn?.addEventListener('click', () => {
        statusEl.textContent = 'Status: Declined';
    });
    </script>
</body>
</html>
