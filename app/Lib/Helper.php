<?php

namespace App\Lib;

use App\Models\SubmissionReviewer;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

class Helper
{
    public static function countyFormat($county)
    {
        $counties = config('counties');
        $county = strtolower($county);

        if (in_array($county, array_keys($counties))) {
            return $counties[$county];
        }

        return strtoupper(substr($county, 0, 3));
    }

    public static function setArrayKey($collection, $key = 'id')
    {
        $result = [];
        $keyLists = [];

        if (is_object($collection)) {
            $keyLists = $collection->lists($key)->toArray();
            $data = $collection->toArray();
            $result = array_combine($keyLists, $data);
        } elseif (is_array($collection)) {
            foreach ($collection as $item) {
                if (is_object($item)) {
                    $itemArr = get_object_vars($item);

                    if (isset($itemArr[$key])) {
                        $keyLists[] = $itemArr[$key];
                    } else {
                        break;
                    }
                } else {
                    if (isset($item[$key])) {
                        $keyLists[] = $item[$key];
                    } else {
                        break;
                    }
                }
            }

            if (count($keyLists) == count($collection)) {
                $result = array_combine($keyLists, $collection);
            }
        }

        return $result;
    }

    /**
     * Return available thumbnails for a given image.
     *
     * @param string $image
     * @param string $folder
     * @param string $size
     *
     * @return array
     */
    public static function getThumbnail($image, $folder, $size = '')
    {
        $path = [];

        if (!empty($image)) {
            $thumbnailSizes = config('app.thumbnailSizes');
            $uploadPath = config('app.upload.folder') . '/' . $folder . '/' .
                config('app.upload.' . $folder . '.thumbnails') . '/';

            if (!empty($size)) {
                $path[$size] = $uploadPath . $size . '-' . $image;
            } else {
                foreach ($thumbnailSizes as $key => $values) {
                    $path[$key] = $uploadPath . $key . '-' . $image;
                }
            }
        }

        return $path;
    }

    /**
     * Check if filename exists and increment its name.
     *
     * @param $path
     * @param $filename
     *
     * @return string
     */
    public static function incrementFilename($path, $filename)
    {
        $file['name'] = self::getFileName($filename);
        $file['ext'] = self::getFileExtension($filename);

        $increment = 1;
        $sufix = '';

        while (file_exists($path . '/' . $file['name'] . $sufix . $file['ext'])) {
            $sufix = '-' . $increment;
            $increment++;
        }
        $newFileName = $file['name'] . $sufix . $file['ext'];

        return $newFileName;
    }

    /**
     * Get filename extension.
     *
     * @param $filename
     *
     * @return string
     */
    public static function getFileName($filename)
    {
        return substr($filename, 0, strrpos($filename, '.'));
    }

    /**
     * Get filename name.
     *
     * @param $filename
     *
     * @return string
     */
    public static function getFileExtension($filename)
    {
        return strtolower(strrchr($filename, '.'));
    }

    /**
     * Convert dateime.
     *
     * @param $fromFormat
     * @param $string
     * @param $toFormat
     *
     * @return string
     */
    public static function convertDatetime($fromFormat, $string, $toFormat)
    {
        $datetime = Carbon::createFromFormat($fromFormat, $string);

        return $datetime->format($toFormat);
    }

    public static function dynamicFileSize($bytes)
    {
        if ($bytes > 0) {
            $unit = intval(log($bytes, 1024));
            $units = ['B', 'KB', 'MB', 'GB'];

            if (array_key_exists($unit, $units) === true) {
                return sprintf('%d %s', $bytes / pow(1024, $unit), $units[$unit]);
            }
        }

        return $bytes;
    }

    /**
     * Sort multidimensional array.
     *
     * @param $array
     * @param $key
     *
     * @return array
     */
    public static function multiArraySort(&$array, $key)
    {
        $sorter = [];
        $ret = [];
        reset($array);

        foreach ($array as $ii => $va) {
            if (is_array($va)) {
                $sorter[$ii] = $va[$key];
            }
            if (is_object($va)) {
                $sorter[$ii] = $va->$key;
            }
        }
        asort($sorter);

        foreach ($sorter as $ii => $va) {
            $ret[$ii] = $array[$ii];
        }

        return $ret;
    }

