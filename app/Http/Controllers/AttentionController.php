<?php

namespace App\Http\Controllers;

use App\Attention;
use Illuminate\Http\Request;

class AttentionController extends Controller
{

    /**
     * @param $userId
     * @param $resourceId
     * @param $type
     * @return \Illuminate\Http\JsonResponse
     * 取消关注
     */
    public function cancelAttention($userId, $resourceId, $type) {
        $number = Attention::where('userId', $userId)
            ->where('resourceId', $resourceId)
            ->where('type', $type)
            ->forceDelete();
        if($number == 1) {
            return response()->json([
                'errCode' => 0,
                'data' => ''
            ]);
        } else {
            return response()->json([
                'errCode' => -1,
                'data' => Attention::DELETE_FAIL
            ]);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 关注
     */
    public function addAttention(Request $request) {
        $res = Attention::create([
            'userId' => $request->input('userId'),
            'resourceId' => $request->input('resourceId'),
            'type' => $request->input('type')
        ]);
        if($res) {
            return response()->json([
                'errCode' => 0,
                'data' => ''
            ]);
        }
        return response()->json([
            'errCode' => -1,
            'data' => Attention::ADD_ATTENTION_FAIL
        ]);
    }
}
