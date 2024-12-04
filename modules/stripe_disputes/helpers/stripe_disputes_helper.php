<?php

function getStripeMedia($stripe_file_id)
{
    $CI = &get_instance();
    $stripe = new \Stripe\StripeClient($CI->encryption->decrypt(get_option('paymentmethod_stripe_api_secret_key')));
    try {
        $file = $stripe->files->retrieve(
            $stripe_file_id
        );
        $type = $file->type;
        $url = $file->links->data[0]->url;
    } catch (Exception $e) {
        $file = null;
        $url = null;
    }

    if ($file && $url) {
        if ($type == "png" || $type == "jpg") {
            return ' <a href="' . $url . '" data-lightbox="image-1"><img src="' . $url . '" style="width: 100px; height:100px;"></a>';
        } else {
            return '<a href="' . $url . '">Download File</a>';
        }
    } else {
        return "";
    }
}
