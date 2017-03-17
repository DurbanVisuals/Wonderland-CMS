<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Wonderland CMS</title>

        <!-- Bootstrap -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">

        <!-- Wonderland -->
        <link rel="stylesheet" href="css/main.min.css?v=<?php echo time(); ?>">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.2/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>

    <body>

        <header>
            <nav class="navbar navbar-default" role="navigation">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#utility">
                        <span class="sr-only">Utility Menu</span>
                        <i class="fa fa-bars"></i>
                    </button>
                </div>
                <div class="collapse navbar-collapse" id="utility">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="#"><i class="fa fa-plus"></i> New Story</a></li>
                        <li><a href="#"><i class="fa fa-edit"></i> Edit Story</a></li>
                        <li><a href="#"><i class="fa fa-list"></i> Edit Categories</a></li>
                        <li><a href="#"><i class="fa fa-tags"></i> Edit Tags</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-user-circle"></i>
                                <span class="name">John Doe</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="#"><i class="fa fa-cog"></i> Settings</a></li>
                                <li><a href="#"><i class="fa fa-sign-out"></i> Sign-out</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
            <nav class="navbar navbar-inverse" role="navigation">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#editor">
                        <span class="sr-only">Editor Menu</span>
                        <i class="fa fa-bars"></i>
                    </button>
                </div>
                <div class="collapse navbar-collapse" id="editor">
                    <ul class="nav navbar-nav">
                        <li class="input">
                            <label for="status">Status</label>
                            <select class="form-control">
                                <option value="0" default selected>Draft</option>
                                <option value="1">Published</option>
                            </select>
                        </li>
                        <li class="input">
                            <label for="status">Visibility</label>
                            <select class="form-control">
                                <option value="0" default selected>Public</option>
                            </select>
                        </li>
                        <li class="input">
                            <label for="status">Publish</label>
                            <input type="datetime-local" class="form-control">
                        </li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="#"><i class="fa fa-save"></i> Save Draft</a></li>
                        <li><a href="#"><i class="fa fa-eye"></i> Preview</a></li>
                        <li><a href="#"><i class="fa fa-save"></i> Publish</a></li>
                    </ul>
                </div>
            </nav>
        </header>
        <main>
            <section class="container-fluid">
                <form class="card" action="index.html" method="post">
                    <div class="form-group">
                        <label for="">Title</label>
                        <input type="text" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">Alias</label>
                        <input type="text" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">Summary</label>
                        <textarea class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="">Content</label>
                        <textarea class="wysiwyg form-control"></textarea>
                    </div>
                </form>
            </section>
        </main>
        <footer>

        </footer>

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <!-- Wonderland -->
        <link rel="stylesheet" href="js/main.js?v=<?php echo time(); ?>">
    </body>

</html>
