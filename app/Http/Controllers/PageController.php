<?php

namespace App\Http\Controllers;

use App\Ebook;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\tblebook;
use App\tblpublisher;
use App\tblauthor;
use App\tbllanguage;
use App\tbltype;
use App\User;
use Mail;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use TonchikTm\PdfToHtml\Pdf;

class PageController extends Controller
{
    public function __construct()
    {

    }

    public function getTrangChu(){
    	$new_ebook = tblebook::where('new',0)->orderBy('id','desc')->take(8)->get();
    	$free_ebook = tblebook::where('hire_price',0)->get();
        $view_ebook = tblebook::orderBy('views','desc')->take(8)->get();
    	return view('user.pages.trangchu',['new_ebook'=>$new_ebook,
    										'free_ebook' =>$free_ebook,
                                            'view_ebook' => $view_ebook]);
    }

    public function testmail(){
        $user = User::find(1);
        $mail= 'tranthanhdanh.athena@gmail.com';

        $data = array('user'=>$user);
        Mail::send('mailfb',$data, function($message) use ($mail){
            $message->to ($mail, 'Visitor')->subject('Thông báo đăng ký thành công!');
        });

    }
    public function lienhe(){
        return view('user.pages.lienhe');
    }
    public function postlienhe(Request $req){
        
        return view('user.pages.lienhe');
    }


    public function vechungtoi(){
        return view('user.pages.vechungtoi');
    }
    public function chinhsach(){
        return view('user.pages.chinhsach');
    }


    public function getEbook(){
        $ebook = tblebook::where('id','<>',0)->paginate(12);
        return view('user.pages.ebook',['ebook'=>$ebook]);
    }

     public function getChiTiet(Request $req){
        $ebook = tblebook::where('id',$req->id)->first();
        return view('user.pages.chitietebook',['ebook'=>$ebook]);
    }

//lấy theo loại
    public function getNhaXuatBan($idT, $id){
        if($idT == 1){
            $ebook = tblebook::where('publisher_id',$id)->get();
            $ebook_khac = tblebook::where('publisher_id','<>',$id)->get();
            return view('user.pages.loaiebook',['ebook'=>$ebook,
                                                'ebook_khac'=>$ebook_khac]);
        }
        if($idT == 2){
            $ebook = tbltype::find($id)->type_ebook;
            $ebook_khac = [];
            return view('user.pages.loaiebook',['ebook'=>$ebook,
                                                'ebook_khac'=>$ebook_khac]);
        }
        if($idT == 3){
            $ebook = tbllanguage::find($id)->language_ebook;
            $ebook_khac = [];
            return view('user.pages.loaiebook',['ebook'=>$ebook,
                                                'ebook_khac'=>$ebook_khac]);
        }
        if($idT == 4){
            $ebook = tblauthor::find($id)->author_ebook;
            $ebook_khac = [];
            return view('user.pages.loaiebook',['ebook'=>$ebook,
                                                'ebook_khac'=>$ebook_khac]);
        }
    }
    



    public function timkiem(Request $req){
        $this->validate($req,[
            'tukhoa'=>'alpha_num'
        ],[
            'tukhoa.alpha_num'=>'Không nhập ký tự đặc biệt'
        ]);
        $tukhoa = $req->tukhoa;
        if($tukhoa==''){
            $kqtim = tblebook::all();
        }
        $dm = $req->danhmuctimkiem;
        $kqtim = [];
        if($dm ==0){
            $t = tblebook::where('name','like',"%$tukhoa%")->get();
            if (count ($t)>0){
                $kqtim = tblebook::where('name','like',"%$tukhoa%")->take(20)->get();//->paginate(4);
            }

        }
        if($dm == 1){
            $t = tblpublisher::where('name','like',"%$tukhoa%")->get();
            if (count ($t)>0){
                $kqtim = tblpublisher::where('name','like',"%$tukhoa%")->take(20)->get();//->paginate(4);
            }
            
        }
        if($dm == 2){
            $t = tbllanguage::where('name','like',"%$tukhoa%")->get();
            if (count ($t)>0){
                $kqtim = tbllanguage::where('name','like',"%$tukhoa%")->take(20)->get();//->paginate(4);
            }
        }
        if ($dm == 3) {
            $t = tbltype::where('name','like',"%$tukhoa%")->get();
            if (count ($t)>0){
                $kqtim = tbltype::where('name','like',"%$tukhoa%")->take(20)->get();//->paginate(4);
            }
        }
        if($dm==4){
             $tg = tblauthor::where('name','like',"%$tukhoa%")->get();
            if (count ($tg)>0){
                $kqtim = tblauthor::where('name','like',"%$tukhoa%")->take(20)->get();//->paginate(4);
            }
        }
        return view('user.pages.timkiem',['kqtim'=>$kqtim,
                                          'tukhoa'=>$tukhoa,
                                            'danhmuc'=>$dm]);

    }

//---------------------confif chuyển file pdf/////////////////////////

