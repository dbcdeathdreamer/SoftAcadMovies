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
                <li>
                    <a href="moviesListing.php">Movies</a>
                </li>
                <li class="active">
                    Create Movie
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

            <div class="row">
                <div class="col-md-4"></div>
                <div class="col-md-4">
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="form-group  <?php echo (!empty($errors['movies_categories_id']))? 'has-error': ''; ?>">
                            <select name="movies_categories_id" id="">
                                <option value="">-- Select Movie Category --</option>
                                <?php foreach($categories as $category) : ?>
                                    <option <?php echo  ($data['movies_categories_id'] == $category->getId())? 'selected' : ''; ?> value="<?php echo $category->getId() ?>"><?php echo $category->getTitle(); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group  <?php echo (!empty($errors['title']))? 'has-error': ''; ?>">
                            <label for="title">title</label>
                            <input type="text" value="<?php echo $data['title']; ?>" class="form-control" name="title" placeholder="Title" id="title" />
                            <?php foreach($errors['title'] as $errorTitle) { ?>
                                <div class="alert alert-danger" role="alert" style="margin-top:10px;">
                                    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                    <span class="sr-only">Error: </span>
                                    <?php echo $errorTitle; ?>
                                </div>
                            <?php } ?>
                            <?php //} ?>
                        </div>
                        <div class="form-group  <?php echo (!empty($errors['description']))? 'has-error': ''; ?>">
                            <label for="description">Description</label>
                            <input type="text" value="<?php echo $data['description']; ?>" class="form-control" name="description" placeholder="Description" id="name" />
                            <?php foreach($errors['description'] as $errorDescription) { ?>
                                <div class="alert alert-danger" role="alert" style="margin-top:10px;">
                                    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                    <span class="sr-only">Error: </span>
                                    <?php echo $errorDescription; ?>
                                </div>
                            <?php } ?>
                            <?php //} ?>
                        </div>
                        <div class="form-group  <?php echo (!empty($errors['duration']))? 'has-error': ''; ?>">
                            <label for="Duration">Duration</label>
                            <input type="number" value="<?php echo $data['duration']; ?>" class="form-control" name="duration" placeholder="Duration" id="Duration" />
                            <?php foreach($errors['duration'] as $errorName) { ?>
                                <div class="alert alert-danger" role="alert" style="margin-top:10px;">
                                    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                    <span class="sr-only">Error: </span>
                                    <?php echo $errorName; ?>
                                </div>
                            <?php } ?>
                            <?php //} ?>
                        </div>
                        <div class="form-group  <?php echo (!empty($errors['genres']))? 'has-error': ''; ?>">
                            <label for="Name">Genres</label>
                            <br/>
                            <input type="checkbox" name="genres[]" value="Drama" <?php echo  (in_array('Drama', $data['genres']))? 'checked' : ''; ?> /> Drama <br/>
                            <input type="checkbox" name="genres[]" value="Action" <?php echo (in_array('Action', $data['genres']))? 'checked' : ''; ?>/> Action <br/>
                            <input type="checkbox" name="genres[]" value="Comedy" <?php echo (in_array('Comedy', $data['genres']))? 'checked' : ''; ?>/> Comedy <br/>
                            <input type="checkbox" name="genres[]" value="Mystery" <?php echo (in_array('Mystery', $data['genres']))? 'checked' : ''; ?>/> Mystery <br/>


                            <?php foreach($errors['genres'] as $errorGenres) { ?>
                                <div class="alert alert-danger" role="alert" style="margin-top:10px;">
                                    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                    <span class="sr-only">Error: </span>
                                    <?php echo $errorGenres; ?>
                                </div>
                            <?php } ?>
                            <?php //} ?>
                        </div>
                        <div class="form-group  <?php echo (!empty($errors['director']))? 'has-error': ''; ?>">
                            <label for="director">Director</label>
                            <input type="text" value="<?php echo $data['director']; ?>" class="form-control" name="director" placeholder="director" id="director" />
                            <?php foreach($errors['director'] as $errorDirector) { ?>
                                <div class="alert alert-danger" role="alert" style="margin-top:10px;">
                                    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                    <span class="sr-only">Error: </span>
                                    <?php echo $errorDirector; ?>
                                </div>
                            <?php } ?>
                            <?php //} ?>
                        </div>
                        <div class="form-group  <?php echo (!empty($errors['writers']))? 'has-error': ''; ?>">
                            <label for="writers">Writers</label>
                            <input type="text" value="<?php echo $data['writers']; ?>" class="form-control" name="writers" placeholder="writers" id="name" />
                            <?php foreach($errors['writers'] as $errorWriters) { ?>
                                <div class="alert alert-danger" role="alert" style="margin-top:10px;">
                                    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                    <span class="sr-only">Error: </span>
                                    <?php echo $errorWriters; ?>
                                </div>
                            <?php } ?>
                            <?php //} ?>
                        </div>
                        <div class="form-group  <?php echo (!empty($errors['cast']))? 'has-error': ''; ?>">
                            <label for="cast">Cast</label>
                            <input type="text" value="<?php echo $data['cast']; ?>" class="form-control" name="cast" placeholder="cast" id="cast" />
                            <?php foreach($errors['cast'] as $errorCast) { ?>
                                <div class="alert alert-danger" role="alert" style="margin-top:10px;">
                                    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                    <span class="sr-only">Error: </span>
                                    <?php echo $errorCast; ?>
                                </div>
                            <?php } ?>
                            <?php //} ?>
                        </div>
                        <div class="form-group  <?php echo (!empty($errors['cover_photo']))? 'has-error': ''; ?>">
                            <label for="cover_photo">Cover Photo</label>
                            <input type="file"  class="form-control" name="cover_photo"  id="cover_photo" />
                            <?php foreach($errors['cover_photo'] as $errorCoverPhoto) { ?>
                                <div class="alert alert-danger" role="alert" style="margin-top:10px;">
                                    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                    <span class="sr-only">Error: </span>
                                    <?php echo $errorCoverPhoto; ?>
                                </div>
                            <?php } ?>
                            <?php //} ?>
                        </div>
                        <div class="form-group  <?php echo (!empty($errors['youtube_link']))? 'has-error': ''; ?>">
                            <label for="youtube_link">Youtube Link</label>
                            <input type="url" value="<?php echo $data['youtube_link']; ?>" class="form-control" name="youtube_link" placeholder="youtube_link" id="youtube_link" />
                            <?php foreach($errors['youtube_link'] as $errorYoutubeLink) { ?>
                                <div class="alert alert-danger" role="alert" style="margin-top:10px;">
                                    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                    <span class="sr-only">Error: </span>
                                    <?php echo $errorYoutubeLink; ?>
                                </div>
                            <?php } ?>
                            <?php //} ?>
                        </div>
                        <div class="form-group  <?php echo (!empty($errors['language']))? 'has-error': ''; ?>">
                            <label for="language">Language</label>
                            <input type="text" value="<?php echo $data['language']; ?>" class="form-control" name="language" placeholder="language" id="language" />
                            <?php foreach($errors['language'] as $errorLanguage) { ?>
                                <div class="alert alert-danger" role="alert" style="margin-top:10px;">
                                    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                                    <span class="sr-only">Error: </span>
                                    <?php echo $errorLanguage; ?>
                                </div>
                            <?php } ?>
                            <?php //} ?>
                        </div>


                        <input type="submit" class="btn btn-primary" name="submit" value="Add movie">
                    </form>
                </div>
                <div class="col-md-4"></div>
            </div>

        </div>
    </div>
    <!-- /.row -->

<?php require_once 'common/footer.php'; ?>