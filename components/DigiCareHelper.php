<?php
/**
 * Created by PhpStorm.
 * User: ivan
 * Date: 06.03.18
 * Time: 11:45
 */
namespace app\components;
use app\models\Providers;
use Yii;

class DigiCareHelper
{
    static public function getProviderId(){
        $request = Yii::$app->request; $pid =  $request->get('pid'); if( !$pid ) { $pid = 1;  }

        $provider_id =  Yii::$app->user->identity->provider_id;
        $user_role =  Yii::$app->user->identity->user_role;

        if( $user_role > 0 ) { $pid = $provider_id;  }
        return $pid;
    }

    public static function getProvider(){
        return Providers::findOne([self::getProviderId()]);
    }

    public static function resizeImage($width, $height, $uploadfile){

        // -----------------  RESIZE IMAGE ------------------
        /* Get original image x y*/
        list($w, $h) = getimagesize( $uploadfile  );

        /* calculate new image size with ratio */
        $ratio = max($width/$w, $height/$h);
        //$ratio = $width / $w; //  //resizeToWidth
        $h = ceil($height / $ratio);

        $x = ($w - $width / $ratio) / 2;
        $w = ceil($width / $ratio);
        /* new file name */

        $path = $uploadfile ;
        /* read binary data from image file */
        $imgString = file_get_contents( $uploadfile  );
        /* create image from string */
        $image = imagecreatefromstring($imgString);
        $tmp = imagecreatetruecolor($width, $height);

        //-- alpha
        imagealphablending( $tmp, false);
        imagesavealpha($tmp,true);
        $transparent = imagecolorallocatealpha( $tmp, 255, 255, 255, 127);
        imagefilledrectangle( $tmp, 0, 0, $width, $height, $transparent);
        //-- alpha - end

        imagecopyresampled($tmp, $image,
            0, 0,
            $x, 0,
            $width, $height,
            $w, $h);
        /* Save image */

        $ext = explode('.',$uploadfile)[1];
        switch ( $ext ) {
            case 'jpg':
                imagejpeg($tmp, $path, 100);
                break;
            case 'png':
                imagepng($tmp, $path, 0); // disabled resize png images
                break;
            case 'gif':
                imagegif($tmp, $path);
                break;
            default:
                exit;
                break;
        }
       // imagejpeg($tmp, $path, 100);

        /* cleanup memory */
        imagedestroy($image);
        imagedestroy($tmp);

    }


    /*
     * Send a remote call to Onesignal server with data
     * Params:
     * Content - Content of notification
     * headings - heading of notification
     * data - parameters of notification
     * includedSEngemnts  - Segments of notification
     * filters - Filterns on Segments
     * hasFilets - shhould filter apply? Default false
     */


    public static function sendNotification($content, $headings, $data, $includedSegments, $filters, $hasFilters = false)
    {

        $fields = array();
        if($hasFilters)
        {
            $fields = array(
                'app_id' => "7b7a54ae-770b-461b-af4a-995d52ce451d",
                'included_segments' => $includedSegments,
                'data' => $data,
                'headings' => $headings,
                'large_icon' =>"ic_launcher_round.png",
                'contents' => $content,
                "filters" => $filters,
            );
        } else {
            $fields = array(
                'app_id' => "7b7a54ae-770b-461b-af4a-995d52ce451d",
                'included_segments' => $includedSegments,
                'data' => $data,
                'headings' => $headings,
                'large_icon' =>"ic_launcher_round.png",
                'contents' => $content
            );
        }


        $fields = json_encode($fields);
        
        //print("\nJSON sent:\n");
        //print($fields);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
            'Authorization: Basic ZDI0OTZhM2MtNjgzZC00MTAzLTgyNTktNmJiNmQyNjFjYTIy'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }
}
