<?php
/**
 * Undergrad Chat Inbox
 * Lists all active chat sessions this undergrad has with counselors.
 * The undergrad cannot start new sessions (counselors initiate).
 */

$TITLE        = 'MindHeaven — My Chats';
$CURRENT_PAGE = 'chat';
$PAGE_CSS     = ['/MindHeaven/public/css/chat/chat.css'];

require BASE_PATH . '/app/views/layouts/header.php';

$sessions = isset($sessions) ? $sessions : [];
?>

<main id="main" style="padding:2rem; max-width:860px; margin:0 auto;">

    <div class="chat-page">

        <!-- Page Header -->
        <div class="chat-list-header" style="margin-bottom:2rem;">
            <h1 style="font-size:1.75rem; font-weight:700; background:linear-gradient(135deg,#6366f1,#0ea5e9);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;margin:0;">
                💬 My Counselling Chats
            </h1>
            <span class="secure-badge">🔒 Private & Secure</span>
        </div>

        <!-- Info Note -->
        <div style="background:rgba(14,165,233,0.08);border:1px solid rgba(14,165,233,0.2);border-radius:12px;padding:1rem 1.25rem;margin-bottom:1.5rem;font-size:0.85rem;color:#94a3b8;">
            ℹ️ Your counselor will open a chat with you. Only you and your counselor can see this conversation.
        </div>

        <!-- Sessions List -->
        <p class="sessions-label">Your conversations</p>

        <?php if (empty($sessions)): ?>
            <div class="empty-chat-state">
                <div class="empty-icon">💬</div>
                <h3>No chats yet</h3>
                <p>Your counselor will start a chat once your appointment is confirmed. Check back soon!</p>
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
                        <div class="session-avatar">🧑‍💼</div>
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

    </div><!-- /.chat-page -->
</main>

<?php require BASE_PATH . '/app/views/layouts/footer.php'; ?>
