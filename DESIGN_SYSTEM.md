# MindHeaven Design System

> **Purpose:** This document defines the standard visual language for MindHeaven. Every page — dashboards, forms, modals, sidebars — should follow these rules to maintain a consistent, wellness-first experience.

---

## 1. Color Palette

### CSS Variables (define in `:root`)

```css
:root {
    /* ── Primary (Sage Teal) ── */
    --primary:       #3D8B6E;   /* Main brand — buttons, links, icons, active states */
    --primary-dark:  #2A6B52;   /* Hover states, headers, emphasis */
    --primary-light: #6BB89A;   /* Tags, badges, light accents, progress fills */

    /* ── Accent Colors ── */
    --accent-warm:   #E8A87C;   /* Warm Apricot — highlights, notifications, warm accents */
    --accent-calm:   #A8C5DA;   /* Soft Sky — informational, calm highlights, secondary tags */

    /* ── Backgrounds ── */
    --bg-deep:       #1C2B2A;   /* Dark Canopy — footers, dark sections, overlays */
    --bg-soft:       #F5F0E8;   /* Linen Cream — alternate section backgrounds, cards on white */
    --bg-mid:        #EEF6F2;   /* Pale Sage — sidebars, table zebra rows, input backgrounds */

    /* ── Text ── */
    --text-primary:   #1E3A34;  /* All headings, body text, labels */
    --text-secondary: #6B8C7E;  /* Descriptions, helper text, metadata, timestamps */

    /* ── Surface & Border ── */
    --surface:       #FFFFFF;   /* Cards, modals, input backgrounds */
    --border:        #D6E4DD;   /* Card borders, dividers, input outlines */

    /* ── Semantic ── */
    --crisis:        #D64F4F;   /* Errors, destructive actions, crisis/urgent elements */
    --success:       #4CAF82;   /* Success states, positive indicators, habit streaks */
}
```

### Usage Rules

| Scenario | Color |
|----------|-------|
| Primary buttons, active tabs, links | `--primary` |
| Button hover, focused borders | `--primary-dark` |
| Tags, badges, progress bars | `--primary-light` |
| Warm accents, notification dots | `--accent-warm` |
| Info badges, calm highlights | `--accent-calm` |
| Page background | `--surface` |
| Alternate section / sidebar bg | `--bg-mid` |
| Card-on-white distinction | `--bg-soft` |
| Footer, dark overlays, dark modals | `--bg-deep` |
| Headings, body copy, labels | `--text-primary` |
| Helper text, metadata, placeholders | `--text-secondary` |
| Error messages, delete buttons | `--crisis` |
| Success toasts, completed states | `--success` |

> [!CAUTION]
> Never use raw hex values in new CSS. Always reference the CSS variable (e.g. `var(--primary)`).

---

## 2. Typography

### Font Stack

```css
font-family: 'DM Sans', 'Inter', system-ui, -apple-system, sans-serif;
```

**Required imports** (place in `<head>`):
```html
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;1,9..40,400&display=swap" rel="stylesheet">
```

### Type Scale

| Element | Size | Weight | Line Height | Letter Spacing |
|---------|------|--------|-------------|----------------|
| Page title (h1) | `2.2rem` – `3.4rem` | 700 | 1.12 – 1.25 | `-1px` |
| Section title (h2) | `1.8rem` – `2.2rem` | 700 | 1.25 | `-0.5px` |
| Card title (h3) | `1rem` – `1.05rem` | 600 | 1.4 | `-0.2px` |
| Body text | `0.88rem` – `1rem` | 400 | 1.65 – 1.7 | normal |
| Small/meta text | `0.82rem` – `0.85rem` | 500 | 1.5 | normal |
| Labels / uppercase | `0.78rem` | 600 | 1.4 | `1.5px` |
| Button text | `0.85rem` – `0.95rem` | 600 | 1.4 | normal |

