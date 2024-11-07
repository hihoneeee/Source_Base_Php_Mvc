<?php
require_once './app/core/Controller.php';

class UserController extends Controller {
    protected $_userService;

    public function __construct(UserService $userService) {
        $this->_userService = $userService;
    }

    public function index() {
        $response = $this->_userService->getAllUsers();
        if ($response->success) {
            $this->render('User/index', ['users' => $response->data]);
        } else {
            $this->render('User/error', ['message' => $response->message]);
        }
    }

    public function delete($id) {
        $response = $this->_userService->deleteUser($id);
        if ($response->success) {
            $this->redirectToAction('user', 'index');
        } else {
            $this->render('User/error', ['message' => $response->message]);
        }
    }
    
    
    public function show($id) {
        $user = $this->_userService->getUserById($id);
         $this->render('User/show', ['user' => $user]);
    }

    public function create() {
        $this->render('User/form');
    }

    public function store() {
        // Giả định dữ liệu được gửi từ form (POST request)
        $username = $_POST['username'] ?? null;
        $email = $_POST['email'] ?? null;

        if (!$username || !$email) {
            echo json_encode([
                'success' => false,
                'message' => 'Username and email are required.'
            ]);
            return;
        }

        // Khởi tạo UserDTO từ dữ liệu POST
        $userDTO = new UserDTO($username, $email);

        // Gọi service để tạo người dùng mới
        $response = $this->_userService->createUser($userDTO);

        // Trả về phản hồi JSON
        echo json_encode($response->getData());
    }
}