<?php

/**
 * Class cho login và dk api
 */

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Lcobucci\JWT\Parser;

/**
 * Undocumented class
 */
class LoginController extends Controller
{
    /**
     * hàm login cho api
     *
     * @param Request $request
     *
     * @return void
     */
    public function login(Request $request)
    {
        // validate request/input/post data
        $validator = Validator::make(
            $request->all(),
            [
                'email' => 'required|email',
                'password' => 'required|min:6',
                'remember_me' => 'boolean'
            ]
        );
        if ($validator->fails()) {
            // neu data loi format thì die
            return response()->json(['message' => 'error', 'error' => $validator->errors()], 401);
        }
        // lấy array chỉ email và password trong request thôi.
        $credentials = request(['email', 'password']);

        // hàm login + check luôn
        if (!Auth::attempt($credentials)) {
            // nếu lỗi
            return response()->json([
                'message' => 'error',
                'error' => 'Unauthorized'
            ], 401);
        }

        // nếu đúng thì có nghĩ là đã login rồi
        // lấy request->user là ra user
        $user = $request->user();

        // tạo 1 token cho user sau khi đã login
        // tạo bằng cơ chế của Aouth2, k biết nó hash kiểu nao -_-
        $tokenResult = $user->createToken('Personal Access Token');

        // object token
        $token = $tokenResult->token;

        // nếu request có thêm remember_me = true thì token được sài trong 1 year.
        // có thể đổi số lại cho phù hợp
        if ($request->remember_me) {
            $token->expires_at = Carbon::now()->addYear(1);
        }

        // save vào bảng oauth_access_tokens
        $token->save();

        $user = User::getImageLinkApi($user);

        // mỗi request từ client phải có header:
        // 'Authorization' => 'Bearer '.$accessToken,
        return response()->json(
            [
                // đây là token
                'access_token' => $tokenResult->accessToken,
                // đây là loại token, hiện tại mặc định là Bearer, Nó là 1 chuẩn Aouth2
                'token_type' => 'Bearer',
                // đây là ngày hết hạng token, được trả về cho client
                'expires_at' => Carbon::parse(
                    $tokenResult->token->expires_at
                )->toDateTimeString(),
                'user' => $user->toArray()
            ]
        );
    }

    /**
     * Đăng ký 1 tài khoản api
     *
     * @param Request $request
     * @return void
     */
    // Ctr + click go to defintion
    // $request->get('name', 'giá trị khi null');
    // $request->getUser()
    // 2 cái này khá hữu dụng
    // ctrl + D: multi con trỏ giống text, giúp sửa 1 loạt các text giống nhau
    // Alt + click: multi con trỏ bất kỳ:
    // ctrl + p: search nhanh 1 hàm, class
    // ctrl + e: history file opened
    // ctrl + shift + o: hiện list function + attribute của class hiện tại
    // alt + shift + up/down: duplicate 1 line
    public function signup(Request $request)
    {
        // tương tự trên:
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users|email',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            // mã hóa bcryt là mặc định của laravel
            'password' => bcrypt($request->password)
        ]);
        $user->save();

        return response()->json([
            'message' => 'success',
        ], 200);
    }
    
    public function logout(Request $request)
    {
//        $value = $request->bearerToken();
//        $id = (new Parser())->parse($value)->getHeader('jti');
//        $token = $request->user()->tokens->find($id);
//        $token->revoke();

        $request->user()->token()->revoke();
        return response()->json(['message' => 'success'], 204);
    }
}