### Rules
- **Headings** use `--text-primary` and tight letter-spacing
- **Body/descriptions** use `--text-secondary`
- **Labels** use `--primary`, uppercase, extra letter-spacing (`1.5px`)
- Base `line-height` for `body` is `1.7`

---

## 3. Spacing & Layout

### Container
```css
.container {
    max-width: 1180px;
    margin: 0 auto;
    padding: 0 24px;
}
```

### Section Padding
| Context | Padding |
|---------|---------|
| Full section (desktop) | `80px 0` |
| Full section (mobile ≤768px) | `56px 0` |
| Compact band / banner | `48px 0` – `64px 0` |

### Spacing Scale (reference)
| Token | Value | Use |
|-------|-------|-----|
| `4px` | Micro | Icon-to-text gaps |
| `8px` | XS | Tight inner gaps |
| `12px` | SM | Label-to-input, small card gaps |
| `16px` | MD | Card inner padding sides |
| `20px`–`24px` | LG | Card padding, section gaps |
| `28px`–`32px` | XL | Between elements inside sections |
| `40px`–`48px` | 2XL | Between section header and content |
| `60px`–`80px` | 3XL | Grid column gaps, section vertical padding |

---

## 4. Shadows & Elevation

```css
--shadow-sm: 0 1px 3px rgba(30, 58, 52, 0.06);    /* Default cards, inputs */
--shadow-md: 0 4px 12px rgba(30, 58, 52, 0.08);    /* Hovered cards, dropdowns */
--shadow-lg: 0 12px 32px rgba(30, 58, 52, 0.10);   /* Modals, floating panels */
--shadow-xl: 0 20px 48px rgba(30, 58, 52, 0.12);   /* Large overlays */
```

> [!NOTE]
> Shadow color is always based on `rgba(30, 58, 52, ...)` (derived from `--text-primary`), NOT generic black. This keeps shadows feeling warm and cohesive.

---

## 5. Border Radius

```css
--radius-sm:   8px;     /* Inputs, small tags, icon containers */
--radius-md:   14px;    /* Dropdowns, small cards, tooltips */
--radius-lg:   20px;    /* Standard cards, panels */
--radius-xl:   28px;    /* Large cards, modal containers */
--radius-full: 9999px;  /* Buttons, pills, badges, avatars */
```

| Component | Radius |
|-----------|--------|
| Buttons | `--radius-full` (pill shape) |
| Cards | `--radius-lg` |
| Inputs | `--radius-sm` |
| Modals | `--radius-xl` |
| Avatars / tags | `--radius-full` |
| Icon containers | `--radius-sm` |
| Dropdowns | `--radius-md` |

---

## 6. Buttons

### Variants

```css
/* Primary — main CTAs */
.btn-primary {
    background: var(--primary);
    color: white;
    border: none;
}
.btn-primary:hover {
    background: var(--primary-dark);
    transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(61, 139, 110, 0.3);
}

/* Outline — secondary actions */
.btn-outline {
    background: transparent;
    color: var(--primary);
    border: 1.5px solid var(--border);
}
.btn-outline:hover {
    border-color: var(--primary);
    background: var(--bg-mid);
}

/* Ghost (on dark bg) — tertiary actions on dark surfaces */
.btn-ghost {
    background: rgba(255, 255, 255, 0.15);
    color: white;
    border: 1.5px solid rgba(255, 255, 255, 0.3);
}

/* Danger — destructive actions */
/* Use --crisis as background, white text */
```

### Base Styles (applied to all `.btn`)
```css
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
}
```

### Sizes
| Size | Padding | Font Size |
|------|---------|-----------|
| Default | `10px 22px` | `0.88rem` |
| Small | `8px 18px` | `0.85rem` |
| Large (`.btn-lg`) | `14px 32px` | `0.95rem` |

---

## 7. Cards

### Standard Card
```css
.card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius-lg);    /* 20px */
    padding: 28px 24px;
    transition: all 0.3s ease;
}

.card:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow-lg);
    border-color: var(--primary-light);
}
```

