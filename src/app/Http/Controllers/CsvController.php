<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Rap2hpoutre\FastExcel\FastExcel;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CsvController extends Controller
{
    public function upload(Request $request) {

    $uploaded_file = $request->file('csvdata');
    $orgName = date('YmdHis') ."_".$request->file('csvdata')->getClientOriginalName();
    $spath = storage_path('app/');
    $path = $spath.$request->file('csvdata')->storeAs('',$orgName);

    $converted_file = $spath . "converted_" . $orgName;
    $this->convertFileEncode($path, 'sjis-win', $converted_file, 'UTF-8', "\r\n");

    $result = (new FastExcel)->configureCsv(',')->importSheets($converted_file);

    $count = 0;
    foreach ($result as $row) {
    foreach($row as $item){
    // 画像のURLを取得
            $imageUrl = $item["url"];
            // URLから拡張子を取得
            $extension = pathinfo($imageUrl, PATHINFO_EXTENSION);
            // 画像をダウンロードして保存
            $contents = file_get_contents($imageUrl);
            $imageName = Str::random(10) . '.' . $extension;
            Storage::put('public/shop_photo/'.$imageName, $contents);
            // 保存した画像のパス
            $imagePath = 'storage/shop_photo/' . $imageName;
    $param = [
    'name' => $item["name"],
    'area' => $item["area"],
    'category' => $item["category"],
    'overview' => $item["overview"],
    'image_name' => $imageName,
    'path' => $imagePath,
    'created_at' => now(),
    ];
    DB::table('shops')->insert($param);
    $count++;
    }}

    Storage::delete($orgName);
    Storage::delete("converted_" . $orgName);

    return redirect(route('managementIndex',['count' => $count]));
    }


    protected function convertFileEncode($infname="", $incode='sjis-win', $outfname="", $outcode='UTF-8', $nl="\r\n") {
        if ( ! is_file($infname) ) {
            die("変換失敗：{$infname} が見つかりません．");
        }
        $tmp_filename = getmypid().'.tmp';
        $outfp = fopen($tmp_filename, 'wb');
        if ($outfp === FALSE) {
            die("変換失敗：{$tmp_filename} に書き込むことができません．");
        }
        $fp = fopen($infname,'r') or die("ファイル({$infname})のオープンに失敗しました");
        while ( ($line = fgets($fp,999999)) !== false ) {
            $outstr = mb_convert_encoding($line, $outcode, $incode);
            $outstr = preg_replace("/\r\n|\r|\n/", $nl, $outstr);
            fwrite($outfp, $outstr);
        }
        fclose($fp);
        fclose($outfp);
        rename($tmp_filename, $outfname);
        chmod($outfname, 0666);
        return true;
    }
}
