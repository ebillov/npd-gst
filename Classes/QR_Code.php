<?php

//Exit if accessed directly.
defined('ABSPATH') or exit;

class QR_Code {

	public $data = array();
	public $filename = '';
	public $path = '';

    /**
     * Our constructor
     * @param array
     */
	public function __construct(Array $data) {
		$this->data = $data;
	}

    /**
     * Method to setup the file path
     * @param string
     */
	public function set_filepath(string $path = '') {
		$this->path = $path;
	}

    /**
     * Method to setup the file name
     * @param string
     */
	public function set_filename(string $filename = '') {
		$this->filename = $filename;
		if(empty($filename)){
			$this->filename = bin2hex(random_bytes(8));
		}
	}

	public function get_filepath() {
		return $this->path . '/' . $this->filename . '.png';
	}

    /**
     * Method to return plain string output
     */
	public function plain_text(){
		$out = '';
		if ( is_array( $this->data ) && count( $this->data ) > 0 ) {
			foreach ( $this->data as $item ) {
				$out .= $this->place_break( '.', 60 );

				if ( isset( $item['attendees'] ) && is_array( $item['attendees'] ) ) {
					$out .= $this->place_break( '.', 50 );
					$out .= "Attendees" . "\n" . $this->place_break( '.', 50 );
					foreach ( $item['attendees'] as $attendee ) {
						$fullname = $attendee['first_name'] . " " . $attendee['last_name'];
						$out .= "- " . implode( ', ', array( $fullname, $attendee['email'] ) ) . "\n";
					}
				}

				// Other meta
				$out .= $this->place_break( '.', 50 );
				foreach(
                    [
                        $item['title'],
                        $item['ticket_name'],
                        $item['start_date'],
                        $item['end_date'],
                        $item['start_time'],
                        $item['ends_time'],
                        $item['event_addr'],
                        $item['quantity'],
                    ] as $key => $val ) {
					$out .=  sprintf( '%s: %s', $val['label'], $val['value'] ) . "\n";
				}
				$out .= $this->place_break( '.', 50 );
			}
			$out .= $this->place_break( '.', 60 );
		}
		return $out;
	}

    /**
     * Method to generate the QR code
     * @return string the file name
     */
	public function generate(){
		QRcode::png($this->plain_text(), $this->get_filepath(), QR_ECLEVEL_L, 12);
		return $this->filename . '.png';
	}

    /**
     * Method to place break points per line
     * @return string
     */
	public function place_break( $char = '.', $length = 100 ) {
		$return = '';
		for ( $i = 1; $i <= $length; $i++ ) {
			$return .= $char;
		}
		return $return . "\n";
    }
    
}