### Card Icon Container
```css
/* Colored icon block inside a card */
.card-icon {
    width: 48px;
    height: 48px;
    border-radius: var(--radius-sm);    /* 8px */
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    margin-bottom: 18px;
    color: white;
}

/* Icon color variants */
.card-icon--teal    { background: var(--primary); }
.card-icon--apricot { background: var(--accent-warm); }
.card-icon--sky     { background: var(--accent-calm); }
.card-icon--mint    { background: var(--success); }
.card-icon--red     { background: var(--crisis); }
.card-icon--forest  { background: var(--primary-dark); }
```

### Card Typography
- Title: `1.05rem`, weight `600`, color `--text-primary`
- Description: `0.88rem`, color `--text-secondary`, line-height `1.65`

---

## 8. Forms & Inputs

> [!IMPORTANT]
> These are recommended standards. Apply consistently to all forms.

```css
/* Text inputs, selects, textareas */
.form-input {
    width: 100%;
    padding: 12px 16px;
    border: 1.5px solid var(--border);
    border-radius: var(--radius-sm);    /* 8px */
    font-family: inherit;
    font-size: 0.9rem;
    color: var(--text-primary);
    background: var(--surface);
    transition: border-color 0.25s ease, box-shadow 0.25s ease;
}

.form-input:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(61, 139, 110, 0.12);
}

.form-input::placeholder {
    color: var(--text-secondary);
    opacity: 0.7;
}

/* Labels */
.form-label {
    display: block;
    font-size: 0.85rem;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 6px;
}

/* Helper / error text */
.form-helper { font-size: 0.8rem; color: var(--text-secondary); margin-top: 4px; }
.form-error  { font-size: 0.8rem; color: var(--crisis); margin-top: 4px; }
```

---

## 9. Grids

### Standard Patterns

```css
/* 3-column grid (features, cards) */
.grid-3 {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 22px;
}

/* 2-column grid (forms, side-by-side content) */
.grid-2 {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 24px;
}

/* 4-column grid (stats, footer) */
.grid-4 {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 24px;
}
```

### Responsive Breakdowns
| Breakpoint | 3-col → | 2-col → | 4-col → |
|------------|---------|---------|---------|
| ≤ 1024px | 2-col | 1-col | 2-col |
| ≤ 768px | 1-col | 1-col | 1-col |

---

## 10. Navigation Bar

### Structure
```
[Logo]              [Nav Links]              [Action Buttons]
MindHeaven (leaf)   Home Resources Forum     Donate CrisisSupport Login SignUp
```

### Key Styles
- **Default**: `background: rgba(255,255,255,0.7)`, `backdrop-filter: blur(16px)`, transparent bottom border
- **Scrolled** (>40px): `background: rgba(255,255,255,0.95)`, `border-bottom: 1px solid var(--border)`, `box-shadow: var(--shadow-sm)`
- **Position**: `fixed`, `top: 0`, `z-index: 1000`
- **Height**: ~72px (via `padding: 16px 0`, shrinks to `12px` on scroll)
- **Logo**: `font-size: 1.3rem`, weight `700`, color `--primary-dark`, with a 32×32 rounded icon box (`--primary` bg, white icon)
- **Nav links**: `0.9rem`, weight `500`, color `--text-secondary`, hover → `--primary-dark` + `bg-mid` pill background
- **Mobile** (≤768px): Hamburger menu toggling a dropdown panel

---

## 11. Footer

### Structure
```
[Brand + desc]  [Platform links]  [Support links]  [Contact info]
──────────────────────────────────────────────────────────────────
© 2026 MindHeaven...                     Privacy Policy  Terms
```

### Styles
- Background: `--bg-deep` (`#1C2B2A`)
- Text: `rgba(255,255,255,0.6)` for body, `rgba(255,255,255,0.9)` for headings
- Links: `rgba(255,255,255,0.55)`, hover → `white`
- Bottom bar: `border-top: 1px solid rgba(255,255,255,0.08)`

