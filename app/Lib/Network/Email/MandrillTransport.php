<?php
/**
 *  HE cPanel -- Hosting Engineers Control Panel
 *  Copyright (C) 2015  Dynamictivity LLC (http://www.hecpanel.com)
 *
 *   This program is free software: you can redistribute it and/or modify
 *   it under the terms of the GNU Affero General Public License as
 *   published by the Free Software Foundation, either version 3 of the
 *   License, or (at your option) any later version.
 *
 *   This program is distributed in the hope that it will be useful,
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *   GNU Affero General Public License for more details.
 *
 *   You should have received a copy of the GNU Affero General Public License
 *   along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
?>

<?php

App::uses('AbstractTransport', 'Network/Email');

class MandrillTransport extends AbstractTransport {

    /**
     * CakeEmail
     *
     * @var CakeEmail
     */
    protected $_cakeEmail;

    /**
     * CakeEmail headers
     *
     * @var array
     */
    protected $_headers;

    /**
     * Configuration to transport
     *
     * @var mixed
     */
    protected $_config = array();

    /**
     * Recipients list
     *
     * @var mixed
     */
    protected $_recipients = array();

    /**
     * Sends out email via Mandrill
     *
     * @return array
     */
    public function send(CakeEmail $email) {

        // CakeEmail
        $this->_cakeEmail = $email;

        $this->_config = $this->_cakeEmail->config();

        $this->_headers = $this->_cakeEmail->getHeaders();
        $this->_recipients = $email->to();

        $message = array(
            'html' => $this->_cakeEmail->message('html'),
            'text' => $this->_cakeEmail->message('text'),
            'subject' => $this->_cakeEmail->subject(),
            'from_email' => $this->_config['from'],
            'from_name' => $this->_config['fromName'],
            'to' => array(),
            'headers' => array('Reply-To' => $this->_config['from']),
            'important' => false,
            'track_opens' => null,
            'track_clicks' => null,
            'auto_text' => null,
            'auto_html' => null,
            'inline_css' => null,
            'url_strip_qs' => null,
            'preserve_recipients' => null,
            'view_content_link' => null,
            'tracking_domain' => null,
            'signing_domain' => null,
            'return_path_domain' => null,
            'merge' => true,
            'tags' => null,
            'subaccount' => null,
        );

        $message = array_merge($message, $this->_headers);

        foreach ($this->_recipients as $email => $name) {
            $message['to'][] = array(
                'email' => $email,
                'name' => $name,
                'type' => 'to'
            );
        }

        foreach ($this->_cakeEmail->cc() as $email => $name) {
            $message['to'][] = array(
                'email' => $email,
                'name' => $name,
                'type' => 'cc'
            );
        }

        foreach ($this->_cakeEmail->bcc() as $email => $name) {
            $message['to'][] = array(
                'email' => $email,
                'name' => $name,
                'type' => 'bcc'
            );
        }

        $attachments = $this->_cakeEmail->attachments();

        if (!empty($attachments)) {
            $message['attachments'] = array();
            foreach ($attachments as $file => $data) {
                $message['attachments'][] = array(
                    'type' => $data['mimetype'],
                    'name' => $file,
                    'content' => base64_encode(file_get_contents($data['file'])),
                );
            }
        }

        $params = array('message' => $message, "async" => false, "ip_pool" => null, "send_at" => null);

        return $this->_exec($params);
    }

    private function _exec($params) {
        $params['key'] = $this->_config['api_key'];
        $params = json_encode($params);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mandrill-PHP/1.0.52');
        curl_setopt($ch, CURLOPT_POST, true);
        if (!ini_get('safe_mode') && !ini_get('open_basedir')) {
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        }
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_TIMEOUT, 600);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch, CURLOPT_URL, 'https://mandrillapp.com/api/1.0/messages/send.json');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_VERBOSE, false);

        $response_body = curl_exec($ch);

        if (curl_error($ch)) {
            throw new Exception("API call to messages/send failed: " . curl_error($ch));
        }
        $result = json_decode($response_body, true);
        if ($result === null)
            throw new Exception('We were unable to decode the JSON response from the Mandrill API: ' . $response_body);

        return $result;
    }

}
