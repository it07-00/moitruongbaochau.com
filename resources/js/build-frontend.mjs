import { readFile, writeFile } from 'node:fs/promises';
import { resolve, dirname } from 'node:path';
import { fileURLToPath } from 'node:url';
import { createHash } from 'node:crypto';
import { gzipSync } from 'node:zlib';
import postcss from 'postcss';
import { transform } from 'lightningcss';
import { Scanner } from '@tailwindcss/oxide';

const root = resolve(dirname(fileURLToPath(import.meta.url)), '../..');
const cssFolder = resolve(root, 'public/assets/css');
const sheets = ['style.css', 'swiper.min.css', 'header.css', 'footer.css'];
let css = (await Promise.all(sheets.map(name => readFile(resolve(cssFolder, name), 'utf8')))).join('\n');
css += '\n' + await readFile(resolve(root, 'resources/css/frontend-performance.css'), 'utf8');
css = css.replace(/@font-face\{font-family:Poppins;[^}]*\}/g, rule => rule
    .replace('font-display:swap', 'font-display:optional')
    .replace(/src:[^}]+/, source => source.split(',url(')[0].replace('.woff2', '.subset.woff').replace('format("woff2")', 'format("woff")')));

const versions = new Map();
for (const match of css.matchAll(/url\((['"]?)([^)'"\s]+)\1\)/g)) {
    const url = match[2];
    if (/^(data:|https?:|\/|#)/.test(url) || versions.has(url)) continue;
    const file = resolve(cssFolder, url.split('?')[0]);
    const version = createHash('sha256').update(await readFile(file)).digest('hex').slice(0, 12);
    versions.set(url, '/assets/' + url.replace(/^\.\.\//, '').split('?')[0] + '?v=' + version);
}
css = css.replace(/url\((['"]?)([^)'"\s]+)\1\)/g, (match, quote, url) => versions.has(url) ? `url(${quote}${versions.get(url)}${quote})` : match);
// The legacy generated stylesheet contains empty selectors inside color feature queries.
const parsed = postcss.parse(css);
parsed.walkRules(rule => { if (!rule.selector.trim()) rule.remove(); });
const fontRules = postcss.root();
parsed.walkAtRules('font-face', rule => {
    if (rule.toString().includes('font-family:Poppins')) {
        fontRules.append(rule.clone());
        rule.remove();
    }
});
const fonts = transform({ filename: 'frontend-fonts.css', code: Buffer.from(fontRules.toString()), minify: true }).code;
await writeFile(resolve(cssFolder, 'frontend-fonts.css'), fonts);
css = parsed.toString();
const full = transform({ filename: 'frontend.css', code: Buffer.from(css), minify: true }).code;
await writeFile(resolve(cssFolder, 'frontend.min.css'), full);

// Include complete header, hero and introduction at both mobile and desktop breakpoints.
const sourceFiles = ['resources/views/components/frontend/header.blade.php', 'resources/views/components/frontend/floating-contact.blade.php', 'resources/views/frontend/layouts/app.blade.php'];
const sources = await Promise.all(sourceFiles.map(async path => ({ content: await readFile(resolve(root, path), 'utf8'), extension: 'html' })));
sources.push({ content: (await readFile(resolve(root, 'resources/views/frontend/home.blade.php'), 'utf8')).split('id="section-2e070d0c2f"')[0], extension: 'html' });
const used = new Set(new Scanner({}).scanFiles(sources));
const critical = postcss.parse(css);
critical.walkRules(rule => {
    if (rule.parent.type === 'atrule' && /keyframes$/.test(rule.parent.name)) return;
    const classes = [...rule.selector.matchAll(/(?<!\\)\.((?:\\[0-9a-fA-F]{1,6}\s?|\\.|[\w-])+)/g)].map(match => match[1].replace(/\\([0-9a-fA-F]{1,6})\s?|\\(.)/g, (_, hex, char) => hex ? String.fromCodePoint(parseInt(hex, 16)) : char));
    if (classes.length && !classes.some(name => used.has(name))) rule.remove();
});
critical.walkAtRules('font-face', rule => {
    if (!rule.toString().includes('font-family:Poppins')) rule.remove();
});
critical.walkAtRules(rule => { if (rule.nodes && !rule.nodes.length) rule.remove(); });
const inline = transform({ filename: 'frontend-critical.css', code: Buffer.from(critical.toString()), minify: true }).code;
await writeFile(resolve(cssFolder, 'frontend-critical.css'), inline);
console.log(`Frontend CSS: full ${full.length} bytes (${gzipSync(full).length} gzip), critical ${inline.length} bytes (${gzipSync(inline).length} gzip)`);
