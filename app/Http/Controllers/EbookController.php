<?php

namespace App\Http\Controllers;

use App\Hire;
use Illuminate\Http\Request;
use App\Ebook;
use App\Author;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use App\tblebook;
use App\tblpublisher;
use App\tblauthor;
use App\tbllanguage;
use App\tbltype;
use Response;

class EbookController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getList(Request $request)
    {
        $arrView = ['views', 'id', 'hire_price'];
        $validator = Validator::make($request->all(), [
            Ebook::PAGE_NO => 'numeric|min:1',
            Ebook::LIMIT => 'numeric|min:1',
            Ebook::ORDER_BY => Rule::in($arrView),
            'id' => 'numeric|min:1',
            'min_rate' => 'numeric|min:1',
            'max_rate' => 'numeric|min:1',
            'min_pagenum' => 'numeric',
            'max_pagenum' => 'numeric',
            'min_hire_price' => 'numeric',
            'max_hire_price' => 'numeric',
            'min_price' => 'numeric',
            'max_price' => 'numeric',
            'is_new' => 'in:0,1', // 2 chỉ số 0 hoặc 1
            'publisher_id' => 'exists:Publisher,id', // tồn tại trong bảng Publisher, cột id mới vào được
            'name' => 'regex:/^[a-z\ A-ZÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ]+$/u|max:255',
            'type' => 'in:home,library'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'error', 'error' => $validator->errors()], 401);
        }

        // số trang (đang ở trang số mấy)
        $pageNo = $request->get(Ebook::PAGE_NO, 1);
        // giới hạn item của 1 trang
        $limit = $request->get(Ebook::LIMIT, 10);
        $orderBy = $request->get(Ebook::ORDER_BY, 'id');
        $searchData = \request(Ebook::$searchFields);

        $user = $request->user();
        // hàm build query cho paginate
        $query = Ebook::getQueryByCondition($searchData, $orderBy, $user->id);

        /** @var LengthAwarePaginator $data phân trang */
        $data = $query->paginate($limit, ['*'], 'page', $pageNo);
        $items = $data->getIterator();

        foreach ($items as $key => $value) {
            $tmpEbook = Ebook::find($value->id);
            $tmpAuthor = [];
            $tmpType = [];
            $tmpLanguage = [];
            if ($tmpEbook) {
                foreach ($tmpEbook->authors as $k => $author) {
                    $tmpAuthor[] = $author->name;
                }

                foreach ($tmpEbook->types as $Type) {
                    $tmpType[] = $Type->name;
                }

                foreach ($tmpEbook->Languages as $k => $Language) {
                    $tmpLanguage[] = $Language->name;
                }
            }
            $items[$key]->author = $tmpAuthor;
            $items[$key]->type = $tmpType;
            $items[$key]->language = $tmpLanguage;
        }
        
        // tao link cho pdf/image
        $data->data = Ebook::getLinkApi($items);

        return response()->json([
            'message' => 'success',
            'data' => $data->toArray(),
        ], 200);
    }

    /**
     * Thue sach
     *
     * @param Request $request
     * @return void
     */
    public function rentEbook(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ebook_id' => 'required|exists:Ebook,id', // tồn tại trong bảng Ebook, cột id mới pass được
            // 'hour_start' => 'date_format:H:i', // 07:00
            // 'date_start' => 'date_format:Y-m-d', // 2019-07-02
            'rent_day' => 'required|numeric|min:1|max:365', // từ 1 tới 365 ngày
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'error', 'error' => $validator->errors()], 401);
        }

        $Ebook = Ebook::find($request->ebook_id);
        // tính tiền tổng các ngày
        $date = (new \DateTime())->modify("+ " . $request->rent_day . ' days');
        $now = new \DateTime();
        $user = $request->user();

        // check đủ tiền
        if ($user->money < $Ebook->hire_price) {
            return response()->json(['message' => 'error', 'error' => 'You don\'t have enough money'], 401);
        }

        // tạo hire
        $hire = new Hire();
        $hire->hour_start = $now->format('h:m');
        $hire->date_start = $now->format('Y-m-d');
        $hire->ebook_id = $request->ebook_id;
        $hire->hour_end = $hire->hour_start;
        $hire->date_end = $date->format('Y-m-d');
        $hire->hire_price = $Ebook->hire_price;
        $hire->total_price = $Ebook->hire_price * $request->rent_day;
        $hire->user_id = $user->id;

        // trừ tiền
        $user->money = $user->money - $hire->total_price;
        $user->save();

        // increase view
        $Ebook->views += 1;
        $Ebook->save();

        $hire->save();

        return \response()->json(['message' => 'success', 'data' => $hire->toArray()], 200);
    }

    public function getType(Request $request)
    {
        $types = \App\Type::all();

        return response()->json([
            'message' => 'success',
            'data' => $types,
        ]);
    }


