<?php


class OfferService
{
    public static function saveOffer()
    {
        $props = self::filterData();
        try {
            self::uploadImage($props['image_name']);
            OfferRequester::saveOne($props);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public static function fromShortcode($id)
    {
        $id = DataFilter::convertToInt($id);
        try {
            return OfferRequester::findOneById($id);
        } catch (Exception $e) {
            throw $e;
        }
    }

    private static function filterData()
    {
        $props['title'] = DataFilter::convertToString($_POST['offer-title']);
        $props['description'] = DataFilter::convertToString($_POST['offer-desc']);
        $props['category'] = DataFilter::convertToString($_POST['offer-cat']);
        $props['regular_price'] = DataFilter::convertToFloat($_POST['offer-reg-price']);
        $props['special_price'] = DataFilter::convertToFloat($_POST['offer-spec-price']);
        $props['datetime'] = DataFilter::convertToDate($_POST['offer-date']);
        try {
            $props['image_name'] = RandomGenerator::hexString(10);
        } catch (Exception $e) {
            exit($e->getMessage());
        }
        $props['image_name'] = $props['image_name'] . FileHelper::getFileExt($_FILES['offer-image']['type']);
        return $props;
    }

    private static function uploadImage($img_name)
    {
        $width = 300;
        $height = 200;
        $img = $_FILES['offer-image'];
        $img_path = __DIR__ . '/../img/' . $img_name;
        FileHelper::saveImage($img['tmp_name'], $img_path);
        if (!FileHelper::checkFile($img_path)) {
            FileHelper::deleteFile($img_path);
            throw new \Exception('Incorrect image type!');
        }
        ImageEditor::resizeImage($img_path, $img_path, $img['type'], $width, $height);
    }
}