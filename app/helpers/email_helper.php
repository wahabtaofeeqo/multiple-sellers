<?php
if (!function_exists('getEmailTemplate')) {
	function getEmailTemplate($key = ""){
		$result = (object)array();
		$result->subject = '';
		$result->content = '';
		if(!empty($key)){
			switch ($key) {

				case 'payment':
					$result->subject = "{{website_name}} -  Thank You! Deposit Payment Received";
					$result->content = "<p>Hi<strong> {{user_firstname}}! </strong></p><p>We&#39;ve just received your final remittance and would like to thank you. We appreciate your diligence in adding funds to your balance in our service.</p><p>It has been a pleasure doing business with you. We wish you the best of luck.</p><p>Thanks and Best Regards!</p>";
					return $result;
					break;

				case 'verify':
					$result->subject = "{{website_name}} - Please validate your account";
					$result->content = "<p><strong>Welcome to {{website_name}}! </strong></p><p>Hello <strong>{{user_firstname}}</strong>!</p><p> Thank you for joining! We&#39;re glad to have you as community member, and we&#39;re stocked for you to start exploring our service.  If you don&#39;t verify your address, you won&#39;t be able to create a User Account.</p><p>  All you need to do is activate your account by click this link: <br>  {{activation_link}} </p><p>Thanks and Best Regards!</p>";
					return $result;
					break;

				case 'welcome':
					$result->subject = "{{website_name}} - Getting Started with Our Service!";
					$result->content = "<p><strong>Welcome to {{website_name}}! </strong></p><p>Hello <strong>{{user_firstname}}</strong>!</p><p>Congratulations! <br>You have successfully signed up for our service - {{website_name}} with follow data</p><ul><li>Firstname: {{user_firstname}}</li><li>Lastname: {{user_lastname}}</li><li>Email: {{user_email}}</li><li>Timezone: {{user_timezone}}</li></ul><p>We want to exceed your expectations, so please do not hesitate to reach out at any time if you have any questions or concerns. We look to working with you.</p><p>Best Regards,</p>";
					return $result;
					break;

				case 'forgot_password':
					$result->subject = "{{website_name}} - Password Recovery";
					$result->content = "<p>Hi<strong> {{user_firstname}}! </strong></p><p>Somebody (hopefully you) requested a new password for your account. </p><p>No changes have been made to your account yet. <br>You can reset your password by click this link: <br>{{recovery_password_link}}</p><p>If you did not request a password reset, no further action is required. </p><p>Thanks and Best Regards!</p>                ";
					return $result;
					break;

				case 'new_user':
					$result->subject = "{{website_name}} - New Registration";
					$result->content = "<p>Hi Admin!</p><p>Someone signed up in <strong>{{website_name}}</strong> with follow data</p><ul><li>Firstname {{user_firstname}}</li><li>Lastname: {{user_lastname}}</li><li>Email: {{user_email}}</li><li>Timezone: {{user_timezone}}</li></ul> ";
					return $result;
					break;

				case 'order_success':
					$result->subject = "{{website_name}} - New Order";
					$result->content = "<p><strong>Hi Admin!</strong></p><p>Someone have already placed order successfully  in <strong>{{website_name}}</strong> with follow data:</p><ul><li>Email: <strong>{{user_email}}</strong></li><li>OrderID:    <strong>{{order_id}}</strong>  </li><li>Total Charge:  <strong>{{currency_symbol}}{{total_charge}}</strong>    </li></ul>";
					return $result;
					break;
			}
		}
		return $result;
	}
}

/** 
 * Class to validate the email address 
 * 
 * @author CodexWorld.com <contact@codexworld.com> 
 * @copyright Copyright (c) 2018, CodexWorld.com
 * @url https://www.codexworld.com
 */ 
class VerifyEmail { 

    protected $stream = false; 

    /** 
     * SMTP port number 
     * @var int 
     */ 
    protected $port = 25; 

    /** 
     * Email address for request 
     * @var string 
     */ 
    protected $from = 'root@localhost'; 

