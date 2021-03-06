<?php namespace App\Http\Controllers;
use App\Action;
use App\Requirement;
use App\Document;
use Illuminate\Http\Request;

class ActionController extends Controller {


    public $restful = true;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
        return view('action.index')
        ->with('actions', Action::orderBy('name')->get());
    }

    public function detail($id){
        $old = Requirement::join('action', 'requirement.action_id', '=', 'action.action_id')
            ->join('document', 'requirement.document_id', '=', 'document.document_id')
            ->where('requirement.action_id','=',$id)
            ->select('document.name','document.document_id')
            ->get();
        return view('action.detail')
        ->with('action', Action::where('action_id','=',$id)->first())
        ->with('olds',$old);
    }

    public function addActionShow(){
        return view('action.addAction')->with('documents',Document::all());
    }

    public function addAction(Request $request){
        $arrays = $request->input('my-select');
        $name = $request->input('name');
        $description = $request->input('description');
        $id = Action::insertGetId(
            ['name' => $name,'description' => $description]
        );
        if(!is_null($arrays)){
            foreach($arrays as $element){
                Requirement::insert(
                    ['document_id' => $element,'action_id' => $id]
                );
            }
        }
        return redirect('actions/add')
                       ->with('success', 'เพิ่มบริการเรียบร้อยแล้ว');
    }

    public function editActionShow($id){
        $action = Action::where('action_id','=',$id)->first();
        return view('action.editAction')
                        ->with('action',$action)
                        ->with('documents',Document::all());
    }

    public function editAction(Request $request){
        $id = $request->input('id');
        $name = $request->input('name');
        $description = $request->input('description');
        Action::where('action_id', $id)
            ->update(['name' => $name,'description' => $description]);
        return redirect('actions/'.$id)
                       ->with('success', 'แก้ไขบริการเรียบร้อยแล้ว');
    }

    public function removeAction($id){
        Action::where('action_id', $id)->delete();
        return redirect('actions')
                       ->with('success', 'ลบบริการเรียบร้อยแล้ว');
    }

    public function show($id){
        try{
            $response = [
                'action' => []
            ];
            $statusCode = 200;
            $action = Action::find($id);
            $response['action'][] = [
                'id' => $action->action_id,
                'name' => $action->name,
                'description' => $action->description
            ];
        }catch (Exception $e){
            $statusCode = 404;
        }finally{
            return Response::json($response, $statusCode);
        }
    }

}