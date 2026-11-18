const fs = require('fs'),path=require('path'); const root=__dirname;
const alter=(file,fn)=>{const p=path.join(root,file);fs.writeFileSync(p,fn(fs.readFileSync(p,'utf8')))};
alter('build-content.cjs',s=>s.replace("for (const [slug, content] of Object.entries(pages))", "for (const slug of Object.keys(pages)) { if (!pages[slug].includes('<h1')) pages[slug] = pages[slug].replace('wp:heading {\"level\":2}', 'wp:heading {\"level\":1}').replace('<h2 ', '<h1 ').replace('</h2>', '</h1>'); }\nfor (const [slug, content] of Object.entries(pages))"));
alter('infinity-enterprise/front-page.php',s=>s.replace('get_header();',"if (is_home()) { require get_template_directory() . '/home.php'; return; } get_header();"));
alter('infinity-enterprise/header.php',s=>s.replace('body_class();',"body_class('no-js');"));
alter('infinity-enterprise/assets/js/main.js',s=>s.replace("document.documentElement.classList.add('js');","document.documentElement.classList.add('js');\n  document.body.classList.remove('no-js');"));
alter('infinity-content/infinity-content.php',s=>s.replace("'show_in_rest' => true, 'sanitize_callback' => $key", "'show_in_rest' => $key !== 'approval', 'sanitize_callback' => $key"));
// Ensure UTF-8 without BOM: BOMs in PHP can break cookies, redirects and feeds.
for (const base of ['infinity-enterprise','infinity-content']) {
 const walk=d=>{for(const entry of fs.readdirSync(d,{withFileTypes:true})){const p=path.join(d,entry.name); if(entry.isDirectory())walk(p);else if(/\.(php|css|js|json|txt)$/.test(p))fs.writeFileSync(p,fs.readFileSync(p,'utf8').replace(/^\uFEFF/,''));}};walk(path.join(root,base));
}
