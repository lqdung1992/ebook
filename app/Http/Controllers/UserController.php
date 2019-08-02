<?php

namespace App\Http\Controllers;

use App\Ebook;
use App\Hire;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Validator;
use App\Library;

use Illuminate\Support\Facades\Auth;
use App\tbladmin;
use App\tblebook;
use Session;
use Mail;

class UserController extends Controller
{
    public function __construct() {
        @session_start();        
    }
    // chap nhan update
    private $updateAccept = ['name', 'password', 'email', 'img', 'phone'];

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'max:255',
            'email' => 'email|unique:users|email',
            'password' => 'min:6',
            'phone' => 'regex:/(0)[0-9]{9}/|max:10|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'error', 'error' => $validator->errors()], 401);
        }

        /** @var User $user */
        $user = $request->user();

        $data = \request($this->updateAccept);
        foreach ($data as $key => $datum) {
            if (empty($datum)) {
                continue;
            }

            if ($key == 'password') {
                $user->setAttribute($key, bcrypt($datum));
            } elseif ($key == 'img') {
                // remove old file
                $oldFile = public_path('/upload/user/' . $user->img);
                if (file_exists($oldFile)) {
                    unlink($oldFile);
                }

                // image nhan ve la base64
                // tao file name
                $fileName = str_random(10) . '_' . (new \DateTime())->format('YmdHmi'). '.jpeg';
                    
                file_put_contents(public_path('/upload/user/'.$fileName), base64_decode($datum));

                $user->setAttribute($key, $fileName);
            } else {
                $user->setAttribute($key, $datum);
            }
        }
        // không cho user tự update tiền
//        $user->money = $request->money;

        $user->save();

        return response()->json([
            'message' => 'success',
            'user' => $user->toArray()
        ]);
    }

    /**
     * Lay danh sach da thue
     *
     * Chấp nhận type: 0: hết hạn, 1: còn hạn, 2: all, mặc định là 1
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getRentEbook(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'in:0,1,2', // 0: hết hạn, 1: còn hạn, 2: all
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'error', 'error' => $validator->errors()], 401);
        }

        $user = $request->user();
        // mặc định là 1: còn hạn
        $type = $request->get('type', Hire::EXPIRY_DATE);

        // tao cau truy van
        $query = Hire::getRentEbookQuery($user, $type);
        $data = $query->get();

        // tao link cho pdf/image
        $returnData = Ebook::getLinkApi($data);

        return response()->json([
            'message' => 'success',
            'data' => $returnData->toArray()
        ]);
    }

    /**
     * Get user info
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserInfo(Request $request)
    {
        $user = $request->user();

        $user = User::getImageLinkApi($user);

        return response()->json([
            'messsage' => 'success',
            'data' => $user->toArray(),
        ]);
    }

    /**
     * @param Request $request
     * @param $book_id Ebook->getId()
     * @param int $bookmark
     */
    public function readEbook(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ebook_id' => 'required|numeric|exists:ebook,id',
            'bookmark' => 'numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'error', 'error' => $validator->errors()->first()], 401);
        }

        $ebook_id = $request->get('ebook_id');

        $ebook = Ebook::find($ebook_id);
        $isFree = false;
        /** @var User $user */
        $user = $request->user();
        $bookmark = $request->get('bookmark', 1);
        // free dưới 10 page
        if ($ebook->hire_price == 0 || $bookmark <= 10) {
            $isFree = true;
        }
        // check user rented ebook?
        if (!$isFree) {
            $int = Hire::checkRentedBook($user, $ebook_id);
            if ($int == 0) {
                return response()->json(['message' => 'error', 'error' => 'Ebook is not rented!'], 404);
            }
        }

        // get ebook link
        $link = public_path(Ebook::UPLOAD_CONTENT_DIR .$ebook->link_content);

        if (!file_exists($link)) {
            return response()->json(['message' => 'error', 'error' => 'File not found at server!'], 404);
        }

        $pdf = new \Smalot\PdfParser\Parser();
        $text  = $pdf->parseFile($link);
        foreach ($text->getPages() as $key => $pageItem) {
            if ($key == 0) {
                continue;
            }

            if ($key == $bookmark) {
                $str = $pageItem->getText();
                // ÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀẾỂưăạảấầẩẫậắằẳẵặẹẻẽềếểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ
                $str = preg_replace(
                    '/[^a-z0-9A-Z\S\t\nÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀẾỂưăạảấầẩẫậắằẳẵặẹẻẽềếểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ]/miu',
                    '',
                    $str
                );

                // bỏ qua trang trắng
                // if (empty($str)) {
                //     $bookmark++;
                //     continue;
                // }

                return response()->json(
                    ['message' => 'success', 'data' => $str],
                    200,
                    ['Content-type'=> 'application/json; charset=utf-8'],
                    JSON_UNESCAPED_UNICODE
                );
            }
        }

        return response()->json(['message' => 'error', 'error' => 'Cannot find that page!'], 404);
    }

    /**
     * Them vao library
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addLibrary(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ebook_id' => 'required|numeric|exists:ebook,id',
            'bookmark' => 'numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'error', 'error' => $validator->errors()->first()], 401);
        }

        $user = $request->user();

        $ebook_id = $request->get('ebook_id');

        /** @var Lirary $Library */
        $Library = Library::where('ebook_id', $ebook_id)->where('user_id', $user->id)->first();
        if ($Library) {
            $Library->bookmark = $request->get('bookmark', $Library->bookmark);
        } else {
            $Library = new Library();
            $Library->user_id = $user->id;
            $Library->ebook_id = $ebook_id;
            $Library->bookmark = $request->get('bookmark', 1);
        }
        
        $Library->save();

        return response()->json([
            'message' => 'success',
            'data' => []
        ], 200);
    }

    /**
     * Xoa library
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeLibrary(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ebook_id' => 'required|numeric|exists:ebook,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'error', 'error' => $validator->errors()->first()], 401);
        }

        $user = $request->user();
        $ebook_id = $request->get('ebook_id');

        /** @var Lirary $Library */
        $Library = Library::where('ebook_id', $ebook_id)->where('user_id', $user->id)->first();
        if ($Library) {
            $Library->delete();
        }

        return response()->json([
            'message' => 'success',
            'data' => []
        ], 200);
    }

