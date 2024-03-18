const { spawn } = require('node:child_process');
const fs = require('node:fs');
const path = require('node:path');

function getPHPPagePath(page) {
    if (page == "/") page = "index";

    const phpPath = path.join('pages', page + '.php');
    return phpPath;
}

function isPHPPage(page) {
    return fs.existsSync(getPHPPagePath(page));
}

function isPostPage(page) {
    if (!page.startsWith("/posts/")) return false;
    return fs.existsSync("." + path.join(page + '.md'));
}

function runPHP(args, callback) {
    let resultData = '';

    const ps = spawn('php', args);
    ps.stdout.on('data', (data) => {
        resultData += data;
    });
    ps.stderr.on('data', (data) => {
        process.stderr.write(data);
    });

    ps.on('close', (code) => {
        if (code == 0) {
            callback(null, resultData);
        } else {
            console.log(resultData);
            callback(new Error("PHP exited unsucessfully:" + code), null);
        }
    });
}

function compilePHP(page, callback) {
    const pagePath = getPHPPagePath(page);
    const args = ['-f', path.resolve(pagePath)];
    runPHP(args, callback);
}

function compilePost(page, callback) {
    const args = ['-f', 'layout/blogpost.php', "post=." + (page + '.md')];
    runPHP(args, callback);
}

module.exports = {
    getPHPPagePath,
    isPHPPage,
    isPostPage,
    compilePHP,
    compilePost,
}