<?php require_once 'common/header.php'; ?>
<?php if (!isLoggedInAdmin()) {
    redirect('login.php');
} ?>
    <!-- Page Heading/Breadcrumbs -->
    <div class="row">
        <div class="col-lg-12">
            <ol class="breadcrumb">
                <li>
                    <a href="index.php">Home</a>
                </li>
                <li class="active">
                    Movie Images
                </li>
            </ol>
        </div>
    </div>
    <!-- /.row -->
    <!-- Content Row -->
    <div class="row">
        <!-- Sidebar Column -->
        <div class="col-md-3">
            <?php require_once 'common/nav.php'; ?>
        </div>
        <?php

      ?>



        <!-- Content Column -->
        <div class="col-md-9">
            <form action="" method="post" enctype="multipart/form-data">
                Upload Movie Image
                <input type="file" name="image"/>
                <input type="submit" value="Upload" name="submit"/>
            </form>

            <div class="row">
                <?php foreach ($images as $image) : ?>
                    <div class="col-xs-6 col-md-3">
                        <a href="#" class="thumbnail">
                            <img src="<?php echo MOVIES_PICS_URL.'/'.$image->getImage(); ?>" alt="...">
                        </a>
                        <a href="index.php?c=movies&m=deleteMovieImage&id=<?php echo $image->getId(); ?>">Delete</a>
                    </div>
                <?php endforeach; ?>
            </div>

        </div>
    </div>
    <!-- /.row -->

<?php require_once 'common/footer.php'; ?>