<?php

namespace App\Helper;

trait DataResponse
{
    /**
     * Retrieve the model for a bound value.
     *
     * @param  string|null  $message
     * @param  int  $status
     * @param  array  $data
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function data_response($message = null, $status = 200, $data = null)
    {
        return response()->json(array("message" => $message, "status" => $status, "data" => $data), $status);
    }

    public function error_response($message = '', $status = 500)
    {
        return response()->json(array("message" => $message, "status" => $status), $status);
    }

    public function validation_response($e)
    {
        $message = [];
        $messages = $e->validator->messages()->messages();
        foreach ($messages as $key => $value) {
            foreach ($value as $key => $val) {
                array_push($message, $val);
            }
        }
        return response()->json(array("message" => $message, "status" => 422), 422);
    }

}
