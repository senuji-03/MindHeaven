<?php
/**
 * Chat Room — shared by counselor and undergrad.
 * Server-renders initial messages; manual refresh loads new ones via fetch().
 *
 * Variables injected by ChatControl::room():
 *   $session   - chat_sessions row
 *   $messages  - array of chat_messages rows
 *   $otherName - display name of the other participant
 *   $userId    - current user's ID (int)
 *   $sessionId - current session ID (int)
 */

$session   = isset($session)   ? $session   : [];
$messages  = isset($messages)  ? $messages  : [];
$otherName = isset($otherName) ? $otherName : 'Unknown';
$userId    = isset($userId)    ? (int)$userId    : 0;
$sessionId = isset($sessionId) ? (int)$sessionId : 0;

// Determine if the current user is the counselor or undergrad
$isCounselor = isset($session['counselor_user_id']) && (int)$session['counselor_user_id'] === $userId;
$backUrl = BASE_URL . '/chat';

// Helper: format timestamp
function fmt_time(string $ts): string {
    $t = strtotime($ts);
    return date('g:i A', $t);
}
function fmt_date(string $ts): string {
    $t = strtotime($ts);
    $today = date('Y-m-d');
    $day   = date('Y-m-d', $t);
    if ($day === $today) return 'Today';
    if ($day === date('Y-m-d', strtotime('-1 day'))) return 'Yesterday';
    return date('M j, Y', $t);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat with <?php echo htmlspecialchars($otherName); ?> — MindHeaven</title>
    <meta name="description" content="Private counselling chat session on MindHeaven.">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/css/chat/chat.css">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { background: #0f172a; }
    </style>
</head>
<body class="chat-room-body">

<!-- ── Room Header ──────────────────────────────────────────────────────── -->
<header class="room-header">
    <a href="<?php echo $backUrl; ?>" class="room-back-btn" title="Back to chats">← Back</a>

    <div class="room-avatar"><?php echo $isCounselor ? '🎓' : '🧑‍💼'; ?></div>

    <div class="room-user-info">
        <div class="room-user-name"><?php echo htmlspecialchars($otherName); ?></div>
        <div class="room-user-role"><?php echo $isCounselor ? 'Undergraduate Student' : 'Counselor'; ?></div>
    </div>

    <span class="secure-badge" style="margin-left:auto; margin-right:0.75rem;">🔒 Secure</span>

    <button class="room-refresh-btn" id="refreshBtn" onclick="refreshMessages()">
        <span class="refresh-icon">↻</span> Refresh
    </button>
</header>

<!-- ── Messages Area ─────────────────────────────────────────────────────── -->
<div class="messages-area" id="messagesArea">
    <?php if (empty($messages)): ?>
        <div class="messages-empty" id="emptyState">
            <div class="empty-icon">💬</div>
            <p>No messages yet. Send the first message to start the conversation!</p>
        </div>
    <?php else: ?>
        <?php
        $lastDate = '';
        foreach ($messages as $msg):
            $msgDate  = fmt_date($msg['created_at']);
            $msgTime  = fmt_time($msg['created_at']);
            $isOwn    = ((int)$msg['sender_user_id'] === $userId);
            $rowClass = $isOwn ? 'own' : 'other';
            $canEdit  = $isOwn && ((int)$msg['minutes_since_sent'] <= 15);
        ?>
        <?php if ($msgDate !== $lastDate): $lastDate = $msgDate; ?>
            <div class="date-divider"><?php echo htmlspecialchars($msgDate); ?></div>
        <?php endif; ?>

        <div class="message-row <?php echo $rowClass; ?>"
             id="msg-<?php echo (int)$msg['id']; ?>"
             data-id="<?php echo (int)$msg['id']; ?>"
             data-own="<?php echo $isOwn ? '1' : '0'; ?>">

            <?php if (!$isOwn): ?>
                <div class="message-sender"><?php echo htmlspecialchars($msg['sender_name']); ?></div>
            <?php endif; ?>

            <div class="message-bubble" id="bubble-<?php echo (int)$msg['id']; ?>">
                <?php echo htmlspecialchars($msg['message']); ?>
            </div>

            <div class="message-meta">
                <span class="message-time"><?php echo $msgTime; ?></span>
                <?php if ($msg['edited_at']): ?>
                    <span class="edited-tag">(edited)</span>
                <?php endif; ?>
            </div>

            <?php if ($isOwn): ?>
            <!-- Action buttons (visible on hover via CSS) -->
            <div class="message-actions">
                <?php if ($canEdit): ?>
                <button class="msg-action-btn edit-btn"
                        onclick="openEdit(<?php echo (int)$msg['id']; ?>)"
                        title="Edit message">
                    ✏️ Edit
                </button>
                <?php endif; ?>
                <button class="msg-action-btn delete-btn"
                        onclick="deleteMsg(<?php echo (int)$msg['id']; ?>)"
                        title="Delete message">
                    🗑 Delete
                </button>
            </div>

            <!-- Inline edit form -->
            <div class="inline-edit-form" id="editForm-<?php echo (int)$msg['id']; ?>">
                <textarea class="inline-edit-input"
                          id="editInput-<?php echo (int)$msg['id']; ?>"
                          rows="2"><?php echo htmlspecialchars($msg['message']); ?></textarea>
                <div class="inline-edit-actions">
                    <button class="inline-save-btn"
                            onclick="saveEdit(<?php echo (int)$msg['id']; ?>)">Save</button>
                    <button class="inline-cancel-btn"
                            onclick="cancelEdit(<?php echo (int)$msg['id']; ?>)">Cancel</button>
                </div>
            </div>
            <?php endif; ?>

        </div><!-- /.message-row -->
        <?php endforeach; ?>
    <?php endif; ?>
</div><!-- /#messagesArea -->

<!-- ── Toast Notification ───────────────────────────────────────────────── -->
<div class="chat-toast" id="chatToast"></div>

<!-- ── Input Bar ─────────────────────────────────────────────────────────── -->
<div class="input-bar">
    <textarea class="message-input"
              id="messageInput"
              placeholder="Type your message… (Enter to send, Shift+Enter for new line)"
              rows="1"
              maxlength="4000"
              autocomplete="off"></textarea>
    <button class="send-btn" id="sendBtn" onclick="sendMessage()" title="Send message" disabled>
        ➤
    </button>
</div>

<!-- ── JavaScript ────────────────────────────────────────────────────────── -->
<script>
/* ========================================================================
   MindHeaven Secure Chat — Room JS
   No external libraries. Vanilla JS + native fetch.
======================================================================== */

var SESSION_ID  = <?php echo $sessionId; ?>;
var CURRENT_UID = <?php echo $userId; ?>;
var BASE_API    = '<?php echo BASE_URL; ?>/api/chat';

/* scroll to bottom of messages */
function scrollToBottom() {
    var area = document.getElementById('messagesArea');
    if (area) area.scrollTop = area.scrollHeight;
}

/* ── Toast ────────────────────────────────────────────────────────────── */
function showToast(msg, type) {
    var el = document.getElementById('chatToast');
    el.textContent = msg;
    el.className = 'chat-toast ' + (type || '');
    void el.offsetWidth; // reflow
    el.classList.add('show');
    setTimeout(function () { el.classList.remove('show'); }, 3000);
}

/* ── Enable/disable send button ───────────────────────────────────────── */
document.getElementById('messageInput').addEventListener('input', function () {
    var btn = document.getElementById('sendBtn');
    btn.disabled = this.value.trim() === '';
    // Auto-resize textarea
    this.style.height = 'auto';
    this.style.height = Math.min(this.scrollHeight, 120) + 'px';
});

/* Enter to send, Shift+Enter for new line */
document.getElementById('messageInput').addEventListener('keydown', function (e) {
    if (e.key === 'Enter' && !e.shiftKey) {
        e.preventDefault();
        if (this.value.trim() !== '') sendMessage();
    }
});

/* ── SEND (CREATE) ────────────────────────────────────────────────────── */
function sendMessage() {
    var input = document.getElementById('messageInput');
    var text  = input.value.trim();
    if (!text) return;

    var btn = document.getElementById('sendBtn');
    btn.disabled = true;

    fetch(BASE_API + '/send', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        credentials: 'same-origin',
        body: JSON.stringify({ session_id: SESSION_ID, message: text })
    })
    .then(function (r) { return r.json(); })
    .then(function (data) {
        if (data.success) {
            input.value = '';
            input.style.height = 'auto';
            btn.disabled = true;
            refreshMessages(); // reload to show the new message
        } else {
            showToast(data.message || 'Failed to send', 'error');
            btn.disabled = false;
        }
    })
    .catch(function () {
        showToast('Network error. Please try again.', 'error');
        btn.disabled = false;
    });
}

