<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />

        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }
            html, body {
                height: 100%;
                width: 100%;
                background-color: #f0f0f0;
                font-family: sans-serif;
                font-size: 16px;
                line-height: 20px;
                color: #222;
            }
            fieldset {
                width: 420px;
                height: 190px;
                border: 1px solid #ccc;
                position: absolute;
                top: calc(50% - 95px);
                left: calc(50% - 210px);
                background-color: #fff;
                text-align: center;
                padding: 5px;
            }
            fieldset * {
                padding: 5px;
            }
            input[type="email"],
            input[type="password"] {
                text-align: left;
                width: 100%;
                font-family: sans-serif;
                font-size: 16px;
                line-height: 20px;
            }
            input[type="submit"] {
                cursor: pointer;
                background-color: #eee;
                border: 1px solid #ccc;
                padding: 5px 15px;
                font-family: sans-serif;
                font-size: 16px;
                line-height: 20px;
            }
            input[type="submit"]:hover,
            input[name="login"] {
                background-color: #4169e1;
                color: #fff;
            }
            .error {
                background-color: #fff0f5;
                padding: 5px;
                margin-bottom: 1px;
                border: 1px solid #ccc;
                text-align: center;
                color: #b00;
            }
            legend {
                color: #4169e1;
                font-size: 22px;
            }
            a {
                color: #4169e1;
                text-decoration: none;
            }
            a:hover {
                text-decoration: underline;
            }
            .text-right {
                text-align: right;
            }
            .float-left {
                float: left;
            }
            .float-right {
                float: right;
            }
        </style>
    </head>
    <body>
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
    </body>
</html>