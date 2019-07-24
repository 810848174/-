<?php
namespace App\Http\Controllers\Merchant; use App\Library\Response; use App\System; use function GuzzleHttp\Psr7\mimetype_from_filename; use Illuminate\Http\Request; use App\Http\Controllers\Controller; use Illuminate\Support\Facades\Auth; use Illuminate\Support\Facades\Storage; class File extends Controller { public static function uploadImg($sp671fc7, $sp45cf7f, $sp627e2a, $sp51c805 = false) { try { $spbe2c49 = $sp671fc7->extension(); } catch (\Throwable $sp696863) { return Response::fail($sp696863->getMessage()); } if (!$sp671fc7 || !in_array(strtolower($spbe2c49), array('jpg', 'jpeg', 'png', 'gif'))) { return Response::fail('图片错误, 系统支持jpg/png/gif格式'); } if ($sp671fc7->getSize() > 5 * 1024 * 1024) { return Response::fail('图片不能大于5MB'); } try { $sp678350 = $sp671fc7->store($sp627e2a, array('disk' => System::_get('storage_driver'))); } catch (\Exception $sp696863) { \Log::error('File.uploadImg folder:' . $sp627e2a . ', error:' . $sp696863->getMessage(), array('exception' => $sp696863)); if (config('app.debug')) { return Response::fail($sp696863->getMessage()); } else { return Response::fail('上传文件失败, 内部错误, 请联系客服'); } } if (!$sp678350) { return Response::fail('系统保存文件出错, 请稍后再试'); } $spde903c = System::_get('storage_driver'); $spc2ee22 = Storage::disk($spde903c)->url($sp678350); $spcdced8 = \App\File::insertGetId(array('user_id' => $sp45cf7f, 'driver' => $spde903c, 'path' => $sp678350, 'url' => $spc2ee22)); if ($spcdced8 < 1) { Storage::disk($spde903c)->delete($sp678350); return Response::fail('数据库繁忙，请稍后再试'); } $sp599084 = array('id' => $spcdced8, 'url' => $spc2ee22, 'name' => pathinfo($sp678350, PATHINFO_BASENAME)); if ($sp51c805) { return $sp599084; } return Response::success($sp599084); } function upload_merchant(Request $spbaac90) { $spdc0e57 = $this->getUser($spbaac90); if ($spdc0e57 === null) { return Response::forbidden('无效的用户'); } $sp671fc7 = $spbaac90->file('file'); return $this->uploadImg($sp671fc7, $spdc0e57->id, \App\File::getProductFolder()); } public function renderImage(Request $spbaac90, $spfc46b9) { if (str_contains($spfc46b9, '..') || str_contains($spfc46b9, './') || str_contains($spfc46b9, '.\\') || !starts_with($spfc46b9, 'images/')) { $spb9f1f4 = file_get_contents(public_path('images/illegal.jpg')); } else { $spfc46b9 = str_replace('\\', '/', $spfc46b9); $sp671fc7 = \App\File::wherePath($spfc46b9)->first(); if ($sp671fc7) { $spde903c = $sp671fc7->driver; } else { $spde903c = System::_get('storage_driver'); } if (!in_array($spde903c, array('local', 's3', 'oss', 'qiniu'))) { return response()->view('message', array('title' => '404', 'message' => '404 Driver NotFound'), 404); } try { $spb9f1f4 = Storage::disk($spde903c)->get($spfc46b9); } catch (\Illuminate\Contracts\Filesystem\FileNotFoundException $sp696863) { \Log::error('File.renderImage error: ' . $sp696863->getMessage(), array('exception' => $sp696863)); return response()->view('message', array('title' => '404', 'message' => '404 NotFound'), 404); } } ob_end_clean(); header('Content-Type: ' . mimetype_from_filename($spfc46b9)); die($spb9f1f4); } }