<?php
        //requier important files
        require_once('template.class.php');
        define('TEMPLATE_PATH', 'template');

        //instanciate a new onject
        $template = new Template(TEMPLATE_PATH.'/tpl.html');

        //file import... if there are any
        $staty = file_get_contents('src/staty.txt');


        //assign valuse
        $template->assign('title','Staty');
        $template->assign('Staty', $staty);

        //show
        $template->show();
