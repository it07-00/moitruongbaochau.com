import { readFile, writeFile, readdir } from 'node:fs/promises';
import { resolve, dirname } from 'node:path';
import { fileURLToPath } from 'node:url';
import { compile, optimize } from '@tailwindcss/node';
import { Scanner } from '@tailwindcss/oxide';

const root = resolve(dirname(fileURLToPath(import.meta.url)), '../..');
const folder = resolve(root, 'resources/views/frontend/landing/ghg-service');
const files = (await readdir(folder)).filter(name => name.endsWith('.blade.php')).map(name => resolve(folder, name));
files.push(resolve(root, 'public/landing/ghg-service/js/consultation-form.js'));
const scanner = new Scanner({});
const candidates = scanner.scanFiles(await Promise.all(files.map(async file => ({ content: await readFile(file, 'utf8'), extension: file.endsWith('.js') ? 'js' : 'html' }))));
const input = resolve(root, 'resources/css/ghg-landing.css');
const compiler = await compile(await readFile(input, 'utf8'), { base: dirname(input), onDependency() {} });
const output = optimize(compiler.build(candidates), { minify: true }).code;
await writeFile(resolve(root, 'public/landing/ghg-service/css/tailwind.css'), output);
console.log(`Landing CSS: ${candidates.length} candidates, ${Buffer.byteLength(output)} bytes`);