    /** 
     * The connection timeout, in seconds. 
     * @var int 
     */ 
    protected $max_connection_timeout = 30; 

    /** 
     * Timeout value on stream, in seconds. 
     * @var int 
     */ 
    protected $stream_timeout = 5; 

    /** 
     * Wait timeout on stream, in seconds. 
     * * 0 - not wait 
     * @var int 
     */ 
    protected $stream_timeout_wait = 0; 

    /** 
     * Whether to throw exceptions for errors. 
     * @type boolean 
     * @access protected 
     */ 
    protected $exceptions = false; 

    /** 
     * The number of errors encountered. 
     * @type integer 
     * @access protected 
     */ 
    protected $error_count = 0; 

    /** 
     * class debug output mode. 
     * @type boolean 
     */ 
    public $Debug = false; 

    /** 
     * How to handle debug output. 
     * Options: 
     * * `echo` Output plain-text as-is, appropriate for CLI 
     * * `html` Output escaped, line breaks converted to `<br>`, appropriate for browser output 
     * * `log` Output to error log as configured in php.ini 
     * @type string 
     */ 
    public $Debugoutput = 'echo'; 

    /** 
     * SMTP RFC standard line ending. 
     */ 
    const CRLF = "\r\n"; 

    /** 
     * Holds the most recent error message. 
     * @type string 
     */ 
    public $ErrorInfo = ''; 

    /** 
     * Constructor. 
     * @param boolean $exceptions Should we throw external exceptions? 
     */ 
    public function __construct($exceptions = false) { 
        $this->exceptions = (boolean) $exceptions; 
    } 

    /** 
     * Set email address for SMTP request 
     * @param string $email Email address 
     */ 
    public function setEmailFrom($email) { 
        if (!self::validate($email)) { 
            $this->set_error('Invalid address : ' . $email); 
            $this->edebug($this->ErrorInfo); 
            if ($this->exceptions) { 
                throw new verifyEmailException($this->ErrorInfo); 
            } 
        } 
        $this->from = $email; 
    } 

    /** 
     * Set connection timeout, in seconds. 
     * @param int $seconds 
     */ 
    public function setConnectionTimeout($seconds) { 
        if ($seconds > 0) { 
            $this->max_connection_timeout = (int) $seconds; 
        } 
    } 

    /** 
     * Sets the timeout value on stream, expressed in the seconds 
     * @param int $seconds 
     */ 
    public function setStreamTimeout($seconds) { 
        if ($seconds > 0) { 
            $this->stream_timeout = (int) $seconds; 
        } 
    } 

    public function setStreamTimeoutWait($seconds) { 
        if ($seconds >= 0) { 
            $this->stream_timeout_wait = (int) $seconds; 
        } 
    } 

    /** 
     * Validate email address. 
     * @param string $email 
     * @return boolean True if valid. 
     */ 
    public static function validate($email) { 
        return (boolean) filter_var($email, FILTER_VALIDATE_EMAIL); 
    } 

    /** 
     * Get array of MX records for host. Sort by weight information. 
     * @param string $hostname The Internet host name. 
     * @return array Array of the MX records found. 
     */ 
    public function getMXrecords($hostname) { 
        $mxhosts = array(); 
        $mxweights = array(); 
        if (getmxrr($hostname, $mxhosts, $mxweights) === FALSE) { 
            $this->set_error('MX records not found or an error occurred'); 
            $this->edebug($this->ErrorInfo); 
        } else { 
            array_multisort($mxweights, $mxhosts); 
        } 
        /** 
         * Add A-record as last chance (e.g. if no MX record is there). 
         * Thanks Nicht Lieb. 
         * @link http://www.faqs.org/rfcs/rfc2821.html RFC 2821 - Simple Mail Transfer Protocol 
         */ 
        if (empty($mxhosts)) { 
            $mxhosts[] = $hostname; 
        } 
        return $mxhosts; 
    } 

    /** 
     * Parses input string to array(0=>user, 1=>domain) 
     * @param string $email 
     * @param boolean $only_domain 
     * @return string|array 
     * @access private 
     */ 
    public static function parse_email($email, $only_domain = TRUE) { 
        sscanf($email, "%[^@]@%s", $user, $domain); 
        return ($only_domain) ? $domain : array($user, $domain); 
    } 

