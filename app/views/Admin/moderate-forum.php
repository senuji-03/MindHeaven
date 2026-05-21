<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moderate Forum - Admin | Mind Haven</title>
    <!-- Fonts & Icons (Design System §2, §15) -->
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/admin/style.css">
    <style>
        :root {
            --crisis: #D64F4F;
            --success: #4CAF82;
        }

        /* ── Forum-specific styles ── */
        <?php include '_forum_styles.php'; ?>

        .forum-page-wrapper {
            padding: 0;
            background: var(--surface);
            min-height: 100vh;
        }

        /* Embed (forum preview iframe) */
        .embed {
            background: var(--surface);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border);
            overflow: hidden;
            margin-bottom: 1.5rem;
        }

        .embed-header {
            padding: 1.25rem 1.5rem;
            background: var(--bg-mid);
            border-bottom: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .embed-header strong {
            font-size: 1rem;
            color: var(--text-primary);
            font-weight: 600;
        }

        .chip {
            background: var(--primary-light);
            color: white;
            padding: 0.3rem 0.85rem;
            border-radius: var(--radius-full);
            font-size: 0.8rem;
            font-weight: 600;
        }

        /* Report / Flag list */
        .list {
            background: var(--surface);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--border);
            overflow: hidden;
            margin-bottom: 1.5rem;
        }

        .list-header {
            padding: 1.25rem 1.5rem;
            background: var(--bg-mid);
            border-bottom: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .list-header h2 {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 1rem;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0;
            padding: 0;
            background: none;
            border: none;
        }

        .list h2 {
            padding: 1.25rem 1.5rem;
            background: var(--bg-mid);
            border-bottom: 1px solid var(--border);
            color: var(--text-primary);
            font-size: 1rem;
            font-weight: 700;
            margin: 0;
        }

        .row {
            display: flex;
            align-items: flex-start;
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid var(--border);
            gap: 1rem;
            transition: background 0.2s;
        }

        .row:hover {
            background: var(--bg-mid);
        }

        .row:last-child {
            border-bottom: none;
        }

        .row .title {
            flex: 1;
            font-weight: 500;
            color: var(--text-primary);
        }

        .row .chip {
            padding: 0.3rem 0.7rem;
            font-size: 0.78rem;
        }

        .row .chip:not(.approved) {
            background: var(--bg-soft);
            color: var(--crisis);
        }

        .row .chip.approved {
            background: rgba(76, 175, 130, 0.12);
            color: var(--success);
        }

        .report-details {
            flex: 1;
        }

        .snippet {
            color: var(--text-secondary);
            font-size: 0.88rem;
            margin: 6px 0;
            line-height: 1.5;
        }

        .meta {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            margin-top: 8px;
        }

        .match-highlight {
            background: rgba(214, 79, 79, 0.15);
            padding: 2px 6px;
            border-radius: 4px;
            font-weight: 700;
            color: var(--crisis);
        }

        .actions {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
            align-items: flex-start;
            padding-top: 4px;
        }

    /* Action buttons */
    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 10px 22px;
        border-radius: var(--radius-full);   /* Always pill-shaped */
        font-weight: 600;
        font-size: 0.88rem;
        cursor: pointer;
        transition: all 0.3s ease;
        white-space: nowrap;
        text-decoration: none;
        border: none;
        box-sizing: border-box;
    }
    .btn-outline {
        background: transparent;
        color: var(--primary);
        border: 1.5px solid var(--border);
        padding: 8.5px 20.5px; /* Adjust for border */
    }
    .btn-outline:hover {
        border-color: var(--primary);
        background: var(--bg-mid);
    }
    .btn-primary { background: var(--primary); color: white; }
    .btn-primary:hover {
        background: var(--primary-dark);
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(61, 139, 110, 0.3);
    }
    .btn-danger { background: var(--crisis); color: white; }
    .btn-danger:hover {
        opacity: 0.9;
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(214, 79, 79, 0.3);
    }
    .btn-warning {
        background: rgba(245, 158, 11, 0.12);
        color: #92400e;
        border: 1.5px solid #fcd34d;
        padding: 8.5px 20.5px;
    }
    .btn-warning:hover {
        background: rgba(245, 158, 11, 0.2);
        border-color: #fbbf24;
    }

        /* Alert banners */
        .alert {
            padding: 12px 16px;
            border-radius: var(--radius-sm);
            margin-bottom: 16px;
            font-size: 0.9rem;
        }

        .alert-success {
            background: rgba(76, 175, 130, 0.12);
            border-left: 4px solid var(--success);
            color: var(--success);
        }

        .alert-danger {
            background: rgba(214, 79, 79, 0.1);
            border-left: 4px solid var(--crisis);
            color: var(--crisis);
        }

        /* Modals */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(30, 58, 52, 0.45);
            z-index: 2000;
            align-items: center;
            justify-content: center;
        }

        .modal.active {
            display: flex;
        }

    .modal-content {
        background: var(--surface);
        border-radius: var(--radius-xl);
        padding: 32px;
        width: 90%; max-width: 520px;
        box-shadow: var(--shadow-lg);
        position: relative;
    }

        .modal-content h2 {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 20px;
        }

        .close {
            position: absolute;
            top: 16px;
            right: 20px;
            font-size: 1.5rem;
            cursor: pointer;
            color: var(--text-secondary);
            background: none;
            border: none;
            line-height: 1;
        }

        .close:hover {
            color: var(--crisis);
        }

    .form-row { margin-bottom: 16px; }
    .form-label { display: block; font-size: 0.85rem; font-weight: 600; color: var(--text-primary); margin-bottom: 6px; }
    .form-input {
        width: 100%; padding: 12px 16px;
        border: 1.5px solid var(--border); border-radius: var(--radius-sm);
        font-size: 0.9rem; color: var(--text-primary); background: var(--surface);
        font-family: inherit; resize: vertical;
        box-sizing: border-box;
        transition: border-color 0.25s ease, box-shadow 0.25s ease;
    }
    .form-input:focus {
        outline: none; border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(61,139,110,0.12);
    }
