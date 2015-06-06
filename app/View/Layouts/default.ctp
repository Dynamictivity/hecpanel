<?php
/**
 *  HE cPanel -- Hosting Engineers Control Panel
 *  Copyright (C) 2015  Dynamictivity LLC (http://www.hecpanel.com)
 *
 *   This program is free software: you can redistribute it and/or modify
 *   it under the terms of the GNU Affero General Public License as
 *   published by the Free Software Foundation, either version 3 of the
 *   License, or (at your option) any later version.
 *
 *   This program is distributed in the hope that it will be useful,
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *   GNU Affero General Public License for more details.
 *
 *   You should have received a copy of the GNU Affero General Public License
 *   along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
?>

<?php
$websiteDescription = Configure::read(APP_CONFIG_SCOPE . '.App.appName');
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="en" class="no-js"> <!--<![endif]-->
    <head>
        <title>
            <?php echo $websiteDescription ?>:
            <?php echo $this->fetch('title'); ?>
        </title>

        <?php echo $this->Html->charset(); ?>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="<?php echo $websiteDescription ?>">
        <meta name="author" content="Dynamictivity LLC">

        <!-- Google Font: Open Sans -->
        <?php
        echo $this->Html->css('http://fonts.googleapis.com/css?family=Open+Sans:400,400italic,600,600italic,800,800italic');
        echo $this->Html->css('http://fonts.googleapis.com/css?family=Oswald:400,300,700');
        ?>

        <!-- Font Awesome CSS -->
        <?php //echo $this->Html->css('font-awesome.min'); ?>
        <?php echo $this->Html->css('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/3.2.1/css/font-awesome.min.css'); ?>

        <!-- Bootstrap CSS -->
        <?php echo $this->Html->css('bootstrap.min'); ?>

        <!-- App CSS -->
        <?php
        echo $this->Html->css('ux-admin');
        echo $this->Html->css('ux-flat');
        echo $this->Html->css('hse');
        ?>

        <!-- Favicon -->
        <?php echo $this->Html->meta('favicon'); ?>

        <!-- jQuery Version 1.11.0 -->
        <?php echo $this->Html->script('https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js'); ?>

        <!-- Bootstrap Core JavaScript -->
        <?php echo $this->Html->script('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js'); ?>

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <?php echo $this->Html->script('https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js'); ?>
        <?php echo $this->Html->script('https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js'); ?>
        <![endif]-->
        <?php
        echo $this->fetch('meta');
        echo $this->fetch('css');
        ?>
    </head>

    <body class=" ">
        <div id="wrapper">
            <header class="navbar navbar-inverse" role="banner">
                <div class="container">
                    <div class="navbar-header">
                        <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".navbar-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <i class="fa fa-cog"></i>
                        </button>
                        <a href="./" class="navbar-brand navbar-brand-img">
                            <?php $env = null; ?>
                            <?php if (Configure::read(APP_CONFIG_SCOPE . '.App.environment') != 'PROD') : ?>
                                    <?php $env = ' <sup>' . Configure::read(APP_CONFIG_SCOPE . '.App.environment') . '</sup>'; ?>
                            <?php endif; ?>
                            <?php echo $this->Html->link($websiteDescription . $env, '/', array('class' => 'navbar-brand', 'escape' => false)); ?>
                        </a>
                    </div> <!-- /.navbar-header -->
                    <nav class="collapse navbar-collapse" role="navigation">
                        <ul class="nav navbar-nav noticebar navbar-left">
                            <?php //echo $this->element('Main/notifications'); ?>
                            <?php //echo $this->element('Main/messages'); ?>
                            <?php //echo $this->element('Main/alerts'); ?>
                        </ul>
                        <?php echo $this->element('Nav/top_right'); ?>
                    </nav>
                </div> <!-- /.container -->
            </header>

            <div class="mainnav">
                <div class="container">
                    <a class="mainnav-toggle" data-toggle="collapse" data-target=".mainnav-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <i class="fa fa-bars"></i>
                    </a>
                    <nav class="collapse mainnav-collapse" role="navigation">
                        <!-- <form class="mainnav-form pull-right" role="search">
                                <input type="text" class="form-control input-md mainnav-search-query" placeholder="Search">
                                <button class="btn btn-sm mainnav-form-btn"><i class="fa fa-search"></i></button>
                        </form>-->
                    <?php if (AuthComponent::user('id')): ?>
                        <ul class="mainnav-menu">
                        <?php if (AuthComponent::user('role_id') <= 2): ?>
                            <?php echo $this->element('Nav/admin'); ?>
                        <?php else: ?>
                            <?php echo $this->element('Nav/customer'); ?>
                        <?php endif; ?>
                        </ul>
                    <?php endif; ?>
                    </nav>
                </div> <!-- /.container -->
            </div> <!-- /.mainnav -->

            <div class="content">
                <div class="container">
                    <?php if (AuthComponent::user('id') && AuthComponent::user('role_id') > 3): ?>
                    <div class="alert alert-warning" role="alert"><strong>UNCONFIRMED:</strong> <?php echo __('Your account is currently unconfirmed. Please check your e-mail for an account confirmation link. If you can\'t find the e-mail, please'); ?> <?php echo $this->Html->link(__('click here to re-set your account.'), array('controller' => 'users', 'action' => 'forgot', 'plugin' => false, 'admin' => false)); ?></div>
                    <?php endif; ?>
                    <?php echo $this->Session->flash('auth'); ?>
                    <?php echo $this->Session->flash(); ?>
                    <?php echo $this->fetch('content'); ?>
                </div> <!-- /.container -->
            </div> <!-- .content -->
        </div> <!-- /#wrapper -->

        <footer class="footer">
            <div class="container">
                <p class="pull-right"><?php echo(APP_SERVER_NAME); ?> || <?php echo(APP_GIT_VERSION); ?> || Copyright &copy; 2014-2015 Hosting Engineers a wholly owned subsidiary of Dynamictivity LLC || <?php echo $this->Html->link(__('Terms, Conditions and Privacy Policy'), array('controller' => 'users', 'action' => 'eula', 'plugin' => false, 'admin' => false)); ?> || <?php echo $this->Html->link($this->Html->image('cake.power.gif'), 'http://cakephp.org', array('escape' => false, 'target' => '_blank')); ?></p>
            </div>
        </footer>

        <!-- Bootstrap core JavaScript
        ================================================== -->

        <!--[if lt IE 9]>
            <?php echo $this->Html->script('libs/excanvas.compiled'); ?>
        <![endif]-->

        <!-- App JS -->
        <?php echo $this->Html->script('ux-core'); ?>
        <?php echo $this->Html->script('ux-admin'); ?>

        <!-- HSE -->
        <?php echo $this->Html->script('app'); ?>

        <?php
        // Output scripts
        echo $this->fetch('script');
        // Google analytics
        echo $this->element('analytics');
        ?>
    </body>
</html>