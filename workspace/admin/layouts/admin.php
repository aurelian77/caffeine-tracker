<!DOCTYPE html>
<html>
    <head>
        <title><?php print $this->vars->title ?? 'Caffeine Tracker'; ?></title>
        
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        
        <link rel="stylesheet" type="text/css" href="<?php print href('admin/static/css/admin.css', ['cache' => time()]); ?>" />
        
        <script type="text/javascript" src="<?php print href('admin/static/js/jquery.js', ['cache' => time()]); ?>"></script>
        
        <script type="text/javascript" src="<?php print href('admin/static/js/admin.js', ['cache' => time()]); ?>"></script>
    </head>
    <body>
        <header>
            <ul id="menu-left">
                <li>
                    <a href="#">Company Pages</a>
                </li>
                <li>
                    <a href="#">Users</a>
                </li>
                <li>
                    <a href="#">Projects</a>
                </li>
            </ul>
            <ul id="menu-right">
                <li>
                    <span class="badge">122345</span>
                    <img id="notific-trigger" alt="" src="<?php print href('admin/static/img/bell.png'); ?>" title="Notifications" />
                </li>
                <li>
                    <img id="user-trigger" alt="" src="<?php print href('admin/static/img/user.png'); ?>" title="Your account" />
                </li>
            </ul>
        </header>
        <div id="notific" class="none">
            <div class="notific-module">
                <span class="strong">Foo Bar</span> commented on <a>MPP-2381</a>
            </div>
            <div class="notific-module">
                <span class="strong">Foo Bar</span> logged 34 mins on <a>OK-3520</a>
            </div>
            <div class="notific-module">
                Status was changed from <span class="strong">In Testing</span> to <span class="strong">Not Accepted On Staging</span>
                on <a>MPP-2381</a> by <span class="strong">Konkhra</span>
            </div>
            <div id="notific-clear">
                <a>Clear notifications</a>
            </div>
        </div>
        <div id="user" class="none">
            <div class="user-module">
                <a>Edit profile</a>
            </div>
            <div class="user-module">
                <a>Logout</a>
            </div>
        </div>

        <main>
            <?php
            if (!empty($this->session('custom_errors'))) {
                foreach ($this->session('custom_errors') as $error) { 
                ?>
                    <div class="<?php print $this->session('messages_type'); ?>">
                        <?php print $error; ?>
                    </div>
                <?php 
                }
            }

            print $this->contentForLayout;
            ?>
        </main>
    </body>
</html>