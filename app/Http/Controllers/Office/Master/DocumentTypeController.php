<?php

namespace App\Http\Controllers\Office\Master;

use Illuminate\Http\Request;
use App\Models\Master\DocumentType;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DocumentTypeController extends Controller
{
    public function __construct()
    {
        // 
    }
    public function index(Request $request)
    {
        if($request->ajax()){
            $collection = DocumentType::where('name','LIKE','%'.$request->keyword.'%')->paginate(10);;
            return view('pages.office.master.document_type.list', compact('collection'));
        }
        return view('pages.office.master.document_type.main');
    }
    public function create()
    {
        return view('pages.office.master.document_type.input', ['data' => new DocumentType]);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if ($validator->fails())
        {
            return response()->json([
                'alert' => 'error',
                'message' => $validator->errors()->first(),
            ], 200);
        }
        $document_type = new DocumentType;
        $document_type->name = $request->name;
        $document_type->created_by = Auth::guard('employees')->user()->id;
        $document_type->save();
        return response()->json([
            'alert' => 'success',
            'message' => 'Document Type Created',
        ]);
        
    }
    public function show(DocumentType $documentType)
    {
        //
    }
    public function edit(DocumentType $documentType)
    {
        return view('pages.office.master.document_type.input', ['data' => $documentType]);
    }
    public function update(Request $request, DocumentType $documentType)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if ($validator->fails())
        {
            return response()->json([
                'alert' => 'error',
                'message' => $validator->errors()->first(),
            ], 200);
        }
        $documentType->name = $request->name;
        $documentType->update();
        return response()->json([
            'alert' => 'success',
            'message' => 'Document Type Updated',
        ]);
    }
    public function destroy(DocumentType $documentType)
    {
        $documentType->delete();
        return response()->json([
            'alert' => 'success',
            'message' => 'Document Type Deleted',
        ]);
    }
}
