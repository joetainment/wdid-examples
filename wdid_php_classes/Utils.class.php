<?php

namespace wdid;

//// Most functions that are potentially useful as standalone functions
//// will go into a Utils class.
//// Other classes can easily call these.
class Utils {
    
    //// a getsafe static fuction!
    public static function
    GetWDefault( &$arr, &$key, &$fallback ){
        if (    array_key_exists( $key, $arr )    ){
            return $arr[$key];
        }
        else return $fallback;
    }
    
    public static function
    GetWDefaultNoRefFallback( &$arr, &$key, $fallback ){
        if (    array_key_exists( $key, $arr )    ){
            return $arr[$key];
        }
        else return $fallback;
    }

    
    //// EchoTest - Just a very very simple test function to check Utils
    public static function
    EchoTest(){
        echo "test <br>";
    }
    
    //// EchoLine - A quick way to echo a line with line breaks
    public static function
    EchoLine( $text, $breaks=1, $sep="<br>" ){
        echo $text;
        for ($i=0;$i<$breaks;$i++){
            echo $sep;
        }
    }
    
    //// EchoBr - A quick way to add lots of line breaks
    public static function
    EchoBr( $repeats = 1 ){
         echo self::RepeatTextAsLines( '', $repeats, "<br>" );
    }
    
    
    //// RepeatTextAsLines
    ////   Often we need to repeat some piece of text several times.
    ////   and sometimes we want a line break in between
    public static function
    RepeatTextAsLines( $text, $repeats, $sep="<br>" ){
        $output = '';
        for ($i=0;$i<$repeats;$i++){
            $output = $output . $text . $sep;
        }
        return $output;
    }
    
    
    //// Auto indentation function
    ////   add as many tabs as requested before text
    public static function
    TabText( $text, $count ){
        $tab = "\t";
        $tabs = '';
        for ($i=0;$i<$count;$i++) $tabs = $tabs . $tab;
        return $tabs . $text;
    }
    //// ...same but with a new line at the end...
    public static function
    TabTextWithNewline( $text, $count ){
        $nl = "\n";
        return self::TabText( $text, $count ) . $nl;
    }
    
    
    
    
    ////   GetType
    ////     A more convinient and simpler method of getting an object's
    ////     type_final will get the standard type or the class name,
    ////     which ever is appropriate
    ////        http://php.net/manual/en/function.get-class.php
    ////        http://php.net/manual/en/function.gettype.php
    public static function
    GetType( $v ){
        $type_stage_one = gettype( $v );
        $type_final = $type_stage_one;
        //// if it's an object, we need to find
        //// what specific class it is
        if ( $type_stage_one === 'object' ){
            //// This is safest since PHP has some weird corner cases
            try {
                $type_stage_two = get_class( $v );
                if ($type_stage_two !== false ){
                    $type_final = $type_stage_two;
                }
            }
            finally {
                return $type_final;
            }
        }
        //// If stage one wasn't an object, then the final is fine
        return $type_final;
    }
    
    
    public static function
    LogWarning($warning){
        // no nothing by default
        // we could add a place to send warnings to, but for now, nothing
        // this should probably be a callback long term
    }
    
    //public static function
    //GetServerInfoThisPageFileNameOnly(){
    //    $x = pathinfo( $_SERVER['PHP_SELF'] );
    //    return $x['basename'];
    //}
    
    public static function
    GetServerInfoThisPageFileNameOnlyWithExt(){
        $x = pathinfo( $_SERVER['PHP_SELF'] );
        return $x['basename'];
    }
    public static function
    GetServerInfoThisPageFileNameOnlyNoExt(){
        $x = pathinfo( $_SERVER['PHP_SELF'] );
        return $x['filename'];
    }
    
    
    
    
    //// Session Loading and saving with serialized objects
    ////
    ////   It's useful to have an easy way to save potentially
    ////   complicated things into the session
    public static function
    SessionLoadByKey( $key ){
        if (session_status() != PHP_SESSION_ACTIVE) {
            session_start();
        }
        $loaded = Utils::GetWDefaultNoRefFallback($_SESSION, $key, null );
        if ($loaded === null)  return null;
        else return unserialize( $loaded );
    }
    //// Counterpart to the Session Load function above  
    public static function
    SessionSaveByKey( $key, $toSave ){
        assert( session_status() == PHP_SESSION_ACTIVE );
        $_SESSION[$key]=serialize($toSave);
    }
    
}    

