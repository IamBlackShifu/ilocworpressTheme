const fs=require('fs'),path=require('path');const root=__dirname;
const p=path.join(root,'build-content.cjs');let s=fs.readFileSync(p,'utf8');s=s.replace(' alt="" width="800" height="640"',' alt=""').replace('size-full ${cls}',"size-full${cls?' '+cls:''}");fs.writeFileSync(p,s);
