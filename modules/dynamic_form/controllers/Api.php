<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Api extends ClientsController
{
    public function __construct()
    {

        header("Access-Control-Allow-Origin: *");
        parent::__construct();
        $this->load->model('dynamic_form_fields');
        $this->load->model('briefs');
    }

    public function token()
    {
        try {
            $token_name = $this->security->get_csrf_token_name();
            $token_value = $this->security->get_csrf_hash();
            $response = [
                'status' => true,
                'message' => 'Success',
                'data' => [
                    'token_name' => $token_name,
                    'token_value' => $token_value,
                ]
            ];
            echo json_encode($response);
            return;
        } catch (\Exception $e) {
            $response = [
                'status' => false,
                'message' => 'Error',
                'data' => null
            ];
            echo json_encode($response);
            return;
        }
    }

    public function get($form_id)
    {
        try {
            $fields = $this->dynamic_form_fields->get($form_id);
            $response = [
                'status' => true,
                'message' => 'Success',
                'data' => [
                    'fields' => $fields
                ]
            ];
            echo json_encode($response);
            return;
        } catch (\Exception $e) {
            $response = [
                'status' => false,
                'message' => 'Error',
                'data' => null
            ];
            echo json_encode($response);
            return;
        }
    }

    public function post($form_id)
    {
        try {
            $post_data = $_POST;
            $files_data = $_FILES;
            $data = [];
            $iter = 0;
            $lead_id = null;
            $ip = $this->input->ip_address();

            if (count($post_data)) {
                foreach ($post_data as $label => $value) {
                    if ($label == "lead_id") {
                        $lead_id = $value;
                        continue;
                    }
                    $is_multiple = gettype($value) == "array" ? 1 : 0;

                    $data[$iter]['form_id'] = $form_id;
                    $data[$iter]['lead_id'] = $lead_id;
                    $data[$iter]['label'] = $label;
                    $data[$iter]['value'] = $is_multiple ? json_encode($value) : $value;
                    $data[$iter]['is_media'] = 0;
                    $data[$iter]['is_multiple'] = $is_multiple;
                    $data[$iter]['media_type'] = '';


                    $iter++;
                }
            } else {
                throw new \Exception;
            }

            if (count($files_data)) {
                foreach ($files_data as $file_label => $file_value) {
                    $is_multiple = gettype($files_data[$file_label]['name']) == "array" ? 1 : 0;

                    $uploaded_files = null;
                    $file_type = '';
                    if ($is_multiple) {
                        $file_type =
                            $this->getFileTypeByMimeType($file_value['tmp_name'][0]);

                        $files = $this->upload_files(
                            $file_value['name'],
                            $file_value['tmp_name'],
                            $file_type
                        );

                        $uploaded_files = $files;
                    } else {
                        $file_type =
                            $this->getFileTypeByMimeType($file_value['tmp_name']);
                        if ($file_name = $this->upload_file(
                            $file_value['name'],
                            $file_value['tmp_name'],
                            $file_type
                        )) {
                            $uploaded_files = $file_name;
                        }
                    }

                    $data[$iter]['form_id'] = $form_id;
                    $data[$iter]['lead_id'] = $lead_id;
                    $data[$iter]['label'] = $file_label;
                    $data[$iter]['value'] = $uploaded_files;
                    $data[$iter]['is_media'] = 1;
                    $data[$iter]['is_multiple'] = $is_multiple;
                    $data[$iter]['media_type'] = $file_type;


                    $iter++;
                }
            }

            if (!empty($ip)) {
                $ip_data = $this->getIpData($ip);
                if ($ip_data != null) {
                    $decoded_data = json_decode($ip_data);
                    foreach ($decoded_data as $key => $value) {
                        if (!empty($value)) {
                            $data[$iter]['form_id'] = $form_id;
                            $data[$iter]['lead_id'] = $lead_id;
                            $data[$iter]['label'] = $key;
                            $data[$iter]['value'] =  $value;
                            $data[$iter]['is_media'] = 0;
                            $data[$iter]['is_multiple'] = 0;
                            $data[$iter]['media_type'] = '';
                            $iter++;
                        }
                    }
                }
            }

            if (!$this->briefs->add($data)) {
                throw new \Exception;
            } else {
                $response = [
                    'status' => true,
                    'message' => 'Success',
                    'data' => null
                ];

                echo json_encode($response);
                return;
            }

            if (count($_POST)) {
                $data = [];

                foreach ($_POST['fields'] as $key => $value) {
                    $value['lead_id'] = $_POST['lead_id'];
                    $value['form_id'] = $form_id;

                    array_push($data, $value);

                    // if (!$value['is_media']) {
                    //     array_push($data, $value);
                    // } else {
                    //     if ($value['is_multiple']) {
                    //         $files = $this->upload_files(
                    //             $_FILES['fields']['name'][$key]['value'],
                    //             $_FILES['fields']['tmp_name'][$key]['value'],
                    //             $value['media_type']
                    //         );

                    //         $value['value'] = $files;
                    //         array_push($data, $value);
                    //     } else {
                    //         if ($file_name = $this->upload_file(
                    //             $_FILES['fields']['name'][$key]['value'],
                    //             $_FILES['fields']['tmp_name'][$key]['value'],
                    //             $value['media_type']
                    //         )) {
                    //             $value['value'] = $file_name;
                    //             array_push($data, $value);
                    //         }
                    //     }
                    // }
                }

                if (!$this->briefs->add($data)) {
                    throw new \Exception;
                }
            } else {
                throw new \Exception;
            }

            $response = [
                'status' => true,
                'message' => 'Success',
                'data' => null
            ];

            echo json_encode($response);
            return;
        } catch (\Exception $e) {
            $response = [
                'status' => false,
                'message' => 'Error',
                'data' => null
            ];
            echo json_encode($response);
            return;
        }
    }



    private function upload_file($file_name, $file_temp_name, $folder_name)
    {
        if (!file_exists('uploads/brief/' . $folder_name)) {
            mkdir('uploads/brief/' . $folder_name, 0777, true);
        }
        $file_name = 'brief/' . $folder_name . '/' . microtime() . $file_name;
        $file_name = str_replace(' ', '-', $file_name);
        $target_dir = 'uploads/';
        $target_file = $target_dir . $file_name;

        if (move_uploaded_file($file_temp_name, $target_file)) {
            return $file_name;
        } else {
            return false;
        }
    }

    private function upload_files($file_names, $file_temp_names, $folder_name)
    {
        if (!file_exists('uploads/brief/' . $folder_name)) {
            mkdir('uploads/brief/' . $folder_name, 0777, true);
        }
        $files = [];
        if (count($file_names) && count($file_temp_names)) {
            foreach ($file_names as $key => $file_name) {
                $file_name = 'brief/' . $folder_name . '/' . microtime() . $file_name;
                $file_name = str_replace(' ', '-', $file_name);
                $target_dir = 'uploads/';
                $target_file = $target_dir . $file_name;

                if (move_uploaded_file($file_temp_names[$key], $target_file)) {
                    array_push($files, $file_name);
                }
            }
        }
        return json_encode($files);
    }

    function getFileTypeByMimeType($mimeType)
    {
        $type = '';

        switch ($mimeType) {
            case 'image/jpeg':
            case 'image/png':
            case 'image/gif':
                $type = 'image';
                break;
            case 'audio/mpeg':
            case 'audio/ogg':
            case 'audio/wav':
                $type = 'audio';
                break;
            case 'video/mp4':
            case 'video/avi':
            case 'video/quicktime':
                $type = 'video';
                break;
                // case 'application/pdf':
                //     $type = 'pdf';
                //     break;
                // Add more cases for other MIME types as needed

            default:
                $type = 'other';
                break;
        }

        return $type;
    }

    private function getIpData($ip)
    {
        $ip_Data = file_get_contents('https://ipinfo.io/' . $ip . '/json');
        if (!$ip_Data->error) {
            return $ip_Data;
        } else {
            return null;
        }
    }
}
