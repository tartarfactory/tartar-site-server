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
use App\Documents;
use DB;
use Illuminate\Support\Facades\Input;
use App\Library\query;
use Illuminate\Http\Request;

class DocumentsController extends Controller {
    public function findMultiResult(Documents $documents) {
        $result = $documents->select('id','no','target','deep','category','subject','name','created_at','updated_at');
        $result = query::redefinitionQuery($result,$_GET);
        return $result->get();
    }

    public function findSingleResult(Documents $documents, $id) {
        $result = $documents->select('id','no','target','deep','category','subject','content','img','name','password','created_at','updated_at')->where('id','=',$id)->get();
        if($result == '[]') return 'NotFoundId';
        else return $result;
    }

    public function writeDocument(Documents $documents) {
        $now = date("Y-m-d H:i:s");
        if($documents->max('id') == '')
            $lastId = 1000;
        else
            $lastId = $documents->max('id')+1000;
        $documents->insert(array('id'=>$lastId,'target'=>Input::get('target'),'deep'=>0,'category'=>Input::get('category'),'subject'=>Input::get('subject'), 'content'=>Input::get('content'), 'img'=>Input::get('img'), 'name'=>Input::get('name'), 'password'=>sha1(Input::get('password')), 'created_at'=>$now,'updated_at'=>$now));
        return DocumentsController::findSingleResult($documents,$lastId);
    }

    public function reWriteDocument(Documents $documents,$id) {
        $origin = DocumentsController::findSingleResult($documents,$id);
        $deep = $origin[0]['deep']+1;
        $inputId = $origin[0]['id'] -1;
        $now = date("Y-m-d H:i:s");
        $data = Input::Json();
        $documents->insert(array('id'=>$inputId,'target'=>Input::get('target'),'deep'=>$deep,'category'=>Input::get('category'),'subject'=>Input::get('subject'), 'content'=>Input::get('content'), 'img'=>Input::get('img'), 'name'=>Input::get('name'), 'password'=>sha1(Input::get('password')), 'created_at'=>$now,'updated_at'=>$now));
        return DocumentsController::findSingleResult($documents,$inputId);
    }
    public function checkUser(Documents $documents, $id) {
        $data = Input::Json();
        $result = DocumentsController::findSingleResult($documents,$id);

        if($result[0]['name'] == Input::get('name') && $result[0]['password'] == sha1(Input::get('password')))
            return 'true';
        else
            return 'false';
    }

    public function deleteDocument(Documents $documents, $id) {
        $findId = DocumentsController::findSingleResult($documents,$id);
        if($findId != 'NotFoundId'){
            $documents->where('id','=',$id)->delete();
            return 'deletedStudy';
        }
        else return $findId;
    }
    public function modificationDocument(Documents $documents, $id) {
        $data = Input::Json();
        $documents->where('id','=',$id)->update(
            ['subject' => Input::get('subject'), 'content' => Input::get('content')]
        );
        return DocumentsController::findSingleResult($documents,$id);
    }


}