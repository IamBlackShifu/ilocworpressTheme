# Acceptance checklist

Automated results and environment are recorded in QA-RESULTS.md. Passing source checks does not establish production mail delivery, client approval or performance on the target host.

- [ ] Fresh install and activation on the production WordPress/PHP versions; no PHP notices under WP_DEBUG.
- [ ] Existing-site activation preserves pages, posts, settings, menus and media.
- [ ] Starter setup is permission checked, nonce protected, repeatable and draft-only.
- [ ] All patterns open without invalid-block warnings; content can be edited and saved.
- [ ] Standard, Full width and Service templates; Elementor Free Full Width and Canvas.
- [ ] Menus, nested menu keyboard access, mobile open/close, Escape, focus order and visible focus.
- [ ] Layouts at 360, 390, 768, 1024, 1440 and 1920 px; 200% zoom and no horizontal overflow.
- [ ] One H1 per page, meaningful heading order, landmarks, alt text, labels and contrast.
- [ ] Screen-reader review with NVDA/VoiceOver and keyboard-only navigation.
- [ ] Carousel order, manual controls, hover/focus pause, touch and reduced-motion behaviour.
- [ ] Project filters, paginated archives, categories, search, empty results, 404 and single pages.
- [ ] Draft clients/products and internal approval notes absent from public pages and REST responses.
- [ ] Anonymous case studies contain no identifying slugs, body text, media names or metadata.
- [ ] Product availability and external URLs are accurate. All public claims approved.
- [ ] CF7 required fields, consent, validation, success, failure, spam prevention and actual delivery.
- [ ] Privacy and legal links correct; contact information and approved logo variants configured.
- [ ] Lighthouse performance/accessibility/best-practices/SEO on representative target-host pages; record results rather than claiming unmeasured scores.
- [ ] HTTPS and mixed-content checks; sitemap, SEO plugin output, canonicals and migration redirects.
- [ ] Cache behaviour, responsive image sizes, slow-network load and reduced-motion mode.
- [ ] Verify ZIP root folders and clean installation from the ZIPs, not only the development source.
