---
name: Academic Precision
colors:
  surface: '#f8f9ff'
  surface-dim: '#cbdbf5'
  surface-bright: '#f8f9ff'
  surface-container-lowest: '#ffffff'
  surface-container-low: '#eff4ff'
  surface-container: '#e5eeff'
  surface-container-high: '#dce9ff'
  surface-container-highest: '#d3e4fe'
  on-surface: '#0b1c30'
  on-surface-variant: '#434655'
  inverse-surface: '#213145'
  inverse-on-surface: '#eaf1ff'
  outline: '#737686'
  outline-variant: '#c3c6d7'
  surface-tint: '#0053db'
  primary: '#004ac6'
  on-primary: '#ffffff'
  primary-container: '#2563eb'
  on-primary-container: '#eeefff'
  inverse-primary: '#b4c5ff'
  secondary: '#5c5f61'
  on-secondary: '#ffffff'
  secondary-container: '#e0e3e5'
  on-secondary-container: '#626567'
  tertiary: '#4b566a'
  on-tertiary: '#ffffff'
  tertiary-container: '#636e83'
  on-tertiary-container: '#ecf1ff'
  error: '#ba1a1a'
  on-error: '#ffffff'
  error-container: '#ffdad6'
  on-error-container: '#93000a'
  primary-fixed: '#dbe1ff'
  primary-fixed-dim: '#b4c5ff'
  on-primary-fixed: '#00174b'
  on-primary-fixed-variant: '#003ea8'
  secondary-fixed: '#e0e3e5'
  secondary-fixed-dim: '#c4c7c9'
  on-secondary-fixed: '#191c1e'
  on-secondary-fixed-variant: '#444749'
  tertiary-fixed: '#d8e3fb'
  tertiary-fixed-dim: '#bcc7de'
  on-tertiary-fixed: '#111c2d'
  on-tertiary-fixed-variant: '#3c475a'
  background: '#f8f9ff'
  on-background: '#0b1c30'
  surface-variant: '#d3e4fe'
typography:
  headline-lg:
    fontFamily: Inter
    fontSize: 24px
    fontWeight: '700'
    lineHeight: 32px
  headline-md:
    fontFamily: Inter
    fontSize: 20px
    fontWeight: '600'
    lineHeight: 28px
  headline-sm:
    fontFamily: Inter
    fontSize: 16px
    fontWeight: '600'
    lineHeight: 24px
  body-lg:
    fontFamily: Inter
    fontSize: 16px
    fontWeight: '400'
    lineHeight: 24px
  body-md:
    fontFamily: Inter
    fontSize: 14px
    fontWeight: '400'
    lineHeight: 20px
  label-md:
    fontFamily: Inter
    fontSize: 12px
    fontWeight: '500'
    lineHeight: 16px
    letterSpacing: 0.02em
  label-sm:
    fontFamily: Inter
    fontSize: 11px
    fontWeight: '600'
    lineHeight: 14px
    letterSpacing: 0.05em
rounded:
  sm: 0.125rem
  DEFAULT: 0.25rem
  md: 0.375rem
  lg: 0.5rem
  xl: 0.75rem
  full: 9999px
spacing:
  sidebar-width: 240px
  container-padding: 2rem
  gutter: 1.5rem
  card-gap: 1rem
  stack-sm: 0.5rem
  stack-md: 1rem
---

## Brand & Style
The brand personality is professional, academic, and systematic. It aims to evoke a sense of clarity, reliability, and structured guidance for students and administrators. The UI facilitates data-heavy tasks without overwhelming the user, maintaining a focus on "at-a-glance" insights.

The design style is **Corporate / Modern**. It utilizes a clean, light-mode interface with a focus on functional hierarchy. The aesthetic relies on consistent spacing, logical information grouping through cards, and a crisp blue primary color that communicates trust and institutional authority.

## Colors
This design system uses a primary blue-centric palette balanced by cool grays and high-contrast status colors. 

- **Primary Blue:** Used for call-to-actions, active navigation states, and primary branding.
- **Status Colors:** Semantic colors are critical for the predictive nature of the app. Success (green) indicates "Tepat Waktu" (On Time), while Warning (red) indicates "Berisiko Terlambat" (At Risk of Delay). 
- **Neutral Scale:** Backgrounds use a light-gray wash (`#F1F5F9`) to separate the main content from the white card surfaces. Text utilizes a range of slate grays to establish hierarchy.

## Typography
The typography is powered by **Inter**, chosen for its exceptional legibility in data-heavy environments. The system uses a strict hierarchy to guide the user's eye from section headers down to granular table data.

- **Headlines:** Bold weights are used for page titles and card headings.
- **Body:** Standard reading weight (400) is used for descriptions and input text.
- **Labels:** Medium weights (500-600) are used for form labels and sidebar navigation items to ensure they remain distinct at smaller sizes.

## Layout & Spacing
The layout follows a **Fixed Sidebar + Fluid Content** model. 

- **Sidebar:** A persistent vertical navigation bar on the left with a width of 240px.
- **Grid:** Content is organized within a responsive container that uses a 12-column logic on desktop. Components are grouped into cards that utilize a 1.5rem (24px) gutter.
- **Rhythm:** A 4px/8px base scaling system is used. Vertical spacing between form elements is consistently 1rem (16px), while internal card padding is 1.5rem (24px) to create a sense of airiness and focus.

## Elevation & Depth
The design system utilizes **Tonal Layers** and **Low-contrast Outlines** rather than heavy shadows. 

1.  **Level 0 (Background):** The base canvas uses the default neutral background color.
2.  **Level 1 (Cards/Sidebar):** Pure white surfaces with a subtle 1px border (`#E2E8F0`). 
3.  **Level 2 (Interactive):** Active states on navigation or dropdowns use a primary-colored tint (10% opacity) or a solid primary fill to indicate focus.

Shadows are used sparingly, only on floating elements like tooltips or modal windows, characterized by a soft, 12px blur with 5% opacity.

## Shapes
The shape language is **Soft**. All primary UI elements—including buttons, input fields, and cards—feature a subtle corner radius.

- **Base Radius:** 0.25rem (4px) for small interactive elements like checkboxes.
- **Large Radius:** 0.5rem (8px) for cards, containers, and primary buttons.
- **Avatar/Icons:** Circular shapes are used for profile images and specific status indicators to provide visual contrast against the otherwise rectilinear grid.

## Components

- **Buttons:** Primary buttons use a solid blue background with white text. Secondary buttons use a white background with a gray border and primary blue text.
- **Sidebar Navigation:** Active items are indicated by a solid blue background and white text/icons. Inactive items use slate-gray text.
- **Cards:** White containers with a 1px border. Cards used for statistics (e.g., Total SKS) should center-align content with bold headlines.
- **Inputs:** Standardized text fields with a 1px border. Active fields should have a primary blue focus ring.
- **Status Badges:** Used in tables and results. They feature a light background tint of the status color (success/warning) with dark-colored text for maximum readability.
- **Tables:** Minimalist design with no vertical borders. Horizontal borders between rows use the subtle border color. Header rows are slightly emphasized with a light gray background or bolder text.
- **Progress Indicators:** Circular loaders or progress bars utilize the primary blue to show system activity.