/* ── REFRESH (READ) ───────────────────────────────────────────────────── */
function refreshMessages() {
    var btn = document.getElementById('refreshBtn');
    btn.classList.add('spinning');
    btn.disabled = true;

    fetch(BASE_API + '/messages?session_id=' + SESSION_ID, {
        method: 'GET',
        credentials: 'same-origin'
    })
    .then(function (r) { return r.json(); })
    .then(function (data) {
        if (data.success) {
            renderMessages(data.messages);
        } else {
            showToast(data.message || 'Could not load messages.', 'error');
        }
    })
    .catch(function () {
        showToast('Network error while refreshing.', 'error');
    })
    .finally(function () {
        btn.classList.remove('spinning');
        btn.disabled = false;
    });
}

/* ── Render message list from API response ────────────────────────────── */
function renderMessages(msgs) {
    var area = document.getElementById('messagesArea');
    if (!msgs || msgs.length === 0) {
        area.innerHTML = '<div class="messages-empty" id="emptyState"><div class="empty-icon">💬</div><p>No messages yet. Send the first message to start the conversation!</p></div>';
        return;
    }

    var html = '';
    var lastDate = '';

    msgs.forEach(function (msg) {
        var isOwn    = parseInt(msg.sender_user_id, 10) === CURRENT_UID;
        var rowClass = isOwn ? 'own' : 'other';
        var canEdit  = isOwn && parseInt(msg.minutes_since_sent, 10) <= 15;
        var msgDate  = fmtDate(msg.created_at);
        var msgTime  = fmtTime(msg.created_at);

        if (msgDate !== lastDate) {
            lastDate = msgDate;
            html += '<div class="date-divider">' + escHtml(msgDate) + '</div>';
        }

        html += '<div class="message-row ' + rowClass + '" id="msg-' + msg.id + '" data-id="' + msg.id + '" data-own="' + (isOwn ? '1' : '0') + '">';

        if (!isOwn) {
            html += '<div class="message-sender">' + escHtml(msg.sender_name) + '</div>';
        }

        html += '<div class="message-bubble" id="bubble-' + msg.id + '">' + escHtml(msg.message) + '</div>';
        html += '<div class="message-meta"><span class="message-time">' + msgTime + '</span>';
        if (msg.edited_at) html += '<span class="edited-tag">(edited)</span>';
        html += '</div>';

        if (isOwn) {
            html += '<div class="message-actions">';
            if (canEdit) {
                html += '<button class="msg-action-btn edit-btn" onclick="openEdit(' + msg.id + ')" title="Edit">✏️ Edit</button>';
            }
            html += '<button class="msg-action-btn delete-btn" onclick="deleteMsg(' + msg.id + ')" title="Delete">🗑 Delete</button>';
            html += '</div>';

            html += '<div class="inline-edit-form" id="editForm-' + msg.id + '">'
                  + '<textarea class="inline-edit-input" id="editInput-' + msg.id + '" rows="2">' + escHtml(msg.message) + '</textarea>'
                  + '<div class="inline-edit-actions">'
                  + '<button class="inline-save-btn" onclick="saveEdit(' + msg.id + ')">Save</button>'
                  + '<button class="inline-cancel-btn" onclick="cancelEdit(' + msg.id + ')">Cancel</button>'
                  + '</div></div>';
        }

        html += '</div>';
    });

    area.innerHTML = html;
    scrollToBottom();
}

