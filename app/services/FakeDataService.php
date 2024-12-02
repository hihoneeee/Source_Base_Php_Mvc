<?php

namespace App\Services;

use App\Helpers\ServiceResponse;
use App\Helpers\ServiceResponseExtensions;
use App\Repositories\FakeDataRepository;
use Exception;

class FakeDataService
{
    private $_fakeDataRepo;

    public function __construct(FakeDataRepository $fakeDataRepo)
    {
        $this->_fakeDataRepo = $fakeDataRepo;
    }
    public function generateAndInsertData()
    {
        $response = new ServiceResponse();
        try {
            $this->_fakeDataRepo->generateAndInsertData();
            ServiceResponseExtensions::setSuccess($response, "Tạo dữ liệu thành công!");
        } catch (Exception $ex) {
            ServiceResponseExtensions::setError($response, $ex->getMessage());
        }
        return $response;
    }
}
