<?php
$TITLE = 'Call Responder — Crisis Dashboard';
$CURRENT_PAGE = 'responder_dashboard';
// Make sure this path uses standard header if they have one, or create custom HTML.
// Using standard header:
require BASE_PATH . '/app/views/layouts/header.php';
?>

<script crossorigin src="https://unpkg.com/@daily-co/daily-js"></script>

<style>
    .responder-layout {
        max-width: 1200px;
        margin: 40px auto;
        padding: 0 24px;
        display: grid;
        grid-template-columns: 350px 1fr;
        gap: 30px;
    }

    .mh-panel {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius-lg);
        padding: 24px;
        box-shadow: var(--shadow-sm);
    }

    .call-item {
        background: var(--bg-mid);
        border: 1px solid var(--border);
        border-radius: var(--radius-md);
        padding: 16px;
        margin-bottom: 12px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .call-item .time { font-size: 0.8rem; color: var(--text-secondary); }
    .call-item .name { font-size: 1rem; font-weight: 600; color: var(--text-primary); }

    .pulse {
        color: var(--crisis);
        animation: blink 1.5s infinite;
    }
    @keyframes blink { 50% { opacity: 0.4; } }
</style>

<div class="responder-layout">
    
    <!-- LEFT PANEL: WAITLIST -->
    <div class="mh-panel">
        <h2 style="font-size:1.4rem;margin-bottom:20px;border-bottom:1px solid var(--border);padding-bottom:12px;">
            <i class="fas fa-bell pulse"></i> Incoming Crisis Calls
        </h2>
        <div id="waitingCallsList">
            <p style="color:var(--text-secondary);font-size:0.9rem;">Polling for incoming callers...</p>
        </div>
    </div>

    <!-- RIGHT PANEL: ACTIVE CALL WORKSPACE -->
    <div class="mh-panel" style="display:flex;flex-direction:column;">
        <h2 style="font-size:1.4rem;margin-bottom:20px;">Active Call Workspace</h2>

        <div id="noCallState" style="flex:1;display:flex;justify-content:center;align-items:center;color:var(--text-secondary);background:var(--bg-soft);border-radius:var(--radius-md);border:1.5px dashed var(--border);">
            <div style="text-align:center;">
                <i class="fas fa-headset" style="font-size:3rem;margin-bottom:16px;opacity:0.5;"></i>
                <p>Waiting for you to answer a call...</p>
            </div>
        </div>

        <!-- ACTIVE CALL CONTAINER -->
        <div id="activeCallContainer" style="display:none;flex-direction:column;flex:1;">
            
            <div style="display:flex;justify-content:space-between;margin-bottom:20px;align-items:center;">
                <div>
                    <h3 id="currentCallerName" style="color:var(--text-primary);margin:0;">Caller Name</h3>
                    <span style="font-size:0.85rem;color:var(--success);">Connected <span id="callDuration">00:00</span></span>
                </div>
                <button class="mh-btn mh-btn--danger" onclick="endCall()"><i class="fas fa-phone-slash"></i> Wrap Up Call</button>
            </div>

            <!-- Prebuilt iframe goes here -->
            <div id="dailyIframePlaceholder" style="width:100%; height:300px; background:#111; border-radius:var(--radius-md); overflow:hidden; margin-bottom:20px;"></div>

            <!-- Notes Section -->
            <label class="form-label">Intervention Notes (Internal Only)</label>
            <textarea id="callNotes" class="form-input" style="flex:1;min-height:150px;resize:none;" placeholder="Document risk assessment, coping strategies, and follow-up plan..."></textarea>
            
            <div style="text-align:right;margin-top:16px;">
                <button class="mh-btn mh-btn--primary" onclick="saveNotes()">Save Record</button>
            </div>
            
        </div>
    </div>
</div>

<script>
let currentCallId = null;
let currentCallFrame = null;
let pollInterval = null;

// Poll for waiting calls
async function fetchWaitingCalls() {
    try {
        const res = await fetch('/MindHeaven/public/api/crisis/waiting');
        const data = await res.json();
        const list = document.getElementById('waitingCallsList');
        
        if (!data.calls || data.calls.length === 0) {
            list.innerHTML = '<p style="color:var(--text-secondary);font-size:0.9rem;">No callers waiting.</p>';
            return;
        }

        list.innerHTML = data.calls.map(c => `
            <div class="call-item">
                <div>
                    <div class="name">${c.caller_name || 'Anonymous Student'} <span style="font-size:0.7rem;background:var(--crisis);color:white;padding:2px 6px;border-radius:4px;margin-left:4px;">EMERGENCY</span></div>
                    <div class="time">Waiting Since: ${new Date(c.created_at).toLocaleTimeString()}</div>
                </div>
                <button class="mh-btn" style="background:var(--success);color:white;font-size:0.85rem;" onclick="answerCall(${c.id}, '${c.caller_name || 'Anonymous'}')">
                    <i class="fas fa-phone"></i> Answer
                </button>
            </div>
        `).join('');

    } catch (err) {
        console.error("Polling error", err);
    }
}

async function answerCall(callId, callerName) {
    if (currentCallId) {
        alert("You are already on an active call. Wrap it up first.");
        return;
    }

    try {
        const res = await fetch('/MindHeaven/public/api/crisis/answer', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ call_id: callId })
        });
        const data = await res.json();

        if (data.url) {
            currentCallId = callId;
            document.getElementById('currentCallerName').innerText = callerName;
            document.getElementById('noCallState').style.display = 'none';
            document.getElementById('activeCallContainer').style.display = 'flex';

            // Launch Daily
            const placeholder = document.getElementById('dailyIframePlaceholder');
            placeholder.innerHTML = '';
            
            currentCallFrame = window.DailyIframe.createFrame(placeholder, {
                iframeStyle: { width: '100%', height: '100%', border: '0' },
                dailyConfig: {
                    startVideoOff: true,  // Important: Audio Only
                    startAudioOff: false
                }
            });

            currentCallFrame.on('left-meeting', () => { endCallUI(); });
            await currentCallFrame.join({ url: data.url });

            fetchWaitingCalls(); // Refresh list immediately
        }
    } catch(err) {
        alert("Failed to connect to call.");
    }
}

function endCallUI() {
    if (currentCallFrame) {
        currentCallFrame.leave();
        currentCallFrame.destroy();
        currentCallFrame = null;
    }
}

function endCall() {
    endCallUI();
    // They can still edit notes until they hit "Save Record"
}

async function saveNotes() {
    if (!currentCallId) return;

    const notes = document.getElementById('callNotes').value;
    
    try {
        const res = await fetch('/MindHeaven/public/api/crisis/update', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ call_id: currentCallId, status: 'completed', notes: notes })
        });
        const data = await res.json();
        
        if (data.success) {
            alert('Call record securely saved!');
            document.getElementById('callNotes').value = '';
            document.getElementById('activeCallContainer').style.display = 'none';
            document.getElementById('noCallState').style.display = 'flex';
            currentCallId = null;
        }
    } catch(err) {
        alert("Failed to save notes.");
    }
}

// Start polling
pollInterval = setInterval(fetchWaitingCalls, 3000);
fetchWaitingCalls();

</script>

<?php require BASE_PATH . '/app/views/layouts/footer.php'; ?>
