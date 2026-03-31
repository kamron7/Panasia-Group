<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Core\AdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

class MoxiecutController extends AdminController
{
    private $maxUploadSize = '100M';
    private $allowedExtensions = ['jpg', 'png', 'gif', 'bmp', 'pdf', 'doc', 'docx', 'xls', 'xlsx', 'mp4', 'm4v', 'mov'];
    private $forbiddenExtensions = ['php', 'js', 'htm', 'cgi', 'xml', 'wml', 'pl', 'perl', 'asp', 'php3', 'php4', 'html'];
    private $uploadDir = 'app/public/uploads';
    private $jsrpc = '2.0';
    private $charset = "utf-8";

    public function __construct()
    {
//        dd(auth()->user());
//            $userType = auth()->user()->role;
//
//            if ($userType != 'admin') {
//                abort(403);
//            }

        ini_set("upload_max_filesize", $this->maxUploadSize);
        ini_set("post_max_size", $this->maxUploadSize);
    }

    public function index(Request $request)
    {
        // Handling file uploads and directory browsing
        $uploadsFile = $request->query('uploads_file');
        $globalDirs = $this->getGlobalDirs($uploadsFile);

        $workDir = storage_path($this->uploadDir);

        if ($request->isMethod('post')) {
            $json = json_decode($request->input('json'), true);
            $id = null;
            if ($request->input("action") == "upload") {
                $OUT["jsonrpc"] = $this->jsrpc;
                $file = $_FILES["file"]["tmp_name"];
                $name = $_GET["name"];
                $type = strtolower(substr(strrchr($name, "."), 1));
                if (in_array($type, $this->forbiddenExtensions)) {
                    $OUT["error"] = array(
                        "code" => "100",
                        "message" => "This filetype is forbidden!",
                        "data" => ""
                    );
                } else {
                    $copyto = $_GET["path"];
                    $muf = iconv('utf-8', $this->charset, $workDir . $copyto . "/" . $name);
                    if (move_uploaded_file($file, $muf) == true)
                        $OUT = $this->refreshdirs($globalDirs, $OUT, $this->maxUploadSize);
                }
                $OUT["id"] = $id;
                return $OUT;
            }
            $method = $json['method'];
            $params = $json['params'];

            switch ($method) {
                case 'listRoots':
                    return response()->json($this->listRoots($id, $globalDirs));
                case 'listFiles':
                    return response()->json($this->listFiles($id, $params, $workDir, $globalDirs));
                case 'getFileContents':
                    return response()->json($this->getFileContents($params, $workDir));
                case 'putFileContents':
                    return response()->json($this->putFileContents($params, $workDir));
                case 'FileInfo':
                    return response()->json($this->fileInfo($id, $params, $workDir));
                case 'getConfig':
                    return response()->json($this->getConfig($id, $params, $globalDirs));
                case 'createDirectory':
                    return response()->json($this->createDirectory($id, $params, $workDir, $globalDirs));
                case 'delete':
                    return response()->json($this->FileDelete($id, $params, $workDir, $globalDirs));
                case 'moveTo':
                    return response()->json($this->moveTo($id, $params, $workDir, $globalDirs));
                case 'copyTo':
                    return response()->json($this->copyTo($id, $params, $workDir, $globalDirs));
                default:
                    return response()->json(['error' => 'Method not supported!'], 400);
            }
        }

//        return view('admin.moxiecut.index');
    }

    private function getGlobalDirs($uploadsFile)
    {
        if ($uploadsFile) {
            return [
                $uploadsFile => ['ext' => implode(',', $this->allowedExtensions)]
            ];
        }

        return [
            'pages' => ['ext' => implode(',', $this->allowedExtensions)]
        ];
    }

    function GetData($path, $ext = false, $filter = false, $workdir, $charset)
    {
        // global $workdir, $charset;
        if (strstr($path, "..")) die();
        $dir = $workdir . $path . "/";
        $dir = iconv('utf-8', $charset, $dir);
        $files = array_diff(scandir($dir), array('.', '..'));
        $data = array();
        foreach ($files as $file) {
            $val = (is_file($dir . $file) ? "file" : "dir");
            if ($ext) {
                $type = strtolower(substr(strrchr($file, "."), 1));
                $typearr = explode(",", $ext);
                if (in_array($type, $typearr))
                    $data[$val][] = $file;
            } else {
                if ($filter) {
                    if (stristr($file, $filter))
                        $data[$val][] = $file;
                } else
                    $data[$val][] = $file;
            }
        }
        return $data;
    }

