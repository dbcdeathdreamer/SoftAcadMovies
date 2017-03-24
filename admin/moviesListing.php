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
                    Movies Listing
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
    <!-- Content Column -->
    <div class="col-md-9">
        <a href="addMovie.php"  class="btn btn-info pull-right">Create Movie</a>
        <?php
        if (isset($_SESSION['flash']) && $_SESSION['flash'] != '') {
            echo $_SESSION['flash'];
            unset($_SESSION['flash']);
        }


        $db = db::getInstance();
        $movies = $db->get('movies');
        ?>


        <table class="table">
            <tr>
                <th>Id</th>
                <th>Title</th>
                <th>Description</th>
                <th>Duration</th>
                <th>Year</th>
                <th>Genres</th>
                <th>Director</th>
                <th>Writers</th>
                <th>Cast</th>
                <th>Rating</th>
                <th>Cover Photo</th>
                <th>Youtube Link</th>
                <th>Language</th>
                <th>Category</th>


            </tr>
            <?php foreach ($movies as $movie) : ?>
                <tr>
                    <td><?php echo $movie['id'] ?></td>
                    <td><?php echo $movie['title'] ?></td>
                    <td><?php echo $movie['description'] ?></td>
                    <td><?php echo $movie['duration'] ?></td>
                    <td><?php echo $movie['year'] ?></td>
                    <td><?php echo $movie['genres'] ?></td>
                    <td><?php echo $movie['director'] ?></td>
                    <td><?php echo $movie['writers'] ?></td>
                    <td><?php echo $movie['cast'] ?></td>
                    <td><?php echo $movie['rating'] ?></td>
                    <td>
                        <img style="width:50px; height:50px;" src="<?php echo MOVIES_PICS_URL.'/'.$movie['cover_photo'] ?>" alt="">

                    </td>
                    <td><?php echo $movie['youtube_link'] ?></td>
                    <td><?php echo $movie['language'] ?></td>
                    <td><?php echo $movie['movies_categories_id'] ?></td>

                    <td>
                        <a href="movieImages.php?id=<?php echo $movie['id']; ?>"  class="btn btn-warning">Movie Images</a>
                        <a href="editMovie.php?id="  class="btn btn-warning">Edit</a>
                        <a href="deleteMovie.php?id=>"  class="btn btn-danger">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>

        </table>

    </div>
</div>
<!-- /.row -->

<?php require_once 'common/footer.php'; ?>