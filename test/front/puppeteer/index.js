const puppeteer = require('puppeteer');

async function screenShot(url, path, name) {
    await console.log('Screen Shot ... ');
    await console.log('Save path: ' + path + name + '.png');
    const browser = await puppeteer.launch();
    const page = await browser.newPage();
    await page.goto(url);
    await page.screenshot({path: path + name + '.png'});

    await browser.close();
}

screenShot('http://masterlab.ink','d:/','test');