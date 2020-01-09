<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\Document as DocumentResource;
use App\Models\Document;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDocument;
use App\Models\Submitter;
use App\Models\TypeDocument;
use Aws\Api\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Filesystem\Filesystem;

class DocumentApiController extends Controller
{
    public function __construct()
    {
        $this->S3_DOCUMENTS = env('AWS_URL', 'local');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function validationField(Request $request, $name, $validates)
    {
        $validator = $request->validate([
            $name => $validates
        ]);
        return $validator;
    }

    public function validationFile(Request $request, $name, $allowedfileExtension)
    {
        $extension = $request[$name]->getClientOriginalExtension();
        $checkType = in_array($extension, [$allowedfileExtension]);
        // dd($checkType);
        if (!$checkType) {
            return $request->validate([
                'file' => 'mimes:' . $allowedfileExtension
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Document $document
     * @return \Illuminate\Http\Response
     */
    public function show(Document $document)
    {
        return response([
            'data' => new DocumentResource($document)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDocument $request)
    {
        $store = $request->all();
        $this->validationFile($request, 'file', "pdf,doc,docx");
        $store['created_at'] = now();

        $upload = $request->file('file');
        $fileName = str_replace(' ', '-', $upload->getClientOriginalName());
        $filename_hash = substr(hash('md5', date("mdYhms")), 0, 10) . '-' . $fileName;
        $filePath = '/uploads/documents/' . $filename_hash;
        // \Storage::disk('s3')->put($filePath, file_get_contents($upload), 'public');
        $store['url'] = $this->S3_DOCUMENTS . $filePath;

        $submitter = Submitter::findOrFail($request->submitter_id);
        $typeDocument = TypeDocument::findOrFail($request->type_document_id);

        if ($submitter && ( $submitter->description == 'plaintiff' || $submitter->description == 'defendant' )) {
            if ($typeDocument->description == 'evidence') {
                $this->validationField($request, 'number', 'bail|required');
                Document::create($store);
            } else {
                $store['number'] = 'NULL';
                Document::create($store);
            }
        } else {
            $store['number'] = 'NULL';
            Document::create($store);
        }

        $message = ['status' => 'success', 'content' => 'ドキュメント正常に作成されました'];
        return response()->json(['url'=> route('documents.index'), 'message' => $message], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
