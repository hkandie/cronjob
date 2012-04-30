<?php

class Crontodo extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('MCrontodo');
        $key = "lhiP9QWtQQsXWU+G5HdFHEUr41COHMiI";
        $secret = "5k6xJ7E0G5JFgUowlc+13SFEfkY=";
        $callback = "http://localhost:80/mzoori/crontodo/response";
        $this->load->library('OAuthConsumer', $key, $secret, $callback);
    }

    function index() {
        $key = '';
        $data['query'] = $this->MCrontodo->mycronjob();
        if (empty($data['query'])):
            show_404();
        else:
            foreach ($data as $od):
                if ($od['status']):
                    $token = $params = NULL;
                    $key = 'lhiP9QWtQQsXWU+G5HdFHEUr41COHMiI'; //merchant key
                    $secret = '5k6xJ7E0G5JFgUowlc+13SFEfkY='; //merchant secret
                    $signature_method = new OAuthSignatureMethod_HMAC_SHA1();
                    $iframelink = 'https://www.pesapal.com/api/PostPesapalDirectOrderV4';
                    $callback_url = 'http://localhost:80/mzoori/crontodo/response'; //
                    $post_xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>";
                    $post_xml +="<PesapalDirectOrderInfo xmlns:xsi=\"http://www.w3.org/2001/XMLSchemainstance\" xmlns:xsd=\"http://www.w3.org/2001/XMLSchema\"";
                    $post_xml +="Amount=\"100\" Description=\"".$od['id']."\" Type=\"\" ";
                    $post_xml +="Reference=\"".$od['transaction_id']."\" FirstName=\"Test\"";
                    $post_xml +="LastName=\"\" Email=\"\" ";
                    $post_xml +="PhoneNumber=\"00000000\" xmlns=\"http://www.pesapal.com\" />";
                    $post_xml = htmlentities($post_xml);
                    $consumer = new OAuthConsumer($key, $secret);
//post transaction to pesapal
                    $iframe_src = OAuthRequest::from_consumer_and_token($consumer, $token, "GET", $iframelink, $params);
                    $iframe_src->set_parameter("oauth_callback", $callback_url);
                    $iframe_src->set_parameter("pesapal_request_data", $post_xml);
                    $iframe_src->sign_request($signature_method, $consumer, $token);
                    $data['frame'] = $iframe_src;
                    echo "<iframe src=\"$iframe_src width='100%' height='620px'";
                    echo "scrolling='auto' frameBorder='0'>";
                    echo "<p>Unable to load the payment page</p>";
                    echo "</iframe>";

                endif;
            endforeach;
        endif;
    }

    function response() {
        $this->load->view('response', $data);
    }

}

//end class
?>