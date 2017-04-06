<?php

class MoviesController extends Controller
{

    public function index()
    {
        $search     = (isset($_GET['search']))? $_GET['search'] : '';
        $result    = (isset($_GET['results']) && (int)$_GET['results'] > 0)? $_GET['results'] : 1;
        $order      = (isset($_GET['order']) && (int)$_GET['order'] > 0)? $_GET['order'] : 1;

        switch ($result) {
            case "1":
                $perPage = 5;
                break;
            case "2":
                $perPage = 10;
                break;
            case "3":
                $perPage = 20;
                break;
        }

        switch ($order) {
            case 1:
                $orderBy = ' title ASC ';
                break;
            case 2:
                $orderBy = ' title DESC ';
                break;

        }

        $like = [];
        if ($search != '') {
            $like = ['title', $search];
        }



        $page = (isset($_GET['page']) && (int)$_GET['page'] > 0)? $_GET['page'] : 1;

        $offset  = ($page-1)*$perPage;

        $collection = new MoviesCollection();
        $movies = $collection->get([], $offset, $perPage, $like, $order);

        $totalRows = count($collection->get([], -1, 5, $like)) != 0 ? count($collection->get([], -1, 5, $like)) : 1;


        $pagination = new Pagination();

        $pagination->setPerPage($perPage);
        $pagination->setTotalRows($totalRows);
        $pagination->setBaseUrl('index.php?c=movies&search='.$search.'&results='.$result.'&order='.$order);


        $data = [
            'pagination' => $pagination,
            'movies'     => $movies,
            'search'     => $search,
            'result'     => $result,
            'order'      => $order,

        ];

        $this->loadView('movies/listing', $data);
    }

    public function create()
    {

        $data =[
            'title' => '',
            'description' => '',
            'duration' => '',
            'year' => '',
            'genres' => [],
            'director' => '',
            'writers' => '',
            'cast' => '',
            'cover_photo' => '',
            'youtube_link' => '',
            'language' => '',
            'movies_categories_id' => '',
            'category_id' => '',

        ];

        $errors = [
            'title' => [],
            'description' => [],
            'duration' => [],
            'year' => [],
            'genres' => [],
            'director' => [],
            'writers' => [],
            'cast' => [],
            'cover_photo' => [],
            'youtube_link' => [],
            'language' => [],
            'movies_categories_id' => [],
        ];
        $categoriesCollection = new MoviesCategoriesCollection();
        $categories = $categoriesCollection->get();

        if (isset($_POST['submit'])) {
            $extensions = ['jpg', 'jpeg', 'png', 'gif'];
            $data =[
                'title' => isset($_POST['title'])? htmlspecialchars(trim($_POST['title']), ENT_QUOTES, 'UTF-8'): '',
                'description' => isset($_POST['description'])? htmlspecialchars(trim($_POST['description']), ENT_QUOTES, 'UTF-8'): '',
                'duration' => isset($_POST['duration'])? htmlspecialchars(trim($_POST['duration']), ENT_QUOTES, 'UTF-8'): '',
                'year' => isset($_POST['year'])? htmlspecialchars(trim($_POST['year']), ENT_QUOTES, 'UTF-8'): '',
                'genres' => isset($_POST['genres'])? $_POST['genres'] : [],
                'director' => isset($_POST['director'])? htmlspecialchars(trim($_POST['director']), ENT_QUOTES, 'UTF-8'): '',
                'writers' => isset($_POST['writers'])? htmlspecialchars(trim($_POST['writers']), ENT_QUOTES, 'UTF-8'): '',
                'cast' => isset($_POST['cast'])? htmlspecialchars(trim($_POST['cast']), ENT_QUOTES, 'UTF-8'): '',
                'cover_photo' => isset($_POST['cover_photo'])? htmlspecialchars(trim($_POST['cover_photo']), ENT_QUOTES, 'UTF-8'): '',
                'youtube_link' => isset($_POST['youtube_link'])? htmlspecialchars(trim($_POST['youtube_link']), ENT_QUOTES, 'UTF-8'): '',
                'language' => isset($_POST['language'])? htmlspecialchars(trim($_POST['language']), ENT_QUOTES, 'UTF-8'): '',
                'movies_categories_id' => isset($_POST['movies_categories_id'])? htmlspecialchars(trim($_POST['movies_categories_id']), ENT_QUOTES, 'UTF-8'): '',
            ];


            if (isset($_FILES['cover_photo'])) {
                $file = $_FILES['cover_photo'];
                $ex = explode('.', $file['name']);
                $ext = strtolower(end($ex));
                if (!in_array($ext, $extensions)) {
                    $errors['cover_photo'][] = 'Wrong file type';
                }

                if ($file['size'] > 2000000) {
                    $errors['cover_photo'][] = 'File size is too big';
                }

                if (!is_dir(__DIR__.'/../../../uploads/movies')) {
                    mkdir(__DIR__.'/../../../uploads/movies');
                }

                $newName = sha1(time()).'.'.$ext;


            }

            $data['cover_photo'] = $newName;


            if (empty(array_filter($errors))) {

                $data['genres'] = serialize($data['genres']);

                $moviesCollection = new MoviesCollection();
                $entity = new MoviesEntity();
                $entity->init($data);
                $moviesCollection->save($entity);

                //Записване в базата данни на името на снимката заедно с другата информация от POST
                move_uploaded_file($file['tmp_name'], __DIR__.'/../../../uploads/movies/'.$newName);
                redirect('index.php?c=movies&m=index');
            }
        }

        echo '<pre>';
        var_dump($data);
        echo '</pre>';
        $viewData['categories'] = $categories;
        $viewData['data']       = $data;
        $viewData['errors']     = $errors;

        $this->loadView('movies/create', $viewData);
    }

