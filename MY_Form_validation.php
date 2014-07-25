<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 * @author      Sohail Ahmad Sohel
 * @link        
 *
 */
class MY_Form_validation extends CI_Form_validation {
    
   /**
    * Constructor
    */
    function __construct(){
        parent::__construct();
    }
    
    // --------------------------------------------------------------------

    /**
     * Valid date
     *
     * @access  public
     * @param   string
     * @param   format,delimiter (e.g. d F Y or d/m/y,/ or y-m-d,-)
     * @return  bool
     */
     public function valid_date($str, $format_delimiter)
     {
        
        $CI =&get_instance();
        
        $format_delimiter = explode(',', $format_delimiter); // Split second parameter as format & delimiter
        $delimiter = !empty($format_delimiter[1]) ? $format_delimiter[1] : " "; // Check the delimiter is available or not & assign the value
        $format = $format_delimiter[0];
        
        // Assign characters of date format into corresponding array
        $day_format_characters = array('d', 'D');
        $month_format_characters = array('F', 'm', 'M', 'n');
        $year_format_characters = array('Y', 'y');
        
        $format_example = date($format, strtotime('25 July 2014')); // Date example for error massage
        
        // Check the delimiter is available in string or not
        if(!substr_count($str, $delimiter) || substr_count($str, $delimiter) !== 2){
            $CI->form_validation->set_message('valid_date', "The date format is invalid. Use like this: {$format_example}");
            return false;
        }
        
        // Combine isolated string according to delimiter with corresponding format characters as an Array
        $date_with_format = array_combine(explode($delimiter, $format), explode($delimiter, $str));
        
        // Assign strings value into corresponding variables
        foreach($date_with_format as $key => $value){
            if(in_array($key, $day_format_characters)) $day = $value;
            if(in_array($key, $month_format_characters)) $month = is_numeric($value) ? $value : date('n', strtotime($value));
            if(in_array($key, $year_format_characters)) $year = $value;
        }
        
        // Check the date (logically valid or not)
        if(checkdate($month, $day, $year)){
            return true;
        } else {
            $CI->form_validation->set_message('valid_date', "The date is invalid.");
            return false;
        }

    }
}
/* End of file MY_Form_validation.php */
