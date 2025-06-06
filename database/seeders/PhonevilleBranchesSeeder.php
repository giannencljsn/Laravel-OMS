<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // Make sure this is added


class PhonevilleBranchesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('phoneville_branches')->insert([
            ['store_name' => 'SAMSUNG (MALL OF ASIA)', 'store_location' => '2/F, SM Mall Of Asia North Parking, Pacific Dr, Pasay, 1300 Metro Manila'],
            ['store_name' => 'SAMSUNG (MARQUEE MALL)', 'store_location' => 'LEVEL3 SPACE 3067-3068 MARQUEE MALL FRANCISCO G. NEPOMOCENO AVE'],
            ['store_name' => 'SAMSUNG (STA MESA)', 'store_location' => 'C-07 3RD FLR SM STA MESA AORORA BLVD COR G ARANETA AVE DONA IMELDA 1113 QC'],
            ['store_name' => 'SAMSUNG (TAYTAY)', 'store_location' => 'UNIT 4 BLDG A SM TAYTAY MANILA EAST ROAD DOLERES RIZAL'],
            ['store_name' => 'SAMSUNG (THE PODIUM)', 'store_location' => 'UNIT 3 07 3RD FLR THE PODIUM ADB AVENUE ORTIGAS WACK WACK MANDALUYONG CITY'],
            ['store_name' => 'SAMSUNG (RIVERBANKS CENTER)', 'store_location' => '84 A BONIFACIO AVENUE RIVERBANK MALL BARANGKA'],
            ['store_name' => 'SAMSUNG (SOUTHMALL)', 'store_location' => 'UNIT 28 SM SOUTHMALL 3RD FLOOR CYBERZONE ALABANG ZAPOTE RD ALMANZA UNO CITY LPC'],
            ['store_name' => 'SAMSUNG (MANILA)', 'store_location' => 'CYBERZONE # 003 SM CITY MANILA, SAN MARCELINO ST., ERMITA, MANILA'],
            ['store_name' => 'SAMSUNG (BICUTAN)', 'store_location' => 'K 001(A) SM CITY BICUTAN DONA SOLEDAD AVE. BARANGAY DON BOSCO, PARANAQUE CITY'],
            ['store_name' => 'SAMSUNG (BF)', 'store_location' => 'UNIT CZ 18 SM CITY BF DR A. SANTOS COR. PRES, AVE. BRGY BF HOMES PARANAQUE CITY'],
            ['store_name' => 'SAMSUNG (VISTA MALL)', 'store_location' => '2ND LEVEL VISTA MALL LEVI MARIANO AVE.STA.ANA,TAGUIG CITY'],
            ['store_name' => 'SAMSUNG (FAIRVIEW)', 'store_location' => '329 CYBERZONE SM CITY FAIRVIEW NORTH FAIRVIEW 2 QUEZON CITY'],
            ['store_name' => 'SAMSUNG (TRINOMA)', 'store_location' => 'U-432 LEVEL2 TRINOMA MALL NORTH AVE. BAGONG PAG ASA QUEZON CITY'],
        ]);
    }
}
