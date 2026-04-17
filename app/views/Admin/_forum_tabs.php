<?php
// Shared Navigation Tabs for Moderate Forum Module
// $activeTab should be set by the including page (preview, queue, auto-flags, forum-categories, keywords, report-categories)
$activeTab = $activeTab ?? 'preview';
?>
<div class="toolbar">
    <div class="tabs">
        <a href="<?= BASE_URL ?>/admin/moderate-forum?tab=preview" 
           class="tab <?= $activeTab === 'preview' ? 'active' : '' ?>" 
           data-tab="preview" 
           style="text-decoration:none;">Preview</a>
           
        <a href="<?= BASE_URL ?>/admin/moderate-forum?tab=queue" 
           class="tab <?= $activeTab === 'queue' ? 'active' : '' ?>" 
           data-tab="queue" 
           style="text-decoration:none; margin-left:5px;">Flagged Queue</a>
           
        <a href="<?= BASE_URL ?>/admin/moderate-forum?tab=auto-flags" 
           class="tab <?= $activeTab === 'auto-flags' ? 'active' : '' ?>" 
           data-tab="auto-flags" 
           style="text-decoration:none; margin-left:5px;">Automated Flags</a>
           
        <a href="<?= BASE_URL ?>/admin/forum-categories" 
           class="tab <?= $activeTab === 'forum-categories' ? 'active' : '' ?>" 
           style="text-decoration:none; margin-left:5px;">Manage Thread Categories</a>
           
        <a href="<?= BASE_URL ?>/admin/keywords" 
           class="tab <?= $activeTab === 'keywords' ? 'active' : '' ?>" 
           style="text-decoration:none; margin-left:5px;">Manage Keywords</a>
        <a href="<?= BASE_URL ?>/admin/report-categories" 
           class="tab <?= $activeTab === 'report-categories' ? 'active' : '' ?>"
           style="text-decoration:none; margin-left:5px;">Report Categories</a>
    </div>
    <?php if (isset($rightContent)): ?>
        <div class="toolbar-actions">
            <?= $rightContent ?>
        </div>
    <?php endif; ?>
</div>
