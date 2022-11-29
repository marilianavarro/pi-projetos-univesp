<?php

class Funcao
{

    /**
     * Get human readable time difference between 2 dates
     *
     * Return difference between 2 dates in year, month, hour, minute or second
     * The $precision caps the number of time units used: for instance if
     * $time1 - $time2 = 3 days, 4 hours, 12 minutes, 5 seconds
     * - with precision = 1 : 3 days
     * - with precision = 2 : 3 days, 4 hours
     * - with precision = 3 : 3 days, 4 hours, 12 minutes
     *
     * From: http://www.if-not-true-then-false.com/2010/php-calculate-real-differences-between-two-dates-or-timestamps/
     *
     * @param mixed $time1 a time (string or timestamp)
     * @param mixed $time2 a time (string or timestamp)
     * @param integer $precision Optional precision
     * @return string time difference
     */
    public static function get_date_diff( $time1, $time2, $precision = 3 )
    {
        // If not numeric then convert timestamps
        if( !is_int( $time1 ) )
        {
            $time1 = strtotime( $time1 );
        }
        
        if( !is_int( $time2 ) )
        {
            $time2 = strtotime( $time2 );
        }

        // By default, assume past
        $past = true;

        // If time1 > time2 then swap the 2 values
        if( $time1 > $time2 )
        {
            list( $time1, $time2 ) = array( $time2, $time1 );
            $past = false;
        }

        // Set up intervals and diffs arrays
        $intervals = array( 'year', 'month', 'day', 'hour', 'minute', 'second' );
        $intervals_br_singular = array( 'ano', 'mês', 'dia', 'hora', 'minuto', 'segundo' );
        $intervals_br_plural = array( 'anos', 'meses', 'dias', 'horas', 'minutos', 'segundos' );
        $diffs = array();

        foreach( $intervals as $key_interval => $interval )
        {
            // Create temp time from time1 and interval
            $ttime = strtotime( '+1 ' . $interval, $time1 );
            // Set initial values
            $add = 1;
            $looped = 0;
            // Loop until temp time is smaller than time2
            while ( $time2 >= $ttime )
            {
                // Create new temp time from time1 and interval
                $add++;
                $ttime = strtotime( "+" . $add . " " . $interval, $time1 );
                $looped++;
            }

            $time1 = strtotime( "+" . $looped . " " . $interval, $time1 );
            $diffs[ $key_interval ] = $looped;
        }

        $count = 0;
        $times = array();
        foreach( $diffs as $key_interval => $value )
        {
            // Break if we have needed precission
            if( $count >= $precision )
            {
                break;
            }
            
            // Add value and interval if value is bigger than 0
            if( $value > 0 )
            {
                $interval_text = $intervals_br_singular[$key_interval] ?? null;
                
                if( $value != 1 )
                {
                    $interval_text = $intervals_br_plural[$key_interval] ?? null;
                }
                
                // Add value and interval to times array
                $times[] = $value . " " . $interval_text;
                $count++;
            }
        }

        // Build text for past/future
        if($past == true)
        {
            $suffix = ' atrás';
        }
        else
        {
            $suffix = ' de agora';
        }

        // Return string with times
        return implode( ", ", $times ) . $suffix;
    }
    
    public static function telegram($message, $token, $chatid)
    {

        $ch = curl_init("https://api.telegram.org/bot$token/sendMessage");
        $data = http_build_query([
            "chat_id" => $chatid,
        	"disable_web_page_preview" => 1,
        	"parse_mode" => "markdown", //html
        	"text" => $message,
        ]);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
        curl_setopt($ch, CURLOPT_TIMEOUT, 2);
        $result = curl_exec($ch);
        curl_close($ch);
        
        return $result;
    }
    
    /**
     * Send a Message to a Slack Channel.
     *
     * In order to get the API Token visit: 
     *
     * 1.) Create an APP -> https://api.slack.com/apps/
     * 2.) See menu entry "Install App"
     * 3.) Use the "Bot User OAuth Token"
     *
     * The token will look something like this `xoxb-2100000415-0000000000-0000000000-ab1ab1`.
     * 
     * @param string $message The message to post into a channel.
     * @param string $channel The name of the channel prefixed with #, example #foobar
     * @return boolean
     */
    public static function slack($message, $token, $channel)
    {
        $ch = curl_init("https://slack.com/api/chat.postMessage");
        $data = http_build_query([
            "token" => $token,
        	"channel" => $channel, //"#mychannel",
        	"text" => $message, //"Hello, Foo-Bar channel message.",
        	"username" => "infrabot",
        ]);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($ch);
        curl_close($ch);
        
        return $result;
    }
}
