# Ewoud Fotografie Overrides (Grav child theme of Hadron)

Site-specific overrides for [ewoudfotografie.nl](https://ewoudfotografie.nl), built as a
child theme of [Hadron](https://github.com/Crabston/grav-theme-hadron) (which is itself a
child theme of Quark 2). No files inside `user/themes/hadron/` or `user/themes/quark2/`
need to be modified, so GPM updates for those themes stay clean.

## What it changes

| Change | Where |
| --- | --- |
| Light mode only; old saved dark preference ignored | `js/theme-toggle.js` + `theme-mode: light` in `ewoudfotografie.yaml` |
| Appearance toggle removed from navbar and mobile menu | empty `templates/partials/theme-toggle.html.twig` (+ `.theme-toggle` CSS rule) |
| No logo set + hide title off → site title instead of grav-logo.svg | `templates/partials/logo.html.twig` (adapted from commit `7ae3656`) |
| Active navbar item gets a white pill instead of the dark one | `css/custom/navbar.css` |
| External menu links (Contact → socials) open in a new tab | `templates/macros/macros.html.twig` |

## Install

The theme folder must be named `ewoudfotografie` (the slug in `blueprints.yaml` and the
class name `Ewoudfotografie` in `ewoudfotografie.php` must match it).

```bash
cd /path/to/grav
git clone <this-repo> user/themes/ewoudfotografie
```

Then either:

- Admin → Themes → **Ewoud Fotografie Overrides** → Activate, or
- set `system.pages.theme: ewoudfotografie` in `user/config/system.yaml`.

Finally clear the cache (Admin → Dashboard → Clear Cache, or `bin/grav clear-cache`) and
hard-refresh the site.

### Clean up the old edits in Hadron

The live site currently carries its customisations inside `user/themes/hadron/`. Once the
new theme is active and verified, remove them so Hadron updates are clean:

- `user/themes/hadron/css/custom.css` (Hadron does not ship this file)
- `user/themes/hadron/css/custom/` (homepage.css, navbar.css, contact.css, images.css,
  featured.css)

Do this **after** activating `ewoudfotografie`, so the site never loses its styling. If any
other files were added to `user/themes/hadron/` (extra templates, shortcodes, languages),
move them into the matching path here too.

If you also patched `user/themes/hadron/templates/partials/logo.html.twig` for the site-title
fallback, there is nothing to remove: the copy here shadows it. Leave it as-is, or restore it
during the next Hadron update.

## How the inheritance works

Two pieces make a grandchild theme work:

1. `streams` in `ewoudfotografie.yaml` registers `theme://` with prefixes in order:
   `user/themes/ewoudfotografie`, `user/themes/hadron`, `user/themes/quark2`.
   This is what lets plain includes and asset URLs fall through two levels.
2. `ewoudfotografie.php` extends `Hadron` and exposes Hadron's templates as the `@hadron`
   Twig namespace. Hadron's own `onTwigLoader()` already exposes Quark 2 as `@quark2`.

Because `theme://` is searched child-first, `theme://css/custom.css`,
`theme://js/theme-toggle.js`, `templates/macros/macros.html.twig`, etc. in this theme
automatically shadow the same paths in Hadron and Quark 2.

## Notes

- If a Quark 2 partial is ever reported as "not defined", copy that single file from
  `user/themes/quark2/templates/` into the same path here. The empty
  `partials/theme-toggle.html.twig` is an example of exactly that fix.
- `templates/macros/macros.html.twig` and `templates/partials/logo.html.twig` are copies of
  Hadron's upstream files with small additions: external menu links opening in a new tab,
  and the site-title fallback when no logo is set (commit `7ae3656`). The logo fallback uses
  `theme_var('hide_title')` instead of the commit's `config.theme.hide_title`, so the Hide
  Title option actually takes effect. After a Hadron update, diff them against
  `user/themes/hadron/templates/` and re-apply those additions if the upstream files changed.
- `css/custom.css` and `css/custom/*.css` were copied from the live Hadron theme as they
  were on 2026-11-19. From now on, edit them here instead.
