<?php
/**
 * Counselor Chat Inbox
 * Lists all active chat sessions and lets the counselor start a new one
 * with any undergrad they've had an appointment with.
 */

// Ensure variables are set
$sessions   = isset($sessions)   ? $sessions   : [];
$undergrads = isset($undergrads) ? $undergrads : [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MindHeaven — Counselor Chat</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/css/counselor/Cdashboard.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/css/chat/chat.css">
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar">
        <div class="nav-content">
            <div class="logo">
                <div class="logo-icon">M</div>
                Mindheaven
            </div>
        </div>
    </nav>

    <div class="main-container">
        <!-- Sidebar -->
        <?php include __DIR__ . '/sidebar.php'; ?>

        <!-- Main Content -->
        <div class="main-content" style="background:#0f172a; min-height:100vh; color:#e2e8f0;">
            <div class="chat-page chat-page-wrapper" style="padding:2rem; max-width:860px; margin:0 auto;">

                <!-- Page Header -->
                <div class="chat-list-header">
                    <h1>💬 Counselling Chat</h1>
                    <span class="secure-badge">🔒 End-to-end secure</span>
                </div>

                <!-- Start New Chat Card (only shown if undergrads exist) -->
                <?php if (!empty($undergrads)): ?>
                <div class="new-chat-card">
                    <h2>➕ Start a new chat</h2>
                    <form class="new-chat-form" id="newChatForm">
                        <select id="undergradSelect" class="new-chat-select" required>
                            <option value="">— Select an undergraduate —</option>
                            <?php foreach ($undergrads as $ug): ?>
                                <option value="<?php echo (int)$ug['user_id']; ?>">
                                    <?php echo htmlspecialchars($ug['full_name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <button type="submit" class="btn-start-chat">
                            💬 Open Chat
                        </button>
                    </form>
                    <p id="newChatError" style="color:#fca5a5; font-size:0.82rem; margin:0.5rem 0 0 0; display:none;"></p>
                </div>
                <?php endif; ?>

                <!-- Existing Sessions -->
                <p class="sessions-label">Your conversations</p>

                <?php if (empty($sessions)): ?>
                    <div class="empty-chat-state">
                        <div class="empty-icon">💬</div>
                        <h3>No chats yet</h3>
                        <p>Use the form above to start a private counselling chat with one of your students.</p>
                    </div>
                <?php else: ?>
                    <div class="sessions-list">
                        <?php foreach ($sessions as $s): ?>
                            <?php
                                $preview = $s['last_message']
                                    ? htmlspecialchars(mb_substr($s['last_message'], 0, 60)) . (mb_strlen($s['last_message']) > 60 ? '…' : '')
                                    : 'No messages yet';
                                $timeLabel = '';
                                if ($s['last_message_at']) {
                                    $ts = strtotime($s['last_message_at']);
                                    $timeLabel = (date('Y-m-d') === date('Y-m-d', $ts))
                                        ? date('g:i A', $ts)
                                        : date('M j', $ts);
                                }
                                $statusClass = htmlspecialchars($s['status'] ?? 'active');
                            ?>
                            <a class="session-card"
                               href="<?php echo BASE_URL; ?>/chat/room?session_id=<?php echo (int)$s['id']; ?>">
                                <div class="session-avatar">🎓</div>
                                <div class="session-info">
                                    <div class="session-name"><?php echo htmlspecialchars($s['other_name'] ?? $s['other_username']); ?></div>
                                    <div class="session-preview"><?php echo $preview; ?></div>
                                </div>
                                <div class="session-meta">
                                    <?php if ($timeLabel): ?>
                                        <div class="session-time"><?php echo $timeLabel; ?></div>
                                    <?php endif; ?>
                                    <span class="session-status-badge <?php echo $statusClass; ?>"><?php echo $statusClass; ?></span>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

            </div><!-- /.chat-page-wrapper -->
        </div><!-- /.main-content -->
    </div><!-- /.main-container -->

<script>
(function () {
    var form = document.getElementById('newChatForm');
    var errEl = document.getElementById('newChatError');

    if (!form) return;

    form.addEventListener('submit', function (e) {
        e.preventDefault();
        var select = document.getElementById('undergradSelect');
        var uid = parseInt(select.value, 10);
        if (!uid) {
            showError('Please select an undergraduate first.');
            return;
        }
        errEl.style.display = 'none';

        var btn = form.querySelector('.btn-start-chat');
        btn.disabled = true;
        btn.textContent = 'Opening…';

        fetch('<?php echo BASE_URL; ?>/api/chat/start', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            credentials: 'same-origin',
            body: JSON.stringify({ undergrad_user_id: uid })
        })
        .then(function (r) { return r.json(); })
        .then(function (data) {
            if (data.success) {
                window.location.href = '<?php echo BASE_URL; ?>/chat/room?session_id=' + data.session_id;
            } else {
                showError(data.message || 'Could not start chat. Please try again.');
                btn.disabled = false;
                btn.textContent = '💬 Open Chat';
            }
        })
        .catch(function () {
            showError('Network error. Please check your connection.');
            btn.disabled = false;
            btn.textContent = '💬 Open Chat';
        });
    });

    function showError(msg) {
        errEl.textContent = msg;
        errEl.style.display = 'block';
    }
})();
</script>
</body>
</html>
