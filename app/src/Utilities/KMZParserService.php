<?php


namespace App\src\Utilities;


class KMZParserService
{
    public function parse($xmlPath)
    {
        $xmldata = simplexml_load_file($xmlPath);

        $childs = $xmldata->Document->Folder->children();

        foreach ($childs as $child)
        {
            $childToArray = (array)$child;

            if (array_has($childToArray, 'name')) {
                $this->parseSingleElement($childToArray);
            }
        }
    }

    private function parseSingleElement(array $childElement)
    {
        /**
        "@attributes" => array:1 [
            "id" => "2"
        ]
        "name" => "Каскад № 11"
        "visibility" => "1"
        "description" => " ИП-369"
        "styleUrl" => "#Каскад № 11_Style_00000001"
        "Point" => SimpleXMLElement {#313
        +"coordinates": "48.0650194444444,46.3635305555556,0"
        }
        */
    }
}
