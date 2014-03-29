<?php

namespace FabriceKabongo\Common\Util;

class Securite {

    /**
     * Permet de nettoyer les donnees qui vienne d'un formulaire pour les inserer dans une base de donnees
     * 
     * from : fr.openclassrooms.com (ex: siteduzero.com)
     * */
    public static function bdd($string) {
        // On regarde si le type de string est un nombre entier (int)
        if (ctype_digit($string)) {
            $string = intval($string);
        }
        // Pour tous les autres types
        else {
            $string = mysql_real_escape_string($string);
            $string = addcslashes($string, '%_');
        }

        return $string;
    }

    /**
     * Permet de nettoyer les donnees qui vienne d'une base de donnees pour les afficher sur pages html.
     * 
     * from : fr.openclassrooms.com (ex: siteduzero.com)
     * */
    public static function html($string) {
        if (self::detectUTF8($string)) {
            $string = utf8_decode($string);
        }
        $string = htmlentities($string);
        return htmlspecialchars_decode($string);
    }

    public static function detectUTF8($string) {
        return preg_match('%(?:
            [\xC2-\xDF][\x80-\xBF]
            |\xE0[\xA0-\xBF][\x80-\xBF]
            |[\xE1-\xEC\xEE\xEF][\x80-\xBF]{2}
            |\xED[\x80-\x9F][\x80-\xBF]
            |\xF0[\x90-\xBF][\x80-\xBF]{2} 
            |[\xF1-\xF3][\x80-\xBF]{3}
            |\xF4[\x80-\x8F][\x80-\xBF]{2}
            )+%xs', $string);
    }

