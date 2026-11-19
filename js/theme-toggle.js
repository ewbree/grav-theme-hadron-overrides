/*
 * Light-only overrides theme.
 *
 * Hadron/Quark 2 ship a light/dark/auto appearance toggle. This site is
 * light-only, so this file replaces Quark 2's js/theme-toggle.js, which
 * Hadron's base template loads in the <head>. It:
 *
 *   1. clears any preference a visitor stored while the toggle existed, so
 *      returning visitors cannot get stuck in dark mode with no way back;
 *   2. forces the light theme before the page paints (no flash of dark).
 */
(function () {
  'use strict';

  try {
    localStorage.removeItem('quark2-theme');
  } catch (e) {}

  var root = document.documentElement;
  root.setAttribute('data-theme', 'light');
  root.setAttribute('data-theme-preference', 'light');
  root.classList.remove('dark');
})();
