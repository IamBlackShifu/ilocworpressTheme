# Migration and launch runbook

## Discovery record

- Public HTTPS homepage: fetch timed out on 18 November 2026. No assumptions made about its WordPress version, plugins, hosting or URL inventory.
- Local repository: empty at start, apart from Git metadata. No reusable artwork or content exports supplied.
- Only the project brief is treated as company-approved source copy. Proposed mission/vision and service expansion copy require editorial review. Customer/product names are seeded as drafts, not published references.

## Before staging changes

- [ ] Inventory WordPress/PHP/database versions, hosting restrictions, installed themes, plugins and licenses.
- [ ] Back up database, themes, plugins, uploads, configuration and redirect rules. Test restoration.
- [ ] Crawl all public URLs and export sitemap, titles, descriptions, canonicals, indexability and internal links.
- [ ] Export pages, posts, menus, forms, widgets, custom fields, media metadata and redirects.
- [ ] Record analytics/search-console baseline and identify high-value landing pages and incoming links.
- [ ] Audit current claims, permission for customer references, product status and assets.
- [ ] Create a separate staging copy with indexing disabled, protected access and email interception.

## Implement on staging

- [ ] Install theme and companion plugin; preserve all original content.
- [ ] Import only needed starter drafts. Map existing pages to patterns or templates without changing established paths unnecessarily.
- [ ] Replace temporary wordmark with approved light/dark logo. Add verified contact details.
- [ ] Review all copy, product status, client permissions, alt text and external URLs.
- [ ] Assign homepage, posts page and menus. Review privacy/cookie/terms requirements.
- [ ] Configure CF7, spam prevention, authenticated mail transport and SEO plugin.
- [ ] Build one-to-one 301 redirects only for URLs that actually change. Avoid redirect chains and mass redirects to home.
- [ ] Test retained URLs, canonical tags, metadata, feeds, sitemap, pagination and search.
- [ ] Verify HTTPS certificates, no mixed content, caching rules and secure hosting configuration.
- [ ] Complete TESTING.md on the target hosting stack.

## Launch and recovery

- [ ] Take a fresh backup and capture the final redirect map before launch.
- [ ] Deploy versioned theme and plugin packages. Do not delete legacy content or uploads.
- [ ] Recheck Reading settings, menus, form recipient, mail delivery, HTTPS and permalink rules.
- [ ] Remove staging noindex/protection only on the production site; retain it on staging.
- [ ] Clear caches, submit sitemap and monitor errors, contact delivery, analytics and search coverage.
- [ ] If regression occurs, reactivate the prior theme and restore changed settings/redirects from the recorded baseline. Keep the companion plugin active so content types remain accessible. Restore the database only when required and account for submissions/content created since backup.

No production deployment or database mutation has been performed by this delivery.