/* ── EDIT helpers ────────────────────────────────────────────────────── */
function openEdit(id) {
    document.getElementById('editForm-' + id).classList.add('visible');
    var inp = document.getElementById('editInput-' + id);
    inp.focus();
    inp.setSelectionRange(inp.value.length, inp.value.length);
}

function cancelEdit(id) {
    document.getElementById('editForm-' + id).classList.remove('visible');
}

/* ── EDIT (UPDATE) ────────────────────────────────────────────────────── */
function saveEdit(id) {
    var newText = document.getElementById('editInput-' + id).value.trim();
    if (!newText) { showToast('Message cannot be empty.', 'error'); return; }

    fetch(BASE_API + '/edit', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        credentials: 'same-origin',
        body: JSON.stringify({ message_id: id, message: newText })
    })
    .then(function (r) { return r.json(); })
    .then(function (data) {
        if (data.success) {
            // Update bubble text in place without full reload
            var bubble = document.getElementById('bubble-' + id);
            if (bubble) bubble.textContent = newText;
            cancelEdit(id);
            // Add edited tag if not already present
            var row = document.getElementById('msg-' + id);
            if (row && !row.querySelector('.edited-tag')) {
                var meta = row.querySelector('.message-meta');
                if (meta) {
                    var tag = document.createElement('span');
                    tag.className = 'edited-tag';
                    tag.textContent = '(edited)';
                    meta.appendChild(tag);
                }
            }
            showToast('Message updated.', 'success');
        } else {
            showToast(data.message || 'Could not edit message.', 'error');
        }
    })
    .catch(function () { showToast('Network error.', 'error'); });
}