</style>

<div class="forum-page-wrapper">

                <?php if (isset($_SESSION['success'])): ?>
                    <div class="alert alert-success"><?= $_SESSION['success']; ?> <?php unset($_SESSION['success']); ?></div>
                <?php endif; ?>
                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger"><?= $_SESSION['error']; ?> <?php unset($_SESSION['error']); ?></div>
                <?php endif; ?>

    <?php
    $activeTab = isset($_GET['tab']) ? $_GET['tab'] : 'preview';
    include '_forum_tabs.php';
    ?>

    <!-- Forum Preview (iframe) -->
    <section id="forumPreview" class="embed">
        <div class="embed-header">
            <strong>Student Forum Preview</strong>
        </div>
        <iframe src="<?= BASE_URL ?>/forum?embed=true"
            style="width:100%; height:calc(100vh - 240px); min-height:600px; border:0; background:#fff; border-radius: 0 0 var(--radius-lg) var(--radius-lg);"></iframe>
    </section>

    <!-- Flagged / Reported Items -->
    <section id="queueList" class="list" style="display:none;">
        <div class="list-header">
            <h2>🚩 Flagged / Reported Items</h2>
        </div>
        <div id="queue">
            <?php if (empty($reports)): ?>
                <p style="padding:24px; color:var(--text-secondary);">No pending reports.</p>
            <?php else: ?>
                <?php foreach ($reports as $report): ?>
                    <div class="row">
                        <div class="report-details">
                            <span class="title">
                                <strong><?= htmlspecialchars(!empty($report['content_type']) ? $report['content_type'] : 'unknown') ?>:</strong>
                                <?= htmlspecialchars($report['content_title'] ?? 'Unknown/Deleted Content') ?>
                            </span>
                            <p class="snippet"><?= htmlspecialchars($report['content_snippet'] ?? 'Content could not be loaded.') ?></p>
                            <div class="meta">
                                <span class="chip">By: <?= htmlspecialchars($report['reporter_name']) ?></span>
                                <span class="chip">Category: <?= htmlspecialchars($report['category_name']) ?></span>
                                <span class="chip">Reason: <?= htmlspecialchars($report['explanation']) ?></span>
                            </div>
                            <div style="margin-top:6px; font-size:0.88rem; color:var(--text-secondary);">
                                <strong style="color:var(--text-primary);">Owner:</strong> <?= htmlspecialchars($report['owner_name']) ?> &nbsp;|&nbsp;
                                <strong style="color:var(--text-primary);">Strikes:</strong> <span style="color:var(--crisis);"><?= htmlspecialchars($report['strike_count'] ?? 0) ?></span> &nbsp;|&nbsp;
                                <strong style="color:var(--text-primary);">Status:</strong> <?= htmlspecialchars($report['account_status'] ?? 'active') ?>
                            </div>
                        </div>
                        <div class="actions">
                            <form action="<?= BASE_URL ?>/admin/update-report-status" method="POST" style="display:inline;">
                                <input type="hidden" name="report_id" value="<?= $report['id'] ?>">
                                <input type="hidden" name="status" value="resolved">
                                <button type="submit" class="btn btn-outline">Approve (Keep)</button>
                            </form>
                            <button type="button" class="btn btn-warning"
                                onclick="openEditModal(<?= htmlspecialchars(json_encode($report)) ?>)">Edit Content</button>
                            <form action="<?= BASE_URL ?>/admin/update-report-status" method="POST" style="display:inline;">
                                <input type="hidden" name="report_id" value="<?= $report['id'] ?>">
                                <input type="hidden" name="status" value="resolved">
                                <input type="hidden" name="delete_content" value="1">
                                <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('Delete this content? A strike will be added to the user.')">Delete &amp; Resolve</button>
                            </form>
                            <?php if (($report['account_status'] ?? 'active') !== 'suspended' && ($report['account_status'] ?? 'active') !== 'banned'): ?>
                                <button type="button" class="btn btn-danger"
                                    onclick="openSuspendModal(<?= $report['owner_id'] ?>, '<?= htmlspecialchars($report['owner_name']) ?>')">Suspend User</button>
                            <?php endif; ?>
                            <?php if (!empty($report['context_url'])): ?>
                                <a href="<?= htmlspecialchars($report['context_url']) ?>" target="_blank" class="btn btn-outline">View Context</a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </section>

    <!-- Automated System Flags -->
    <section id="autoFlagsList" class="list" style="display:none;">
        <h2>🤖 Automated System Flags</h2>
        <div id="autoQueue">
            <?php if (empty($systemFlags)): ?>
                <p style="padding:24px; color:var(--text-secondary);">No content currently flagged by the system.</p>
            <?php else: ?>
                <?php foreach ($systemFlags as $flag): ?>
                    <div class="row" style="background:#fff8f8; border-left:4px solid var(--crisis);">
                        <div class="report-details">
                            <span class="title">
                                <strong><?= htmlspecialchars(!empty($flag['content_type']) ? $flag['content_type'] : 'unknown') ?>:</strong>
                                <?= htmlspecialchars($flag['content_title'] ?? 'Unknown/Deleted Content') ?>
                            </span>
                            <p class="snippet"><?= htmlspecialchars($flag['content_snippet'] ?? 'Content could not be loaded.') ?></p>
                            <div style="margin-top:6px; font-size:0.88rem; color:var(--text-secondary);">
                                <strong style="color:var(--text-primary);">Keyword:</strong> <span class="match-highlight"><?= htmlspecialchars($flag['matched_keyword']) ?></span> &nbsp;|&nbsp;
                                <strong style="color:var(--text-primary);">Owner:</strong> <?= htmlspecialchars($flag['owner_name']) ?> &nbsp;|&nbsp;
                                <strong style="color:var(--text-primary);">Strikes:</strong> <span style="color:var(--crisis);"><?= htmlspecialchars($flag['strike_count'] ?? 0) ?></span> &nbsp;|&nbsp;
                                <strong style="color:var(--text-primary);">Status:</strong> <?= htmlspecialchars($flag['account_status'] ?? 'active') ?>
                            </div>
                            <div class="meta" style="margin-top:6px;">
                                <span class="chip">Date: <?= htmlspecialchars($flag['created_at']) ?></span>
                            </div>
                        </div>
                        <div class="actions">
                            <form action="<?= BASE_URL ?>/admin/update-system-flag-status" method="POST" style="display:inline;">
                                <input type="hidden" name="id" value="<?= $flag['id'] ?>">
                                <input type="hidden" name="status" value="reviewed">
                                <button type="submit" class="btn btn-outline">Approve (Keep)</button>
                            </form>
                            <button type="button" class="btn btn-warning"
                                onclick="openEditModal(<?= htmlspecialchars(json_encode($flag)) ?>, true)">Edit Content</button>
                            <form action="<?= BASE_URL ?>/admin/update-system-flag-status" method="POST" style="display:inline;">
                                <input type="hidden" name="id" value="<?= $flag['id'] ?>">
                                <input type="hidden" name="status" value="resolved">
                                <input type="hidden" name="delete_content" value="1">
                                <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('Delete this content? A strike will be added to the user.')">Delete &amp; Resolve</button>
                            </form>
                            <?php if (($flag['account_status'] ?? 'active') !== 'suspended' && ($flag['account_status'] ?? 'active') !== 'banned'): ?>
                                <button type="button" class="btn btn-danger"
                                    onclick="openSuspendModal(<?= $flag['owner_id'] ?>, '<?= htmlspecialchars($flag['owner_name']) ?>')">Suspend User</button>
                            <?php endif; ?>
                            <?php if (!empty($flag['context_url'])): ?>
                                <a href="<?= htmlspecialchars($flag['context_url']) ?>" target="_blank" class="btn btn-outline">View Context</a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </section>