    function GetAttrFiles($path, $arr, $workdir, $preview_types, $charset)
    {
        //global $workdir,$preview_types, $charset;
//    $num = count($arr);
        if (!$arr) {
            return;
        }
//        Log::info($arr);
        foreach ($arr as $key => $dataarr) {
            if ($key == "file") {
                $path = iconv('utf-8', $charset, $path);
                foreach ($dataarr as $filename) {
                    $fname = iconv($charset, 'utf-8', $filename);
                    $file = $workdir . $path . "/" . $filename;
                    $attr = stat($file);
                    $modify = $attr[9];
                    $size = $attr[7];
                    $type = strtolower(substr(strrchr($filename, "."), 1));
                    $preview = (in_array($type, $preview_types) ? "p" : "-");
                    $edit = ($type == "jpg" || $type == "txt" ? "e" : "-");
                    $attr = "-rwr" . $edit . "v" . $preview;
                    $FI[] = array($fname, $size, $modify, $attr);
                }
            } else {
                foreach ($dataarr as $filename) {
                    $fname = iconv($charset, 'utf-8', $filename);
                    $file = $workdir . $path . "/" . $filename;
                    $size = 0;
                    $stat = stat($file);
                    $modify = date($stat[9]);
                    $attr = "drwr---";
                    $FI[] = array($fname, $size, $modify, $attr);
                }
            }
        }
        return $FI;
    }

    function SendParamsDir($dir = false, $globaldirs, $max_uploaded_size)
    {
        // global $globaldirs,$max_uploaded_size;
        $dir = $dir;
        $types = ($globaldirs[$dir]["ext"] ? $globaldirs[$dir]["ext"] : "*");
        $data = array(
            "general.hidden_tools" => "",
            "general.disabled_tools" => "",
            "filesystem.extensions" => "*",
            "filesystem.force_directory_template" => false,
            "upload.maxsize" => $max_uploaded_size,
            "upload.chunk_size" => "100MB",
            "upload.extensions" => $types
        );
        return $data;
    }

    function sendparamsfile($path, $size, $modify, $file = false, $url)
    {
        //global $url;
        $data = array(      //��� ���� ����� ��������� ���������� ����� thumbnails
            "path" => $path,
            "size" => $size,
            "lastModified" => $modify,
            "isFile" => $file,
            "canRead" => true,
            "canWrite" => true,
            "canEdit" => true,
            "canRename" => true,
            "canView" => true,
            "canPreview" => false,
            "exists" => true,
            "meta" => array("url" => $url . $path),
            "info" => array("" => "")
        );
        return $data;
    }

    function refreshdirs($globaldirs, $OUT, $max_uploaded_size)
    {
        //  global $globaldirs, $OUT;
        foreach ($globaldirs as $gd => $key) {
            $OUT["result"][] = array(
                "name" => $gd,
                "path" => "/" . strtolower($gd),
                "meta" => array(
                    "standalone" => false
                ),
                "config" => $this->SendParamsDir($gd, $globaldirs, $max_uploaded_size)
            );
        }
        return $OUT;
    }

    function delTree($dir)
    {
        $files = glob($dir . '*', GLOB_MARK);
        foreach ($files as $file) {
            if (substr($file, -1) == '/')
                $this->delTree($file);
            else
                unlink($file);
        }
        rmdir($dir);
    }

    private function listRoots($id, $globalDirs)
    {

        $OUT["jsonrpc"] = $this->jsrpc;
        $OUT["id"] = $id;
        $OUT = $this->refreshdirs($globalDirs, $OUT, $this->maxUploadSize);
        return $OUT;
    }

    private function listFiles($id, $params, $workDir, $globalDirs)
    {
        $OUT["jsonrpc"] = $this->jsrpc;
        $path = $params["path"];
        $DIR = explode("/", $path);
        if (@$params["only_files"]) {
            $extensions = $params["extensions"];    //"jpg,gif,png,jpeg",
            $filez = $this->GetData($path, $extensions, $params["filter"], $workDir, $this->charset);
            $filesinfo = $this->GetAttrFiles($path, $filez, $workDir, $this->allowedExtensions, $this->charset);
            $stat = stat($workDir . $path);
            $modify = date($stat[9]);
            $OUT["result"] = array(
                "columns" => array("name", "size", "modified", "attrs", "info"),
                "config" => $this->sendparamsdir(trim($DIR[1]), $globalDirs, $this->maxUploadSize),
                "file" => $this->sendparamsfile($path, 4096, $modify, false, $this->uploadDir),
                "urlFile" => null,
                "data" => $filesinfo,
            );
        } else {
            $filez = $this->GetData($path, false, $params["filter"], $workDir, $this->charset);
            $filesinfo = $this->GetAttrFiles($path, $filez, $workDir, $this->allowedExtensions, $this->charset);
//            Log::info(['info' => $filesinfo]);
            if (!$filesinfo)
                $filesinfo = array("" => "");
            $path = iconv('utf-8', $this->charset, $path);
            $stat = stat($workDir . $path);
            $modify = date($stat[9]);
            $path = iconv($this->charset, 'utf-8', $path);
            $OUT["result"] = array(
                "columns" => array("name", "size", "modified", "attrs", "info"),
                "config" => $this->sendparamsdir(trim($DIR[1]), $globalDirs, $this->maxUploadSize),
                "file" => $this->sendparamsfile($path, 0, $modify, false, $this->uploadDir),
                "urlFile" => null,
                "data" => $filesinfo,
            );
        }
        $OUT["id"] = $id;

        return $OUT;
    }