    /** 
     * Add an error message to the error container. 
     * @access protected 
     * @param string $msg 
     * @return void 
     */ 
    protected function set_error($msg) { 
        $this->error_count++; 
        $this->ErrorInfo = $msg; 
    } 

    /** 
     * Check if an error occurred. 
     * @access public 
     * @return boolean True if an error did occur. 
     */ 
    public function isError() { 
        return ($this->error_count > 0); 
    } 

    /** 
     * Output debugging info 
     * Only generates output if debug output is enabled 
     * @see verifyEmail::$Debugoutput 
     * @see verifyEmail::$Debug 
     * @param string $str 
     */ 
    protected function edebug($str) { 
        if (!$this->Debug) { 
            return; 
        } 
        switch ($this->Debugoutput) { 
            case 'log': 
                //Don't output, just log 
                error_log($str); 
                break; 
            case 'html': 
                //Cleans up output a bit for a better looking, HTML-safe output 
                echo htmlentities( 
                        preg_replace('/[\r\n]+/', '', $str), ENT_QUOTES, 'UTF-8' 
                ) 
                . "<br>\n"; 
                break; 
            case 'echo': 
            default: 
                //Normalize line breaks 
                $str = preg_replace('/(\r\n|\r|\n)/ms', "\n", $str); 
                echo gmdate('Y-m-d H:i:s') . "\t" . str_replace( 
                        "\n", "\n \t ", trim($str) 
                ) . "\n"; 
        } 
    } 

    /** 
     * Validate email
     * @param string $email Email address 
     * @return boolean True if the valid email also exist 
     */ 
    public function check($email) { 
        $result = FALSE; 

        if (!self::validate($email)) { 
            $this->set_error("{$email} incorrect e-mail"); 
            $this->edebug($this->ErrorInfo); 
            if ($this->exceptions) { 
                throw new verifyEmailException($this->ErrorInfo); 
            } 
            return FALSE; 
        } 
        $this->error_count = 0; // Reset errors 
        $this->stream = FALSE; 

        $mxs = $this->getMXrecords(self::parse_email($email)); 
        $timeout = ceil($this->max_connection_timeout / count($mxs)); 
        foreach ($mxs as $host) { 
            /** 
             * suppress error output from stream socket client... 
             * Thanks Michael. 
             */ 
            $this->stream = @stream_socket_client("tcp://" . $host . ":" . $this->port, $errno, $errstr, $timeout); 
            if ($this->stream === FALSE) { 
                if ($errno == 0) { 
                    $this->set_error("Problem initializing the socket"); 
                    $this->edebug($this->ErrorInfo); 
                    if ($this->exceptions) { 
                        throw new verifyEmailException($this->ErrorInfo); 
                    } 
                    return FALSE; 
                } else { 
                    $this->edebug($host . ":" . $errstr); 
                } 
            } else { 
                stream_set_timeout($this->stream, $this->stream_timeout); 
                stream_set_blocking($this->stream, 1); 

                if ($this->_streamCode($this->_streamResponse()) == '220') { 
                    $this->edebug("Connection success {$host}"); 
                    break; 
                } else { 
                    fclose($this->stream); 
                    $this->stream = FALSE; 
                } 
            } 
        } 

        if ($this->stream === FALSE) { 
            $this->set_error("All connection fails"); 
            $this->edebug($this->ErrorInfo); 
            if ($this->exceptions) { 
                throw new verifyEmailException($this->ErrorInfo); 
            } 
            return FALSE; 
        } 

        $this->_streamQuery("HELO " . self::parse_email($this->from)); 
        $this->_streamResponse(); 
        $this->_streamQuery("MAIL FROM: <{$this->from}>"); 
        $this->_streamResponse(); 
        $this->_streamQuery("RCPT TO: <{$email}>"); 
        $code = $this->_streamCode($this->_streamResponse()); 
        $this->_streamResponse(); 
        $this->_streamQuery("RSET"); 
        $this->_streamResponse();
        $code2 = $this->_streamCode($this->_streamResponse()); 
        $this->_streamQuery("QUIT"); 
        fclose($this->stream); 
        
        $code = !empty($code2)?$code2:$code;
        switch ($code) { 
            case '250': 
            /** 
             * http://www.ietf.org/rfc/rfc0821.txt 
             * 250 Requested mail action okay, completed 
             * email address was accepted 
             */ 
            case '450': 
            case '451': 
            case '452': 
                /** 
                 * http://www.ietf.org/rfc/rfc0821.txt 
                 * 450 Requested action not taken: the remote mail server 
                 * does not want to accept mail from your server for 
                 * some reason (IP address, blacklisting, etc..) 
                 * Thanks Nicht Lieb. 
                 * 451 Requested action aborted: local error in processing 
                 * 452 Requested action not taken: insufficient system storage 
                 * email address was greylisted (or some temporary error occured on the MTA) 
                 * i believe that e-mail exists 
                 */ 
                return TRUE;
            case '550':
                return FALSE; 
            default : 
                return FALSE; 
        } 
    } 

