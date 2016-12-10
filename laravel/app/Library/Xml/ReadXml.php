<?php
namespace App\Library\Xml;

class ReadXml
{
    public static function readDatabase($filename): array
    {
        $data = implode("",file($filename));
        $parser = xml_parser_create();
        xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
        xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
        xml_parse_into_struct($parser, $data, $values, $tags);
        xml_parser_free($parser);

        foreach ($tags as $key => $val) {
            if ($key == 'record') {
                $molranges = $val;

                for ($i = 0; $i < count($molranges); $i += 2) {
                    $offset = $molranges[$i] + 1;
                    $len = $molranges[$i + 1] - $offset;
                    $tdb[] = static::parseMol(array_slice($values, $offset, $len));
                }
            } else {
                continue;
            }
        }

        return $tdb;
    }

    public static function parseMol($mvalues): array
    {
        for ($i = 0; $i < count($mvalues); $i++) {
            $mol[$mvalues[$i]["tag"]] = $mvalues[$i]["value"];
        }

        return $mol;
    }
}