    private function getFileContents($params, $workDir)
    {
        $path = $params['path'];
        $filePath = $workDir . '/' . trim($path, '/');

        if (!File::exists($filePath)) {
            return ['error' => 'File not found'];
        }

        return ['result' => ['content' => File::get($filePath)]];
    }

    private function putFileContents($params, $workDir)
    {
        $path = $params['path'];
        $content = $params['content'];
        $filePath = $workDir . '/' . trim($path, '/');

        File::put($filePath, $content);

        return ['result' => 'File saved successfully'];
    }

    private function fileInfo($id, $params, $workDir)
    {
        $OUT["jsonrpc"] = $this->jsrpc;

        if (@$params["insert"]) {
            $file = $workDir . $params["paths"][0];
            $file = iconv('utf-8', $this->charset, $file);
            $attr = stat($file);
            $modify = $attr[9];
            $size = $attr[7];
            $type = strtolower(substr(strrchr($file, "."), 1));
            $preview = ($type == "jpg" ? "p" : "-");
            $attr = "-rwr-v" . $preview;
            $OUT["result"][] = $this->sendparamsfile($params["paths"][0], $size, $modify, true, $this->uploadDir);
        } else {
            $path = $params["path"];
            $path = iconv('utf-8', $this->charset, $path);
            $stat = stat($workDir . $path);
            $modify = date($stat[9]);
            $path = iconv($this->charset, 'utf-8', $path);
            $OUT["result"] = $this->sendparamsfile($path, 0, $modify, false, $this->uploadDir);
        }
        $OUT["id"] = $id;

        return $OUT;
    }

    private function createDirectory($id, $params, $workDir, $globalDirs)
    {
        $path = $params["path"];
        mkdir($workDir . $path);
        $OUT["jsonrpc"] = $this->jsrpc;
        $OUT = $this->refreshdirs($globalDirs, $OUT, $this->maxUploadSize);
        $OUT["id"] = $id;

        return $OUT;
    }

    private function FileDelete($id, $params, $workDir, $globalDirs)
    {
        $OUT["jsonrpc"] = $this->jsrpc;
        foreach ($params["paths"] as $file) {
            $patharr = explode("/", $file);
            if ($globalDirs[$patharr[1]] && !strstr($file, "..")) {
                $file = iconv('utf-8', $this->charset, $file);
                if (is_dir($workDir . $file))
                    $this->delTree($workDir . $file . "/");
                else
                    unlink($workDir . $file);
            }
        }
        $OUT = $this->refreshdirs($globalDirs, $OUT, $this->maxUploadSize);
        $OUT["id"] = $id;

        return $OUT;
    }

    private function moveTo($id, $params, $workDir, $globalDirs)
    {
        $OUT["jsonrpc"] = $this->jsrpc;
        $from = $params["from"];
        $to = iconv('utf-8', $this->charset, $workDir . $params["to"]);
        if (is_array($from)) {
            foreach ($from as $file) {
                $patharr = explode("/", $file);
                $filename = explode("/", $file);
                $num = count($filename) - 1;
                $file = iconv('utf-8', $this->charset, $file);
                $filename[$num] = iconv('utf-8', $this->charset, $filename[$num]);
                if ($globalDirs[$patharr[1]] && !strstr($file, ".."))
                    rename($workDir . $file, $to . "/" . $filename[$num]);
            }
        } else {
            $patharr = explode("/", $from);
            $patharr2 = explode("/", $to);
            $type = strtolower(substr(strrchr($to, "."), 1));
            if (!strstr($from, "..") && !strstr($to, "..") && !in_array($type, $this->forbiddenExtensions)) {
                $from = iconv('utf-8', $this->charset, $from);
                rename($workDir . $from, $to);  //��������������
            } else
                $OUT["error"] = array("code" => "100", "message" => "This filetype is forbidden! Rename aborted!", "data" => "");
        }
        $OUT = $this->refreshdirs($globalDirs, $OUT, $this->maxUploadSize);
        $OUT["id"] = $id;
        return $OUT;
    }

    private function copyTo($id, $params, $workDir, $globalDirs)
    {
        $from = $params["from"];
        $to = iconv('utf-8', $this->charset, $workDir . $params["to"]);
        foreach ($from as $file) {
            $filename = explode("/", $file);
            $num = count($filename) - 1;
            $file = iconv('utf-8', $this->charset, $file);
            $filename[$num] = iconv('utf-8', $this->charset, $filename[$num]);
            copy($workDir . $file, $to . "/" . $filename[$num]);
        }

        $OUT["jsonrpc"] = $this->jsrpc;
        $OUT = $this->refreshdirs($globalDirs, $OUT, $this->maxUploadSize);
        $OUT["id"] = $id;

        return $OUT;
    }

    private function getConfig($id, $params, $globalDirs)
    {
        $path = $params["path"];
        $DIR = explode("/", $path);
        $OUT["jsonrpc"] = $this->jsrpc;
        $OUT["result"] = $this->SendParamsDir($DIR[1], $globalDirs, $this->maxUploadSize);
        $OUT["id"] = $id;


        return $OUT;
    }
}