</div><!-- /.forum-page-wrapper -->

<!-- Edit Content Modal -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <button class="close" onclick="closeEditModal()">&times;</button>
        <h2>✏️ Edit Reported Content</h2>
        <form action="<?= BASE_URL ?>/admin/edit-reported-content" method="POST">
            <input type="hidden" name="report_id" id="editReportId">
            <input type="hidden" name="flag_id" id="editFlagId">
            <input type="hidden" name="post_id" id="editPostId">
            <div class="form-row">
                <label for="editContent" class="form-label">Content:</label>
                <textarea name="content" id="editContent" rows="6" class="form-input"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Save Changes</button>
        </form>
    </div>
</div>

<!-- Suspend User Modal -->
<div id="suspendModal" class="modal">
    <div class="modal-content">
        <button class="close" onclick="closeSuspendModal()">&times;</button>
        <h2>🔒 Suspend User</h2>
        <p style="color:var(--text-secondary); margin-bottom:16px;">Suspending: <strong id="suspendUserName" style="color:var(--text-primary);"></strong></p>
        <form action="<?= BASE_URL ?>/admin/suspend-user" method="POST">
            <input type="hidden" name="user_id" id="suspendUserId">
            <div class="form-row">
                <label for="suspensionDays" class="form-label">Duration:</label>
                <select name="suspension_days" id="suspensionDays" class="form-input">
                    <option value="1">1 Day</option>
                    <option value="3">3 Days</option>
                    <option value="7">7 Days</option>
                    <option value="30">30 Days</option>
                    <option value="">Indefinite</option>
                </select>
            </div>
            <button type="submit" class="btn btn-danger">Confirm Suspension</button>
        </form>
    </div>