    /**
     * Remove number decimal if 0.
     *
     * @param $number
     * @return array
     */
    public static function removeDecimalsIfZero($number)
    {
        $arr = explode('.', $number);

        if (end($arr) > 0) {
            return $number;
        }

        return $arr[0];
    }

    /**
     * @param User $user
     * @return array
     */
    public static function isUserAccountInactive(User $user): array
    {
        $response = [];

        if ($user && $user->status != 'A') {
            $response = [
                'code' => 401,
                'message' => 'This account is inactive!',
                'error' => 'Unauthorised login',
                'data' => [
                    'user_id' => $user->id,
                    'user_name' => $user->full_name,
                    'user_email' => $user->email,

                ],
            ];

            Log::channel('web')->alert(self::getUserAction(), $response);

            Session::flush();
        }

        return $response;
    }

    /**
     * @return string
     */
    public static function getUserAction(): string
    {
        $currentAction = Route::currentRouteAction();

        if (!$currentAction) {
            return request()->ip() . ' ' . 'running phpArtisanImport';
        }

        list($controller, $method) = explode('@', $currentAction);

        $controller = preg_replace('/.*\\\/', '', $controller);

        if (Auth::user()) {
            return Auth::user()->id . ' ' . request()->ip() . ' ' . $controller . '@' . $method;
        } else {
            return request()->ip() . ' ' . $controller . '@' . $method;
        }
    }

    /**
     * @param $content
     * @param int $length
     * @param string $more
     * @return string
     */
    public static function getExcerpt($content, $length = 13, $more = ' ...')
    {
        $excerpt = strip_tags(html_entity_decode(trim($content)), '<i>');
        $words = str_word_count($excerpt, 2);
        if (count($words) > $length) {
            $words = array_slice($words, 0, $length, true);
            end($words);
            $position = key($words) + strlen(current($words));
            $excerpt = substr($excerpt, 0, $position) . $more;
        }

        return $excerpt;
    }

    public static function formatNumber($value)
    {
        $number = abs($value);
        $indicators = ['th', 'st', 'nd', 'rd', 'th', 'th', 'th', 'th', 'th', 'th'];

        $suffix = $indicators[$number % 10];
        if ($number % 100 >= 11 && $number % 100 <= 13) {
            $suffix = 'th';
        }

        return number_format($number) . $suffix;
    }

    public static function showXChars($string, $chars)
    {
        return substr($string, 0, $chars) . '..';
    }

    /**
     * @param Request $request
     * @param $model
     * @param $column
     * @param $filename
     * @param $folder
     */
    public static function uploadFiles(Request $request, $model, $column, $filename, $folder)
    {

        // dd($request->hasFile($filename));

        if ($request->hasFile($filename)) {
            $uploadedFiles = request()->file($filename);
            $uploadPath = config('cms.upload.folder') . '/' . config('cms.upload.' . $folder . '.folder');

            // dd($uploadPath);

            foreach ($uploadedFiles as $uploadedFile) {
                $file = [];
                $originalFileName = $uploadedFile->getClientOriginalName();
                $newFileName = Helper::incrementFilename(public_path() . '/' . $uploadPath, $originalFileName);

                $success = $uploadedFile->move(public_path() . '/' . $uploadPath, $newFileName);
                if ($success) {
                    $model->{$column} = $newFileName;
                    $model->save();
                }
            }
        }
    }

    public static function checkSubmissionDenied($submission): void
    {
        // reviewer responses : 0-no action,1-accept,2-deny
        $reviewers = SubmissionReviewer::where('submission_id', $submission->id)->count();
        $otherThanDeniedSubmissions = SubmissionReviewer::where('submission_id', $submission->id)
            ->where('status', 2)
            ->count();

        if ($reviewers == $otherThanDeniedSubmissions) {
            $submission->status = 0;
            $submission->save();
        }
    }

    public static function editorEmails()
    {
        return User::where('roles', 'LIKE', '%editor%')->pluck('email')->toArray();
    }
}
