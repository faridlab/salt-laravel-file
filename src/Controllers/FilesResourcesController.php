<?php

namespace SaltFile\Controllers;

use OpenApi\Annotations as OA;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use SaltLaravel\Controllers\Controller;
use SaltLaravel\Controllers\Traits\ResourceIndexable;
use SaltLaravel\Controllers\Traits\ResourceStorable;
use SaltLaravel\Controllers\Traits\ResourceShowable;
use SaltLaravel\Controllers\Traits\ResourceUpdatable;
use SaltLaravel\Controllers\Traits\ResourcePatchable;
use SaltLaravel\Controllers\Traits\ResourceDestroyable;
use SaltLaravel\Controllers\Traits\ResourceTrashable;
use SaltLaravel\Controllers\Traits\ResourceTrashedable;
use SaltLaravel\Controllers\Traits\ResourceRestorable;
use SaltLaravel\Controllers\Traits\ResourceDeletable;
use SaltLaravel\Controllers\Traits\ResourceImportable;
use SaltLaravel\Controllers\Traits\ResourceExportable;
use SaltLaravel\Controllers\Traits\ResourceReportable;

/**
 * @OA\Info(
 *      title="Countries Endpoint",
 *      version="1.0",
 *      @OA\Contact(
 *          name="Farid Hidayat",
 *          email="farid@startapp.id",
 *          url="https://startapp.id"
 *      )
 *  )
 */
class FilesResourcesController extends Controller
{
    protected $modelNamespace = 'SaltFile';

    /**
     * @OA\Get(
     *      path="/api/v1/countries",
     *      @OA\ExternalDocumentation(
     *          description="More documentation here...",
     *          url="https://github.com/faridlab/laravel-search-query"
     *      ),
     *      @OA\Parameter(
     *          in="query",
     *          name="search",
     *          required=false
     *      ),
     *      @OA\Response(
     *          response="200",
     *          description="List of Country"
     *      ),
     *      @OA\Response(response="default", description="Welcome page")
     * )
     */
    use ResourceIndexable;

    use ResourceStorable;
    use ResourceShowable;
    use ResourceUpdatable;
    use ResourcePatchable;
    use ResourceDestroyable;
    use ResourceTrashable;
    use ResourceTrashedable;
    use ResourceRestorable;
    use ResourceDeletable;
    use ResourceImportable;
    use ResourceExportable;
    use ResourceReportable;

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function upCreate(Request $request)
    {
        // TODO: make this permission work in the future
        // try {
        //     $this->checkPermissions('updatePhoto', 'update');
        // } catch (\Exception $e) {
        //     $this->responder->set('message', 'You do not have authorization.');
        //     $this->responder->setStatus(401, 'Unauthorized');
        //     return $this->responder->response();
        // }

        try {

            $validator = Validator::make($request->all(), [
                                    'file' => 'required|file',
                                    'foreign_table' => 'required|string',
                                    'foreign_id' => 'required|integer',
                                    'directory' => 'required|string'
                                ]);

            if ($validator->fails()) {
                $this->responder->set('errors', $validator->errors());
                $this->responder->set('message', $validator->errors()->first());
                $this->responder->setStatus(400, 'Bad Request.');
                return $this->responder->response();
            }

            $model = $this->model
                        ->where($request->only([
                            'foreign_table',
                            'foreign_id',
                            'directory'
                        ]))
                        ->first();

            if(is_null($model)) {
                $model = $this->model;
            }

            $params = $request->only($this->model->getTableFields());
            $file = request()->file('file');
            $data = Filestore::create($file, $params);
            foreach ($data as $key => $value) {
                $model->setAttribute($key, $value);
            }
            $model->save();

            $this->responder->set('message', 'Data updated.');
            $this->responder->set('data', $model);
            return $this->responder->response();

        } catch (\Exception $e) {
            $this->responder->set('message', $e->getMessage());
            $this->responder->setStatus(500, 'Internal server error.');
            return $this->responder->response();
        }
    }
}