</div>

<script>
    // Tab switching
    document.querySelectorAll('.tab[data-tab]').forEach(function(tabBtn) {
        tabBtn.addEventListener('click', function(e) {
            e.preventDefault();
            document.querySelectorAll('.tab').forEach(function(t) { t.classList.remove('active'); });
            this.classList.add('active');
            var tab = this.dataset.tab;
            if (tab) {
                document.getElementById('forumPreview').style.display  = tab === 'preview'    ? 'block' : 'none';
                document.getElementById('queueList').style.display     = tab === 'queue'      ? 'block' : 'none';
                document.getElementById('autoFlagsList').style.display = tab === 'auto-flags' ? 'block' : 'none';
                var newUrl = new URL(window.location);
                newUrl.searchParams.set('tab', tab);
                window.history.pushState({}, '', newUrl);
            }
        });
    });

    window.addEventListener('load', function() {
        var tab = new URLSearchParams(window.location.search).get('tab');
        if (tab) {
            var tabBtn = document.querySelector('.tab[data-tab="' + tab + '"]');
            if (tabBtn) tabBtn.click();
        }
    });

    // Edit modal
    var editModal = document.getElementById('editModal');
    function openEditModal(item, isSystemFlag) {
        if (isSystemFlag) {
            document.getElementById('editFlagId').value  = item.id;
            document.getElementById('editReportId').value = '';
        } else {
            document.getElementById('editReportId').value = item.id;
            document.getElementById('editFlagId').value   = '';
        }
        document.getElementById('editPostId').value = item.content_id;
        var txt = document.createElement('textarea');
        txt.innerHTML = item.full_content || item.content_snippet;
        document.getElementById('editContent').value = txt.value;
        editModal.style.display = 'flex';
    }
    function closeEditModal() { editModal.style.display = 'none'; }

    // Suspend modal
    var suspendModal = document.getElementById('suspendModal');
    function openSuspendModal(userId, userName) {
        document.getElementById('suspendUserId').value = userId;
        document.getElementById('suspendUserName').textContent = userName;
        suspendModal.style.display = 'flex';
    }
    function closeSuspendModal() { suspendModal.style.display = 'none'; }

    window.onclick = function(event) {
        if (event.target === editModal)   closeEditModal();
        if (event.target === suspendModal) closeSuspendModal();
    };
</script>

            </div> <!-- .forum-page-wrapper -->
        </div> <!-- .content-wrapper -->
    </div> <!-- .main-content -->

    <script src="<?= BASE_URL ?>/js/Admin/script.js"></script>
</body>

</html>