public function setMoney(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'money' => 'alpha_num',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => 'error', 'error' => $validator->errors()->first()], 404);
        }
        $mg20 = array("20abcd", "20efgh", "20ijkl");
        $mg50 = array("50abcd", "50efgh", "50ijkl");
        $user = $request->user();
        if (in_array($request->money, $mg20)) {
            $user->money += 20000;
            $user->save();
        } elseif (in_array($request->money, $mg50)) {
            $user->money += 50000;
            $user->save();
        } else {
            return response()->json(['message' => 'error', 'error' => 'Code do not equal'], 404);
        }
        return response()->json([
            'message' => 'success'
        ], 200);
    }

    public function create(Request $request)
    {
        $users = new User();

        $users->name = $request->name;
        $users->password = $password = bcrypt($request->password);
        $users->mail = $request->mail;
        $users->img = $request->img;
        $users->phone = $request->phone;
        //$users->money = $request->money;

        $users->save();
        return response()->json($users);
    }

//----------------website------------------------------------------
    public function getDangKy(){
        return view('user.pages.dangky');
    }

    public function postDangKy(Request $req){
        $this->validate($req,
            [
                'email'=>'required|email|unique:users,email', 
                'password'=>'required|min:6|max:20',
                'name'=>'required|min:6|max:20',
                're_password'=>'required|same:password',
                'phone' => 'bail|required|numeric|digits:10|unique:users,phone'
            ],
            [
                'email.required'=>'Vui lòng nhập địa chỉ email của bạn!',
                'email.email'=>'Không đúng định dạng mail',
                'email.unique'=>'Email đã có người sử dụng',
                'password.required'=>'Vui lòng nhập password',
                'password.min'=>'Mật khẩu ít nhất 6 ký tự.',
                'password.max'=> 'mật khẩu tối đa 20 ký tự',
                'name.required'=>'Vui lòng nhập tên của bạn',
                'name.min'=>'Tên ít nhất 6 ký tự.',
                'name.max'=> 'Tên tối đa 20 ký tự',
                're_password.same'=>'Nhập lại mật khẩu không đúng.',
                'phone.required'=>'nhập số điện thoại của bạn',
                'phone.numeric'=>'Số điện thoại là 1 dãy số',
                'phone.digits' =>'Số điện thoại gồm 10 số',
                'phone.unique' => 'Số điện đã có người sử dụng'
            ]
        );
        $user = new User();
        $user->name = $req->name;
        $user->email = $req->email;
        $user->password= bcrypt($req->password);
        $user->phone = $req->phone;
        $user->role = 1;
        $user->save();

        $mail= $req->email;

        $data = array('user'=>$user);
        Mail::send('mailfb',$data, function($message) use ($mail){
            $message->to ($mail, 'Visitor')->subject('Thông báo đăng ký thành công!');
        });

        return redirect('dangnhap')->with('thangcong','Đã tạo tài khoản thành công!');
    }

    public function getDangNhap(){
        return view('user.pages.dangnhap');
    }

    public function postDangNhap(Request $req){
       $this->validate($req,
            [
                'email'=>'required|email', 
                'password'=>'required|min:6|max:20'
            ],
            [
                'email.email'=>'Không đúng định dạng mail',
                'email.required'=>'Vui lòng nhập địa chỉ email của bạn!',
                'password.required'=>'Vui lòng nhập password',
                'password.min'=>'Mật khẩu ít nhất 6 ký tự.',
                'password.max'=>'Mat khau khong qua 20 ky tu.'
            ]
        );
        $remember = $req->has('remember') ? true : false;
        if(Auth::attempt(['email'=>$req->email,'password'=>$req->password], $remember))
        {
            return redirect('trangchu');
        }
        return redirect('dangnhap')->with('thongbao','Dang nhap khong thanh cong');
    }

    public function logout(){
        Auth::logout();
        return view('user.pages.dangnhap');
    }

    public function getThongTin(){
        if(Auth::check()){
            $user = Auth::user();
            return view('user.pages.thongtincanhan',['user'=>$user]);
        }else return redirect('dangnhap')->with('thongbao','Bạn hãy đăng nhập');
            
    }
    public function postThongTin(Request $req, $id){
        $user = User::find($id);
        $this->validate($req,
            [
                'name'=>'required|min:6|max:20',
                
                'phone' => 'bail|required|numeric|digits:10'
            ],[
                'name.required'=>'Vui lòng nhập tên của bạn',
                'name.min'=>'Tên ít nhất 6 ký tự.',
                'name.max'=> 'Tên tối đa 20 ký tự',
                
                'phone.required'=>'nhập số điện thoại của bạn',
                'phone.numeric'=>'Số điện thoại là 1 dãy số',
                'phone.digits' =>'Số điện thoại gồm 10 số'
            ]);
        $user->name = $req->name;
        
        $user->phone = $req->phone;
        $user->save();
        return redirect('thongtin')->with('thongbao','Sửa thành công');
    }

    public function getDoiPass(){
        return view('user.pages.doipass');
    }

    public function postDoiPass(Request $req,$id){
        $user = User::find($id);
        $this->validate($req,
            [
                'password_old' =>'required',
                'password_new' => 'required|different:password_old|confirmed',
                'password_new_confirmation' => 'required'
            ],[
                'password.required'=>'Chưa nhập mật khẩu hiện tại',
                'password_new.required'=>'Chưa nhập mật khẩu mới',
                'password_new.different'=>'Mật khẩu mới không được trùng với mật khẩu hiện tại',
                'password_new.confirmed'=>'Mật khẩu nhập lại không đúng',
                'password_new_confirmation.required'=>'Chưa nhập mật khẩu mới'
            ]);
        $user = Auth::user();
        if(Auth::attempt(['email'=>$user->email,'password'=>$req->password_old]))
        {
            $user->password = bcrypt($req->password_new);
            $user->save();
            return redirect('doipass')->with('thongbao','Đổi mật khẩu thành công!');
        }else{
            return redirect('doipass')->with('thongbao','xác nhận mật khẩu không thành công!');
        }
        
    }

    public function getLayLaiMK(){
        return view('user.pages.laylaimatkhau');
    }

    public function postLayLaiMK(Request $req){
        $this->validate($req,
            [
                'email'=>'required|email',
                'phone' => 'bail|required|numeric|digits:10'
            ],[
                'email.email'=>'Không đúng định dạng mail',
                'email.required'=>'Vui lòng nhập địa chỉ email của bạn!',
                'phone.required'=>'nhập số điện thoại của bạn',
                'phone.numeric'=>'Số điện thoại là 1 dãy số',
                'phone.digits' =>'Số điện thoại gồm 10 số'
            ]);
        $user = User::where('email',$req->email)->where('phone',$req->phone)->get();
        if(count($user)>0) {
            $mail= $req->email;
            $t = User::where('email',$req->email)->where('phone',$req->phone)->update(['password'=>str_random(6)]);


            $data = array('user'=>$t);
            Mail::send('mailxacthuc',$data, function($message) use ($mail){
                $message->to ($mail, 'Visitor')->subject('Thông báo đăng ký thành công!');
            });
            return view('user.pages.doipass');
        }
        else {
            return redirect('laylaimatkhau')->with('thongbao','Xác nhận không thành công');
        }
    }
    public function getNapTien(){
        if(Auth::check()){
            $user = Auth::user();
            return view('user.pages.naptien',['user'=>$user]);
        }else return redirect('dangnhap')->with('thongbao','Bạn hãy đăng nhập');
    }

    public function postNapTien(Request $req, $id){
        $user = User::find($id);
        $this->validate($req,[
            'money'=>'alpha_num'
        ],[
            'money.alpha_num'=>'Mã không chứ ký tự đặc biệt'
        ]);

        $mg20 = array("20abcd","20efgh","20ijkl");
        $mg50 = array("50abcd","50efgh","50ijkl");

        if(in_array($req->money,$mg20)){
            $user->money +=20000;
            $user->save();
        }else{
            return redirect('naptien')->with('Ma khong hop le!');
        }
        if(in_array($req->money,$mg50)){
            $user->money +=50000;
            $user->save();
        }else{
            return redirect('naptien')->with('Ma khong hop le!');
        }

        return redirect('thongtin')->with('thongbao','Nạp tiền thành công');
    }


    public function getThuVien(){
        if(Auth::check()){
            $user = Auth::user();
            $dsebook = array();
            foreach ($user->hire as $key => $value) 
            {
                    if($value->pivot->date_end > date("Y-m-d") )
                    {   
                                $dsebook[] = $value->id;
                            
                    }else if($value->pivot->date_end = date("Y-m-d") )
                        {   
                            if($value->pivot->hour_end > date("H:i:s"))
                                {
                                    $dsebook[] = $value->id;
                                }
                        }
            }
            return view('user.pages.thuvien',['dsebook'=>$dsebook,'user'=>$user]);
            
        }else return redirect('dangnhap')->with('thongbao','Bạn hãy đăng nhập');
        
        
    }
    
    public function themThuVien(Request $req, $id){
        $user = Auth::user();
        $ebook = tblebook::find($id);
        $tam = $user->library()->where('ebook_id',$id)->get();
        
        $value = $req->ngaythue;
        if($value<7)
        {       
            $total = $ebook->hire_price*$value;
            if($total <= $user->money)
            {
                if(count($tam)>0)
                    {
                        $user->hire()->attach($ebook->id,
                                    ['hour_start'=>date("h:i:s"),
                                        'date_start'=>date('Y-m-d'),
                                        'hour_end'=>date("h:i:s"),
                                        'date_end'=>date('Y-m-d', strtotime(date('Y-m-d') . "+" . $value . " days")),
                                        'hire_price'=>$ebook->hire_price,
                                        'total_price'=>$ebook->hire_price*$value
                                    ]);
                        $user->money = $user->money - $ebook->total_price;
                        $user->save();
                        $ebook->views++;
                        $ebook->save();
                        return redirect('thuvien')->with('thongbao','Ebook đã có trong thư viện của bạn');
                    }
                else{
                            if($user->money >= $ebook->hire_price)
                            {   
                                $user->hire()->attach($ebook->id,
                                    ['hour_start'=>date("h:i:s"),
                                        'date_start'=>date('Y-m-d'),
                                        'hour_end'=>date("h:i:s"),
                                        'date_end'=>date('Y-m-d', strtotime(date('Y-m-d') . "+" . $value . " days")),
                                        'hire_price'=>$ebook->hire_price,
                                        'total_price'=>$ebook->hire_price*$value
                                    ]);
                                $user->library()->attach($ebook);

                                $user->money = $user->money - $ebook->total_price;
                                $user->save();
                                $ebook->views++;
                                $ebook->save();
                            }
                         
                    }
            }else 
            {
                $dsebook = array();
                foreach ($user->hire as $key => $value) {
                    if($value->pivot->date_end > date("Y-m-d") )
                    {   
                                $dsebook[] = $value->id;
                            
                    }else if($value->pivot->date_end = date("Y-m-d") )
                        {   
                            if($value->pivot->hour_end > date("H:i:s"))
                                {
                                    $dsebook[] = $value->id;
                                }
                        }
                }
                return redirect('thuvien')->with('thongbao','Khong du tien');
            }
            $dsebook = array();
            foreach ($user->hire as $key => $value) {
                    if($value->pivot->date_end > date("Y-m-d") )
                    {   
                                $dsebook[] = $value->id;
                            
                    }else if($value->pivot->date_end = date("Y-m-d") )
                        {   
                            if($value->pivot->hour_end > date("H:i:s"))
                                {
                                    $dsebook[] = $value->id;
                                }
                        }
                }
            return view('user.pages.thuvien',['user'=>$user,'dsebook'=>$dsebook]);
        }
        //7 ngày
        if($value>=7 && $value < 30)
        {       
            $total = $ebook->hire_price*$value - ($ebook->hire_price*$value*0.07);
            if($total <= $user->money)
            {
                if(count($tam)>0)
                    {
                        $user->hire()->attach($ebook->id,
                                    ['hour_start'=>date("h:i:s"),
                                        'date_start'=>date('Y-m-d'),
                                        'hour_end'=>date("h:i:s"),
                                        'date_end'=>date('Y-m-d', strtotime(date('Y-m-d') . "+" . $value . " days")),
                                        'hire_price'=>$ebook->hire_price,
                                        'total_price'=>$total
                                    ]);
                        $user->money = $user->money - $total;
                        $user->save();
                        $ebook->views++;
                        $ebook->save();
                        return redirect('thuvien')->with('thongbao','Ebook đã có trong thư viện của bạn');
                    }
                else{
                            if($user->money >= $ebook->hire_price)
                            {   
                                $user->hire()->attach($ebook->id,
                                    ['hour_start'=>date("h:i:s"),
                                        'date_start'=>date('Y-m-d'),
                                        'hour_end'=>date("h:i:s"),
                                        'date_end'=>date('Y-m-d', strtotime(date('Y-m-d') . "+" . $value . " days")),
                                        'hire_price'=>$ebook->hire_price,
                                        'total_price'=>$total
                                    ]);
                                $user->library()->attach($ebook);

                                $user->money = $user->money - $total;
                                $user->save();
                                $ebook->views++;
                                $ebook->save();
                            }
                         
                    }
            }else 
            {
                $dsebook = array();
                foreach ($user->hire as $key => $value) {
                    if($value->pivot->date_end > date("Y-m-d") )
                    {   
                                $dsebook[] = $value->id;
                            
                    }else if($value->pivot->date_end = date("Y-m-d") )
                        {   
                            if($value->pivot->hour_end > date("H:i:s"))
                                {
                                    $dsebook[] = $value->id;
                                }
                        }
                }
                return redirect('thuvien')->with('thongbao','Khong du tien');
            }
            $dsebook = array();
            foreach ($user->hire as $key => $value) {
                    if($value->pivot->date_end > date("Y-m-d") )
                    {   
                                $dsebook[] = $value->id;
                            
                    }else if($value->pivot->date_end = date("Y-m-d") )
                        {   
                            if($value->pivot->hour_end > date("H:i:s"))
                                {
                                    $dsebook[] = $value->id;
                                }
                        }
                }
            return view('user.pages.thuvien',['user'=>$user,'dsebook'=>$dsebook]);
        }

        //30 ngày
        if($value>=30)
        {       
            $total = $ebook->hire_price*$value - ($ebook->hire_price*$value*0.3);
            if($total <= $user->money)
            {
                if(count($tam)>0)
                    {
                        $user->hire()->attach($ebook->id,
                                    ['hour_start'=>date("h:i:s"),
                                        'date_start'=>date('Y-m-d'),
                                        'hour_end'=>date("h:i:s"),
                                        'date_end'=>date('Y-m-d', strtotime(date('Y-m-d') . "+" . $value . " days")),
                                        'hire_price'=>$ebook->hire_price,
                                        'total_price'=>$total
                                    ]);
                        $user->money = $user->money - $total;
                        $user->save();
                        $ebook->views++;
                        $ebook->save();
                        return redirect('thuvien')->with('thongbao','Ebook đã có trong thư viện của bạn');
                    }
                else{
                            if($user->money >= $ebook->hire_price)
                            {   
                                $user->hire()->attach($ebook->id,
                                    ['hour_start'=>date("h:i:s"),
                                        'date_start'=>date('Y-m-d'),
                                        'hour_end'=>date("h:i:s"),
                                        'date_end'=>date('Y-m-d', strtotime(date('Y-m-d') . "+" . $value . " days")),
                                        'hire_price'=>$ebook->hire_price,
                                        'total_price'=>$total
                                    ]);
                                $user->library()->attach($ebook);

                                $user->money = $user->money - $total;
                                $user->save();
                                $ebook->views++;
                                $ebook->save();
                            }
                         
                    }
            }else 
            {
                $dsebook = array();
                foreach ($user->hire as $key => $value) {
                    if($value->pivot->date_end > date("Y-m-d") )
                    {   
                                $dsebook[] = $value->id;
                            
                    }else if($value->pivot->date_end = date("Y-m-d") )
                        {   
                            if($value->pivot->hour_end > date("H:i:s"))
                                {
                                    $dsebook[] = $value->id;
                                }
                        }
                }
                return redirect('thuvien')->with('thongbao','Khong du tien');
            }
            $dsebook = array();
            foreach ($user->hire as $key => $value) {
                    if($value->pivot->date_end > date("Y-m-d") )
                    {   
                                $dsebook[] = $value->id;
                            
                    }else if($value->pivot->date_end = date("Y-m-d") )
                        {   
                            if($value->pivot->hour_end > date("H:i:s"))
                                {
                                    $dsebook[] = $value->id;
                                }
                        }
                }
            return view('user.pages.thuvien',['user'=>$user,'dsebook'=>$dsebook]);
        }

    }




//ghi chú hàm xóa -- khi một người thuê nhiều lần và trả nhiều lần
    public function xoaThuVien($id){
        $user = Auth::user();
        $ebook = tblebook::find($id);

        // $user_max = $user->hire()->where('ebook_id',$id)->latest()->first();
        // $ngay = date_diff(date_create($user_max->pivot->date_start),date_create($user_max->pivot->date_end))->format('%a');
        // $tongtien =$user_max->pivot->total_price + $ngay*$ebook->hire_price;
        
        $user->hire()->updateExistingPivot($id,['hour_end'=>date("h:i:s"),'date_end'=>date("Y-m-d")]);
        $user->library()->detach($ebook);
        $dsebook = array();
        foreach ($user->hire as $key => $value) {
                if($value->pivot->date_end > date("Y-m-d") )
                {   
                            $dsebook[] = $value->id;
                        
                }else if($value->pivot->date_end = date("Y-m-d") )
                    {   
                        if($value->pivot->hour_end > date("H:i:s"))
                            {
                                $dsebook[] = $value->id;
                            }
                    }
            }
        
        return view('user.pages.thuvien',['user'=>$user, 'dsebook'=>$dsebook]);
        
    }





}
