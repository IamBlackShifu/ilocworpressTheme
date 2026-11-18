const fs=require('fs'),path=require('path');const root=__dirname;
const p=path.join(root,'infinity-enterprise/template-parts/card.php');let s=fs.readFileSync(p,'utf8');s=s.replace("get_post_type() === 'post' ? 'category' : 'iloc_service'", "get_post_type() === 'post' ? 'category' : (get_post_type() === 'iloc_solution' ? 'iloc_product_category' : 'iloc_service')");fs.writeFileSync(p,s);