    /**
     * Returns an string clean of UTF8 characters. It will convert them to a similar ASCII character
     * www.unexpectedit.com
     */
    public static function cleanString($text) {
        if (!self::detectUTF8($text)) {
            $text = utf8_encode($text);
        }
        // 1) convert á ô => a o
        $text = mb_ereg_replace("/[áàâãªä]/u", "a", $text);
        $text = mb_ereg_replace("/[ÁÀÂÃÄ]/u", "A", $text);
        $text = mb_ereg_replace("/[ÍÌÎÏ]/u", "I", $text);
        $text = mb_ereg_replace("/[íìîï]/u", "i", $text);
        $text = mb_ereg_replace("/[éèêë]/u", "e", $text);
        $text = mb_ereg_replace("/[ÉÈÊË]/u", "E", $text);
        $text = mb_ereg_replace("/[óòôõºö]/u", "o", $text);
        $text = mb_ereg_replace("/[ÓÒÔÕÖ]/u", "O", $text);
        $text = mb_ereg_replace("/[úùûü]/u", "u", $text);
        $text = mb_ereg_replace("/[ÚÙÛÜ]/u", "U", $text);
        $text = mb_ereg_replace("/[’‘‹›‚]/u", "'", $text);
        $text = mb_ereg_replace("/[“”«»„]/u", '"', $text);
        $text = preg_replace("/[áàâãªä]/u", "a", $text);
        $text = preg_replace("/[ÁÀÂÃÄ]/u", "A", $text);
        $text = preg_replace("/[ÍÌÎÏ]/u", "I", $text);
        $text = preg_replace("/[íìîï]/u", "i", $text);
        $text = preg_replace("/[éèêë]/u", "e", $text);
        $text = preg_replace("/[ÉÈÊË]/u", "E", $text);
        $text = preg_replace("/[óòôõºö]/u", "o", $text);
        $text = preg_replace("/[ÓÒÔÕÖ]/u", "O", $text);
        $text = preg_replace("/[úùûü]/u", "u", $text);
        $text = preg_replace("/[ÚÙÛÜ]/u", "U", $text);
        $text = preg_replace("/[’‘‹›‚]/u", "'", $text);
        $text = preg_replace("/[“”«»„]/u", '"', $text);
        $text = str_replace("–", "-", $text);
        $text = str_replace(" ", " ", $text);
        $text = str_replace("ç", "c", $text);
        $text = str_replace("Ç", "C", $text);
        $text = str_replace("ñ", "n", $text);
        $text = str_replace("Ñ", "N", $text);

        //2) Translation CP1252. &ndash; => -
        $trans = get_html_translation_table(HTML_ENTITIES);
        $trans[chr(130)] = '&sbquo;';    // Single Low-9 Quotation Mark
        $trans[chr(131)] = '&fnof;';    // Latin Small Letter F With Hook
        $trans[chr(132)] = '&bdquo;';    // Double Low-9 Quotation Mark
        $trans[chr(133)] = '&hellip;';    // Horizontal Ellipsis
        $trans[chr(134)] = '&dagger;';    // Dagger
        $trans[chr(135)] = '&Dagger;';    // Double Dagger
        $trans[chr(136)] = '&circ;';    // Modifier Letter Circumflex Accent
        $trans[chr(137)] = '&permil;';    // Per Mille Sign
        $trans[chr(138)] = '&Scaron;';    // Latin Capital Letter S With Caron
        $trans[chr(139)] = '&lsaquo;';    // Single Left-Pointing Angle Quotation Mark
        $trans[chr(140)] = '&OElig;';    // Latin Capital Ligature OE
        $trans[chr(145)] = '&lsquo;';    // Left Single Quotation Mark
        $trans[chr(146)] = '&rsquo;';    // Right Single Quotation Mark
        $trans[chr(147)] = '&ldquo;';    // Left Double Quotation Mark
        $trans[chr(148)] = '&rdquo;';    // Right Double Quotation Mark
        $trans[chr(149)] = '&bull;';    // Bullet
        $trans[chr(150)] = '&ndash;';    // En Dash
        $trans[chr(151)] = '&mdash;';    // Em Dash
        $trans[chr(152)] = '&tilde;';    // Small Tilde
        $trans[chr(153)] = '&trade;';    // Trade Mark Sign
        $trans[chr(154)] = '&scaron;';    // Latin Small Letter S With Caron
        $trans[chr(155)] = '&rsaquo;';    // Single Right-Pointing Angle Quotation Mark
        $trans[chr(156)] = '&oelig;';    // Latin Small Ligature OE
        $trans[chr(159)] = '&Yuml;';    // Latin Capital Letter Y With Diaeresis
        $trans['euro'] = '&euro;';    // euro currency symbol
        ksort($trans);

        foreach ($trans as $k => $v) {
            $text = str_replace($v, $k, $text);
        }

        // 3) remove <p>, <br/> ...
        $text = strip_tags($text);

        // 4) &amp; => & &quot; => '
        $text = html_entity_decode($text);

        // 5) remove Windows-1252 symbols like "TradeMark", "Euro"...
        $text = mb_ereg_replace('/[^(\x20-\x7F)]*/', '', $text);

        $targets = array('\r\n', '\n', '\r', '\t');
        $results = array(" ", " ", " ", "");
        $text = str_replace($targets, $results, $text);
        /*

          $text = str_replace("&", "and", $text);
          $text = str_replace("<", ".", $text);
          $text = str_replace(">", ".", $text);
          $text = str_replace("\\", "-", $text);
          $text = str_replace("/", "-", $text);
         */
        return ($text);
    }

    /**
     * help to remove special char in a string. Can also create slug
     * *
     * from : http://cubiq.org/the-perfect-php-clean-url-generator
     * 
     * */
    public static function toAscii($str, $replace = array(), $delimiter = '-') {
        if (!empty($replace)) {
            $str = str_replace((array) $replace, ' ', $str);
        }

        $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
        $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
        $clean = strtolower(trim($clean, '-'));
        $clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);

        return $clean;
    }

    public static function isValidEmail($email) {
        $Syntaxe = '^(?!\.)(([^\\r\\]|\\[\\r\\])*|([-a-z0-9!#$%&'."*+/=?^_`{|}~] |(?@[a-z0-9][\\w\.-]*[a-z0-9]\.[a-z][a-z\.]*[a-z]$";
        return preg_match($Syntaxe, $email);
    }
    
   public static  function handleMagicQuotes($string){
       return (get_magic_quotes_gpc() ? stripslashes($string) : $string);
   }
}

?>