---

## 12. Section Headers

Standard pattern for titled sections:

```html
<div class="section-header">
    <span class="section-label">LABEL TEXT</span>
    <h2 class="section-title">Main Title Here</h2>
    <p class="section-subtitle">Supporting description text.</p>
</div>
```

```css
.section-header  { text-align: center; margin-bottom: 48px; }
.section-label   { font-size: 0.78rem; font-weight: 600; text-transform: uppercase;
                   letter-spacing: 1.5px; color: var(--primary); }
.section-title   { font-size: 2.2rem; font-weight: 700; color: var(--text-primary);
                   letter-spacing: -0.5px; line-height: 1.25; margin-bottom: 12px; }
.section-subtitle { font-size: 1rem; color: var(--text-secondary);
                    max-width: 540px; margin: 0 auto; line-height: 1.7; }
```

---

## 13. Alternating Section Backgrounds

Alternate sections to create visual rhythm:

| Section Type | Class | Background |
|--------------|-------|------------|
| Default | `.section` | `--surface` (white) |
| Alternate light | `.section--alt` | `--bg-mid` (pale sage `#EEF6F2`) |
| Warm | `.section--cream` | `--bg-soft` (linen cream `#F5F0E8`) |
| Dark (CTA, banner) | custom | `--bg-deep` (dark canopy `#1C2B2A`), white text |
| Brand accent | custom | `--primary` background, white text |

---

## 14. Animations

### Scroll Reveal (Progressive Enhancement)

```css
/* Elements visible by default — animation only when JS is active */
.animate-on-scroll {
    opacity: 1;
    transform: translateY(0);
    transition: opacity 0.6s ease-out, transform 0.6s ease-out;
}

body.js-loaded .animate-on-scroll {
    opacity: 0;
    transform: translateY(28px);
}

body.js-loaded .animate-on-scroll.visible {
    opacity: 1;
    transform: translateY(0);
}
```

### Stagger Pattern (for card grids)
Add `stagger-children` to the grid parent. Each `.animate-on-scroll` child is delayed by `0.05s` increments.

### Hover Interactions
- **Cards**: `transform: translateY(-4px)`, `box-shadow: var(--shadow-lg)`, `border-color: var(--primary-light)`
- **Buttons**: `transform: translateY(-1px)`, colored box-shadow
- **Links**: color transition `0.2s ease`
- All transitions: `0.25s` – `0.3s ease`

### Floating Animation (decorative)
```css
@keyframes float {
    0%, 100% { transform: translateY(0) scale(1); }
    50%      { transform: translateY(-16px) scale(1.03); }
}
/* Duration: 8s, ease-in-out, infinite */
```

---

## 15. Icons

### Library
**Font Awesome 6.5** (CDN):
```html
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
```

### Usage conventions
- Buttons: icon + text, `gap: 8px`
- Card icons: inside a colored `48×48` container with `border-radius: 8px`
- Circular icons: `52×52`, `border-radius: 50%`, soft transparent background with matching icon color
- Always use `<i class="fas fa-...">` for solid style

---

## 16. Responsive Breakpoints

| Breakpoint | Target |
|------------|--------|
| `≤ 1024px` | Tablets — reduce grid columns, simplify layout |
| `≤ 768px` | Mobile — single column, hamburger nav, stacked elements |
| `≤ 480px` | Small mobile — full-width buttons, tighter spacing |

### Key mobile rules
- Hamburger replaces nav links
- All grids collapse to 1-col
- Page titles shrink (e.g. `3.4rem` → `1.9rem`)
- Buttons go full-width on ≤480px
- Section padding reduces from `80px` to `56px`

---

## 17. Quick Reference — Copy-Paste Starter

When creating a new page, include these in your layout `<head>`:

```html
<!-- Fonts -->
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;1,9..40,400&display=swap" rel="stylesheet">
<!-- Icons -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
```

And start your CSS with the `:root` variables from Section 1 above.
