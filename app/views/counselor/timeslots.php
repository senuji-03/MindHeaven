<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MindHeaven — Manage Timeslots</title>
    <meta name="description" content="Set your availability by selecting or creating timeslots for counseling sessions.">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/css/counselor/appoinmentmgt.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/css/counselor/timeslots.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/css/notifications.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<!-- Navigation Bar -->
<nav class="navbar">
    <div class="nav-content">
        <div class="logo">
            <div class="logo-icon">M</div>
            Mindheaven
        </div>
        <div class="nav-icons">
            <div class="nav-icon">🔔<span class="badge">0</span></div>
        </div>
    </div>
</nav>

<!-- Main Container -->
<div class="main-container ts-layout">
    <!-- Sidebar -->
    <?php include __DIR__ . '/sidebar.php'; ?>

    <!-- Main Content -->
    <div class="ts-main">

        <!-- Hero Header -->
        <div class="ts-hero">
            <div class="ts-hero-inner">
                <div>
                    <div class="ts-hero-badge">
                        <i class="fas fa-clock"></i> AVAILABILITY MANAGER
                    </div>
                    <h1 class="ts-hero-title">Your <span>Timeslots</span></h1>
                    <p class="ts-hero-desc">Define when you're available for counseling sessions. Pick a day, then select fixed evening slots or create flexible custom slots.</p>
                </div>

                <!-- Day Selector -->
                <div class="ts-day-selector">
                    <span class="ts-day-label"><i class="fas fa-calendar-days"></i> Select Day</span>
                    <input type="date" id="tsDatePicker" class="ts-date-input">
                </div>
            </div>
        </div>

        <!-- Counter Strip -->
        <div class="ts-counter-strip">
            <div class="ts-counter-bar">
                <span class="ts-counter-bar__label">
                    <i class="fas fa-layer-group"></i> Slots used for this day:
                </span>
                <div class="ts-dots" id="tsCounterDots">
                    <!-- 6 dots injected by JS -->
                </div>
                <span class="ts-counter-bar__count" id="tsCounterText">
                    <span id="tsUsedCount">0</span> / 6
                </span>
            </div>
        </div>

        <!-- Two-column content -->
        <div class="ts-content">

            <!-- ════ SECTION 1: Fixed Slots ════ -->
            <section class="ts-section" id="sectionFixed">
                <div class="ts-section__header">
                    <div class="ts-section__icon ts-section__icon--fixed">
                        <i class="fas fa-list-check"></i>
                    </div>
                    <div>
                        <h2 class="ts-section__title">Select Available Timeslots</h2>
                        <p class="ts-section__subtitle">Fixed 1-hour evening slots (5 PM – 9 PM). Check the ones you're available for.</p>
                    </div>
                </div>

                <div class="ts-section__body">
                    <!-- Slot cards (rendered by JS) -->
                    <div class="ts-fixed-grid" id="tsFixedGrid">
                        <div class="ts-skeleton"></div>
                        <div class="ts-skeleton"></div>
                        <div class="ts-skeleton"></div>
                        <div class="ts-skeleton"></div>
                    </div>
                </div>

                <div class="ts-section__footer">
                    <div class="ts-save-row">
                        <span id="tsFixedHint" style="font-size:.78rem;color:var(--ts-text-muted);"></span>
                        <button class="ts-btn ts-btn--primary" id="btnSaveFixed">
                            <i class="fas fa-floppy-disk"></i> Save Fixed Slots
                        </button>
                    </div>
                </div>
            </section>

            <!-- ════ SECTION 2: Custom Slots ════ -->
            <section class="ts-section" id="sectionCustom">
                <div class="ts-section__header">
                    <div class="ts-section__icon ts-section__icon--custom">
                        <i class="fas fa-sliders"></i>
                    </div>
                    <div>
                        <h2 class="ts-section__title">Create Your Own Timeslots</h2>
                        <p class="ts-section__subtitle">Add flexible slots with your preferred start & end times. Minimum duration: <strong style="color:var(--ts-primary-light)">45 minutes</strong>.</p>
                    </div>
                </div>

                <div class="ts-section__body">
                    <!-- Add Custom Form -->
                    <div class="ts-custom-form" id="tsCustomForm">
                        <p class="ts-custom-form__title"><i class="fas fa-plus-circle"></i> New Custom Slot</p>

                        <div class="ts-time-row">
                            <div class="ts-field-group">
                                <label class="ts-field-label" for="tsStartTime">Start Time</label>
                                <input type="time" id="tsStartTime" class="ts-time-input">
                            </div>
                            <div class="ts-field-group">
                                <label class="ts-field-label" for="tsEndTime">End Time</label>
                                <input type="time" id="tsEndTime" class="ts-time-input">
                            </div>
                        </div>

                        <div id="tsDurationHint" class="ts-duration-hint">
                            <i class="fas fa-stopwatch"></i>
                            <span id="tsDurationText">Set start and end time to calculate duration</span>
                        </div>
                        <span class="ts-field-error" id="tsCustomError"></span>

                        <button class="ts-btn ts-btn--accent ts-btn--full" id="btnAddCustom">
                            <i class="fas fa-plus"></i> Add Custom Slot
                        </button>
                    </div>

                    <!-- Custom Slots List -->
                    <div class="ts-custom-list" id="tsCustomList">
                        <!-- Rendered by JS -->
                    </div>
                </div>
            </section>

        </div><!-- /ts-content -->

    </div><!-- /ts-main -->
</div><!-- /main-container -->

<!-- Edit Custom Slot Modal -->
<div id="tsEditModal" class="ts-modal-overlay" style="display:none;">
    <div class="ts-modal">
        <div class="ts-modal__header">
            <h3 class="ts-modal__title"><i class="fas fa-pen"></i> Edit Custom Slot</h3>
            <button class="ts-icon-btn" id="btnCloseEditModal" aria-label="Close"><i class="fas fa-times"></i></button>
        </div>
        <div class="ts-modal__body">
            <input type="hidden" id="editSlotId">
            <div class="ts-time-row" style="margin-bottom:12px;">
                <div class="ts-field-group">
                    <label class="ts-field-label" for="editStartTime">Start Time</label>
                    <input type="time" id="editStartTime" class="ts-time-input">
                </div>
                <div class="ts-field-group">
                    <label class="ts-field-label" for="editEndTime">End Time</label>
                    <input type="time" id="editEndTime" class="ts-time-input">
                </div>
            </div>
            <div id="editDurationHint" class="ts-duration-hint">
                <i class="fas fa-stopwatch"></i>
                <span id="editDurationText">Set start and end time</span>
            </div>
            <span class="ts-field-error" id="tsEditError"></span>
        </div>
        <div class="ts-modal__actions">
            <button class="ts-btn ts-btn--ghost" id="btnCancelEdit">Cancel</button>
            <button class="ts-btn ts-btn--primary" id="btnConfirmEdit">
                <i class="fas fa-floppy-disk"></i> Save Changes
            </button>
        </div>
    </div>
</div>

<script>
    window.BASE_URL = '<?php echo BASE_URL; ?>';
</script>
<script src="<?php echo BASE_URL; ?>/js/counselor/timeslots.js"></script>
<script src="<?php echo BASE_URL; ?>/js/notifications.js"></script>

</body>
</html>
