<?php

namespace App\Http\Controllers\System\XML;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Schema;
use Artisan;
use DB;

// Parser
use Nathanmac\Utilities\Parser\Parser;

class ItemsController extends Controller
{
    public function index()
    {
        if(!Schema::hasTable('weapon_items') || !Schema::hasTable('armor_items') || !Schema::hasTable('etc_items')):
            Artisan::calL('migrate');
        endif;

        return view('dash.modules.xmlitems');
    }

    public function sendXML(Request $request){
        
        if (!isset($_FILES['files']['name'])):
            $XMLInput = $request->input('xml');
        else:
            $XMLInput = file_get_contents($_FILES['files']['tmp_name'][0]);
        endif;


        $parser = new Parser();
        $parsedFile = $parser->xml($XMLInput);
        
        $Counter = 0;

        foreach ($parsedFile['item'] as $XMLItem):
            if (isset($XMLItem['@type'])):
            $Counter++;
            endif;
        endforeach;
        if ($Counter == 0):
            foreach ($parsedFile as $XMLItem):
            if (isset($XMLItem['@type'])):
                $Counter++;
            endif;
            endforeach;
        endif; 
        
        if($Counter > 1):
            foreach ($parsedFile['item'] as $parsedXML):
                $XMLToDatabase = Self::XMLToDatabase($parsedXML);
            endforeach;
        else:
            $XMLToDatabase = Self::XMLToDatabase($parsedFile['item']);

        endif;

        return response()->json([
            'Status'=> true,
            'Message'=>'OK',
        ]);

    }

    static function XMLToDatabase($XMLArray)
    {
        
        $WeaponTable = 'weapon_items';
        $ArmorTable = 'armor_items';
        $EtcTable = 'etc_items';
        
        if($XMLArray['@type'] == 'Weapon'):
        $Insert = DB::table($WeaponTable)->insert([
            [
                'idItem' => $XMLArray['@id'],
                'type' => $XMLArray['@type'],
                'name' => $XMLArray['@name'],
                'reference' => isset($XMLArray['set'][0]['@val']) ? str_after($XMLArray['set'][0]['@val'], '.') : 'NOIMAGE',
                'weapon_type' => isset($XMLArray['set'][2]['@val']) ? $XMLArray['set'][2]['@val'] : null,
                
            ],
        ]);
            if ($Insert == true):
                return true;
            else:
                return false;
            endif;
        elseif($XMLArray['@type'] == 'EtcItem' AND $XMLArray['@name'] != 'Adena'):
            if(isset($XMLArray['set'][0]['@val'])):
            $Insert = DB::table($EtcTable)->insert([
                [
                    'idItem' => $XMLArray['@id'],
                    'type' => $XMLArray['@type'],
                    'name' => $XMLArray['@name'],
                    'reference' => isset($XMLArray['set'][0]['@val']) ? str_after($XMLArray['set'][0]['@val'], '.') : 'NOIMAGE',
                ],
            ]);
            if ($Insert == true):
                return true;
            else:
                return false;
            endif;
        else:
            $Insert = DB::table($EtcTable)->insert([
                [
                    'idItem' => $XMLArray['@id'],
                    'type' => $XMLArray['@type'],
                    'name' => $XMLArray['@name'],
                    'reference' => isset($XMLArray['set'][0]['@val']) ? str_after($XMLArray['set'][0]['@val'], '.') : 'NOIMAGE',
                ],
                ]);
            if ($Insert == true):
            return true;
            else:
            return false;
            endif;
        endif;
        elseif($XMLArray['@type'] == 'Armor'):
        $Insert = DB::table($ArmorTable)->insert([
            [
                'idItem' => $XMLArray['@id'],
                'type' => $XMLArray['@type'],
                'name' => $XMLArray['@name'],
                'reference' => isset($XMLArray['set'][0]['@val']) ? str_after($XMLArray['set'][0]['@val'], '.') : 'NOIMAGE',
            ],
        ]);
        if ($Insert == true):
            return true;
        else:
            return false;
        endif;
        elseif($XMLArray['@type'] == 'EtcItem' AND $XMLArray['@name'] == 'Adena'):
        $Insert = DB::table($EtcTable)->insert([
            [
                'idItem' => $XMLArray['@id'],
                'type' => $XMLArray['@type'],
                'name' => $XMLArray['@name'],
                'reference' => isset($XMLArray['set'][0]['@val']) ? str_after($XMLArray['set'][0]['@val'], '.') : 'NOIMAGE',
            ],
        ]);
        if ($Insert == true):
            return true;
        else:
            return false;
        endif;
        endif;
    }
}
