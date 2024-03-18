const fs = require("node:fs");
const path = require("node:path");
const { compilePHP, compilePost } = require("./common");

async function* walk(dir) {
    const dirents = await fs.readdirSync(dir, { withFileTypes: true });
    for (const dirent of dirents) {
        const entry = path.join(dir, dirent.name);
        if (dirent.isDirectory()) {
            yield* walk(entry);
        } else {
            yield entry;
        }
    }
}

async function importCsso() {
    // Load csso module
    return import("./vendor/csso.mjs");
}

function compilePHPAsync(page) {
    return new Promise((resolve, reject) => {
        compilePHP(page, (err, result) => {
            if (err) {
                reject(err);
            } else {
                resolve(result);
            }
        });
    });
}

function compilePostAsync(page) {
    return new Promise((resolve, reject) => {
        compilePost(page, (err, result) => {
            if (err) {
                reject(err);
            } else {
                resolve(result);
            }
        });
    });
}

async function main() {
    try {
        fs.mkdirSync("build", { recursive: true });

        console.log("Copying static files");
        for await (const p of walk('public')) {
            const destPath = path.join("build", path.relative("public", p));
            console.log(destPath);

            // Check if it's a CSS file
            if (p.endsWith(".css")) {
                // If yes minify with CSSO
                const csso = await importCsso();
                const cssContent = await fs.promises.readFile(p, 'utf-8');
                const minifiedCss = csso.minify(cssContent).css;
                // Save compiled CSS to build directory
                await fs.promises.mkdir(path.dirname(destPath), { recursive: true });
                await fs.promises.writeFile(destPath, minifiedCss);
                console.log(`Minified and copied ${p} to ${destPath}`);
            } else {
                // Copy file to build directory
                await fs.promises.mkdir(path.dirname(destPath), { recursive: true });
                await fs.promises.copyFile(p, destPath);
                console.log(`Copied ${p} to ${destPath}`);
            }
        }


        console.log("Compiling PHP files and saving as HTML...");
        for await (const p of walk('pages')) {
            if (p.endsWith(".php")) {
                const pageName = path.basename(p, ".php");
                // Compile PHP file
                const result = await compilePHPAsync(pageName);
                // Save compiled HTML to build directory
                const destPath = path.join('build', pageName + ".html");
                await fs.promises.mkdir(path.dirname(destPath), { recursive: true });
                await fs.promises.writeFile(destPath, result, 'utf-8')
                    .then(() => console.log(`Compiled ${p} and saved as ${destPath}`))
                    .catch((err) => console.error(`Error saving ${destPath}: ${err.message}`));
            }
        }

        console.log("Compiling and saving posts...");
        // List files in the posts directory
        const postFiles = await fs.readdirSync("posts");

        // Iterate through each file
        for (const postFile of postFiles) {
            if (postFile.endsWith(".md")) {
                const postPath = path.join("posts", postFile);
                const postName = path.basename(postFile, ".md");

                // Compile post content asynchronously
                const compiledHTML = await compilePostAsync("/posts/" + postName);

                // Save compiled HTML to build/posts directory
                const destPath = path.join("build/posts", `${postName}.html`);
                await fs.promises.mkdir(path.dirname(destPath), { recursive: true });
                await fs.promises.writeFile(destPath, compiledHTML, 'utf-8');
                console.log(`Compiled ${postPath} and saved as ${destPath}`);
            }
        }
    } catch (e) {
        console.error("An error occurred:", e);
        process.exit(1);
    }
}

main().catch(console.error);