    public function movieImages()
    {
        $id = (isset($_GET['id']) && (int)$_GET['id']>0)?$_GET['id']: false;
        if (!$id) {
            redirect('index.php?c=movies');
        }

        $imagesCollection = new MoviesImagesCollection();
        $moviesCollection = new MoviesCollection();

        $movie =  $moviesCollection->getOne(['id' => $id]);
        if (empty($movie)) {
            redirect('index.php?c=movies');
        }

        $images = $imagesCollection->get(['movies_id' => $id]);

        $extensions = ['jpg', 'jpeg', 'png', 'gif'];

        if (isset($_FILES['image'])) {
            $file = $_FILES['image'];
            $ex = explode('.', $file['name']);
            $ext = strtolower(end($ex));
            if (!in_array($ext, $extensions)) {
                $errors['image'][] = 'Wrong file type';
            }

            if ($file['size'] > 2000000) {
                $errors['image'][] = 'File size is too big';
            }

            if (!is_dir(__DIR__.'/../../../uploads/movies')) {
                mkdir(__DIR__.'/../../../uploads/movies');
            }

            $newName = sha1(time()).'.'.$ext;

            $data = [
                'movies_id' => $id,
                'image'    => $newName,
            ];

            $entity = new MoviesImagesEntity();
            $entity->init($data);
            $imagesCollection->save($entity);

            move_uploaded_file($file['tmp_name'], __DIR__.'/../../../uploads/movies/'.$newName);

            redirect('index.php?c=movies&m=movieImages&id='.$id);
        }

        $viewData['images'] = $images;

        $this->loadView('movies/movieImages', $viewData);
    }

    public function deleteMovieImage()
    {

        if (!isLoggedInAdmin()) {
            redirect('login.php');
        }

        $collection = new MoviesImagesCollection();

        $id = isset($_GET['id']) ? $_GET['id'] : '';

        if ((int)$id <= 0) {
            redirect('index.php?c=movies');
        }

        $where = [
            'id' => $id
        ];
        $image = $collection->getOne($where);


        if (empty($image)) {
            redirect('index.php?c=movies');
        }


        $where = [
            'id' => $id
        ];
        $result = $collection->delete($where);
        unlink(__DIR__.'/../../../uploads/movies/'.$image->getImage());

        redirect('index.php?c=movies&m=movieImages&id='.$image->getMoviesId());

    }

}