/* ── DELETE (soft) ────────────────────────────────────────────────────── */
function deleteMsg(id) {
    if (!confirm('Delete this message? This cannot be undone.')) return;

    fetch(BASE_API + '/delete', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        credentials: 'same-origin',
        body: JSON.stringify({ message_id: id })
    })
    .then(function (r) { return r.json(); })
    .then(function (data) {
        if (data.success) {
            var el = document.getElementById('msg-' + id);
            if (el) {
                el.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
                el.style.opacity = '0';
                el.style.transform = 'scale(0.95)';
                setTimeout(function () { el.remove(); }, 300);
            }
            showToast('Message deleted.', 'success');
        } else {
            showToast(data.message || 'Could not delete message.', 'error');
        }
    })
    .catch(function () { showToast('Network error.', 'error'); });
}

/* ── Date/time helpers ───────────────────────────────────────────────── */
function fmtTime(ts) {
    var d = new Date(ts.replace(' ', 'T'));
    return d.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
}
function fmtDate(ts) {
    var d   = new Date(ts.replace(' ', 'T'));
    var now = new Date();
    var today    = new Date(now.getFullYear(), now.getMonth(), now.getDate());
    var yesterday = new Date(today - 86400000);
    var day = new Date(d.getFullYear(), d.getMonth(), d.getDate());
    if (day.getTime() === today.getTime())     return 'Today';
    if (day.getTime() === yesterday.getTime()) return 'Yesterday';
    return d.toLocaleDateString([], { month: 'short', day: 'numeric', year: 'numeric' });
}

/* ── XSS-safe HTML escaper ───────────────────────────────────────────── */
function escHtml(str) {
    return String(str)
        .replace(/&/g,  '&amp;')
        .replace(/</g,  '&lt;')
        .replace(/>/g,  '&gt;')
        .replace(/"/g,  '&quot;')
        .replace(/'/g,  '&#039;');
}

/* ── Init ────────────────────────────────────────────────────────────── */
scrollToBottom();
</script>

</body>
</html>
