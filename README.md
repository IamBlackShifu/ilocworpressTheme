# Infinity Enterprise — installation and administration

This delivery contains a classic PHP WordPress theme with native block patterns and a small, separate content plugin. No build service, paid plugin or Elementor Pro is required. Source is GPL-2.0-or-later; the locally hosted Manrope and Inter fonts have their own included SIL Open Font Licenses.

## Install on staging

1. Back up the existing database, wp-content directory, uploads, configuration and redirects. Verify that the backup can be restored. Work on an isolated staging copy; block indexing and outgoing production email.
2. In Plugins → Add New → Upload Plugin, install `packages/infinity-content-1.0.0.zip` and activate it.
3. In Appearance → Themes → Add New → Upload Theme, install `packages/infinity-enterprise-1.0.0.zip` and activate it. Use WordPress 6.6+ and PHP 8.1+; use maintained versions for production.
4. Optionally visit Appearance → Infinity setup → Create missing starter drafts. This creates 13 pages (including six services and Insights), six article categories, four project service categories, four unapproved client drafts and two unverified product drafts. It does not change existing pages, menus, Reading settings or published content. Repeating setup skips existing paths. Renaming or deleting starter paths can cause them to be created again.
5. Review all copy, including the proposed mission and vision. Publish approved pages. In Settings → Reading choose Home as the static homepage and Insights as the posts page. A blog homepage remains supported if you do not choose a static page.
6. In Appearance → Menus, create and assign Primary, Footer and Legal menus. Add Home, About Us, Services, Solutions, Our Work, Insights and Contact. Assign a reviewed privacy page through Settings → Privacy. Add cookie and terms pages only when applicable, with reviewed copy. No legal documents are fabricated.
7. In Appearance → Customize → Site Identity upload the approved company logo. In Infinity company settings add your dark-background logo, business email, phone, address, company description, social URLs and Contact Form 7 ID. Blank contact details and social URLs are omitted.
8. Save Settings → Permalinks. Verify all old URLs against the migration inventory before launch.

## Editing pages

Starter pages contain real core blocks, not one HTML widget. Select any heading, paragraph, button or image in the page editor to change it. Groups have CSS classes that control layouts; retain these when editing content. Insert additional sections from Patterns → Infinity Enterprise. A custom homepage is also possible without the installer.

The Full width template displays the page content without an extra title. It is used for the supplied patterns, which already contain one H1. Standard pages supply their own title. The Service landing page template supplies its title and excerpt; do not insert a second page-hero H1 when using this template.

Services are normal child pages of Services. Their titles and excerpts populate service cards. Keep the supplied slugs or update links if you change them. Service icons are original theme SVGs. Editing page body copy is independent of the short excerpt used on service cards.

Use the block editor or Elementor on a given page; switching editors does not convert existing block groups into Elementor widgets. For Elementor Free, select the theme Full width template or Elementor Full Width. Elementor Canvas supplies its own blank document without the theme header/footer. No Pro widgets or Theme Builder are needed. Keep exactly one H1 in full-width/Canvas content. Core archive and single templates remain theme-managed.

## Collections

- Projects: title, excerpt, featured image, content, service taxonomy and Industry. Use the Case study pattern for background, challenge, scope, approach, methods, outcomes and an optional authorised testimonial. To anonymise, remove identity from every field, slug, image filename, metadata and image alt text. Anonymisation is an editorial workflow, not an automatic redaction tool.
- Clients: title is the accessible company name; featured image is its approved logo. Page Attributes → Order controls ordering (lower numbers first). Only published entries appear. Draft starter names are not public endorsements. PNG and WebP work natively. For SVG uploads, use a trusted SVG sanitisation workflow such as the free Safe SVG plugin; this theme does not enable unrestricted SVG uploads. Sanitised SVG media can be used as client images.
- Solutions: use the Product detail pattern. Set category, excerpt, featured screenshot, features, technologies, availability status and optional external URL. InfinityOps and ShopaFlow are drafts pending factual review. Publish neither until its scope, status and screenshot are verified.
- Testimonials: publish only with explicit permission. Use the Testimonials block where desired; no testimonials are invented or seeded.
- Insights: standard WordPress posts, categories, dates, excerpts, featured images and pagination. The original insight SVG is a neutral fallback, not a product screenshot.

Insert Infinity collection blocks through the block inserter. Project filters apply to the 12 most recent projects in a collection; View all case studies opens the paginated archive containing all published projects. Clients load up to 50 entries. Other homepage collections load the latest three entries. The plugin continues to expose editable content and basic collection lists when the theme changes. Service pages remain native pages.

Permission records are internal editorial notes, not public content. They are excluded from public REST metadata. No client details are automatically approved by filling in a field: publishing is the editorial approval action.

## Contact Form 7

Install and activate Contact Form 7. Create a form using `docs/contact-form-7.txt`, enter its ID in the Customizer, and configure its Mail tab. The theme provides styling and rendering, not an independent mail endpoint.

Use your actual recipient address. Set From to an authorised mailbox on your website domain; put the visitor's address in Reply-To, not From. Include all mail tags from the supplied form in the message. Follow the official configuration guide: https://contactform7.com/setting-up-mail/ . Configure your host's authenticated mail transport or a reputable free SMTP plugin. Verify SPF, DKIM and DMARC with the domain/mail administrator. Run real submission and delivery tests, including spam-folder checks, in staging and after launch. Theme installation alone cannot establish reliable email delivery.

Configure CF7's supported spam prevention (for example an available privacy-reviewed integration), add the necessary disclosure, and test it. Do not cache form submissions or authenticated dashboard responses. The consent label must match the reviewed privacy policy and actual processing purpose. Add the real privacy URL after that page exists.

## Assets and performance

All 11 supplied illustrations and six inline service icons are original geometric artwork. They are decorative and carry empty alt text. Add meaningful alt text to real project screenshots, charts and client logos. The textual Infinity wordmark is a temporary treatment; replace it with the approved company artwork.

Fonts are hosted locally with font-display: swap and no visitor-time third-party font request. Images use fixed dimensions and responsive WordPress image sizes; the hero is not lazy-loaded. Use optimised WebP/AVIF for approved photographs/screenshots. Add caching and compression at the hosting layer, and use a compatible SEO plugin for canonical/social metadata and structured data. WordPress supplies document titles and native sitemaps. Avoid duplicate SEO output from multiple plugins.

Reduced-motion preference disables decorative floating and carousel autoplay; manual controls remain available. Carousel pauses on hover, focus, touch, hidden tabs and offscreen. Mobile navigation supports Escape and keyboard containment. JavaScript failure leaves navigation and collection content readable.

## Content and launch dependencies

The existing public site timed out during discovery. No production dashboard, configuration export, original brand assets, analytics, credentials, approved logos, product screenshots or verified project narratives were supplied. Complete the inventory in MIGRATION.md before deployment. Existing URLs have not been changed. These packages have not been deployed to the live site.
