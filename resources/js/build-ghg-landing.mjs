import { readFile, writeFile, readdir } from 'node:fs/promises';
import { resolve, dirname } from 'node:path';
import { fileURLToPath } from 'node:url';
import { createHash } from 'node:crypto';
import { compile, optimize } from '@tailwindcss/node';
import { Scanner } from '@tailwindcss/oxide';
import { transform } from 'lightningcss';

const root = resolve(dirname(fileURLToPath(import.meta.url)), '../..');
const folder = resolve(root, 'resources/views/frontend/landing/ghg-service');
const files = (await readdir(folder)).filter(name => name.endsWith('.blade.php')).map(name => resolve(folder, name));
const scriptFolder = resolve(root, 'public/landing/ghg-service/js');
const scriptNames = ['consultation-form.js', 'bootstrap.bundle.min.js', 'aos.js', 'partners-carousel.js'];
files.push(...scriptNames.map(name => resolve(scriptFolder, name)));
const sources = await Promise.all(files.map(async file => ({ content: await readFile(file, 'utf8'), extension: file.endsWith('.js') ? 'js' : 'html' })));
const scanner = new Scanner({});
const candidates = scanner.scanFiles(sources.filter((source, index) => !scriptNames.slice(1).some(name => files[index].endsWith(name))));
const input = resolve(root, 'resources/css/ghg-landing.css');
const compiler = await compile(await readFile(input, 'utf8'), { base: dirname(input), onDependency() {} });
const cssFolder = resolve(root, 'public/landing/ghg-service/css');
const stylesheets = ['inter.css', 'bootstrap-icons.min.css', 'global.css', 'bootstrap.min.css', 'modal-auth.css', 'aos.css', 'styles.css', 'consultation-form.css'];
// Include runtime states, including Bootstrap's constructed backdrop class names.
const usedSymbols = new Set(sources.flatMap(source => source.content.match(/[A-Za-z_][\w-]*/g) ?? []));
['modal-backdrop', 'modal-open', 'show', 'showing', 'hiding', 'fade', 'active', 'collapsing', 'aos-init', 'aos-animate'].forEach(name => usedSymbols.add(name));
const templateCss = (await Promise.all(stylesheets.map(async name => {
    const css = await readFile(resolve(cssFolder, name), 'utf8');
    if (!['bootstrap.min.css', 'bootstrap-icons.min.css'].includes(name)) return css;

    const unusedSymbols = new Set();
    transform({
        filename: name,
        code: Buffer.from(css),
        visitor: {
            Selector(selector) {
                for (const component of selector) {
                    if (component.type === 'class' && !usedSymbols.has(component.name)) unusedSymbols.add(component.name);
                }
            },
        },
    });
    return transform({ filename: name, code: Buffer.from(css), minify: true, unusedSymbols: [...unusedSymbols] }).code.toString();
}))).join('\n');
let bundledCss = templateCss + '\n' + compiler.build(candidates);
const assetVersions = new Map();
for (const match of bundledCss.matchAll(/url\((['"]?)([^)'"\s]+)\1\)/g)) {
    const url = match[2];
    if (/^(data:|https?:|\/|#)/.test(url) || assetVersions.has(url)) continue;
    const file = resolve(cssFolder, url.split('?')[0]);
    const version = createHash('sha256').update(await readFile(file)).digest('hex').slice(0, 12);
    assetVersions.set(url, `${url.split('?')[0]}?v=${version}`);
}
bundledCss = bundledCss.replace(/url\((['"]?)([^)'"\s]+)\1\)/g, (match, quote, url) => assetVersions.has(url) ? `url(${quote}${assetVersions.get(url)}${quote})` : match);
const output = optimize(bundledCss, { minify: true }).code;
await writeFile(resolve(root, 'public/landing/ghg-service/css/tailwind.css'), output);
console.log(`Landing CSS: ${candidates.length} candidates, ${Buffer.byteLength(output)} bytes`);
