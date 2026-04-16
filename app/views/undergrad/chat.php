<?php
/**
 * Undergrad Chat Inbox
 * Lists all active chat sessions this undergrad has with counselors.
 * The undergrad cannot start new sessions (counselors initiate).
 */

$TITLE        = 'MindHeaven — My Chats';
$CURRENT_PAGE = 'chat';
// Remove dark-mode distinct chat.css to adopt global theme via inline styles/classes
require BASE_PATH . '/app/views/layouts/header.php';

$sessions = isset($sessions) ? $sessions : [];
?>

<style>
/* Local alignment to match Mood/Habits grids */
.dashboard-main {
    padding: 16px 28px;
    max-width: 1200px;
    margin: 0 auto;
    font-family: 'DM Sans', system-ui, sans-serif;
}

.chat-hero {
    background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 55%, var(--primary-light) 100%);
    border-radius: var(--radius-lg);
    padding: 24px 32px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    box-shadow: var(--shadow-lg);
    margin-bottom: 24px;
    position: relative;
    overflow: hidden;
}

.chat-hero::after {
    content: '';
    position: absolute;
    width: 150px;
    height: 150px;
    border-radius: 50%;
    background: rgba(232,168,124,0.15);
    bottom: -40px;
    left: 15%;
}

.chat-hero-content {
    position: relative;
    z-index: 1;
}

.chat-hero-title {
    color: #fff;
    font-size: 2rem;
    font-weight: 700;
    margin: 0 0 6px 0;
    letter-spacing: -0.5px;
}

.chat-hero-subtitle {
    color: rgba(255,255,255,0.85);
    font-size: 1rem;
    margin: 0;
}

.secure-badge {
    background: rgba(255,255,255,0.2);
    border: 1px solid rgba(255,255,255,0.3);
    color: #fff;
    padding: 6px 14px;
    border-radius: var(--radius-full);
    font-size: 0.8rem;
    font-weight: 600;
    z-index: 1;
}

.chat-container {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-sm);
    padding: 24px;
}

.chat-list-title {
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 16px;
    display: flex;
    align-items: center;
    gap: 8px;
}
.chat-list-title i { color: var(--primary); }

.info-note {
    background: var(--bg-mid);
    border: 1px solid var(--border);
    border-radius: var(--radius-md);
    padding: 16px;
    margin-bottom: 24px;
    font-size: 0.9rem;
    color: var(--text-secondary);
    display: flex;
    align-items: center;
    gap: 12px;
}
.info-note i { color: var(--accent-calm); font-size: 1.2rem; }

.session-card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius-md);
    padding: 18px 24px;
    display: flex;
    align-items: center;
    gap: 16px;
    text-decoration: none;
    color: var(--text-primary);
    transition: all 0.2s ease;
    margin-bottom: 12px;
}

.session-card:hover {
    background: var(--bg-mid);
    border-color: var(--primary-light);
    transform: translateY(-2px);
    box-shadow: var(--shadow-sm);
}

.session-avatar {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--accent-calm), var(--primary-light));
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 1.4rem;
    flex-shrink: 0;
    font-weight: 700;
}

.session-info {
    flex: 1;
    min-width: 0;
}

.session-name {
    font-weight: 700;
    font-size: 1.05rem;
    color: var(--text-primary);
    margin-bottom: 4px;
}

.session-preview {
    font-size: 0.88rem;
    color: var(--text-secondary);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.session-meta {
    text-align: right;
    flex-shrink: 0;
}

.session-time {
    font-size: 0.8rem;
    color: var(--text-secondary);
    margin-bottom: 6px;
}

.status-badge {
    display: inline-block;
    padding: 4px 10px;
    border-radius: var(--radius-full);
    font-size: 0.72rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}
.status-badge.active { background: var(--bg-mid); color: var(--success); border: 1px solid var(--border); }
.status-badge.closed { background: #FEF2F2; color: var(--crisis); border: 1px solid #FECACA; }

.empty-state {
    text-align: center;
    padding: 48px;
}
.empty-state i {
    font-size: 3rem;
    color: var(--border);
    margin-bottom: 16px;
}
.empty-state h3 { font-size: 1.2rem; color: var(--text-primary); margin-bottom: 8px; }
.empty-state p { color: var(--text-secondary); max-width: 400px; margin: 0 auto; line-height: 1.6; }
</style>

<main id="main" class="dashboard-main">

    <!-- Hero Header -->
    <div class="chat-hero">
        <div class="chat-hero-content">
            <h1 class="chat-hero-title"><i class="fa-regular fa-comments"></i> Counselling Chats</h1>
            <p class="chat-hero-subtitle">Secure, confidential messaging with your counselor.</p>
        </div>
        <span class="secure-badge"><i class="fas fa-lock"></i> Private & Secure</span>
    </div>

    <!-- Main Content Container -->
    <div class="chat-container">

        <!-- Info Note -->
        <div class="info-note">
            <i class="fas fa-info-circle"></i>
            <div>Your counselor will initiate a chat with you based on your appointments. These conversations are strictly confidential and encrypted.</div>
        </div>

        <h2 class="chat-list-title"><i class="fas fa-inbox"></i> Your Conversations</h2>

        <!-- Sessions List -->
        <?php if (empty($sessions)): ?>
            <div class="empty-state">
                <i class="fas fa-comments"></i>
                <h3>No active chats</h3>
                <p>You don't have any open conversations yet. Your counselor will start a chat here when your session begins.</p>
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
                        $initials = strtoupper(substr($s['other_name'] ?? $s['other_username'] ?? 'C', 0, 1));
                    ?>
                    <a class="session-card" href="<?php echo BASE_URL; ?>/chat/room?session_id=<?php echo (int)$s['id']; ?>">
                        <div class="session-avatar"><?php echo $initials; ?></div>
                        <div class="session-info">
                            <div class="session-name"><?php echo htmlspecialchars($s['other_name'] ?? $s['other_username']); ?></div>
                            <div class="session-preview"><?php echo $preview; ?></div>
                        </div>
                        <div class="session-meta">
                            <?php if ($timeLabel): ?>
                                <div class="session-time"><?php echo $timeLabel; ?></div>
                            <?php endif; ?>
                            <span class="status-badge <?php echo $statusClass; ?>"><?php echo $statusClass; ?></span>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    </div>
</main>

<?php require BASE_PATH . '/app/views/layouts/footer.php'; ?>