//---------------------------WEBSITE----------
    public function getDanhSach() {
    $ebook = tblebook::all();
    return view('admin.ebook.danhsach',['ebook'=>$ebook]);
   }

   public function getSua($id) {
      $ebook = tblebook::find($id);
      return view('admin.ebook.sua', ['ebook'=>$ebook]);
   }
   public function postSua(Request $req, $id) {
         $ebook = tblebook::find($id);
         $this->validate($req, 
            [
               'name' => 'required|unique:type,name|min:3|max:200',
               'price' => 'required',
               'hire_price' => 'required'
            ],
            [
               'name.required' => 'Bạn chưa nhập tên thể loại', 
               'name.unique' => 'ten thể loại đã tồn tại',
               'name.min' => 'Tên thể loại tối thiểu 3 ký tự.', 
               'name.max' => 'Tên thể loại tối đa 200 ký tự.',
               'price.required' => 'Bạn chưa nhập giá',
               'hire_price.required'=>'bạn chưa nhập giá thuê'
            ]);
         $ebook->name = $req->name;
         $ebook->description = $req->description;
         $ebook->save();

         return redirect('admin/ebook/sua/'.$id)->with('thongbao','Bạn đã sửa thành công');
   }

   public function getThem() {
      $type = tbltype::all();
      $publisher = tblpublisher::all();
      $author = tblauthor::all();
      $language = tbllanguage::all();
    return view('admin.ebook.them',['type'=>$type,
                                       'publisher'=>$publisher, 
                                       'author'=>$author, 
                                       'language'=>$language]);
   }

   public function postThem(Request $req) {
        $this->validate($req, 
            [
                'name' => 'required|min:3|max:200', 
               'description'=>'required',
               'pagenum'=>'required',
               'image'=>'required',
               'link_content'=>'required',
               'language'=>'required',
               'type'=>'required',
               'publisher'=>'required',
               'author'=>'required',
               'price'=>'required',
               'hire_price'=>'required',

            ],
            [
                'name.required' => 'Bạn chưa nhập tên ebook', 
                'name.min' => 'Tên ebook tối thiểu 3 ký tự.', 
                'name.max' => 'Tên ebook tối đa 200 ký tự.',
               'description.required'=>'Bạn chưa nhập mô tả',
               'pagenum.required'=>'Bạn chưa nhập số trang',
               'link_content.required'=>'Bạn chưa nhập nội dung',
               'price.required'=>'Bạn chưa nhập giá'

            ]);
        $ebook = new tblebook();
        $ebook->name = $req->name;
         $ebook->description = $req->description;
         $ebook->rate = 3;
         $ebook->link_content='a';
         $ebook->pagenum = $req->pagenum;
         //image
         if($req->hasFile('image')){
            $file = $req->file('image');
            $duoi = $file->getClientOriginalExtension();
            if($duoi != 'jpg' && $duoi != 'png' && $duoi != 'jpeg'){
               return redirect('admin.ebook/them')->with('loi','Bạn chỉ được chọn file có đuôi là jpg, png, jpeg');
            }
            $name = $file->getClientOriginalName();
            $image = str_random(2)."_".$name;
            while (file_exists("upload/ebook/".$image)) {
               $image = str_random(2)."_".$name;
            }
            
            $file->move("upload/ebook",$image);
            $ebook->image = $image;

         }else {
            $ebook->image = "";
         }
         //pdf
         if($req->hasFile('link_content')){
            $file = $req->file('link_content');
            $duoi = $file->getClientOriginalExtension();
            if($duoi != 'pdf'){
               return redirect('admin.ebook/them')->with('loi','Bạn chỉ được chọn file có đuôi là pdf');
            }
            $name = $file->getClientOriginalName();
            $content = str_random(2)."_".$name;
            while (file_exists("upload/content/".$content)) {
               $content = str_random(2)."_".$name;
            }
            
            $file->move("upload/content",$content);
            $ebook->link_content = $content;

         }else {
            $ebook->link_content = "";
         }
         $ebook->price = $req->price;
         $ebook->hire_price = $req->hire_price;
         $ebook->new = 0;
         $ebook->publisher_id = $req->publisher;
         $ebook->save();
         $ebook->author_ebook()->attach($req->author);
         $ebook->language_ebook()->attach($req->language);
         $ebook->type_ebook()->attach($req->type);


         
         return redirect('admin/ebook/them')->with('thongbao','thêm ebook thành công');

   }

   public function getXoa($id){
      $ebook = tblebook::find($id);
      if((count($ebook->hire) > 0)||(count($ebook->author_ebook) > 0)||(count($ebook->language_ebook) > 0)||(count($ebook->type_ebook) > 0))
      {
         return redirect('admin/ebook/danhsach')->with('thongbao','Không thể xóa ebook này');
      }else{
         $ebook->delete();
         return redirect('admin/ebook/danhsach')->with('thongbao','Bạn đã xóa thành công');
      }
   }

   public function read(){
      return response()->file('upload/content/1w_QUY-DINH-CUONG-LUAN-VAN.pdf');
   }

}
