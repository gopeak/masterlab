<div class="top-area">
    <ul class="nav-links issues-state-filters">
        <li class="<? if($top_active=='smtp_config') echo 'active';?>">
            <a id="state-opened" title="SMTP配置" href="<?=ROOT_URL?>admin/system/smtp_config"><span>SMTP配置</span>
            </a>
        </li>
        <li class="<? if($top_active=='email_queue') echo 'active';?>">
            <a id="state-all" title="邮件队列" href="<?=ROOT_URL?>admin/system/email_queue"><span>邮件队列</span>
            </a>
        </li>
        <li class="<? if($top_active=='send_mail') echo 'active';?>">
            <a id="state-all" title="发送邮件" href="<?=ROOT_URL?>admin/system/send_mail"><span>发送邮件</span>
            </a>
        </li>
    </ul>
</div>