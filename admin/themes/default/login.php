<!DOCTYPE html>
<html>
<head>
    <title><?php echo ULTRANAME; ?></title>
    <meta charset="utf-8"/>
<?php
    echo get_assets_css();
    echo get_assets_js();
?>
    <style type="text/css">
        body {
            background-color: #fbfbfb;
        }
        .cms-form-center{
            background-color: #fff;
            margin-top:10%;
            border: 1px solid #dcdcdc;
            -webkit-box-shadow: rgba(200,200,200,0.7) 0 4px 10px -1px;
                    box-shadow: rgba(200,200,200,0.7) 0 4px 10px -1px;
        }
        .namelogo{
            padding:20px 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <span class="col-md-4 col-lg-4 col-md-offset-4 col-lg-offset-4 cms-form-center text-center img-rounded">

                <h1 class="namelogo"><?php echo ULTRANAME; ?></h1>

                <?php admin_err_suc_msg() ?>

                <form method="post" class="form cms-form" action="">
                    <input type="hidden" name="do_login" value="login" />
                    <div class="form-group">
                        <!-- <label for="login_email"></label> -->
                        <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-user"></i></div>
                            <input type="email" class="form-control" id="login_email" name="email" placeholder="E-Mail" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <!-- <label for="login_password"></label> -->
                        <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-lock"></i></div>
                            <input type="password" class="form-control" id="login_password" name="password" placeholder="Senha" required> 
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" value="Login">
                        <a href="javascript:;" class="btn btn-default" onclick="jQuery('form').slideToggle();return false;">Recuperar senha</a>
                    </div>
                </form>

                <form method="post" class="form cms-form" style="display:none;" action="<?php echo admin_url('/auth/recover') ?>">
                    <input type="hidden" name="do_login" value="login_recover" />
                    <div class="form-group">
                        <!-- <label for="login_email"></label> -->
                        <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-user"></i></div>
                            <input type="email" class="form-control" id="recover_email" name="email" placeholder="E-Mail" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" value="Recuperar">
                        <a href="javascript:;" class="btn btn-default" onclick="jQuery('form').slideToggle();return false;">Login</a>
                    </div>
                </form>

            </span>

        </div>
    </div>

</body>
</html>