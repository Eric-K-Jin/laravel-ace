<?php

/**
 * Created by PhpStorm.
 * User: EricJin
 * Date: 2017/7/18
 * Time: 12:17
 */
namespace App\Tools;

class Response
{
    protected $statusCode = 200;

    protected $code;

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param mixed $code
     * @return $this
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param mixed $statusCode
     * @return $this
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * responseError
     * @param $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseWithError($message)
    {
        return $this->respond([
                'code' => $this->getCode(),
                'message' => $message
            ]
        );
    }

    /**
     * responseNotFound
     * @param $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseNotFound($message = 'Data Not Found')
    {
        return $this->setCode(404)->responseWithError($message);
    }


    /**
     * respond
     * @param $data
     * @param array $header
     * @return \Illuminate\Http\JsonResponse
     */
    public function respond($data, $header = [])
    {
        return response()->json($data, $this->getStatusCode(), $header);
    }

    /**
     * responseNormal
     * @param string $info
     * @param array $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseNormal($info = 'success', $data = [])
    {
        return $this->respond([
            'code' => 0,
            'message' => $info,
            'data' => $data
        ]);
    }
}