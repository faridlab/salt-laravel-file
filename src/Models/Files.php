<?php

namespace SaltFile\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Facades\Schema;

use SaltLaravel\Models\Resources;
use SaltLaravel\Traits\ObservableModel;
use SaltLaravel\Traits\Uuids;
use SaltFile\Traits\Fileable;

class Files extends Resources {
    use Uuids;
    use ObservableModel;
    use Fileable;
    protected $selfFileable = true;
    protected $fillable = [
        'fullpath',
        'path',
        'filename',
        'title',
        'description',
        'size',
        'ext',
        'directory',
        'type',
        'foreign_table',
        'foreign_id',
        'order'
    ];

    protected $filters = [
        'default',
        'search',
        'fields',
        'relationship',
        'withtrashed',
        'orderby',
        // Fields table
        'id',
        "file",
        "directory",
        "foreign_table",
        "foreign_id",
        "fullpath",
        "path",
        "filename",
        "title",
        "description",
        "ext",
        "size",
        "type",
        "order",
    ];

    protected $rules = array(
        'file' => 'required|file',
        'fullpath' => 'nullable|string|max:255',
        'path' => 'nullable|string|max:255',
        'filename' => 'nullable|string|max:255',
        'title' => 'nullable|string|max:255',
        'description' => 'nullable|string|max:255',
        'size' => 'nullable|integer',
        'order' => 'nullable|integer',
        'ext' => 'nullable|string|max:20',
        'type' => 'required|string|in:compress,document,image,video,audio,other',
        'directory' => 'nullable|string',
        'foreign_table' => 'nullable|string',
        'foreign_id' => 'nullable|string',
    );

    protected $auths = array (
        // 'index',
        'store',
        // 'show',
        'update',
        'patch',
        'destroy',
        'trash',
        'trashed',
        'restore',
        'delete',
        'import',
        'export',
        'report',
        'upCreate'
    );

    protected $forms = array();
    protected $structures = array();

    protected $searchable = array(
        'fullpath',
        'path',
        'filename',
        'title',
        'description',
        'size',
        'ext',
        'directory',
        'type',
        'foreign_table',
        'foreign_id',
        'order'
    );
}
