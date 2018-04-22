<?php
/**
 * シリアルコード生成用
 */
namespace App\Http\Controllers\Chokaigi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Models\FormModel;

use Response;
use Cookie;
use Log;
use Auth;
use Input;
use Session;
use Validator;
use Redmine;

class SerialCodeController extends Controller
{
    const FORM_NM = 'ideaForm';

    public function __construct()
    {
        $this->model = new FormModel();
    }

    /**
     * indexアクション
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function unlock_achv()
    {
        try {
            // ユーザ情報を取得
            $jms_user_info = $this->model->jms_login_auth();

            return view(
                'form.'.self::FORM_NM,
                [
                    'user'    => $jms_user_info->getUser(),
                ]
            );
        }
        // 未ログインの場合、例外としてキャッチする
        catch (\Exception $e) {
            // セッションに戻り先URLをセット
            Session::put('callback_url', '/ideaForm');

            Log::debug(print_r($e->getMessage(), 1));
            return redirect()->to('/login/jms');
        }
    }

}
