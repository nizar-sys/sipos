<?php 

namespace App\Http\Traits;

use Illuminate\Http\Request;
/**
 * @param Request $request
 * @return $this|false|string|array
 */
trait ReturnTrait
{
    public function success($data, $message)
    {
        return response()->json([
            'data' => $data,
            'message' => $message
        ]);
    }

    public function error($message)
    {
        return response()->json([
            'message' => $message
        ]);
    }
}
