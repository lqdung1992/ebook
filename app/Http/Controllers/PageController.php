<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\tblebook;
use App\tblpublisher;
use App\tblauthor;
use App\tbllanguage;
use App\tbltype;
use App\User;
use Mail;
use TonchikTm\PdfToHtml\Pdf;

class PageController extends Controller
{
    public function __construct()
    {

    }

    public function getTrangChu(){
    	$new_ebook = tblebook::where('new',0)->take(8)->get();
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
    public function convertPDF()
    {
        $pdf = new Pdf('upload/content/1w_QUY-DINH-CUONG-LUAN-VAN.pdf', [
        'pdftohtml_path' => 'backend\poppler-0.68.0\bin\pdftohtml', // đường dẫn của `pdf to html` sau khi cài đặt
        'pdfinfo_path' => 'backend\poppler-0.68.0\bin\pdfinfo', // đường dẫn của `pdf info` sau khi cài đặt
        'clearAfter' => false, // xóa file pdf sau khi convert - mặc định là true
        'outputDir' => storage_path('upload/content'), // thư mục output của file html
        ]);

        $pdfInfo = $pdf->getInfo(); // Lấy thông tin của file pdf
        $countPages = $pdf->countPages(); // đếm số trang của file pdf
        $contentFirstPage = $pdf->getHtml()->getPage(1); //Lấy nội dung tất cả các trang
        

        //Lấy nội dung tất cả các trang
        foreach ($pdf->getHtml()->getAllPages() as $page) {
            echo "<div align='center'>";
            echo $page."<br>";
            echo "</div>";
         }
        //return $allpages;//$contentFirstPage;//$countPages;//dd($pdfInfo);
        //return view('user.pages.test',['pdfInfor']=$pdfInfo);
    }
    

}
