<?php

class AdministratorsController extends Controller
{

    public function index()
    {
        if (!isLoggedInAdmin()) {
            redirect('index.php?c=login&m=login');
        }

        $page = (isset($_GET['page']) && (int)$_GET['page'] > 0)? $_GET['page'] : 1;
        $perPage = 5;
        $offset  = ($page-1)*$perPage;

        $collection = new UserCollection();
        $users = $collection->get([], $offset, $perPage);

        $totalRows = count($collection->get());


        $pagination = new Pagination();

        $pagination->setPerPage($perPage);
        $pagination->setTotalRows($totalRows);
        $pagination->setBaseUrl('index.php?c=administrators');

        $data = [
            'users'      => $users,
            'pagination' => $pagination,
        ];


        $this->loadView('administrators/listing', $data);
    }

    public function create()
    {
        $viewData = [];

        $data =[
            'username' => '',
            'password' => '',
            'email'    => '',
        ];

        $errors = [
            'username' => [],
            'password' => [],
            'email'    => [],
        ];


        if (isset($_POST['addAdmin'])) {
            $data =[
                'username' => isset($_POST['username'])? htmlspecialchars(trim($_POST['username']), ENT_QUOTES, 'UTF-8'): '',
                'password' => isset($_POST['password'])? htmlspecialchars(trim($_POST['password']), ENT_QUOTES, 'UTF-8'): '',
                'email'    => isset($_POST['email'])? htmlspecialchars(trim($_POST['email']), ENT_QUOTES, 'UTF-8'): '',
            ];


            $errors = isValidAddAdministrator($data);

            $flag = checkForErrors($errors);

            if ($flag === true) {
                //Записваме стойността от полетата в базата данни
                $data['password'] = sha1($data['password']);

                $entity = new UserEntity();
                $entity->init($data);
                $collection = new UserCollection();
                $collection->save($entity);

                $_SESSION['flash'] = 'Записът беше записан в базата данни успешно.';

                redirect('index.php?c=administrators');
            }

        }

        $viewData['data'] = $data;
        $viewData['errors'] = $errors;

        $this->loadView('administrators/create', $viewData);
    }

    public function update()
    {

        $id = (isset($_GET['id'])) ? $_GET['id'] : '';
        if ((int)$id <= 0) {
            redirect('index.php?c=administrators');
        }

        $collection = new UserCollection();
        $where = ['id' => $id];
        $user = $collection->getOne($where);

        if (empty($user)) {
            redirect('index.php?c=administrators');
        }

        $data =[
            'id'        => $user->getId(),
            'username'  => $user->getUsername(),
            'email'     => $user->getEmail(),
        ];

        $errors = [
            'username' => [],
            'email'    => [],
        ];


        if (isset($_POST['editAdmin'])) {

            $data =[
                'id' => $user->getId(),
                'username' => isset($_POST['username'])? htmlspecialchars(trim($_POST['username']), ENT_QUOTES, 'UTF-8'): '',
                'email'    => isset($_POST['email'])? htmlspecialchars(trim($_POST['email']), ENT_QUOTES, 'UTF-8'): '',
            ];

            $errors = isValidAddAdministrator($data);
            $flag = checkForErrors($errors);

            if ($flag === true) {

                $user->init($data);
                $collection->save($user);

                $_SESSION['flash'] = 'Записът беше записан в базата данни успешно.';

                redirect('index.php?c=administrators');
                exit;
            }

        }


        $viewData['errors'] = $errors;
        $viewData['data']   = $data;

        $this->loadView('administrators/update', $viewData);
    }

    public function delete()
    {
        if (!isLoggedInAdmin()) {
            redirect('login.php');
        }

        $collection = new UserCollection();

        $id = isset($_GET['id']) ? $_GET['id'] : '';

        if ((int)$id <= 0) {
            redirect('index.php?c=administrators');
        }

        $where = [
            'id' => $id
        ];
        $user = $collection->getOne($where);

        if (empty($user)) {
            redirect('index.php?c=administrators');
        }


        $where = [
            'id' => $id
        ];
        $result = $collection->delete($where);

        redirect('index.php?c=administrators');
    }

}