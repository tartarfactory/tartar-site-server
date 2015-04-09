<?php
/**
 * Created by IntelliJ IDEA.
 * User: Administrator
 * Date: 2015-04-02
 * Time: ¿ÀÈÄ 11:52
 */

namespace App\Http\Controllers;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Emails;
use DB;
use Illuminate\Support\Facades\Input;
use App\Library\query;
use Illuminate\Http\Request;

class EmailsController extends Controller {
    public function findMultiResult(Emails $emails) {
        $result = $emails->select('id','name','email','content','created_at','updated_at');
        $result = query::redefinitionQuery($result,$_GET);
        return $result->get();
    }

    public function findSingleResult(Emails $emails,$id) {
        $result = $emails->select('id','name','email','content','created_at','updated_at')->where('id','=',$id)->get();
        if($result == '[]') return 'NotFoundId';
        else return $result;
    }

    public function sendEmail(Emails $emails) {
        $data = Input::Json();
        $now = date("Y-m-d H:i:s");
        return EmailsController::findSingleResult($emails,$emails->insertGetId(array('name'=>$data->get('name'), 'email'=>$data->get('email'), 'content'=>$data->get('content'), 'created_at'=>$now,'updated_at'=>$now)));
    }
}