    /** 
     * writes the contents of string to the file stream pointed to by handle 
     * If an error occurs, returns FALSE. 
     * @access protected 
     * @param string $string The string that is to be written 
     * @return string Returns a result code, as an integer. 
     */ 
    protected function _streamQuery($query) { 
        $this->edebug($query); 
        return stream_socket_sendto($this->stream, $query . self::CRLF); 
    } 

    /** 
     * Reads all the line long the answer and analyze it. 
     * If an error occurs, returns FALSE 
     * @access protected 
     * @return string Response 
     */ 
    protected function _streamResponse($timed = 0) { 
        $reply = stream_get_line($this->stream, 1); 
        $status = stream_get_meta_data($this->stream); 

        if (!empty($status['timed_out'])) { 
            $this->edebug("Timed out while waiting for data! (timeout {$this->stream_timeout} seconds)"); 
        } 

        if ($reply === FALSE && $status['timed_out'] && $timed < $this->stream_timeout_wait) { 
            return $this->_streamResponse($timed + $this->stream_timeout); 
        } 


        if ($reply !== FALSE && $status['unread_bytes'] > 0) { 
            $reply .= stream_get_line($this->stream, $status['unread_bytes'], self::CRLF); 
        } 
        $this->edebug($reply); 
        return $reply; 
    } 

    /** 
     * Get Response code from Response 
     * @param string $str 
     * @return string 
     */ 
    protected function _streamCode($str) { 
        preg_match('/^(?<code>[0-9]{3})(\s|-)(.*)$/ims', $str, $matches); 
        $code = isset($matches['code']) ? $matches['code'] : false; 
        return $code; 
    } 

} 

/** 
 * verifyEmail exception handler 
 */ 
class verifyEmailException extends Exception { 

    /** 
     * Prettify error message output 
     * @return string 
     */ 
    public function errorMessage() {
        $errorMsg = $this->getMessage(); 
        return $errorMsg; 
    } 

} 


if (!function_exists('check_exits_email')) {
	function check_exits_email($email_to){
		// Initialize library class
		$mail = new VerifyEmail();

		// Set the timeout value on stream
		$mail->setStreamTimeoutWait(5);

		// Set debug output mode
		// $mail->Debug= TRUE; 
		// $mail->Debugoutput= 'html'; 

		// Set email address for SMTP request
		$mail->setEmailFrom('tuyennguyen2906@email.com');

		// Check if email is valid and exist
		if($mail->check($email_to)){ 
			return true;
		    // echo 'Email &lt;'.$email_to.'&gt; is exist!'; 
		}elseif(verifyEmail::validate($email_to)){ 
			return false;
		    // echo 'Email &lt;'.$email_to.'&gt; is valid, but not exist!'; 
		}else{
			return false; 
		    // echo 'Email &lt;'.$email_to.'&gt; is not valid and not exist!'; 
		}
	}
}


?>