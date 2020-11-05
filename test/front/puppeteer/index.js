

'use strict';

const puppeteer = require('puppeteer');

(async () => {
    const browser = await puppeteer.launch({headless: false,defaultViewport:{width :1440,height:900}});
    const page = await browser.newPage();

    await page.goto('http://masterlab.ink');

    // Type into search box.
    await page.type('#user_login', 'master');
    await page.type('#user_password', '123456');

    // Wait for suggest overlay to appear and click "show all results".
    const submit_btn = '#login_submit_btn';
    await page.waitForSelector(submit_btn);
    await page.click(submit_btn);


    // extra-item-num
    const resultsSelectorSpan = '.extra-item-num';
    await page.waitForSelector(resultsSelectorSpan);
    // Extract the results from the page.
    const spans = await page.evaluate((resultsSelectorSpan) => {
        const anchors = Array.from(document.querySelectorAll(resultsSelectorSpan));
        return anchors.map((anchor) => {
            const title = anchor.textContent.split('|')[0].trim();
            return `${title} - ${anchor.className}`;
        });
    }, resultsSelectorSpan);
    console.log(spans.join('\n'));

    await page.goto('http://masterlab.ink/default/example');

    // Wait for the results page to load and display the results.
    const resultsSelector = 'a.commit-row-message';
    await page.waitForSelector(resultsSelector);
    // Extract the results from the page.
    const links = await page.evaluate((resultsSelector) => {
        const anchors = Array.from(document.querySelectorAll(resultsSelector));
        return anchors.map((anchor) => {
            const title = anchor.textContent.split('|')[0].trim();
            return `${title} - ${anchor.href}`;
        });
    }, resultsSelector);
    console.log(links.join('\n'));

    // 进入项目列表，点击创建
    await page.goto('http://masterlab.ink/projects');
    const btn_create = '.btn-create';
    await page.waitForSelector(btn_create);
    await page.click(btn_create);

    await page.waitForSelector('.qq-uploader-selector');
    await page.type('#project_name', 'TestProject');
    await page.type('#project_key', 'testproject');
    await page.select('#project_lead', '1');
    await page.select('#project_tpl_id', '1');
    await page.evaluate(" $('.selectpicker').selectpicker('refresh');");
    await page.click('input[name=commit]');
    await page.waitForSelector('a[title="所有事项"]');

    // js_admin_do_delet
    await page.goto('http://masterlab.ink/admin/project');
    await page.waitForSelector('a[data-name=TestProject].js_admin_do_delete');

    // 删除项目
    let deleteElement = await page.$('a[data-name=TestProject].js_admin_do_delete');
    const project_id = await page.$eval('a[data-name=TestProject].js_admin_do_delete', el => el.getAttribute('data-project_id'));
    await page.evaluate(`project.projectRemove(${project_id}, 30)`);

    //await browser.close();
})();