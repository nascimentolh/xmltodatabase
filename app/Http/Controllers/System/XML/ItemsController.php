<?php

namespace App\Http\Controllers\System\XML;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Session;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Illuminate\Support\Facades\Input;
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

        $active = route('xml.items');
        $queryWeapon = DB::table('weapon_items')->count();
        $queryArmor = DB::table('armor_items')->count();
        $queryEtc = DB::table('etc_items')->count();

        $queryCustomW = DB::table('custom_weapon_items')->count();
        $queryCustomA = DB::table('custom_armor_items')->count();
        $queryCustomE = DB::table('custom_etc_items')->count();

        $queryCustom = ($queryCustomA + $queryCustomE + $queryCustomW);

        return view('dash.modules.xmlitems', compact('active'))
            ->with('queryWeapon', $queryWeapon)
            ->with('queryArmor', $queryArmor)
            ->with('queryEtc', $queryEtc)
            ->with('queryCustom', $queryCustom);
    }

    public function customItems()
    {
        if(!Schema::hasTable('custom_weapon_items') || !Schema::hasTable('custom_armor_items') || !Schema::hasTable('custom_etc_items')):
            Artisan::calL('migrate');
        endif;

        $custom = true;
        $active = route('xml.items.custom');

        $queryWeapon = DB::table('weapon_items')->count();
        $queryArmor = DB::table('armor_items')->count();
        $queryEtc = DB::table('etc_items')->count();

        $queryCustomW = DB::table('custom_weapon_items')->count();
        $queryCustomA = DB::table('custom_armor_items')->count();
        $queryCustomE = DB::table('custom_etc_items')->count();

        $queryCustom = ($queryCustomA + $queryCustomE + $queryCustomW);

        return view('dash.modules.xmlitems', compact('custom', 'active'))
            ->with('queryWeapon', $queryWeapon)
            ->with('queryArmor', $queryArmor)
            ->with('queryEtc', $queryEtc)
            ->with('queryCustom', $queryCustom);
    }

    public function sendXML(Request $request)
    {
        
        if (!isset($_FILES['files']['name'])):
            $XMLInput = $request->input('xml');
        else:
            $XMLInput = file_get_contents($_FILES['files']['tmp_name'][0]);
        endif;

        
        $parser = new Parser();
        $parsedFile = $parser->xml($XMLInput);
        
        $Counter = 0;
        $CustomTables = $request->custom_items;

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
                $XMLToDatabase = Self::XMLToDatabase($parsedXML, $CustomTables);
            endforeach;
        else:
            $XMLToDatabase = Self::XMLToDatabase($parsedFile['item'], $CustomTables);
        endif;


        return response()->json([
            'Status'=> true,
            'Message'=>'OK',
        ]);

    }

    static function XMLToDatabase($XMLArray, $CustomTables)
    {
        

        $WeaponTable = $CustomTables ? 'custom_weapon_items' : 'weapon_items';
        $ArmorTable = $CustomTables ? 'custom_armor_items' : 'armor_items';
        $EtcTable = $CustomTables ? 'custom_etc_items' : 'etc_items';
        
        if($XMLArray['@type'] == 'Weapon'):

        foreach ($XMLArray['set'] as $XMLItems):
            if($XMLItems['@name'] == 'weapon_type'):
                $WeaponType = $XMLItems['@val'];
            elseif($XMLItems['@name'] == 'crystal_type'):
                $CrystalType = $XMLItems['@val'];
            elseif($XMLItems['@name'] == 'material'):
                $MaterialWeapon = $XMLItems['@val'];
            elseif($XMLItems['@name'] == 'price'):
                $PriceWeapon = $XMLItems['@val'];
            endif;
        endforeach;

        $Insert = DB::table($WeaponTable)->insert([
            [
                'idItem' => $XMLArray['@id'],
                'type' => $XMLArray['@type'],
                'name' => $XMLArray['@name'],
                'reference' => isset($XMLArray['set'][0]['@val']) ? str_after($XMLArray['set'][0]['@val'], '.') : 'NOIMAGE',
                'weapon_type' => isset($WeaponType) ? $WeaponType : 'NONE',
                'crystal_type' => isset($CrystalType) ? $CrystalType : 'NO-Grade',
                'material' => isset($MaterialWeapon) ? $MaterialWeapon : 'NONE',
                'price' => isset($PriceWeapon) ? $PriceWeapon : '0'
            ],
        ]);
        elseif($XMLArray['@type'] == 'EtcItem' AND $XMLArray['@name'] != 'Adena'):

            foreach ($XMLArray['set'] as $XMLItems):
                if($XMLItems['@name'] == 'material'):
                    $EtcMaterial = $XMLItems['@val'];
                elseif($XMLItems['@name'] == 'price'):
                    $PriceEtc = $XMLItems['@val'];
                endif;
            endforeach;           

            $Insert = DB::table($EtcTable)->insert([
                [
                    'idItem' => $XMLArray['@id'],
                    'type' => $XMLArray['@type'],
                    'name' => $XMLArray['@name'],
                    'reference' => isset($XMLArray['set'][0]['@val']) ? str_after($XMLArray['set'][0]['@val'], '.') : 'NOIMAGE',
                    'material' => isset($EtcMaterial) ? $EtcMaterial : 'NONE',
                    'price' => isset($PriceEtc) ? $PriceEtc : '0'
                ],
            ]);
        elseif($XMLArray['@type'] == 'Armor'):

            foreach ($XMLArray['set'] as $XMLItems):
                if($XMLItems['@name'] == 'armor_type'):
                    $ArmorType = $XMLItems['@val'];
                elseif($XMLItems['@name'] == 'bodypart'):
                    $Bodypart = $XMLItems['@val'];
                elseif($XMLItems['@name'] == 'crystal_type'):
                    $CrystalTypeArmor = $XMLItems['@val'];
                elseif($XMLItems['@name'] == 'material'):
                    $MaterialArmor = $XMLItems['@val'];
                elseif($XMLItems['@name'] == 'price'):
                    $PriceArmor = $XMLItems['@val'];
                endif;
            endforeach;

        $Insert = DB::table($ArmorTable)->insert([
            [
                'idItem' => $XMLArray['@id'],
                'type' => $XMLArray['@type'],
                'name' => $XMLArray['@name'],
                'reference' => isset($XMLArray['set'][0]['@val']) ? str_after($XMLArray['set'][0]['@val'], '.') : 'NOIMAGE',
                'armor_type' => isset($ArmorType) ? $ArmorType : 'NONE',
                'bodypart' => isset($Bodypart) ? $Bodypart : 'NONE',
                'crystal_type' => isset($CrystalTypeArmor) ? $CrystalTypeArmor : 'NO-Grade',
                'material' => isset($MaterialArmor) ? $MaterialArmor : 'NONE',
                'price' => isset($PriceArmor) ? $PriceArmor : '0'
            ],
        ]);
        elseif($XMLArray['@type'] == 'EtcItem' AND $XMLArray['@name'] == 'Adena'):

            foreach ($XMLArray['set'] as $XMLItems):
                if($XMLItems['@name'] == 'material'):
                    $Material = $XMLItems['@val'];
                elseif($XMLItems['@name'] == 'price'):
                    $Price = $XMLItems['@val'];
                endif;
            endforeach;

        $Insert = DB::table($EtcTable)->insert([
            [
                'idItem' => $XMLArray['@id'],
                'type' => $XMLArray['@type'],
                'name' => $XMLArray['@name'],
                'reference' => isset($XMLArray['set'][0]['@val']) ? str_after($XMLArray['set'][0]['@val'], '.') : 'NOIMAGE',
                'material' => isset($Material) ? $Material : 'NONE',
                'price' => isset($Price) ? $Price : '0'
            ],
        ]);
        endif;
    }
}
