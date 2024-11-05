<?php

namespace App\controllers;

use App\repository\BaseRepository;

abstract class Controller
{
    public $apiName = '';

    protected $method = ''; //GET|POST|PUT|DELETE

    public $requestUri = [];
    public $requestParams = [];

    protected $action = ''; //Название метода для выполнения
    protected BaseRepository $repository;
    protected ?int $id = null;

    public function __construct(BaseRepository $repository) {
        header("Access-Control-Allow-Orgin: *");
        header("Access-Control-Allow-Methods: *");
        header("Access-Control-Allow-Headers: *");
        header("Access-Control-Allow-Credentials: *");
        header("Content-Type: application/json");

        $this->requestUri = explode('/', trim($_SERVER['REQUEST_URI'],'/'));
        $this->requestParams = $_REQUEST;

        $this->method = $_SERVER['REQUEST_METHOD'];
        if ($this->method == 'POST' && array_key_exists('HTTP_X_HTTP_METHOD', $_SERVER)) {
            if ($_SERVER['HTTP_X_HTTP_METHOD'] == 'DELETE') {
                $this->method = 'DELETE';
            } else if ($_SERVER['HTTP_X_HTTP_METHOD'] == 'PUT') {
                $this->method = 'PUT';
            } else {
                throw new \Exception("Unexpected Header");
            }
        }
        $this->repository = $repository;
        $q = $_GET['q'];
        $params = explode('/', $q);
        $this->id = $params[1] ?? null;
    }

    public function run() {
        if(array_shift($this->requestUri) !== $this->apiName){
            throw new \RuntimeException('API Not Found', 404);
        }

        $this->action = $this->getAction();
        if (method_exists($this, $this->action)) {
            return $this->{$this->action}();
        } else {
            throw new \RuntimeException('Invalid Method', 405);
        }
    }

    protected function getAction()
    {
        $method = $this->method;
        switch ($method) {
            case 'GET':
                if($this->requestUri){
                    return 'viewAction';
                } else {
                    return 'indexAction';
                }
                break;
            case 'POST':
                return 'createAction';
                break;
            case 'PUT':
                return 'updateAction';
                break;
            case 'DELETE':
                return 'deleteAction';
                break;
            default:
                return null;
        }
    }

    abstract protected function indexAction();
    abstract protected function viewAction();
    abstract protected function createAction();
    abstract protected function updateAction();
    abstract protected function deleteAction();
}