    /**
     * @param Request $request
     * @param $id
     * @param int $pageNum số trang đang đọc
     */
    public function convertPDF(Request $request, $id, $pageNum = 1)
    {
        $ebook = Ebook::find($id);
        if (!$ebook) {
            throw new NotFoundHttpException();
        }

        // lấy từ ebook
        $fileName = $ebook->link_content;
        $fullPath = public_path('upload/content/' . $fileName);
        if (!file_exists($fullPath)) {
            throw new NotFoundHttpException();
        }
        // nếu là window thì sài package đính kèm, nếu là linux thì phải cài gói poppler, hiện server linux đã cài rồi.
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            $filePath = 'upload/content/'.$fileName;
            $pdf = new Pdf($filePath, [
                'pdftohtml_path' => 'backend\poppler-0.68.0\bin\pdftohtml', // đường dẫn của `pdf to html` sau khi cài đặt
                'pdfinfo_path' => 'backend\poppler-0.68.0\bin\pdfinfo', // đường dẫn của `pdf info` sau khi cài đặt
                'generate' => ['singlePage' => true],
                'clearAfter' => false, // xóa file pdf sau khi convert - mặc định là true
                'outputDir' => storage_path('upload/content'), // thư mục output của file html
            ]);

//            $pdfInfo = $pdf->getInfo(); // Lấy thông tin của file pdf

            //Lấy nội dung tất cả các trang
            $message = $this->formatPdfHtml($pdf, $pageNum);
            echo $message;
        } else {
            $url = $request->getUri();
            if (strpos($url, '34.87.60.191') === false) {
                $url = str_replace('nnebook.tk', '34.87.60.191', $url);
                $client = new Client();
                $body = $client->get($url);
                echo $body->getBody();
            } else {
                // linux only
                $pdf = new Pdf($fileName, [
                    'clearAfter' => false,
                    'generate' => ['singlePage' => true],
                    'outputDir' => storage_path('upload/content'), // thư mục output của file html
                ]);

                $message = $this->formatPdfHtml($pdf, $pageNum);

                echo $message;
            }
        }

        //return $allpages;//$contentFirstPage;//$countPages;//dd($pdfInfo);
//        return view('user.pages.test',['pdfInfor']=$pdfInfo);
    }

    /**
     * Chỉ hỗ trợ đọc trên linux
     * @param Request $request
     * @param $urlFileName
     */
    public function readOnLinux(Request $request)
    {
        $urlFileName = $request->get('urlFileName');
        if (empty($urlFileName)) {
            throw new NotFoundHttpException();
        }
        $pageNum = $request->get('pageNum', 1);

        if (strtoupper(substr(PHP_OS, 0, 3)) != 'WIN') {
            // pdftohtml_path để default trên môi trường linux
            $urlFileName = urldecode($urlFileName);
            $pdf = new Pdf($urlFileName, [
                'clearAfter' => false,
                'generate' => ['singlePage' => true],
                'outputDir' => storage_path('upload/content'), // thư mục output của file html
            ]);

            $message = $this->formatPdfHtml($pdf, $pageNum);

            return $message;
        } else {
            throw new \Exception("hàm chỉ hỗ trợ Linux");
        }
    }

    /**
     * @param $pdf
     * @return string
     */
    protected function formatPdfHtml(Pdf $pdf, $pageNumber = 1)
    {
        if ($pageNumber > $pdf->countPages()) {
            $pageNumber = $pdf->countPages();
        }
        //Lấy nội dung theo trang
        // chỉnh sửa format chung ở đây
        return '<div align=\'center\'>'.$pdf->getHtml()->getPage($pageNumber)."</div>";
//        foreach ($pdf->getHtml()->getAllPages() as $page) {
//            $message = "<div align='center'>";
//            $message .= $page . "<br>";
//            $message .= "</div>";
//        }
//        return $message;
    }

    public function convertText($id, $bookmark)
    {

        $ebook = tblebook::find($id);
        $isFree = false;

        // free dưới 10 page
        if ($ebook->hire_price == 0 || $bookmark <= 10) {
            $isFree = true;
        }
        // check user rented ebook?
        // if (!$isFree) {
        //     $int = Hire::checkRentedBook($user, $ebook_id);
        //     if ($int == 0) {
        //         return response()->json(['message' => 'error', 'error' => 'Ebook is not rented!'], 404);
        //     }
        // }

        // get ebook link
        $link = public_path('backend\\ebook\\'.$ebook->link_content);

        if (!file_exists($link)) {
            echo "á hahahahahahahahahahah";
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
                // $str = preg_replace(
                //     '/[^a-z0-9A-Z\S\t\nÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀẾỂưăạảấầẩẫậắằẳẵặẹẻẽềếểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ]/miu',
                //     '',
                //     $str
                // );

                // bỏ qua trang trắng
                // if (empty($str)) {
                //     $bookmark++;
                //     continue;
                // }

                // return response()->json(
                //     ['message' => 'success', 'data' => $str],
                //     200,
                //     ['Content-type'=> 'application/json; charset=utf-8'],
                //     JSON_UNESCAPED_UNICODE
                // );
                echo "test haha".$str;
            }
       }

        // return response()->json(['message' => 'error', 'error' => 'Cannot find that page!'], 404);
        echo "chạy tới cuoi cung";
    }
}
