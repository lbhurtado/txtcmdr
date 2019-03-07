<?php

namespace App\Campaign\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class AreasExport implements FromCollection, Responsable, ShouldAutoSize
{
    use Exportable;

    public function collection()
    {
        $area_nodes = [
            '5th District of Leyte.City of Baybay.Poblacion Zone 1.Cluster Group 1.0001A',
            '5th District of Leyte.City of Baybay.Poblacion Zone 1.Cluster Group 2.0001B',
            '5th District of Leyte.City of Baybay.Poblacion Zone 1.Cluster Group 1.0002A',
            '5th District of Leyte.City of Baybay.Poblacion Zone 1.Cluster Group 2.0002B',
            '5th District of Leyte.City of Baybay.Poblacion Zone 1.Cluster Group 2.0003A',
            '5th District of Leyte.City of Baybay.Poblacion Zone 1.Cluster Group 2.0003B',
            '5th District of Leyte.City of Baybay.Poblacion Zone 1.Cluster Group 1.0004A',
            '5th District of Leyte.City of Baybay.Poblacion Zone 1.Cluster Group 2.0005A',
            '5th District of Leyte.City of Baybay.Poblacion Zone 1.Cluster Group 1.0006A',

            '5th District of Leyte.City of Baybay.Poblacion Zone 2.Cluster Group 3.0007A',
            '5th District of Leyte.City of Baybay.Poblacion Zone 2.Cluster Group 3.0008A',

            '5th District of Leyte.City of Baybay.Poblacion Zone 3.0009A',
            '5th District of Leyte.City of Baybay.Poblacion Zone 3.0010A',

            '5th District of Leyte.City of Baybay.Poblacion Zone 4.0011A',
            '5th District of Leyte.City of Baybay.Poblacion Zone 4.0012A',
            '5th District of Leyte.City of Baybay.Poblacion Zone 4.0013A',

            '5th District of Leyte.City of Baybay.Poblacion Zone 5.0014A',
            '5th District of Leyte.City of Baybay.Poblacion Zone 5.0014B',
            '5th District of Leyte.City of Baybay.Poblacion Zone 5.0015A',
            '5th District of Leyte.City of Baybay.Poblacion Zone 5.0015B',

            '5th District of Leyte.City of Baybay.Poblacion Zone 6.0016A',
            '5th District of Leyte.City of Baybay.Poblacion Zone 6.0016B',
            '5th District of Leyte.City of Baybay.Poblacion Zone 6.0017A',

            '5th District of Leyte.City of Baybay.Poblacion Zone 7.0018A',
            '5th District of Leyte.City of Baybay.Poblacion Zone 7.0019A',

            '5th District of Leyte.City of Baybay.Poblacion Zone 8.0020A',
            '5th District of Leyte.City of Baybay.Poblacion Zone 8.0020B',
            '5th District of Leyte.City of Baybay.Poblacion Zone 8.0021A',

            '5th District of Leyte.City of Baybay.Poblacion Zone 9.0022A',
            '5th District of Leyte.City of Baybay.Poblacion Zone 9.0023A',

            '5th District of Leyte.City of Baybay.Poblacion Zone 10.0024A',
            '5th District of Leyte.City of Baybay.Poblacion Zone 10.0025A',

            '5th District of Leyte.City of Baybay.Poblacion Zone 11.0026A',
            '5th District of Leyte.City of Baybay.Poblacion Zone 11.0027A',
            '5th District of Leyte.City of Baybay.Poblacion Zone 11.0028A',

            '5th District of Leyte.City of Baybay.Poblacion Zone 12.0029A',
            '5th District of Leyte.City of Baybay.Poblacion Zone 12.0030A',
            '5th District of Leyte.City of Baybay.Poblacion Zone 12.0031A',

            '5th District of Leyte.City of Baybay.Poblacion Zone 13.0032A',
            '5th District of Leyte.City of Baybay.Poblacion Zone 13.0033A',

            '5th District of Leyte.City of Baybay.Poblacion Zone 14.0034A',
            '5th District of Leyte.City of Baybay.Poblacion Zone 14.0034B',

            '5th District of Leyte.City of Baybay.Poblacion Zone 15.0035A',
            '5th District of Leyte.City of Baybay.Poblacion Zone 15.0036A',
            '5th District of Leyte.City of Baybay.Poblacion Zone 15.0037A',

            '5th District of Leyte.City of Baybay.Poblacion Zone 16.0038A',
            '5th District of Leyte.City of Baybay.Poblacion Zone 16.0039A',
            '5th District of Leyte.City of Baybay.Poblacion Zone 16.0040A',
            '5th District of Leyte.City of Baybay.Poblacion Zone 16.0041A',

            '5th District of Leyte.City of Baybay.Poblacion Zone 17.0042A',
            '5th District of Leyte.City of Baybay.Poblacion Zone 17.0043A',
            '5th District of Leyte.City of Baybay.Poblacion Zone 17.0044A',

            '5th District of Leyte.City of Baybay.Poblacion Zone 18.0045A',
            '5th District of Leyte.City of Baybay.Poblacion Zone 18.0046A',
            '5th District of Leyte.City of Baybay.Poblacion Zone 18.0047A',
            '5th District of Leyte.City of Baybay.Poblacion Zone 18.0048A',
            '5th District of Leyte.City of Baybay.Poblacion Zone 18.0048B',

            '5th District of Leyte.City of Baybay.Poblacion Zone 19.0049A',

            '5th District of Leyte.City of Baybay.Poblacion Zone 20.0050A',
            '5th District of Leyte.City of Baybay.Poblacion Zone 20.0050B',
            '5th District of Leyte.City of Baybay.Poblacion Zone 20.0051A',

            '5th District of Leyte.City of Baybay.Poblacion Zone 21.0052A',
            '5th District of Leyte.City of Baybay.Poblacion Zone 21.0052B',
            '5th District of Leyte.City of Baybay.Poblacion Zone 21.0053A',

            '5th District of Leyte.City of Baybay.Poblacion Zone 22.0054A',
            '5th District of Leyte.City of Baybay.Poblacion Zone 22.0054B',
            '5th District of Leyte.City of Baybay.Poblacion Zone 22.0055A',
            '5th District of Leyte.City of Baybay.Poblacion Zone 22.0056A',

            '5th District of Leyte.City of Baybay.Poblacion Zone 23.0057A',

            '5th District of Leyte.City of Baybay.Poblacion Zone 21.0057B',
            '5th District of Leyte.City of Baybay.Poblacion Zone 21.0058A',
            '5th District of Leyte.City of Baybay.Poblacion Zone 21.0058B',
            '5th District of Leyte.City of Baybay.Poblacion Zone 21.0059A',
            '5th District of Leyte.City of Baybay.Poblacion Zone 21.0060A',
            '5th District of Leyte.City of Baybay.Poblacion Zone 21.0061A',

            '5th District of Leyte.City of Baybay.Altavista.0062A',
            '5th District of Leyte.City of Baybay.Altavista.0062B',

            '5th District of Leyte.City of Baybay.Ambacan.0063A',
            '5th District of Leyte.City of Baybay.Ambacan.0064A',

            '5th District of Leyte.City of Baybay.Amguhan.0065A',
            '5th District of Leyte.City of Baybay.Amguhan.0065B',
            '5th District of Leyte.City of Baybay.Amguhan.0066A',
            '5th District of Leyte.City of Baybay.Amguhan.0067A',

            '5th District of Leyte.City of Baybay.Ampihanon.0068A',
            '5th District of Leyte.City of Baybay.Ampihanon.0068B',
            '5th District of Leyte.City of Baybay.Ampihanon.0069A',

            '5th District of Leyte.City of Baybay.Balao.0070A',
            '5th District of Leyte.City of Baybay.Balao.0070B',
            '5th District of Leyte.City of Baybay.Balao.0071A',

            '5th District of Leyte.City of Baybay.Banahao.0072A',
            '5th District of Leyte.City of Baybay.Banahao.0073A',
            '5th District of Leyte.City of Baybay.Banahao.0074A',

            '5th District of Leyte.City of Baybay.Biasong.0075A',
            '5th District of Leyte.City of Baybay.Biasong.0075B',
            '5th District of Leyte.City of Baybay.Biasong.0076A',

            '5th District of Leyte.City of Baybay.Bidlinan.0077A',
            '5th District of Leyte.City of Baybay.Bidlinan.0078A',

            '5th District of Leyte.City of Baybay.Bitanhuan.0079A',
            '5th District of Leyte.City of Baybay.Bitanhuan.0079B',
            '5th District of Leyte.City of Baybay.Bitanhuan.0080A',
            '5th District of Leyte.City of Baybay.Bitanhuan.0081A',
            '5th District of Leyte.City of Baybay.Bitanhuan.0082A',
            '5th District of Leyte.City of Baybay.Bitanhuan.0083A',
            '5th District of Leyte.City of Baybay.Bitanhuan.0084A',
            '5th District of Leyte.City of Baybay.Bitanhuan.0085A',
            '5th District of Leyte.City of Baybay.Bitanhuan.0086A',

            '5th District of Leyte.City of Baybay.Bubon.0087A',
            '5th District of Leyte.City of Baybay.Bubon.0088A',

            '5th District of Leyte.City of Baybay.Buenavista.0089A',
            '5th District of Leyte.City of Baybay.Buenavista.0090A',
            '5th District of Leyte.City of Baybay.Buenavista.0091A',

            '5th District of Leyte.City of Baybay.Bunga.0092A',
            '5th District of Leyte.City of Baybay.Bunga.0093A',
            '5th District of Leyte.City of Baybay.Bunga.0094A',
            '5th District of Leyte.City of Baybay.Bunga.0095A',
            '5th District of Leyte.City of Baybay.Bunga.0096A',
            '5th District of Leyte.City of Baybay.Bunga.0097A',
            '5th District of Leyte.City of Baybay.Bunga.0098A',
            '5th District of Leyte.City of Baybay.Bunga.0099A',

            '5th District of Leyte.City of Baybay.Butigan.0100A',
            '5th District of Leyte.City of Baybay.Butigan.0101A',

            '5th District of Leyte.City of Baybay.Candadam.0102A',
            '5th District of Leyte.City of Baybay.Candadam.0102B',
            '5th District of Leyte.City of Baybay.Candadam.0103A',
            '5th District of Leyte.City of Baybay.Candadam.0103B',
            '5th District of Leyte.City of Baybay.Candadam.0104A',
            '5th District of Leyte.City of Baybay.Candadam.0104B',
            '5th District of Leyte.City of Baybay.Candadam.0105A',
            '5th District of Leyte.City of Baybay.Candadam.0105B',

            '5th District of Leyte.City of Baybay.Kan-ipa.0106A',
            '5th District of Leyte.City of Baybay.Kan-ipa.0106B',
            '5th District of Leyte.City of Baybay.Kan-ipa.0107A',
            '5th District of Leyte.City of Baybay.Kan-ipa.0108A',

            '5th District of Leyte.City of Baybay.Caridad.0109A',
            '5th District of Leyte.City of Baybay.Caridad.0110A',
            '5th District of Leyte.City of Baybay.Caridad.0111A',
            '5th District of Leyte.City of Baybay.Caridad.0112A',
            '5th District of Leyte.City of Baybay.Caridad.0113A',
            '5th District of Leyte.City of Baybay.Caridad.0114A',
            '5th District of Leyte.City of Baybay.Caridad.0115A',
            '5th District of Leyte.City of Baybay.Caridad.0116A',
            '5th District of Leyte.City of Baybay.Caridad.0117A',
            '5th District of Leyte.City of Baybay.Caridad.0118A',
            '5th District of Leyte.City of Baybay.Caridad.0119A',
            '5th District of Leyte.City of Baybay.Caridad.0120A',

            '5th District of Leyte.City of Baybay.Ciabo.0121A',
            '5th District of Leyte.City of Baybay.Ciabo.0122A',
            '5th District of Leyte.City of Baybay.Ciabo.0123A',
            '5th District of Leyte.City of Baybay.Ciabo.0124A',

            '5th District of Leyte.City of Baybay.Cogon.0125A',
            '5th District of Leyte.City of Baybay.Cogon.0125B',
            '5th District of Leyte.City of Baybay.Cogon.0126A',
            '5th District of Leyte.City of Baybay.Cogon.0127A',

            '5th District of Leyte.City of Baybay.Ga-as.0128A',
            '5th District of Leyte.City of Baybay.Ga-as.0128B',
            '5th District of Leyte.City of Baybay.Ga-as.0129A',
            '5th District of Leyte.City of Baybay.Ga-as.0129B',
            '5th District of Leyte.City of Baybay.Ga-as.0130A',
            '5th District of Leyte.City of Baybay.Ga-as.0131A',
            '5th District of Leyte.City of Baybay.Ga-as.0132A',
            '5th District of Leyte.City of Baybay.Ga-as.0133A',

            '5th District of Leyte.City of Baybay.Gabas.0134A',
            '5th District of Leyte.City of Baybay.Gabas.0134B',
            '5th District of Leyte.City of Baybay.Gabas.0135A',
            '5th District of Leyte.City of Baybay.Gabas.0135B',
            '5th District of Leyte.City of Baybay.Gabas.0136A',
            '5th District of Leyte.City of Baybay.Gabas.0137A',
            '5th District of Leyte.City of Baybay.Gabas.0138A',
            '5th District of Leyte.City of Baybay.Gabas.0139A',

            '5th District of Leyte.City of Baybay.Gakat.0140A',
            '5th District of Leyte.City of Baybay.Gakat.0140B',
            '5th District of Leyte.City of Baybay.Gakat.0141A',
            '5th District of Leyte.City of Baybay.Gakat.0142A',
            '5th District of Leyte.City of Baybay.Gakat.0143A',
            '5th District of Leyte.City of Baybay.Gakat.0144B',

            '5th District of Leyte.City of Baybay.Guadalupe.0145A',
            '5th District of Leyte.City of Baybay.Guadalupe.0145B',
            '5th District of Leyte.City of Baybay.Guadalupe.0146A',
            '5th District of Leyte.City of Baybay.Guadalupe.0147A',
            '5th District of Leyte.City of Baybay.Guadalupe.0148A',
            '5th District of Leyte.City of Baybay.Guadalupe.0149A',
            '5th District of Leyte.City of Baybay.Guadalupe.0150A',
            '5th District of Leyte.City of Baybay.Guadalupe.0151A',

            '5th District of Leyte.City of Baybay.Gubang.0152A',
            '5th District of Leyte.City of Baybay.Gubang.0153A',

            '5th District of Leyte.City of Baybay.Hibunawan.0154A',
            '5th District of Leyte.City of Baybay.Hibunawan.0154B',
            '5th District of Leyte.City of Baybay.Hibunawan.0155A',
            '5th District of Leyte.City of Baybay.Hibunawan.0155B',
            '5th District of Leyte.City of Baybay.Hibunawan.0156A',
            '5th District of Leyte.City of Baybay.Hibunawan.0157A',

            '5th District of Leyte.City of Baybay.Higuloan.0158A',
            '5th District of Leyte.City of Baybay.Higuloan.0159A',

            '5th District of Leyte.City of Baybay.Hilapnitan.0160A',
            '5th District of Leyte.City of Baybay.Hilapnitan.0160B',
            '5th District of Leyte.City of Baybay.Hilapnitan.0161A',
            '5th District of Leyte.City of Baybay.Hilapnitan.0162A',
            '5th District of Leyte.City of Baybay.Hilapnitan.0163A',
            '5th District of Leyte.City of Baybay.Hilapnitan.0163B',

            '5th District of Leyte.City of Baybay.Hipusngo.0164A',
            '5th District of Leyte.City of Baybay.Hipusngo.0164B',
            '5th District of Leyte.City of Baybay.Hipusngo.0165A',
            '5th District of Leyte.City of Baybay.Hipusngo.0166A',
            '5th District of Leyte.City of Baybay.Hipusngo.0167A',
            '5th District of Leyte.City of Baybay.Hipusngo.0168A',
            '5th District of Leyte.City of Baybay.Hipusngo.0168B',

            '5th District of Leyte.City of Baybay.Igang.0169A',
            '5th District of Leyte.City of Baybay.Igang.0170A',
            '5th District of Leyte.City of Baybay.Igang.0171A',
            '5th District of Leyte.City of Baybay.Igang.0172A',
            '5th District of Leyte.City of Baybay.Igang.0173A',
            '5th District of Leyte.City of Baybay.Igang.0173B',

            '5th District of Leyte.City of Baybay.Imelda.0174A',
            '5th District of Leyte.City of Baybay.Imelda.0175A',
            '5th District of Leyte.City of Baybay.Imelda.0175B',

            '5th District of Leyte.City of Baybay.Jaena.0176A',
            '5th District of Leyte.City of Baybay.Jaena.0176B',
            '5th District of Leyte.City of Baybay.Jaena.0177A',
            '5th District of Leyte.City of Baybay.Jaena.0178A',

            '5th District of Leyte.City of Baybay.Kabalasan.0179A',
            '5th District of Leyte.City of Baybay.Kabalasan.0179B',
            '5th District of Leyte.City of Baybay.Kabalasan.0180A',

            '5th District of Leyte.City of Baybay.Kabatuan.0181A',

            '5th District of Leyte.City of Baybay.Kabungaan.0182A',
            '5th District of Leyte.City of Baybay.Kabungaan.0182B',
            '5th District of Leyte.City of Baybay.Kabungaan.0183A',

            '5th District of Leyte.City of Baybay.Kagumay.0184A',
            '5th District of Leyte.City of Baybay.Kagumay.0184B',
            '5th District of Leyte.City of Baybay.Kagumay.0185A',

            '5th District of Leyte.City of Baybay.Kambonggan.0186A',
            '5th District of Leyte.City of Baybay.Kambonggan.0187A',
            '5th District of Leyte.City of Baybay.Kambonggan.0187B',

            '5th District of Leyte.City of Baybay.Kansungka.0188A',
            '5th District of Leyte.City of Baybay.Kansungka.0189A',
            '5th District of Leyte.City of Baybay.Kansungka.0190A',
            '5th District of Leyte.City of Baybay.Kansungka.0190B',

            '5th District of Leyte.City of Baybay.Kantagnos.0191A',
            '5th District of Leyte.City of Baybay.Kantagnos.0192A',

            '5th District of Leyte.City of Baybay.Kilim.0193A',
            '5th District of Leyte.City of Baybay.Kilim.0193B',
            '5th District of Leyte.City of Baybay.Kilim.0194A',
            '5th District of Leyte.City of Baybay.Kilim.0195A',
            '5th District of Leyte.City of Baybay.Kilim.0196A',
            '5th District of Leyte.City of Baybay.Kilim.0197A',
            '5th District of Leyte.City of Baybay.Kilim.0198A',
            '5th District of Leyte.City of Baybay.Kilim.0198B',
            '5th District of Leyte.City of Baybay.Kilim.0199A',
            '5th District of Leyte.City of Baybay.Kilim.0200A',
            '5th District of Leyte.City of Baybay.Kilim.0201A',

            '5th District of Leyte.City of Baybay.Lintaon.0202A',

            '5th District of Leyte.City of Baybay.Maganhan.0203A',
            '5th District of Leyte.City of Baybay.Maganhan.0203B',
            '5th District of Leyte.City of Baybay.Maganhan.0204A',
            '5th District of Leyte.City of Baybay.Maganhan.0205A',

            '5th District of Leyte.City of Baybay.Mahayahay.0206A',
            '5th District of Leyte.City of Baybay.Mahayahay.0206B',

            '5th District of Leyte.City of Baybay.Mailhi.0207A',
            '5th District of Leyte.City of Baybay.Mailhi.0208A',
            '5th District of Leyte.City of Baybay.Mailhi.0209A',

            '5th District of Leyte.City of Baybay.Maitum.0210A',
            '5th District of Leyte.City of Baybay.Maitum.0210B',
            '5th District of Leyte.City of Baybay.Maitum.0211A',
            '5th District of Leyte.City of Baybay.Maitum.0212A',

            '5th District of Leyte.City of Baybay.Makinhas.0213A',
            '5th District of Leyte.City of Baybay.Makinhas.0213B',
            '5th District of Leyte.City of Baybay.Makinhas.0214A',
            '5th District of Leyte.City of Baybay.Makinhas.0215A',

            '5th District of Leyte.City of Baybay.Mapgap.0216A',
            '5th District of Leyte.City of Baybay.Mapgap.0217A',

            '5th District of Leyte.City of Baybay.Marcos.0218A',
            '5th District of Leyte.City of Baybay.Marcos.0218B',
            '5th District of Leyte.City of Baybay.Marcos.0219A',
            '5th District of Leyte.City of Baybay.Marcos.0220A',
            '5th District of Leyte.City of Baybay.Marcos.0221A',

            '5th District of Leyte.City of Baybay.Maslug.0222A',
            '5th District of Leyte.City of Baybay.Maslug.0223A',
            '5th District of Leyte.City of Baybay.Maslug.0224A',
            '5th District of Leyte.City of Baybay.Maslug.0225A',
            '5th District of Leyte.City of Baybay.Maslug.0226A',

            '5th District of Leyte.City of Baybay.Matam-is.0227A',
            '5th District of Leyte.City of Baybay.Matam-is.0227B',

            '5th District of Leyte.City of Baybay.Maybog.0228A',
            '5th District of Leyte.City of Baybay.Maybog.0228B',
            '5th District of Leyte.City of Baybay.Maybog.0229A',
            '5th District of Leyte.City of Baybay.Maybog.0230A',
            '5th District of Leyte.City of Baybay.Maybog.0231A',

            '5th District of Leyte.City of Baybay.Maypatag.0232A',
            '5th District of Leyte.City of Baybay.Maypatag.0232B',
            '5th District of Leyte.City of Baybay.Maypatag.0233A',

            '5th District of Leyte.City of Baybay.Monterico.0234A',
            '5th District of Leyte.City of Baybay.Monterico.0234B',

            '5th District of Leyte.City of Baybay.Monte Verde.0235A',
            '5th District of Leyte.City of Baybay.Monte Verde.0235B',

            '5th District of Leyte.City of Baybay.Palhi.0236A',
            '5th District of Leyte.City of Baybay.Palhi.0236B',
            '5th District of Leyte.City of Baybay.Palhi.0237A',
            '5th District of Leyte.City of Baybay.Palhi.0238A',
            '5th District of Leyte.City of Baybay.Palhi.0239A',
            '5th District of Leyte.City of Baybay.Palhi.0240A',
            '5th District of Leyte.City of Baybay.Palhi.0241A',
            '5th District of Leyte.City of Baybay.Palhi.0242A',

            '5th District of Leyte.City of Baybay.Pangasungan.0248A',
            '5th District of Leyte.City of Baybay.Pangasungan.0249A',
            '5th District of Leyte.City of Baybay.Pangasungan.0250A',
            '5th District of Leyte.City of Baybay.Pangasungan.0251A',
            '5th District of Leyte.City of Baybay.Pangasungan.0252A',

            '5th District of Leyte.City of Baybay.Pansagan.0253A',
            '5th District of Leyte.City of Baybay.Pansagan.0254A',

            '5th District of Leyte.City of Baybay.Patag.0255A',
            '5th District of Leyte.City of Baybay.Patag.0255B',
            '5th District of Leyte.City of Baybay.Patag.0256A',
            '5th District of Leyte.City of Baybay.Patag.0257A',
            '5th District of Leyte.City of Baybay.Patag.0258A',

            '5th District of Leyte.City of Baybay.Plaridel.0259A',
            '5th District of Leyte.City of Baybay.Plaridel.0260A',
            '5th District of Leyte.City of Baybay.Plaridel.0261A',
            '5th District of Leyte.City of Baybay.Plaridel.0262A',
            '5th District of Leyte.City of Baybay.Plaridel.0263A',
            '5th District of Leyte.City of Baybay.Plaridel.0264A',
            '5th District of Leyte.City of Baybay.Plaridel.0265A',
            '5th District of Leyte.City of Baybay.Plaridel.0266A',
            '5th District of Leyte.City of Baybay.Plaridel.0267A',
            '5th District of Leyte.City of Baybay.Plaridel.0268A',
            '5th District of Leyte.City of Baybay.Plaridel.0269A',
            '5th District of Leyte.City of Baybay.Plaridel.0270A',
            '5th District of Leyte.City of Baybay.Plaridel.0271A',

            '5th District of Leyte.City of Baybay.Pomponan.0272A',
            '5th District of Leyte.City of Baybay.Pomponan.0273A',
            '5th District of Leyte.City of Baybay.Pomponan.0274A',
            '5th District of Leyte.City of Baybay.Pomponan.0275A',
            '5th District of Leyte.City of Baybay.Pomponan.0276A',
            '5th District of Leyte.City of Baybay.Pomponan.0277A',
            '5th District of Leyte.City of Baybay.Pomponan.0278A',
            '5th District of Leyte.City of Baybay.Pomponan.0279A',
            '5th District of Leyte.City of Baybay.Pomponan.0280A',
            '5th District of Leyte.City of Baybay.Pomponan.0281A',

            '5th District of Leyte.City of Baybay.Punta.0282A',
            '5th District of Leyte.City of Baybay.Punta.0282B',
            '5th District of Leyte.City of Baybay.Punta.0283A',
            '5th District of Leyte.City of Baybay.Punta.0284A',

            '5th District of Leyte.City of Baybay.Sabang.0286A',
            '5th District of Leyte.City of Baybay.Sabang.0286B',
            '5th District of Leyte.City of Baybay.Sabang.0287A',
            '5th District of Leyte.City of Baybay.Sabang.0288A',
            '5th District of Leyte.City of Baybay.Sabang.0289A',

            '5th District of Leyte.City of Baybay.San Agustin.0290A',
            '5th District of Leyte.City of Baybay.San Agustin.0290B',
            '5th District of Leyte.City of Baybay.San Agustin.0291A',
            '5th District of Leyte.City of Baybay.San Agustin.0291B',
            '5th District of Leyte.City of Baybay.San Agustin.0292A',

            '5th District of Leyte.City of Baybay.San Isidro.0293A',
            '5th District of Leyte.City of Baybay.San Isidro.0293B',
            '5th District of Leyte.City of Baybay.San Isidro.0294A',
            '5th District of Leyte.City of Baybay.San Isidro.0294B',
            '5th District of Leyte.City of Baybay.San Isidro.0295A',
            '5th District of Leyte.City of Baybay.San Isidro.0296A',

            '5th District of Leyte.City of Baybay.San Juan.0297A',
            '5th District of Leyte.City of Baybay.San Juan.0298A',
            '5th District of Leyte.City of Baybay.San Juan.0299A',
            '5th District of Leyte.City of Baybay.San Juan.0300A',

            '5th District of Leyte.City of Baybay.Sapa.0301A',
            '5th District of Leyte.City of Baybay.Sapa.0302A',

            '5th District of Leyte.City of Baybay.Santa Cruz.0303A',
            '5th District of Leyte.City of Baybay.Santa Cruz.0303B',
            '5th District of Leyte.City of Baybay.Santa Cruz.0304A',
            '5th District of Leyte.City of Baybay.Santa Cruz.0305A',
            '5th District of Leyte.City of Baybay.Santa Cruz.0306A',
            '5th District of Leyte.City of Baybay.Santa Cruz.0307A',

            '5th District of Leyte.City of Baybay.Santo Rosario.0308A',
            '5th District of Leyte.City of Baybay.Santo Rosario.0308B',
            '5th District of Leyte.City of Baybay.Santo Rosario.0309A',
            '5th District of Leyte.City of Baybay.Santo Rosario.0309B',
            '5th District of Leyte.City of Baybay.Santo Rosario.0310A',
            '5th District of Leyte.City of Baybay.Santo Rosario.0311A',
            '5th District of Leyte.City of Baybay.Santo Rosario.0312A',

            '5th District of Leyte.City of Baybay.Villa Solidaridad.0313A',
            '5th District of Leyte.City of Baybay.Villa Solidaridad.0313B',
            '5th District of Leyte.City of Baybay.Villa Solidaridad.0314A',
            '5th District of Leyte.City of Baybay.Villa Solidaridad.0315A',

            '5th District of Leyte.City of Baybay.Villa Mag-aso.0316A',
            '5th District of Leyte.City of Baybay.Villa Mag-aso.0317A',

            '5th District of Leyte.City of Baybay.Zacarito.0318A',
            '5th District of Leyte.City of Baybay.Zacarito.0319A',
        ];

        $areas = [];

        foreach ($area_nodes as $node) {
            $areas [] = explode('.', $node);
        }

        return collect($areas);
    }


}
